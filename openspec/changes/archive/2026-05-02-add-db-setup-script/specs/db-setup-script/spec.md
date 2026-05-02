## ADDED Requirements

### Requirement: Database setup script exists
The project SHALL have a `public/setup_db.php` script for initializing PostgreSQL database on Render.com deployment.

#### Scenario: Script requires bootstrap
- **WHEN** `setup_db.php` is accessed
- **THEN** it requires `app/bootstrap.php` to load environment and database connection

#### Scenario: Script reads and executes SQL
- **WHEN** `setup_db.php` runs
- **THEN** it reads `database_pg.sql` and executes it using `DBAbstractModel::getConnection()->exec()`

#### Scenario: Script returns JSON response
- **WHEN** `setup_db.php` completes execution
- **THEN** it returns JSON with success confirmation or error details

#### Scenario: Script accessible via browser
- **WHEN** user accesses `/setup_db.php` URL
- **THEN** the script executes and shows JSON response (no route definition needed)
