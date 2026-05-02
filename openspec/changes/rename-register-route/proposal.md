## Why

The current user registration route is `POST /api/usuarios`, while the login route is `POST /api/auth/login`. This creates semantic inconsistency in the API's authentication endpoint naming. Aligning the registration route under the `/api/auth/` prefix improves API clarity and consistency.

## What Changes

- Modify the user registration route in `public/index.php` from `POST /api/usuarios` to `POST /api/auth/register`
- Keep the target controller and method as `[UsuariosController::class, 'register']` (no controller changes)
- Update the `usuarios-api` specification to reflect the new route path

## Capabilities

### New Capabilities
(none)

### Modified Capabilities
- `usuarios-api`: Update the register route path requirement from `/api/usuarios` to `/api/auth/register`

## Impact

- **Modified files**: `public/index.php`
- **No database changes**
- **Breaking change**: Existing API clients using `POST /api/usuarios` for registration will receive 404 Not Found errors. Frontend integration must be updated to use the new route.
- **No new dependencies**
