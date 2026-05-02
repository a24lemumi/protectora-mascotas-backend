## MODIFIED Requirements

### Requirement: DB Singleton supports hybrid connections
The `DBAbstractModel` SHALL support both PostgreSQL (via `DATABASE_URL` environment variable) and MySQL (via individual `.env` variables).

#### Scenario: DATABASE_URL present (Render deployment)
- **WHEN** `DBAbstractModel::__construct()` runs with `DATABASE_URL` set
- **THEN** it parses the URL and uses `pgsql:` driver for PDO connection

#### Scenario: Individual .env variables (local development)
- **WHEN** `DBAbstractModel::__construct()` runs without `DATABASE_URL` but with `DBHOST`, `DBUSER`, etc.
- **THEN** it uses `pgsql:` driver with individual variables (or `mysql:` if configured)

#### Scenario: Connection established
- **WHEN** `getConnection()` is called
- **THEN** it returns a PDO instance connected to the appropriate database
