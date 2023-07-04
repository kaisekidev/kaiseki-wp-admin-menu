<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\AdminMenu;

use Kaiseki\WordPress\Hook\HookCallbackProviderInterface;
use RuntimeException;

use function is_callable;

/**
 * @phpstan-type RemovePageCallback callable(): bool
 */
class RemoveAdminMenuPages implements HookCallbackProviderInterface
{
    /**
     * @param array<string, RemovePageCallback|bool> $pages
     */
    public function __construct(private readonly array $pages)
    {
    }

    public function registerHookCallbacks(): void
    {
        add_action('admin_menu', [$this, 'walkConfig'], 999);
    }

    public function walkConfig(): void
    {
        foreach ($this->pages as $page => $callback) {
            if ($callback === true) {
                remove_menu_page($page);
            }

            if (is_bool($callback)) {
                continue;
            }

            if (!is_callable($callback)) {
                throw new RuntimeException('Callback for page ' . $page . ' is not callable');
            }

            if ($callback() === false) {
                continue;
            }

            remove_menu_page($page);
        }
    }
}
