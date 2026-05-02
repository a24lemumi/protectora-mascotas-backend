## MODIFIED Requirements

### Requirement: Usuarios API simplified to authentication-only
The `UsuariosController` SHALL only provide authentication endpoints (login, register). All CRUD operations (index, show, update, delete) are removed.

#### Scenario: Only login and register routes exist
- **WHEN** checking `public/index.php` route definitions
- **THEN** only `POST /api/auth/login` and `POST /api/usuarios` (register) routes exist for usuarios

#### Scenario: UsuariosController has only login and register methods
- **WHEN** checking `UsuariosController.php` source code
- **THEN** only `login()` and `register()` methods exist (no index, show, update, delete)

### Requirement: No usuario CRUD endpoints
The system SHALL NOT provide CRUD endpoints for usuarios (index, show, update, delete).

#### Scenario: No usuario protected routes
- **WHEN** a request is made to `/api/usuarios` or `/api/usuarios/{id}`
- **THEN** the system returns 404 Not Found (route does not exist)

### Requirement: UsuariosController uses UsuarioForm
The UsuariosController SHALL use `UsuarioForm` for login and register operations.

#### Scenario: Login uses UsuarioForm
- **WHEN** `UsuariosController::login()` processes request
- **THEN** it uses `UsuarioForm` to validate and sanitize login data

#### Scenario: Register uses UsuarioForm
- **WHEN** `UsuariosController::register()` processes request
- **THEN** it uses `UsuarioForm` to validate and sanitize registration data

### Requirement: No manual validation in UsuariosController
The UsuariosController SHALL NOT have manual field validation logic.

#### Scenario: No manual field checking
- **WHEN** checking UsuariosController source code
- **THEN** there are no manual `isset()` or `trim()` checks for required fields
