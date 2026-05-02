## ADDED Requirements

### Requirement: Adopt available pet
The system SHALL allow authenticated users to adopt available pets (those with `usuario_id` = NULL). The adoption updates the pet's `usuario_id` to the authenticated user's ID.

#### Scenario: Successful adoption
- **WHEN** an authenticated user sends POST to `/api/mascotas/{id}/adopt`
- **THEN** the system sets `usuario_id` = user's ID and returns success JSON

#### Scenario: Pet not found
- **WHEN** an authenticated user tries to adopt non-existent pet
- **THEN** the system returns 404 JSON error

#### Scenario: Pet already adopted
- **WHEN** an authenticated user tries to adopt a pet with `usuario_id` != NULL
- **THEN** the system returns 400 JSON error "Mascota ya adoptada"

### Requirement: Adoption route exists
The system SHALL have a protected POST route `/api/mascotas/{id}/adopt` with JwtMiddleware.

#### Scenario: Route registered in index.php
- **WHEN** checking `public/index.php` route definitions
- **THEN** there is a POST route `/api/mascotas/{id}/adopt` with JwtMiddleware
