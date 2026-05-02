## Context

The user wants todo add pet adoption functionality. Authenticated users can adopt available pets (those with `usuario_id` = NULL). The adoption process updates the pet's `usuario_id` field to the authenticated user's ID from the JWT token.

## Goals / Non-Goals

**Goals:**
- Add `POST /api/mascotas/{id}/adopt` route in `public/index.php`
- Create `adopt($id)` method in `MascotasController`
- Add `adoptPet($id, $userId)` static method in `MascotasModel`
- Verify pet exists and is available (`usuario_id` IS NULL)
- Update pet's `usuario_id` to the authenticated user's ID
- Return JSON responses using direct I/O pattern

**Non-Goals:**
- Changing existing adoption status (re-adoptions)
- Adding adoption history tracking
- Modifying other CRUD operations

## Decisions**

### 1. Route Design

**Decision**: Use `POST /api/mascotas/{id}/adopt` with JwtMiddleware.

**Rationale**: Follows RESTful conventions for actions on resources. POST is appropriate for the adoption action.

**Alternative considered**: Using PUT on mascotas resource - rejected because adoption is a specific action, not a general update.

### 2. Model Method

**Decision**: Add static `adoptPet($id, $userId)` method to `MascotasModel`.

**Rationale**: Static method keeps the operation self-contained. The method handles the UPDATE query internally.

### 3. Controller Logic

**Decision**: `MascotasController::adopt($id)` verifies JWT user, checks pet availability, calls model.

**Rationale**: Controller handles authorization (is user authenticated?) and business logic (is pet available?).

## Risks / Trade-offs*

**[Risk] Race condition** → Two users adopt same pet simultaneously. Acceptable for MVP.

**[Risk] Pet already adopted** → Return 400 error "Mascot ya adoptada"

## Migration Plan*

1. Add route to `public/index.php`
2. Add `adoptPet()` static method to `MascotasModel`
3. Add `adopt($id)` method to `MascotasController`
4. Test adoption flow
