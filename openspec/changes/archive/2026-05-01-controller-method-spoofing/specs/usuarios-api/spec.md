## MODIFIED Requirements

### Requirement: Update user via POST with method spoofing (controller-handled)
The system SHALL allow updating users via POST request with `_method=PUT` in the request body, handled internally by UsuariosController.

#### Scenario: Update via POST with _method=PUT detected by controller
- **WHEN** a POST request is sent to `/api/usuarios/{id}` with `_method=PUT` in POST data or JSON body
- **THEN** UsuariosController::update() detects the spoofed method and processes it as a PUT request

#### Scenario: Update validates ownership
- **WHEN** an authenticated user sends POST with `_method=PUT` to `/api/usuarios/{id}`
- **THEN** the controller validates that the user can only update their own account

### Requirement: Delete user via POST with method spoofing (controller-handled)
The system SHALL allow deleting users via POST request with `_method=DELETE` in the request body, handled internally by UsuariosController.

#### Scenario: Delete via POST with _method=DELETE detected by controller
- **WHEN** a POST request is sent to `/api/usuarios/{id}` with `_method=DELETE` in POST data or JSON body
- **THEN** UsuariosController::delete() detects the spoofed method and processes it as a DELETE request

### Requirement: Router does not handle method spoofing
The Router's `match()` method SHALL NOT check for `_method` field - controllers handle this internally.

#### Scenario: Router match() is method-agnostic
- **WHEN** checking Router's `match()` method implementation
- **THEN** it does not contain logic to detect `_method` in POST data
