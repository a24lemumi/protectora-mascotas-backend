## ADDED Requirements

### Requirement: Global CORS middleware registration
The system SHALL register `CorsMiddleware::handle()` as a global middleware in `app/bootstrap.php` to intercept all incoming HTTP requests.

#### Scenario: CORS headers on all requests
- **WHEN** any HTTP request is received by the backend
- **THEN** the `CorsMiddleware::handle()` method SHALL be called before any controller logic

#### Scenario: Preflight OPTIONS handling
- **WHEN** an OPTIONS request is received
- **THEN** the CorsMiddleware SHALL return HTTP 200 and exit before reaching the controller

### Requirement: CORS environment variable verification
The CorsMiddleware SHALL correctly read the `CORS_ALLOWED_ORIGINS` variable from `$_ENV` to determine allowed origins.

#### Scenario: Wildcard origin in development
- **WHEN** `CORS_ALLOWED_ORIGINS` is set to `*` in `.env`
- **THEN** the middleware SHALL set `Access-Control-Allow-Origin: *` header

#### Scenario: Specific origins in production
- **WHEN** `CORS_ALLOWED_ORIGINS` contains comma-separated origins (e.g., `https://example.com`)
- **THEN** the middleware SHALL validate the request origin against the list and set the appropriate header
