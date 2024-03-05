<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\AdminMenu;

use Kaiseki\WordPress\Hook\HookProviderInterface;

use function add_action;
use function count;

class AddAdminMenuSeparators implements HookProviderInterface
{
    /** @var list<string> */
    private array $separatorNames;

    public function __construct(int $count, string $prefix)
    {
        $this->separatorNames = $this->generateSeparatorNames($count, $prefix);
    }

    public function addHooks(): void
    {
        add_action('admin_menu', [$this, 'addMenuSeparators']);
    }

    public function addMenuSeparators(): void
    {
        $count = count($this->separatorNames);
        if ($count < 1) {
            return;
        }
        global $menu;
        foreach ($this->separatorNames as $index => $name) {
            $menu[$this->getIndexForSeparator($index, $count)] = ['', 'read', $name, '', 'wp-menu-separator'];
        }
    }

    private function getIndexForSeparator(int $index, int $separatorsCount): string
    {
        return (string)(99.9999 - ($separatorsCount - 1) / 10000 + $index / 10000);
    }

    /**
     * @param int    $count
     * @param string $prefix
     *
     * @return list<string>
     */
    private function generateSeparatorNames(int $count, string $prefix): array
    {
        if ($count < 1) {
            return [];
        }
        $names = [];
        for ($i = 1; $i <= $count; $i++) {
            $names[] = $prefix . $i;
        }

        return $names;
    }
}
