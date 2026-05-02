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
