<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\AdminMenu;

use Kaiseki\Config\Config;
use Kaiseki\WordPress\Context\Filter\ContextFilterInterface;
use Kaiseki\WordPress\Context\Filter\ContextFilterPipeline;
use Psr\Container\ContainerInterface;

use function array_map;
use function is_array;
use function is_bool;

/**
 * @phpstan-type ContextFilterType class-string<ContextFilterInterface>|ContextFilterInterface
 * @phpstan-type ContextFilterTypes ContextFilterType|list<ContextFilterType>
 */
final class RemoveAdminMenuPagesFactory
{
    public function __invoke(ContainerInterface $container): RemoveAdminMenuPages
    {
        /** @var array<string, bool|ContextFilterTypes> $pagesConfig */
        $pagesConfig = Config::get($container)->array('admin_menu/remove_menu_pages', []);
        $pages = array_map(function ($config) use ($container) {
            if (is_bool($config)) {
                return $config;
            }

            $map = is_array($config) ? $config : [$config];
            return new ContextFilterPipeline(...Config::initClassMap($container, $map));
        }, $pagesConfig);
        return new RemoveAdminMenuPages($pages);
    }
}
