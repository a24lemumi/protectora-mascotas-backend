## 1. Rename registration route

- [x] 1.1 Update `public/index.php` to change the registration route from `POST /api/usuarios` to `POST /api/auth/register`
- [x] 1.2 Keep the controller mapping as `[UsuariosController::class, 'register']`
- [x] 1.3 Verify the route correctly dispatches to `UsuariosController::register()`

## 2. Update Documentation

- [x] 2.1 Update `README.md` to document the new registration endpoint `POST /api/auth/register`
- [x] 2.2 Verify the old endpoint `POST /api/usuarios` returns 404 Not Found

## 3. Testing

- [x] 3.1 Test `POST /api/auth/register` correctly creates a new user (same behavior as before)
- [x] 3.2 Test `POST /api/usuarios` returns 404 Not Found
- [x] 3.3 Verify `POST /api/auth/login` still works (no regression)
