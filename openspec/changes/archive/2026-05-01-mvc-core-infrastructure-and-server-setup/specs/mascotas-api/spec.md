## ADDED Requirements

### Requirement: List all pets
The system SHALL provide a GET endpoint to list all pets with pagination support.

#### Scenario: Get paginated list of pets
- **WHEN** a GET request is made to `/api/mascotas` with optional `page` and `limit` query parameters
- **THEN** the system returns a JSON response with `success: true`, list of pets with their associated user data, and pagination metadata

#### Scenario: Include owner information
- **WHEN** a GET request is made to `/api/mascotas`
- **THEN** each pet in the response includes the `nombre`, `email` fields from the associated usuario (if `usuario_id` is set)

### Requirement: Get single pet by ID
The system SHALL provide a GET endpoint to retrieve a single pet by ID.

#### Scenario: Get existing pet
- **WHEN** a GET request is made to `/api/mascotas/{id}` with a valid pet ID
- **THEN** the system returns a JSON response with `success: true` and the pet data including owner information

#### Scenario: Get non-existent pet
- **WHEN** a GET request is made to `/api/mascotas/{id}` with a non-existent pet ID
- **THEN** the system returns a JSON response with `success: false` and HTTP status 404

### Requirement: Create new pet
The system SHALL provide a POST endpoint to create a new pet, associating it with the authenticated user.

#### Scenario: Authenticated user creates pet
- **WHEN** an authenticated user makes a POST request to `/api/mascotas` with required fields (`nombre`, `especie`) and optional fields (`raza`, `fecha_nac`, `imagen`)
- **THEN** the system creates the pet with `usuario_id` set to the authenticated user's ID, returns `success: true`, and HTTP status 201

#### Scenario: Missing required fields
- **WHEN** a POST request is made to `/api/mascotas` without required fields (`nombre`, `especie`)
- **THEN** the system returns a JSON response with `success: false` and HTTP status 400

#### Scenario: Unauthenticated user cannot create pet
- **WHEN** an unauthenticated request is made to POST `/api/mascotas`
- **THEN** the system returns a JSON response with `success: false` and HTTP status 401

### Requirement: Update pet
The system SHALL provide a PUT endpoint to update pet information, restricted to the pet's owner.

#### Scenario: Owner updates pet
- **WHEN** an authenticated user makes a PUT request to `/api/mascotas/{id}` with their own pet (matching `usuario_id`)
- **THEN** the system updates the pet and returns `success: true` with updated pet data

#### Scenario: Non-owner attempts to update pet
- **WHEN** an authenticated user makes a PUT request to `/api/mascotas/{id}` for a pet owned by another user
- **THEN** the system returns a JSON response with `success: false` and HTTP status 403

#### Scenario: Update non-existent pet
- **WHEN** an authenticated user makes a PUT request to `/api/mascotas/{id}` with a non-existent pet ID
- **THEN** the system returns a JSON response with `success: false` and HTTP status 404

### Requirement: Delete pet
The system SHALL provide a DELETE endpoint to delete a pet, restricted to the pet's owner.

#### Scenario: Owner deletes pet
- **WHEN** an authenticated user makes a DELETE request to `/api/mascotas/{id}` with their own pet
- **THEN** the system deletes the pet and returns `success: true` with HTTP status 200

#### Scenario: Non-owner attempts to delete pet
- **WHEN** an authenticated user makes a DELETE request to `/api/mascotas/{id}` for a pet owned by another user
- **THEN** the system returns a JSON response with `success: false` and HTTP status 403

### Requirement: Filter pets by species
The system SHALL allow filtering the list of pets by species using query parameters.

#### Scenario: Filter pets by species
- **WHEN** a GET request is made to `/api/mascotas?especie=perro`
- **THEN** the system returns only pets where `especie` equals `perro`

#### Scenario: Filter pets by multiple criteria
- **WHEN** a GET request is made to `/api/mascotas?especie=gato&raza=Europeo`
- **THEN** the system returns only pets matching both criteria
