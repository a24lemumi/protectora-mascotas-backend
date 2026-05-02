## 1. Update public/index.php

- [x] 1.1 Remove `GET /api/usuarios` route (index)
- [x] 1.2 Remove `GET /api/usuarios/{id}` route (show)
- [x] 1.3 Remove `POST /api/usuarios/{id}` route with update middleware (update)
- [x] 1.4 Remove `POST /api/usuarios/{id}` route with delete middleware (delete)
- [x] 1.5 Verify only `POST /api/auth/login` and `POST /api/usuarios` (register) remain for usuarios

## 2. Refactor UsuariosController

- [x] 2.1 Remove `index()` method completely
- [x] 2.2 Remove `show($id)` method completely
- [x] 2.3 Remove `update($id)` method completely
- [x] 2.4 Remove `delete($id)` method completely
- [x] 2.5 Remove `use App\Models\UsuariosModel;` if no longer needed
- [x] 2.6 Verify only `register()` and `login()` methods remain

## 3. Testing

- [ ] 3.1 Test `POST /api/auth/login` still works
- [ ] 3.2 Test `POST /api/usuarios` (register) still works
- [ ] 3.3 Verify `GET /api/usuarios` returns 404 (route removed)
- [ ] 3.4 Verify `GET /api/usuarios/{id}` returns 404 (route removed)
- [ ] 3.5 Test mascotas endpoints still work (not affected)
