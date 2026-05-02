## MODIFIED Requirements

### Requirement: List all pets
The system SHALL provide a GET endpoint to list all pets with pagination support, accessible via subdirectory URL.

#### Scenario: Get paginated list via subdirectory
- **WHEN** a GET request is made to `/protectora-mascotas-backend/api/mascotas`
- **THEN** the system returns a JSON response with `success: true` and list of pets

### Requirement: All mascotas routes work via subdirectory
The system SHALL ensure all mascotas API routes are accessible via the XAMPP subdirectory URL.

#### Scenario: All routes have corresponding controller actions
- **WHEN** the routes are defined in `public/index.php`
- **THEN** each route handler (index, show, create, update, delete) exists in `MascotasController`
