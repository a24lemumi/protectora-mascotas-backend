## ADDED Requirements

### Requirement: PostgreSQL SQL syntax file exists
The project SHALL have a `database_pg.sql` file with PostgreSQL-compatible SQL syntax.

#### Scenario: database_pg.sql exists
- **WHEN** checking project root directory
- **THEN** there is a `database_pg.sql` file with PostgreSQL syntax

#### Scenario: SERIAL instead of AUTO_INCREMENT
- **WHEN** checking `database_pg.sql` table definitions
- **THEN** primary keys use `SERIAL PRIMARY KEY` instead of `INT AUTO_INCREMENT PRIMARY KEY`

#### Scenario: Compatible data types
- **WHEN** checking `database_pg.sql` column definitions
- **THEN** data types use PostgreSQL equivalents (e.g., `VARCHAR` is compatible, `TIMESTAMP` is compatible)
