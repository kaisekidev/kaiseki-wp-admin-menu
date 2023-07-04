<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\AdminMenu;

use Kaiseki\Config\Config;
use Psr\Container\ContainerInterface;

/**
 * @phpstan-import-type RemovePageCallback from RemoveAdminMenuPages
 */
final class RemoveAdminMenuPagesFactory
{
    public function __invoke(ContainerInterface $container): RemoveAdminMenuPages
    {
        /** @var array<string, RemovePageCallback|bool> $pages */
        $pages = Config::get($container)->array('admin_menu/remove_menu_pages', []);
        return new RemoveAdminMenuPages($pages);
    }
}
