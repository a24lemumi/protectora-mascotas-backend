## ADDED Requirements

### Requirement: Router has no setBasePath method
The Router SHALL NOT have `setBasePath()` method or `$basePath` property.

#### Scenario: setBasePath method does not exist
- **WHEN** checking Router.php source code
- **THEN** the `setBasePath()` method is not present

#### Scenario: Router uses paths as-is
- **WHEN** a route is registered with path `/api/mascotas`
- **THEN** the Router matches it directly without basePath normalization
