<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\AdminMenu;

use Kaiseki\WordPress\Context\Filter\ContextFilterInterface;
use Kaiseki\WordPress\Hook\HookProviderInterface;

use function add_action;
use function remove_menu_page;

class RemoveAdminMenuPages implements HookProviderInterface
{
    /**
     * @param array<string, bool|ContextFilterInterface> $pages
     */
    public function __construct(private readonly array $pages = [])
    {
    }

    public function addHooks(): void
    {
        add_action('admin_menu', [$this, 'walkConfig'], 999);
    }

    public function walkConfig(): void
    {
        foreach ($this->pages as $page => $condition) {
            if ($condition !== true && ($condition instanceof ContextFilterInterface && $condition() === false)) {
                continue;
            }

            remove_menu_page($page);
        }
    }
}
