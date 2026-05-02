## MODIFIED Requirements

### Requirement: Update pet via POST with method spoofing (controller-handled)
The system SHALL allow updating pets via POST request with `_method=PUT` in the request body, handled internally by MascotasController.

#### Scenario: Update via POST with _method=PUT detected by controller
- **WHEN** a POST request is sent to `/api/mascotas/{id}` with `_method=PUT` in POST data or JSON body
- **THEN** MascotasController::update() detects the spoofed method and processes it as a PUT request

#### Scenario: Update validates ownership
- **WHEN** an authenticated user sends POST with `_method=PUT` to `/api/mascotas/{id}`
- **THEN** the controller validates that the pet belongs to the authenticated user

### Requirement: Delete pet via POST with method spoofing (controller-handled)
The system SHALL allow deleting pets via POST request with `_method=DELETE` in the request body, handled internally by MascotasController.

#### Scenario: Delete via POST with _method=DELETE detected by controller
- **WHEN** a POST request is sent to `/api/mascotas/{id}` with `_method=DELETE` in POST data or JSON body
- **THEN** MascotasController::delete() detects the spoofed method and processes it as a DELETE request

### Requirement: Router does not handle method spoofing
The Router's `match()` method SHALL NOT check for `_method` field - controllers handle this internally.

#### Scenario: Router match() is method-agnostic
- **WHEN** checking Router's `match()` method implementation
- **THEN** it does not contain logic to detect `_method` in POST data
