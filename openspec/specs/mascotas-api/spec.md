## MODIFIED Requirements

### Requirement: MascotasController uses direct I/O
The MascotasController SHALL NOT use `App\Core\ApiResponse` or `App\Core\Request`. All input reading uses `json_decode(file_get_contents('php://input'), true)` or `$_POST`. All responses use `header('Content-Type: application/json'); http_response_code(); echo json_encode(); exit;`.

#### Scenario: Read input directly
- **WHEN** MascotasController::create(), update(), delete(), or adoptar() reads request data
- **THEN** it uses `json_decode(file_get_contents('php://input'), true)` or `$_POST` directly

#### Scenario: Output JSON directly
- **WHEN** MascotasController sends a response (success or error)
- **THEN** it uses `header('Content-Type: application/json'); http_response_code(); echo json_encode([...]); exit;`

### Requirement: No dependency on wrapper classes
The MascotasController SHALL NOT import or use `App\Core\ApiResponse` or `App\Core\Request`.

#### Scenario: No use of ApiResponse or Request
- **WHEN** checking MascotasController source code
- **THEN** there are no references to `ApiResponse` or `Request` classes

### Requirement: MascotasController has adoption method
The MascotasController SHALL have an `adoptar($id)` method to handle pet adoption.

#### Scenario: Adopt method exists
- **WHEN** checking MascotasController source code
- **THEN** there is a public function `adoptar($id)` that handles the adoption logic

#### Scenario: Adopt uses direct I/O
- **WHEN** `adoptar($id)` executes
- **THEN** it uses `header('Content-Type: application/json'); http_response_code(); echo json_encode(); exit;` pattern
