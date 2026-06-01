# kaiseki/wp-admin-menu

Customize the WordPress admin menu: reorder entries, add separators, and conditionally remove menu pages.

Three `kaiseki/wp-hook` `HookProviderInterface`s wired through `ConfigProvider`, all driven by the
`admin_menu` config key:

- **`ChangeAdminMenuOrder`** — sets a custom top-level menu order; entries not listed are appended.
- **`AddAdminMenuSeparators`** — registers a number of named separators you can place in the order.
- **`RemoveAdminMenuPages`** — removes menu pages, optionally gated by a `kaiseki/wp-context`
  `ContextFilterInterface` (e.g. by capability or context).

## Installation

```bash
composer require kaiseki/wp-admin-menu
```

Requires PHP 8.2 or newer.

## Usage

Register `ConfigProvider` with your laminas-style config aggregator, configure `admin_menu`, and
activate the providers via `kaiseki/wp-hook`:

```php
use Kaiseki\WordPress\AdminMenu\AddAdminMenuSeparators;
use Kaiseki\WordPress\AdminMenu\ChangeAdminMenuOrder;
use Kaiseki\WordPress\AdminMenu\RemoveAdminMenuPages;

return [
    'admin_menu' => [
        // Custom top-level order; '{#}' is replaced by the next custom separator index.
        'order' => [
            'index.php',
            'custom-separator-{#}',
            'edit.php',
            'upload.php',
        ],
        'separator_index_placeholder' => '{#}',
        'debug' => false,
        'additional_menu_separators' => [
            'count'  => 1,
            'prefix' => 'custom-separator-',
        ],
        // handle => true (always) | ContextFilter class-string | list of filters
        'remove_menu_pages' => [
            'edit-comments.php' => true,
        ],
    ],
    'hook' => [
        'provider' => [
            AddAdminMenuSeparators::class,
            ChangeAdminMenuOrder::class,
            RemoveAdminMenuPages::class,
        ],
    ],
];
```

`ConfigProvider` registers a factory for each provider; they read their slice of `admin_menu` from the
container. Set `admin_menu.debug` to `true` to dump the computed order (on local/development
environments, detected via `kaiseki/wp-env`) while setting it up.

## Development

```bash
composer install
composer check   # check-deps, cs-check, phpstan
```

## License

MIT — see [LICENSE](LICENSE).
