## 1. Create Dockerfile with base image and extensions

- [x] 1.1 Create `Dockerfile` in project root
- [x] 1.2 Use `php:8.2-apache` as base image
- [x] 1.3 Install `libpq-dev` system package for PostgreSQL support
- [x] 1.4 Install `pdo` and `pdo_pgsql` PHP extensions via `docker-php-ext-install`
- [x] 1.5 Verify extensions are loaded in PHP configuration

## 2. Configure Apache web server

- [x] 2.1 Enable Apache `mod_rewrite` module for Router functionality
- [x] 2.2 Set Apache `DocumentRoot` to `/var/www/html/public`
- [x] 2.3 Configure Apache to allow `.htaccess` overrides (if needed)

## 3. Copy and install project dependencies

- [x] 3.1 Copy `composer.json` to container working directory
- [x] 3.2 Run `composer install --no-dev --optimize-autoloader` inside container
- [x] 3.3 Copy all project code to `/var/www/html/` in container

## 4. Set permissions and final configuration

- [x] 4.1 Create `logs` and `cache` directories if they don't exist
- [x] 4.2 Set appropriate permissions (chmod 755 or 777) for `logs` and `cache` directories
- [x] 4.3 Set working directory to `/var/www/html`

## 5. Testing

- [ ] 5.1 Test Docker build completes without errors
- [ ] 5.2 Test Apache serves `public/index.php` correctly
- [ ] 5.3 Test PostgreSQL connection works inside container (if DATABASE_URL provided)
- [ ] 5.4 Verify mod_rewrite works with Router (test a protected route)
