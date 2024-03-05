<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\AdminMenu;

use Kaiseki\Config\Config;
use Kaiseki\WordPress\Environment\EnvironmentInterface;
use Psr\Container\ContainerInterface;

final class ChangeAdminMenuOrderFactory
{
    public function __invoke(ContainerInterface $container): ChangeAdminMenuOrder
    {
        $config = Config::fromContainer($container);
        /** @var list<string> $order */
        $order = $config->array('admin_menu.order');

        return new ChangeAdminMenuOrder(
            $container->get(EnvironmentInterface::class),
            $order,
            $config->string('admin_menu.separator_index_placeholder'),
            $config->bool('admin_menu.debug')
        );
    }
}
