# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## 1.0.0 - 2026-06-01

First tagged release.

### Added

- `ChangeAdminMenuOrder`, `AddAdminMenuSeparators` and `RemoveAdminMenuPages` hook providers, driven by
  the `admin_menu` config key, plus their factories and `ConfigProvider`. Reorder the top-level admin
  menu, add named separators, and conditionally remove menu pages (gated by `kaiseki/wp-context`
  filters).

### Changed

- PHP requirement is `^8.2` (PHP 8.4 is the primary target).
- Modernized the dev toolchain (PHPStan 2, PHPUnit 11 schema, composer-require-checker 4) and depend
  on `kaiseki/php-coding-standard: ^1.0` with the shared PHPStan config; `kaiseki/config` and
  `kaiseki/wp-hook` pinned to `^2.0`, `kaiseki/wp-context` and `kaiseki/wp-env` to `^1.0`. CI now runs
  via the reusable workflow in `kaisekidev/.github`.

### Fixed

- PHPStan 2 (level max): `AddAdminMenuSeparators` narrows the WordPress `$menu` global to an array
  before writing to it, and `ChangeAdminMenuOrderFactory` filters the configured order to
  `list<string>` at runtime instead of asserting it with `@var`. No behaviour change.
