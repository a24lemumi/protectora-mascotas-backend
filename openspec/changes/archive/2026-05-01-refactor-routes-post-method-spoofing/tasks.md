## 1. Update Routes in public/index.php

- [x] 1.1 Remove all `put()` and `delete()` calls from `public/index.php`
- [x] 1.2 Change update routes to use `post()` instead: `/api/mascotas/{id}` and `/api/usuarios/{id}`
- [x] 1.3 Change delete routes to use `post()` instead: `/api/mascotas/{id}` and `/api/usuarios/{id}`
- [x] 1.4 Keep GET routes unchanged (index, show endpoints)

## 2. Implement Method Spoofing in Router

- [x] 2.1 Modify `Router::match()` to check for `_method` field in POST data
- [x] 2.2 If `_method=PUT` or `_method=DELETE` in POST, override the HTTP method for route matching
- [x] 2.3 Ensure only POST requests can be spoofed (not GET requests)

## 3. Refactor MascotasController

- [x] 3.1 Modify `update($id)` to handle POST requests with `_method=PUT`
- [x] 3.2 Modify `delete($id)` to handle POST requests with `_method=DELETE`
- [x] 3.3 Check for `_method` field in Request object to determine actual intent

## 4. Refactor UsuariosController

- [x] 4.1 Modify `update($id)` to handle POST requests with `_method=PUT`
- [x] 4.2 Modify `delete($id)` to handle POST requests with `_method=DELETE`
- [x] 4.3 Check for `_method` field in Request object to determine actual intent

## 5. Testing

- [ ] 5.1 Test POST to `/api/mascotas/{id}` with `_method=PUT` updates pet
- [ ] 5.2 Test POST to `/api/mascotas/{id}` with `_method=DELETE` deletes pet
- [ ] 5.3 Test POST to `/api/usuarios/{id}` with `_method=PUT` updates user
- [ ] 5.4 Test POST to `/api/usuarios/{id}` with `_method=DELETE` deletes user
- [ ] 5.5 Verify protected endpoints still require JWT with spoofed methods
