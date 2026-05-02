## MODIFIED Requirements

### Requirement: JWT middleware uses direct JSON responses
The JwtMiddleware SHALL use `header('Content-Type: application/json'); http_response_code(); echo json_encode(); exit;` instead of ApiResponse class.

#### Scenario: Token missing response
- **WHEN** a request lacks Authorization header
- **THEN** JwtMiddleware outputs JSON directly with `header('Content-Type: application/json'); http_response_code(401); echo json_encode(['success' => false, 'error' => [...]])`

#### Scenario: Invalid token response
- **WHEN** a request has invalid/expired JWT token
- **THEN** JwtMiddleware outputs JSON directly with `exit;` after echo

### Requirement: No dependency on ApiResponse or Request classes
The JwtMiddleware SHALL NOT import or use `App\Core\ApiResponse` or `App\Core\Request`.

#### Scenario: No use of ApiResponse
- **WHEN** checking JwtMiddleware source code
- **THEN** there are no references to `ApiResponse` or `Request` classes
