## Context

The application runs on XAMPP in subdirectory `/protectora-mascotas-backend`. The Router class has `setBasePath()` method but it's not being called. Additionally, `public/index.php` has PHP syntax errors (missing commas in array literals for route definitions). The controllers may be missing some action methods that are referenced in routes.

## Goals / Non-Goals

**Goals:**
- Fix PHP syntax errors in `public/index.php` route definitions
- Configure Router's `setBasePath()` to handle XAMPP subdirectory correctly
- Verify all controller actions exist for each route
- Ensure API works via `http://localhost/protectora-mascotas-backend/api/...`

**Non-Goals:**
- Changing the routing architecture
- Adding new endpoints
- Modifying middleware logic

## Decisions

### 1. BasePath Configuration

**Decision**: Call `$router->setBasePath('/protectora-mascotas-backend')` in `public/index.php`.

**Rationale**: The Router already has `setBasePath()` method that strips the prefix from URLs before matching. This is the correct approach for subdirectory deployment.

**Alternative considered**: Modifying `.htaccess` or virtual host config - rejected because the Router already supports this via `setBasePath()`.

### 2. Fixing Route Definition Syntax

**Decision**: Add missing commas in array literals in `public/index.php`.

**Rationale**: PHP requires commas between array elements. The current code has syntax like `[UsuariosController::class, 'login']` missing the comma.

### 3. Controller Action Verification

**Decision**: Check each route's handler against controller methods and add missing methods.

**Rationale**: Routes reference `index`, `show`, `create`, `update`, `delete`, `login`, `register`, `health` actions. All should exist in the respective controllers.

## Risks / Trade-offs

**[Risk] BasePath mismatch** → Use `dirname($_SERVER['SCRIPT_NAME'])` to dynamically detect subdirectory path

**[Risk] Breaking existing routes** → Test all endpoints after fix

## Migration Plan

1. Fix syntax errors in `public/index.php`
2. Add `$router->setBasePath('/protectora-mascotas-backend')`
3. Verify all controller methods exist
4. Test endpoints via browser/curl
