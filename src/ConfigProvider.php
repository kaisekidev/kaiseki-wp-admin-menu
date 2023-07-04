<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\AdminMenu;

final class ConfigProvider
{
    /**
     * @return array<mixed>
     */
    public function __invoke(): array
    {
        return [
            'admin_menu' => [
                'hide_editor_page_templates' => [],
                /**
                 * Customize the WordPress Dashboard menu order via the admin_menu hook.
                 * Entries not found in your custom order array will get appended to the Dashboard Menu
                 *
                 * Set "debug" to true to var_dump the configuration for easier setup.
                 *
                 * @link https://developer.wordpress.org/reference/hooks/menu_order/
                 */
                'order' => [
//                        'index.php',
//                        'separator1',
//                        'edit.php',
//                        'edit.php?post_type=page',
//                        'edit.php?post_type=wp_block',
//                        'edit-comments.php',
//                        'separator2',
//                        'upload.php',
//                        'custom-separator-{#}',
//                        'edit.php?post_type=acf-field-group',
//                        'custom-separator-{#}',
//                        'themes.php',
//                        'plugins.php',
//                        'users.php',
//                        'tools.php',
//                        'options-general.php',
//                        'separator-last',
//                        'wpseo_dashboard',
                ],
                'separator_index_placeholder' => '{#}',
                'debug' => false,
                /**
                 * Add x number of custom separators that are named "{prefix}{index}".
                 * You can then use the separators to better structure the menu.
                 */
                'additional_menu_separators' => [
                    'count' => 0,
                    'prefix' => 'custom-separator-',
                ],
                /**
                 * Remove menu pages for users that don't have certain capabilities.
                 */
                'remove_menu_pages' => [
                //     'example.php' => fn() => !current_user_can('edit_posts'),
                ],
            ],
            'hook' => [
                'provider' => [
                    AddAdminMenuSeparators::class,
                    ChangeAdminMenuOrder::class,
                    RemoveAdminMenuPages::class,
                ],
            ],
            'dependencies' => [
                'aliases' => [],
                'factories' => [
                    AddAdminMenuSeparators::class => AddAdminMenuSeparatorsFactory::class,
                    ChangeAdminMenuOrder::class => ChangeAdminMenuOrderFactory::class,
                    RemoveAdminMenuPages::class => RemoveAdminMenuPagesFactory::class,
                ],
            ],
        ];
    }
}
