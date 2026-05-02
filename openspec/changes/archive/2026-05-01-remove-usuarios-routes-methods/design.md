## Context

The user wants to simplify the API by removing all usuario CRUD operations (index, show, update, delete) from both the routes and the controller. Only authentication endpoints (login, register) should remain in `UsuariosController`. This keeps the code clean and focused on authentication-only functionality for users.

## Goals / Non-Goals

**Goals:**
- Remove usuario protected routes (index, show, update, delete) from `public/index.php`
- Keep usuario public routes (login, register) in `public/index.php`
- Remove corresponding methods (index, show, update, delete) from `UsuariosController.php`
- Keep `register()` and `login()` methods in controller
- Clean up unused imports in `UsuariosController.php`

**Non-Goals:**
- Removing JWT middleware (still needed for other endpoints)
- Modifying mascotas endpoints
- Changing database layer

## Decisions**

### 1. Route Removal Strategy

**Decision**: Remove 4 route definitions from `public/index.php` (2 GET, 2 POST for index/show/update/delete).

**Rationale**: User explicitly requested removal of protected usuario routes. Only login/register are needed.

**Alternative considered**: Commenting out routes - rejected because user wants clean code removal.

### 2. Controller Method Removal

**Decision**: Remove `index()`, `show()`, `update()`, `delete()` methods from `UsuariosController`.

**Rationale**: If routes are removed, corresponding controller methods are dead code.

### 3. Import Cleanup

**Decision**: Remove `use App\Models\UsuariosModel;` if no longer needed (check if register/login use it).

**Rationale**: Dead imports should be removed for clean code.

## Risks / Trade-offs

**[Risk] Breaking frontend clients** → Document that usuario CRUD endpoints are no longer available

**[Risk] Orphaned code** → Ensure all 4 methods are completely removed

## Migration Plan

1. Edit `public/index.php` - remove 4 usuario protected routes
2. Edit `app/Controllers/UsuariosController.php` - remove 4 methods
3. Clean up imports in UsuariosController
4. Test that login and register still work
