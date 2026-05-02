## MODIFIED Requirements

### Requirement: CORS middleware works without Request class
The CorsMiddleware SHALL NOT use `App\Core\Request` class for reading headers or origin.

#### Scenario: CORS headers set without Request class
- **WHEN** CorsMiddleware::handle() is executed
- **THEN** it uses `$_SERVER['HTTP_ORIGIN']` directly instead of Request::header()

### Requirement: No dependency on Request class
The CorsMiddleware SHALL NOT import or use `App\Core\Request`.

#### Scenario: No use of Request class
- **WHEN** checking CorsMiddleware source code
- **THEN** there are no references to `Request` class
