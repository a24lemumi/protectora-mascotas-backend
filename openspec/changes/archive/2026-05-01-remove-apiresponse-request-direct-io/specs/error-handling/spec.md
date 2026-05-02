## MODIFIED Requirements

### Requirement: Dispatcher uses direct JSON responses
The Dispatcher SHALL NOT use `App\Core\ApiResponse` for error responses. It uses `header('Content-Type: application/json'); http_response_code(); echo json_encode(); exit;` directly.

#### Scenario: Not found response
- **WHEN** Dispatcher::handleNotFound() is called
- **THEN** it outputs JSON directly with `header('Content-Type: application/json'); http_response_code(404); echo json_encode(['success' => false, 'error' => [...]]); exit;`

#### Scenario: Error response
- **WHEN** Dispatcher::handleError() is called
- **THEN** it outputs JSON directly with appropriate HTTP status code and `exit;`

### Requirement: No dependency on ApiResponse
The Dispatcher SHALL NOT import or use `App\Core\ApiResponse`.

#### Scenario: No use of ApiResponse
- **WHEN** checking Dispatcher source code
- **THEN** there are no references to `ApiResponse` class
