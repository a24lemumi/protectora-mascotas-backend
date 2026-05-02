## 1. Fix Route Syntax and BasePath

- [x] 1.1 Fix PHP syntax errors in `public/index.php` - add missing commas in route arrays
- [x] 1.2 Add `$router->setBasePath('/protectora-mascotas-backend')` call in `public/index.php`
- [x] 1.3 Verify Router's `cleanUri()` correctly strips the base path

## 2. Verify Controller Actions

- [x] 2.1 Verify `MascotasController` has all required methods: index, show, create, update, delete, health
- [x] 2.2 Verify `UsuariosController` has all required methods: index, show, update, delete, register, login
- [x] 2.3 Add any missing controller methods or fix route references

## 3. Update Bootstrap for Subdirectory

- [x] 3.1 Verify `BASE_URL` is correctly set in `app/bootstrap.php` for subdirectory `/protectora-mascotas-backend`
- [ ] 3.2 Test that all endpoints are accessible via the subdirectory URL

## 4. Testing

- [ ] 4.1 Test GET `/protectora-mascotas-backend/api/mascotas` returns data
- [ ] 4.2 Test POST `/protectora-mascotas-backend/api/auth/login` returns token
- [ ] 4.3 Test protected endpoints with JWT token via subdirectory URL
