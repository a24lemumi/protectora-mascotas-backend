## ADDED Requirements

### Requirement: JWT token generation on login
The system SHALL generate a JWT token when valid credentials are provided to the login endpoint.

#### Scenario: Successful login generates token
- **WHEN** a POST request is sent to `/api/auth/login` with valid email and password
- **THEN** the system returns a JSON response with `success: true` and a `token` field containing a valid JWT

#### Scenario: Invalid credentials return error
- **WHEN** a POST request is sent to `/api/auth/login` with invalid email or password
- **THEN** the system returns a JSON response with `success: false` and HTTP status 401

### Requirement: JWT token validation middleware
The system SHALL validate JWT tokens on protected endpoints using JwtMiddleware.

#### Scenario: Valid token allows access
- **WHEN** a request is made to a protected endpoint with a valid JWT in the Authorization header
- **THEN** the request proceeds to the controller and `user_id` is available in the request context

#### Scenario: Missing token returns 401
- **WHEN** a request is made to a protected endpoint without an Authorization header
- **THEN** the system returns a JSON response with `success: false` and HTTP status 401

#### Scenario: Invalid token returns 401
- **WHEN** a request is made to a protected endpoint with an invalid or expired JWT
- **THEN** the system returns a JSON response with `success: false` and HTTP status 401

### Requirement: JWT token structure
The system SHALL include `user_id`, `email`, and `exp` (expiration) claims in the JWT payload.

#### Scenario: Token contains required claims
- **WHEN** a JWT is generated during login
- **THEN** the decoded token contains `user_id`, `email`, and `exp` claims

### Requirement: Protected endpoints require authentication
The system SHALL require valid JWT authentication for all endpoints except login, health check, and OPTIONS requests.

#### Scenario: Public endpoints accessible without token
- **WHEN** a request is made to `/api/auth/login` or `/health`
- **THEN** the request proceeds without JWT validation

#### Scenario: Protected endpoints block unauthenticated requests
- **WHEN** a request is made to `/api/mascotas` or `/api/usuarios` without authentication
- **THEN** the system returns 401 Unauthorized
