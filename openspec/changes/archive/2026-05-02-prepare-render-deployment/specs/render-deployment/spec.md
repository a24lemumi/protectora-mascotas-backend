## ADDED Requirements

### Requirement: Render deployment configuration exists
The project SHALL have a `render.yaml` file in the root defining the infrastructure for Render.com deployment.

#### Scenario: render.yaml exists
- **WHEN** checking project root directory
- **THEN** there is a `render.yaml` file with web service and PostgreSQL database definitions

#### Scenario: Web service configuration
- **WHEN** checking `render.yaml` content
- **THEN** it defines a web service with PHP, Document Root `/public`, and required environment variables

#### Scenario: PostgreSQL database defined
- **WHEN** checking `render.yaml` content
- **THEN** it defines a managed PostgreSQL database service

### Requirement: PostgreSQL database support
The system SHALL support PostgreSQL as the database backend with appropriate PDO driver (`pgsql`).

#### Scenario: PDO pgsql driver
- **WHEN** connecting to database with `pgsql` driver
- **THEN** the connection succeeds using PostgreSQL-compatible SQL

#### Scenario: DATABASE_URL parsing
- **WHEN** `DATABASE_URL` environment variable is present (Render standard)
- **THEN** the system parses it and extracts host, port, user, pass, dbname for PDO connection
