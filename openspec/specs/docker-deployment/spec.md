## ADDED Requirements

### Requirement: Dockerfile exists for Render deployment
The project SHALL have a `Dockerfile` in the root directory configured for Render.com deployment with PHP 8.2 and Apache.

#### Scenario: Dockerfile uses php:8.2-apache
- **WHEN** checking project root for `Dockerfile`
- **THEN** it uses `php:8.2-apache` as the base image

#### Scenario: PostgreSQL extensions installed
- **WHEN** building the Docker image
- **THEN** `libpq-dev`, `pdo`, and `pdo_pgsql` are installed for PostgreSQL support

#### Scenario: Apache mod_rewrite enabled
- **WHEN** Apache runs in the container
- **THEN** `mod_rewrite` is enabled for Router URL rewriting

#### Scenario: DocumentRoot set to /public
- **WHEN** Apache serves the application
- **THEN** the DocumentRoot points to `/var/www/html/public` to match the project structure

### Requirement: Project code copied with proper permissions
The Dockerfile SHALL copy project code and set appropriate permissions for required directories.

#### Scenario: Composer dependencies installed
- **WHEN** building the Docker image
- **THEN** `composer.json` is copied and `composer install` is executed

#### Scenario: Permissions set for logs and cache
- **WHEN** the container starts
- **THEN** `logs` and `cache` directories have appropriate write permissions for Apache process
