## Why

The project currently uses MySQL with PDO and is configured for local XAMPP development. To enable professional deployment on Render.com with PostgreSQL (their managed database standard), the codebase needs hybrid database support and deployment configuration files.

## What Changes

- **BREAKING**: Modify `app/Models/DBAbstractModel.php` to support hybrid connections (PostgreSQL via `DATABASE_URL` or MySQL via individual `.env` variables)
- **BREAKING**: Change database driver from MySQL to PostgreSQL (`pgsql`)
- Create `database_pg.sql` with PostgreSQL syntax (replace `INT AUTO_INCREMENT` with `SERIAL`, adjust data types)
- Create `render.yaml` in project root defining infrastructure (web service with PHP, managed PostgreSQL database)
- Update `composer.json` to require `ext-pdo_pgsql` extension
- Update `.env.example` to include `DB_DRIVER=pgsql` and `DATABASE_URL` example

## Capabilities

### New Capabilities
- `render-deployment`: Configuration files and setup for deploying on Render.com
- `postgresql-support`: PostgreSQL database support with DATABASE_URL parsing

### Modified Capabilities
- `db-singleton`: Update DBAbstractModel to support hybrid MySQL/PostgreSQL connections via DATABASE_URL detection

## Impact

- **Modified files**: `app/Models/DBAbstractModel.php`, `composer.json`, `.env.example`
- **New files**: `database_pg.sql`, `render.yaml`
- **Database change**: MySQL → PostgreSQL (breaking change for local development without adjustments)
- **Dependencies**: Requires `ext-pdo_pgsql` PHP extension
- **Environment**: Render.com standard `DATABASE_URL` environment variable support
