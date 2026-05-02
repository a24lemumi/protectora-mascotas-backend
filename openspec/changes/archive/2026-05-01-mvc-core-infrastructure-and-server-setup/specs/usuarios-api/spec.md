## ADDED Requirements

### Requirement: List all users
The system SHALL provide a GET endpoint to list all users with pagination support.

#### Scenario: Get paginated list of users
- **WHEN** a GET request is made to `/api/usuarios` with optional `page` and `limit` query parameters
- **THEN** the system returns a JSON response with `success: true`, list of users (excluding passwords), and pagination metadata

#### Scenario: Pagination uses default values
- **WHEN** a GET request is made to `/api/usuarios` without query parameters
- **THEN** the system uses default pagination values from `SHPORPAGINA` constant

### Requirement: Get single user by ID
The system SHALL provide a GET endpoint to retrieve a single user by ID.

#### Scenario: Get existing user
- **WHEN** a GET request is made to `/api/usuarios/{id}` with a valid user ID
- **THEN** the system returns a JSON response with `success: true` and the user data (excluding password)

#### Scenario: Get non-existent user
- **WHEN** a GET request is made to `/api/usuarios/{id}` with a non-existent user ID
- **THEN** the system returns a JSON response with `success: false` and HTTP status 404

### Requirement: Create new user (register)
The system SHALL provide a POST endpoint to create a new user account.

#### Scenario: Successful user registration
- **WHEN** a POST request is made to `/api/usuarios` with valid `username`, `email`, `password`, and optional `nombre`, `apellido`, `telefono`
- **THEN** the system creates the user with hashed password, returns `success: true`, and HTTP status 201

#### Scenario: Duplicate email or username
- **WHEN** a POST request is made to `/api/usuarios` with an email or username that already exists
- **THEN** the system returns a JSON response with `success: false`, HTTP status 400, and message indicating duplicate field

#### Scenario: Missing required fields
- **WHEN** a POST request is made to `/api/usuarios` without required fields (`username`, `email`, `password`)
- **THEN** the system returns a JSON response with `success: false` and HTTP status 400

### Requirement: Update user
The system SHALL provide a PUT endpoint to update user information, restricted to the authenticated user.

#### Scenario: User updates own profile
- **WHEN** an authenticated user makes a PUT request to `/api/usuarios/{id}` with their own user ID and valid update data
- **THEN** the system updates the user and returns `success: true` with updated user data

#### Scenario: User attempts to update another user
- **WHEN** an authenticated user makes a PUT request to `/api/usuarios/{id}` with a different user's ID
- **THEN** the system returns a JSON response with `success: false` and HTTP status 403

### Requirement: Delete user
The system SHALL provide a DELETE endpoint to delete a user account, restricted to the authenticated user.

#### Scenario: User deletes own account
- **WHEN** an authenticated user makes a DELETE request to `/api/usuarios/{id}` with their own user ID
- **THEN** the system deletes the user and returns `success: true` with HTTP status 200

#### Scenario: User attempts to delete another user
- **WHEN** an authenticated user makes a DELETE request to `/api/usuarios/{id}` with a different user's ID
- **THEN** the system returns a JSON response with `success: false` and HTTP status 403

### Requirement: Password hashing
The system SHALL hash all passwords using `password_hash()` with PASSWORD_DEFAULT before storing in database.

#### Scenario: Password is hashed on registration
- **WHEN** a new user is created via POST `/api/usuarios`
- **THEN** the stored password in database is hashed and cannot be reversed

#### Scenario: Password verification works on login
- **WHEN** a login request is made with correct email and password
- **THEN** the system uses `password_verify()` to validate the password against the stored hash
