## ADDED Requirements

### Requirement: Global exception handling
The system SHALL catch and handle all uncaught exceptions globally, returning structured JSON error responses.

#### Scenario: Uncaught exception returns JSON error
- **WHEN** an uncaught exception occurs during request processing
- **THEN** the system catches the exception and returns a JSON response with `success: false`, appropriate error code, and HTTP status 500

#### Scenario: Database exception handling
- **WHEN** a database error occurs (connection failure, query error)
- **THEN** the system catches the DatabaseException and returns a JSON response with `success: false` and HTTP status 500 (without exposing database credentials)

### Requirement: Not found handling
The system SHALL return a structured JSON response for routes that don't match.

#### Scenario: Non-existent route returns 404
- **WHEN** a request is made to a route that doesn't exist (no matching route in Router)
- **THEN** the system returns a JSON response with `success: false`, error code `ROUTE_NOT_FOUND`, and HTTP status 404

### Requirement: Validation error responses
The system SHALL return structured JSON responses for validation failures with specific error details.

#### Scenario: Validation errors include field details
- **WHEN** a request fails validation (missing required fields, invalid data)
- **THEN** the system returns a JSON response with `success: false`, error code `VALIDATION_ERROR`, HTTP status 400, and details about which fields failed

### Requirement: Error logging
The system SHALL log all errors to the configured error log file while not exposing internal details to the client.

#### Scenario: Errors are logged to file
- **WHEN** any error occurs during request processing
- **THEN** the error details (message, file, line, trace) are written to the log file at `APP_ROOT/logs/php_errors.log`

#### Scenario: Error details not exposed to client
- **WHEN** a server error (500) occurs in production mode (`APP_ENV=production`)
- **THEN** the JSON response contains a generic error message without internal details (file paths, stack traces)

### Requirement: HTTP method not allowed
The system SHALL return appropriate error when using wrong HTTP method on existing route.

#### Scenario: Wrong HTTP method returns 405
- **WHEN** a request uses an HTTP method not allowed for a route (e.g., POST to `/api/mascotas/{id}` which only accepts GET, PUT, DELETE)
- **THEN** the system returns a JSON response with `success: false`, error code `METHOD_NOT_ALLOWED`, and HTTP status 405
