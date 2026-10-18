# Database Management - Toy Store

[![tests](https://github.com/hyderoo/Database-Management-Toy-Store/actions/workflows/tests.yml/badge.svg)](https://github.com/hyderoo/Database-Management-Toy-Store/actions/workflows/tests.yml)

Toy store database management app - final practicum project for the Database
Systems course (SBD), group 20. Laravel 10 admin panel for managing toys,
customers, suppliers and transactions, on MySQL/MariaDB.

> Coursework project (2023). Kept public as a record of study; it is not a
> production app - see "Known limitations" below.

## Features

- CRUD for toys, customers and suppliers, plus transaction records linking
  all three
- Keyword search per entity
- Soft delete with restore and a trash view, alongside permanent delete
- Session login screen
- Feature test suite covering the domain flows (see `tests/Feature/ToyStoreTest.php`),
  running in CI against a real MySQL with the original schema and seed data

## Tech

Laravel 10, PHP 8.1+, MySQL/MariaDB, Blade, Vite/Tailwind for assets.

## Run it locally

```bash
composer install
cp .env.example .env   # or copy .env.ci and adjust credentials
php artisan key:generate

# create the database, then load the original schema + seed data:
mysql -u root -p toystore < dbtoystorekel20.sql
php artisan migrate     # auth scaffolding tables (users, tokens)

php artisan serve
```

## Tests

```bash
php artisan test
```

The CI workflow spins up MySQL 8, imports `dbtoystorekel20.sql`, runs the
framework migrations and then the full suite. Tests use database transactions
so seed data stays intact.

## Known limitations (honest list, coursework)

- The CRUD routes are only behind the `web` middleware - they are reachable
  without logging in. The login screen exists but does not gate the admin
  pages.
- Controllers mix raw SQL with the query builder; model classes exist but the
  controllers mostly bypass them.
- IDs are supplied by the user in forms instead of auto-increment.
- `update` handlers match the row on the posted `id` field, not the URL id.

These are left as-is to keep the submitted coursework intact; the test suite
documents the actual behavior.
