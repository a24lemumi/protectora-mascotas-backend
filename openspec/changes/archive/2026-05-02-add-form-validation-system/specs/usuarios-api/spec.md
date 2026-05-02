## MODIFIED Requirements

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
