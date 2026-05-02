## MODIFIED Requirements

### Requirement: Update user via POST with method spoofing
The system SHALL allow updating users via POST request with `_method=PUT` in the request body.

#### Scenario: Update via POST with _method=PUT
- **WHEN** a POST request is sent to `/api/usuarios/{id}` with `_method=PUT` in POST data
- **THEN** the system processes it as a PUT request and updates the user

#### Scenario: Update validates ownership
- **WHEN** an authenticated user sends POST with `_method=PUT` to `/api/usuarios/{id}`
- **THEN** the system validates that the user can only update their own account

### Requirement: Delete user via POST with method spoofing
The system SHALL allow deleting users via POST request with `_method=DELETE` in the request body.

#### Scenario: Delete via POST with _method=DELETE
- **WHEN** a POST request is sent to `/api/usuarios/{id}` with `_method=DELETE` in POST data
- **THEN** the system processes it as a DELETE request and deletes the user

### Requirement: Routes use POST method
The system SHALL define update and delete routes using `post()` method in Router, not `put()` or `delete()`.

#### Scenario: Routes defined with post() method
- **WHEN** checking route definitions in `public/index.php`
- **THEN** all update/delete routes use `$router->post()` instead of non-existent `put()` or `delete()`
