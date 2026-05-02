## MODIFIED Requirements

### Requirement: Update pet via POST with method spoofing
The system SHALL allow updating pets via POST request with `_method=PUT` in the request body.

#### Scenario: Update via POST with _method=PUT
- **WHEN** a POST request is sent to `/api/mascotas/{id}` with `_method=PUT` in POST data
- **THEN** the system processes it as a PUT request and updates the pet

#### Scenario: Update validates ownership
- **WHEN** an authenticated user sends POST with `_method=PUT` to `/api/mascotas/{id}`
- **THEN** the system validates that the pet belongs to the authenticated user

### Requirement: Delete pet via POST with method spoofing
The system SHALL allow deleting pets via POST request with `_method=DELETE` in the request body.

#### Scenario: Delete via POST with _method=DELETE
- **WHEN** a POST request is sent to `/api/mascotas/{id}` with `_method=DELETE` in POST data
- **THEN** the system processes it as a DELETE request and deletes the pet

### Requirement: Routes use POST method
The system SHALL define update and delete routes using `post()` method in Router, not `put()` or `delete()`.

#### Scenario: Routes defined with post() method
- **WHEN** checking route definitions in `public/index.php`
- **THEN** all update/delete routes use `$router->post()` instead of non-existent `put()` or `delete()`
