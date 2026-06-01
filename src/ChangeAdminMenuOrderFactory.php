<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\AdminMenu;

use Kaiseki\Config\Config;
use Kaiseki\WordPress\Environment\EnvironmentInterface;
use Psr\Container\ContainerInterface;

use function array_filter;
use function array_values;
use function is_string;

final class ChangeAdminMenuOrderFactory
{
    public function __invoke(ContainerInterface $container): ChangeAdminMenuOrder
    {
        $config = Config::fromContainer($container);
        $order = array_values(array_filter(
            $config->array('admin_menu.order'),
            static fn(mixed $entry): bool => is_string($entry),
        ));

        return new ChangeAdminMenuOrder(
            $container->get(EnvironmentInterface::class),
            $order,
            $config->string('admin_menu.separator_index_placeholder'),
            $config->bool('admin_menu.debug')
        );
    }
}
