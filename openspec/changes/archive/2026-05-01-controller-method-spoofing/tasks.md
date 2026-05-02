## 1. Revert Router Method Spoofing

- [x] 1.1 Remove method spoofing logic from Router's `match()` method
- [x] 1.2 Ensure Router's `match()` only matches routes based on actual HTTP method
- [x] 1.3 Verify Router no longer checks for `_method` field

## 2. Refactor MascotasController

- [x] 2.1 Modify `MascotasController::update()` to check Request for `_method=PUT`
- [x] 2.2 Modify `MascotasController::delete()` to check Request for `_method=DELETE`
- [x] 2.3 Use `Request::post()` or `Request::json()` to detect `_method` field in POST body or JSON
- [x] 2.4 Log or handle case where `_method` is missing in POST request to update/delete routes

## 3. Refactor UsuariosController

- [x] 3.1 Modify `UsuariosController::update()` to check Request for `_method=PUT`
- [x] 3.2 Modify `UsuariosController::delete()` to check Request for `_method=DELETE`
- [x] 3.3 Use `Request::post()` or `Request::json()` to detect `_method` field in POST body or JSON
- [x] 3.4 Log or handle case where `_method` is missing in POST request to update/delete routes

## 4. Testing

- [ ] 4.1 Test POST to `/api/mascotas/{id}` with `_method=PUT` updates pet (controller detects it)
- [ ] 4.2 Test POST to `/api/mascotas/{id}` with `_method=DELETE` deletes pet (controller detects it)
- [ ] 4.3 Test POST to `/api/usuarios/{id}` with `_method=PUT` updates user (controller detects it)
- [ ] 4.4 Test POST to `/api/usuarios/{id}` with `_method=DELETE` deletes user (controller detects it)
- [x] 4.5 Verify Router's `match()` does NOT have `_method` detection logic
- [ ] 4.6 Verify protected endpoints still require JWT with spoofed methods
