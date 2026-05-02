## ADDED Requirements

### Requirement: Database connection using Singleton pattern
The system SHALL provide a database connection using the Singleton pattern to ensure only one PDO instance exists.

#### Scenario: Single PDO instance
- **WHEN** multiple calls to the database connection method are made
- **THEN** the same PDO instance is returned for all calls

#### Scenario: Connection uses environment variables
- **WHEN** the database connection is established
- **THEN** it uses `DBHOST`, `DBNAME`, `DBUSER`, `DBPASS` environment variables for configuration

### Requirement: PDO configuration
The system SHALL configure PDO with appropriate options for security and error handling.

#### Scenario: PDO throws exceptions on error
- **WHEN** a database error occurs
- **THEN** PDO throws a PDOException (configured with `ERRMODE_EXCEPTION`)

#### Scenario: PDO uses prepared statements by default
- **WHEN** queries are executed through the PDO instance
- **THEN** the connection supports prepared statements for SQL injection prevention

#### Scenario: Character set is UTF-8
- **WHEN** the database connection is established
- **THEN** the connection uses UTF-8 character set (via `charset=utf8mb4` in DSN)

### Requirement: Connection failure handling
The system SHALL handle database connection failures gracefully and throw a custom DatabaseException.

#### Scenario: Failed connection throws DatabaseException
- **WHEN** the database connection fails (invalid credentials, host unreachable)
- **THEN** the system throws a `App\Exceptions\DatabaseException` with a meaningful message

#### Scenario: Connection error is logged
- **WHEN** a database connection error occurs
- **THEN** the error details are logged to the error log file

### Requirement: DBAbstractModel base class
The system SHALL provide `DBAbstractModel` as a base class for all models, using the Singleton database connection.

#### Scenario: Models extend DBAbstractModel
- **WHEN** a model (e.g., `UsuariosModel`, `MascotasModel`) extends `DBAbstractModel`
- **THEN** the model can use the protected `$db` property to access the PDO instance

#### Scenario: Query execution through model
- **WHEN** a model method executes a database query
- **THEN** it uses prepared statements through the PDO instance from `DBAbstractModel`
