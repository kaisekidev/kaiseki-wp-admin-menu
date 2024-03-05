<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\AdminMenu;

use Kaiseki\Config\Config;
use Psr\Container\ContainerInterface;

final class AddAdminMenuSeparatorsFactory
{
    public function __invoke(ContainerInterface $container): AddAdminMenuSeparators
    {
        $config = Config::fromContainer($container);

        return new AddAdminMenuSeparators(
            $config->int('admin_menu.additional_menu_separators.count'),
            $config->string('admin_menu.additional_menu_separators.prefix'),
        );
    }
}
