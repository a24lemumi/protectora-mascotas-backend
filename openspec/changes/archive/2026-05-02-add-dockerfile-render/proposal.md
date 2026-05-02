## Why

The project has `render.yaml` configured for Docker deployment, but lacks the actual `Dockerfile`. A professional Docker setup with PHP 8.2, Apache, and PostgreSQL support is needed to complete the Render.com deployment pipeline.

## What Changes

- Create `Dockerfile` in project root using `php:8.2-apache` base image
- Install PostgreSQL extensions (`libpq-dev`, `pdo`, `pdo_pgsql`) for database connectivity
- Enable Apache `mod_rewrite` module for Router URL rewriting
- Configure Apache `DocumentRoot` to point to `/public` directory
- Copy `composer.json` and run `composer install` inside container
- Copy all project code to container and adjust permissions for `logs` and `cache` directories

## Capabilities

### New Capabilities
- `docker-deployment`: Dockerfile configuration for Render.com with PHP 8.2, Apache, PostgreSQL support

### Modified Capabilities
(none - this is a new capability addition)

## Impact

- **New file**: `Dockerfile` in project root
- **Dependencies**: Requires `composer.json` with `ext-pdo_pgsql` (already added in previous change)
- **Build requirements**: Docker build environment (handled by Render.com)
- **Runtime**: Apache web server with mod_rewrite, PHP 8.2, PostgreSQL PDO extensions
