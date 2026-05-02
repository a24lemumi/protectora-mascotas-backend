## Why

The project is prepared for Render.com deployment with PostgreSQL support and Docker configuration. However, there's no easy way to initialize the PostgreSQL database on Render. A temporary setup script accessible via browser will allow one-click database initialization during deployment.

## What Changes

- Create `public/setup_db.php` that initializes PostgreSQL database from `database_pg.sql`
- Require `app/bootstrap.php` to load environment and database connection
- Get PDO instance from `DBAbstractModel` and execute the SQL file
- Return JSON response confirming success or showing error
- Script serves as temporary database initialization tool accessible via web browser

## Capabilities

### New Capabilities
- `db-setup-script`: Temporary database setup script for Render.com deployment initialization

### Modified Capabilities
(none - this is a new capability)

## Impact

- **New file**: `public/setup_db.php`
- **Dependencies**: Requires `app/bootstrap.php`, `database_pg.sql`, `DBAbstractModel.php`
- **Security risk**: Script should be deleted after use (or protected with secret key)
- **Database**: Executes `database_pg.sql` which DROPS and recreates database/tables
- **No route definition needed**: Direct file access via `/setup_db.php` URL
