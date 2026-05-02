## MODIFIED Requirements

### Requirement: MascotasController uses MascotaForm
The MascotasController SHALL use `MascotaForm` for create and update operations.

#### Scenario: Create uses MascotaForm
- **WHEN** `MascotasController::create()` processes request
- **THEN** it uses `MascotaForm` to validate and sanitize mascota data

#### Scenario: Update uses MascotaForm
- **WHEN** `MascotasController::update()` processes request
- **THEN** it uses `MascotaForm` to validate and sanitize mascota data

### Requirement: No manual validation in MascotasController
The MascotasController SHALL NOT have manual field validation logic.

#### Scenario: No manual field checking
- **WHEN** checking MascotasController source code
- **THEN** there are no manual `isset()` or `trim()` checks for required fields like 'nombre', 'especie'
