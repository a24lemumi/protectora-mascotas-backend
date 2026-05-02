## ADDED Requirements

### Requirement: Standardized JSON response format
The system SHALL return all API responses in a consistent JSON format using ApiResponse class.

#### Scenario: Success response format
- **WHEN** an API request completes successfully
- **THEN** the response has format `{"success": true, "data": {...}, "message": "...", "timestamp": "..."}` with appropriate HTTP status code

#### Scenario: Error response format
- **WHEN** an API request fails with an error
- **THEN** the response has format `{"success": false, "error": {"code": "...", "message": "..."}, "timestamp": "..."}` with appropriate HTTP status code

### Requirement: HTTP status codes
The system SHALL use appropriate HTTP status codes for different response types.

#### Scenario: 200 for successful GET
- **WHEN** a GET request fetches data successfully
- **THEN** the response has HTTP status 200

#### Scenario: 201 for successful creation
- **WHEN** a POST request creates a new resource successfully
- **THEN** the response has HTTP status 201

#### Scenario: 404 for resource not found
- **WHEN** a request targets a non-existent resource
- **THEN** the response has HTTP status 404 with error message

#### Scenario: 400 for validation error
- **WHEN** a request contains invalid data or missing required fields
- **THEN** the response has HTTP status 400 with validation error details

#### Scenario: 401 for unauthorized access
- **WHEN** a request lacks valid authentication
- **THEN** the response has HTTP status 401 with authentication error message

#### Scenario: 500 for server errors
- **WHEN** an unexpected error occurs during request processing
- **THEN** the response has HTTP status 500 with generic error message (no internal details exposed)

### Requirement: Timestamp in responses
The system SHALL include an ISO 8601 timestamp in all API responses.

#### Scenario: Timestamp present in success response
- **WHEN** any successful API request completes
- **THEN** the response JSON includes a `timestamp` field in ISO 8601 format

#### Scenario: Timestamp present in error response
- **WHEN** any failed API request completes
- **THEN** the response JSON includes a `timestamp` field in ISO 8601 format
