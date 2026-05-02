## Context

The project's authentication endpoints currently use inconsistent routing: the login endpoint is `POST /api/auth/login` (under the `/api/auth/` prefix), while the registration endpoint is `POST /api/usuarios` (under the `/api/` root). This change aligns the registration route with the login route's semantic structure for better API consistency.

## Goals / Non-Goals

**Goals:**
- Rename the registration route from `POST /api/usuarios` to `POST /api/auth/register` in `public/index.php`
- Maintain the existing controller action (`UsuariosController::register`) without modification
- Update the `usuarios-api` specification to reflect the route change

**Non-Goals:**
- Changing the registration logic in `UsuariosController`
- Modifying other usuario-related endpoints (all CRUD endpoints were previously removed)
- Adding new authentication features

## Decisions

### 1. Route Renaming
**Decision**: Change the route path in `public/index.php` from `/api/usuarios` to `/api/auth/register`.
**Rationale**: Aligns with the existing login route (`/api/auth/login`) to group authentication endpoints under a consistent `/api/auth/` prefix.

### 2. No Controller Changes
**Decision**: Keep the controller and method mapping as `[UsuariosController::class, 'register']`.
**Rationale**: The registration logic remains unchanged; only the public route path is modified.

## Risks / Trade-offs

**[Risk] Breaking change for existing clients** → Document the change in the API README.md and notify frontend developers to update their endpoint references.

## Migration Plan

1. Edit `public/index.php` to update the registration route definition
2. Create a delta spec for `usuarios-api` to update the route requirement
3. Test the new route to verify it correctly routes to `UsuariosController::register`
4. Update API documentation (README.md) with the new registration endpoint path
