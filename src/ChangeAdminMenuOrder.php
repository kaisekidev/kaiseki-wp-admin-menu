<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\AdminMenu;

use Kaiseki\WordPress\Environment\EnvironmentInterface;
use Kaiseki\WordPress\Hook\HookCallbackProviderInterface;

use function array_diff;
use function array_map;
use function array_merge;
use function str_contains;
use function str_replace;
use function var_dump;

class ChangeAdminMenuOrder implements HookCallbackProviderInterface
{
    /**
     * @param list<string> $menuOrder
     */
    public function __construct(
        private readonly EnvironmentInterface $environment,
        private readonly array $menuOrder = [],
        private readonly string $placeholder = '{#}',
        private readonly bool $debugMenuOrder = false
    ) {
    }

    public function registerHookCallbacks(): void
    {
        add_filter('menu_order', [$this, 'updateMenuOrder'], 999, 1);
        add_filter('custom_menu_order', '__return_true');
    }

    /**
     * @param list<string> $menuOrder
     * @return list<string>
     */
    public function updateMenuOrder(array $menuOrder): array
    {
        $customMenuOrder = $this->replaceIndexPlaceholders($this->menuOrder, $this->placeholder);
        if ($customMenuOrder === []) {
            return $menuOrder;
        }
        $newMenuOrder = array_merge($customMenuOrder, array_diff($menuOrder, $customMenuOrder));
        if (
            $this->debugMenuOrder === true
            && (
                $this->environment->isDevelopment()
                || $this->environment->isLocal()
            )) {
            $this->debugMenuOrder($menuOrder);
        }
        return $newMenuOrder;
    }

    /**
     * @param list<string> $oldMenuOrder
     */
    private function debugMenuOrder(array $oldMenuOrder): void
    {
        $menuOrder = $this->replaceIndexPlaceholders($this->menuOrder, $this->placeholder);
        $menuEntriesMissingFromConfiguration = array_diff($oldMenuOrder, $menuOrder);
        $menuEntriesNotMatched = array_diff($menuOrder, $oldMenuOrder);
        if ($menuEntriesMissingFromConfiguration !== [] || $menuEntriesNotMatched !== []) {
            var_dump([
                'old-menu-order' => $oldMenuOrder,
                'new-menu-order' => $menuOrder,
                'menu-entries-missing-from-configuration' => $menuEntriesMissingFromConfiguration,
                'menu-entries-not-matched' => $menuEntriesNotMatched,
            ]);
            die;
        }
    }

    /**
     * @param list<string> $menuOrder
     * @return list<string>
     */
    private function replaceIndexPlaceholders(array $menuOrder, string $placeholder): array
    {
        $count = 0;
        return array_map(function ($menuEntry) use (&$count, $placeholder): string {
            if (!str_contains($menuEntry, $placeholder)) {
                return $menuEntry;
            }
            $count = $count + 1;
            return str_replace($placeholder, (string)$count, $menuEntry);
        }, $menuOrder);
    }
}
