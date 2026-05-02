## Why

The user wants to simplify the codebase by removing all usuario-related protected routes (index, show, update, delete) from `public/index.php`, keeping only `login` and `register` routes. Additionally, remove the corresponding methods (index, show, update, delete) from `UsuariosController.php` to keep the code clean.

## What Changes

- Remove usuario protected routes from `public/index.php`:
  - Remove: `GET /api/usuarios` (index)
  - Remove: `GET /api/usuarios/{id}` (show)  
  - Remove: `POST /api/usuarios/{id}` with update middleware (update)
  - Remove: `POST /api/usuarios/{id}` with delete middleware (delete)
- Keep usuario public routes:
  - Keep: `POST /api/auth/login` (login)
  - Keep: `POST /api/usuarios` (register)
- Remove methods from `UsuariosController.php`:
  - Remove: `index()` method
  - Remove: `show($id)` method
  - Remove: `update($id)` method
  - Remove: `delete($id)` method
- Keep methods in `UsuariosController.php`:
  - Keep: `register()` method
  - Keep: `login()` method
- Remove related imports if no longer needed

## Capabilities

### New Capabilities
<!-- No new capabilities -->

### Modified Capabilities
- `usuarios-api`: Simplified to only login and register endpoints (no CRUD operations)

## Impact

- **Modified files**: `public/index.php`, `app/Controllers/UsuariosController.php`
- **Breaking change**: All usuario CRUD endpoints removed (index, show, update, delete)
- **No database changes**
- **No middleware changes** (JwtMiddleware, CorsMiddleware stay)
- **Testing required**: Verify only login and register endpoints work
