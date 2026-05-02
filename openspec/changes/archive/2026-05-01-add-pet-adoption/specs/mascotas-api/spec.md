## MODIFIED Requirements

### Requirement: MascotasController has adoption method
The MascotasController SHALL have an `adopt($id)` method to handle pet adoption.

#### Scenario: Adopt method exists
- **WHEN** checking MascotasController source code
- **THEN** there is a public function `adopt($id)` that handles the adoption logic

#### Scenario: Adopt uses direct I/O
- **WHEN** `adopt($id)` executes
- **THEN** it uses `header('Content-Type: application/json'); http_response_code(); echo json_encode(); exit;` pattern
