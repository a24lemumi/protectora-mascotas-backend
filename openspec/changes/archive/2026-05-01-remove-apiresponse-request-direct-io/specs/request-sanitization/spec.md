## MODIFIED Requirements

### Requirement: RequestSanitizer works without Request class
The RequestSanitizer SHALL NOT use `App\Core\Request` class. It validates directly from `$_POST`, `$_GET`, or `json_decode(file_get_contents('php://input'), true)`.

#### Scenario: Validate required fields without Request class
- **WHEN** RequestSanitizer::validateRequired() is called
- **THEN** it reads input directly from `$_POST`, `$_GET`, or `json_decode(file_get_contents('php://input'), true)` instead of Request::json() or Request::post()

### Requirement: No dependency on Request class
The RequestSanitizer SHALL NOT import or use `App\Core\Request`.

#### Scenario: No use of Request class
- **WHEN** checking RequestSanitizer source code
- **THEN** there are no references to `Request` class
