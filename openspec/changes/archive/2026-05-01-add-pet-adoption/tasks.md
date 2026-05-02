## 1. Update public/index.php

- [x] 1.1 Add POST route `/api/mascotas/{id}/adopt` with JwtMiddleware in `public/index.php`

## 2. Update MascotasModel

- [x] 2.1 Add static `adoptPet($id, $userId)` method to `MascotasModel`
- [x] 2.2 Method checks if pet exists and `usuario_id` IS NULL
- [x] 2.3 UPDATE mascotas SET `usuario_id` = `$userId` WHERE id = `$id` AND `usuario_id` IS NULL
- [x] 2.4 Return true on success, false if pet not found or already adopted

## 3. Update MascotasController

- [x] 3.1 Add `adopt($id)` method to `MascotasController`
- [x] 3.2 Verify JWT user from `$_SERVER['JWT_USER']`
- [x] 3.3 Call `MascotasModel::adoptPet($id, $userId)`
- [x] 3.4 Return success JSON with http_response_code(200)
- [x] 3.5 Return 404 if pet not found (no rows affected)
- [x] 3.6 Return 400 if pet already adopted (usuario_id not NULL)
- [x] 3.7 Use direct JSON output (no ApiResponse)

## 4. Testing

- [ ] 4.1 Test POST `/api/mascotas/{id}/adopt` with valid JWT adopts pet
- [ ] 4.2 Test POST `/api/mascotas/{id}/adopt` without JWT returns 401
- [ ] 4.3 Test adoption of non-existent pet returns 404
- [ ] 4.4 Test adoption of already adopted pet returns 400
- [ ] 4.5 Verify JSON response format matches direct I/O pattern
