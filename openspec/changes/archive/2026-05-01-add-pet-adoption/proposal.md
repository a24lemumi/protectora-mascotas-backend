## Why

The user wants to add the ability for authenticated users to adopt available pets. A pet is available if its `usuario_id` is NULL. When a user adopts a pet, the system should update the pet's `usuario_id` to the authenticated user's ID.

## What Changes

- Add protected route `POST /api/mascotas/{id}/adopt` in `public/index.php` with JwtMiddleware
- Create `adopt($id)` method in `MascotasController`:
  - Verify the pet exists
  - Verify the pet has `usuario_id` = NULL (available for adoption)
  - Update the pet setting `usuario_id` to the authenticated user's ID from `$_SERVER['JWT_USER']['user_id']`
  - Return appropriate JSON response (success/error)
- Add `adoptPet($id, $userId)` method in `MascotasModel` to perform the UPDATE
- Return JSON responses using `header('Content-Type: application/json'); http_response_code(); echo json_encode(); exit;`

## Capabilities

### New Capabilities
- `pet-adoption`: Allow authenticated users to adopt available pets (usuario_id = NULL)

### Modified Capabilities
- `mascotas-api`: Add adoption endpoint to MascotasController

## Impact

- **New/Modified files**: `public/index.php`, `app/Controllers/MascotasController.php`, `app/Models/MascotasModel.php`
- **New protected route**: `POST /api/mascotas/{id}/adopt` (requires JWT)
- **Database change**: UPDATE on mascotas table (set usuario_id)
- **No schema changes**: Uses existing mascotas table
- **Testing required**: Test adoption flow, error cases (already adopted, not found)
