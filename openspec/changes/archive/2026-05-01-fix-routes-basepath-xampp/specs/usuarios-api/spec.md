## MODIFIED Requirements

### Requirement: All usuarios routes work via subdirectory
The system SHALL ensure all usuarios API routes are accessible via the XAMPP subdirectory URL.

#### Scenario: All routes have corresponding controller actions
- **WHEN** the routes are defined in `public/index.php`
- **THEN** each route handler (index, show, create/register, update, delete, login) exists in `UsuariosController`

### Requirement: Login endpoint accessible via subdirectory
The system SHALL provide POST `/api/auth/login` accessible via subdirectory URL.

#### Scenario: Login via subdirectory URL
- **WHEN** a POST request is made to `/protectora-mascotas-backend/api/auth/login`
- **THEN** the system returns a JWT token for valid credentials
