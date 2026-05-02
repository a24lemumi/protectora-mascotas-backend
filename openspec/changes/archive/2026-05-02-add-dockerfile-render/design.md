## Context

The project is prepared for Render.com deployment with PostgreSQL support and `render.yaml` configuration. To complete the Docker-based deployment setup, a professional Dockerfile is needed that configures PHP 8.2 with Apache web server, PostgreSQL extensions, and proper routing support.

## Goals / Non-Goals

**Goals:**
- Create `Dockerfile` in project root using `php:8.2-apache` base image
- Install PostgreSQL extensions: `libpq-dev`, `pdo`, `pdo_pgsql`
- Enable Apache `mod_rewrite` module for Router functionality
- Configure Apache `DocumentRoot` to point to `/public` directory
- Copy `composer.json` and run `composer install` inside container
- Copy all project code to container and adjust permissions for `logs` and `cache` directories

**Non-Goals:**
- Setting up frontend deployment (separate phase)
- Configuring database migrations in Dockerfile
- Adding development tools or debugging extensions

## Decisions

### 1. Base Image Selection

**Decision**: Use `php:8.2-apache` official Docker image.
**Rationale**: Matches project's PHP 8.2 requirement and includes Apache web server with mod_rewrite capability.

### 2. PostgreSQL Extension Installation

**Decision**: Install `libpq-dev` system package and `pdo`, `pdo_pgsql` PHP extensions.
**Rationale**: Required for PostgreSQL database connectivity as configured in the `prepare-render-deployment` change.

### 3. Apache Configuration

**Decision**: Enable `mod_rewrite` and set `DocumentRoot` to `/var/www/html/public`.
**Rationale**: The project uses a front controller pattern with `public/index.php`, and Router requires URL rewriting.

### 4. Permission Management

**Decision**: Set appropriate permissions for `logs` and `cache` directories (if they exist).
**Rationale**: Apache process needs write access to these directories for error logging and caching.

## Risks / Trade-offs

**[Risk] Image size** → The `php:8.2-apache` image is larger than minimal PHP-FPM setups, but acceptable for managed deployment.

**[Risk] Build time** → Installing extensions adds build time, but this is a one-time cost during deployment.

## Migration Plan

1. Create `Dockerfile` with base image and extension installation
2. Configure Apache with mod_rewrite and DocumentRoot
3. Copy composer.json and install dependencies
4. Copy project code and set permissions
5. Test Docker build locally (if Docker available) or on Render
