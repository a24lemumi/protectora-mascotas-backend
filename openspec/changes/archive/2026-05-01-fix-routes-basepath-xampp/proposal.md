## Why

The application is deployed in a XAMPP subdirectory (`/protectora-mascotas-backend`), but the Router's `setBasePath()` is never called in `public/index.php`. Additionally, the route definitions have PHP syntax errors (missing commas in array literals). This causes all API routes to fail when accessed via the subdirectory URL.

## What Changes

- Fix PHP syntax errors in `public/index.php` (missing commas in route definition arrays)
- Call `$router->setBasePath()` in `public/index.php` to set the correct base path for XAMPP subdirectory
- Verify all controller actions referenced in routes exist in their respective controllers
- Ensure `MascotasController` and `UsuariosController` have all required methods for the defined routes
- Update `app/bootstrap.php` to define `BASE_URL` correctly for subdirectory deployment

## Capabilities

### New Capabilities
<!-- No new capabilities -->

### Modified Capabilities
- `mascotas-api`: Verify all routes have corresponding controller actions
- `usuarios-api`: Verify all routes have corresponding controller actions

## Impact

- **Modified files**: `public/index.php`, `app/bootstrap.php`
- **Verification needed**: `app/Controllers/MascotasController.php`, `app/Controllers/UsuariosController.php`
- **Testing**: All API endpoints must work when accessed via `http://localhost/protectora-mascotas-backend/api/...`
