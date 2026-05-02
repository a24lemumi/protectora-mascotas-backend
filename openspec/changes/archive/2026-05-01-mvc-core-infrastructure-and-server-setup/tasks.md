## 1. Dependencies and Configuration

- [x] 1.1 Install firebase/php-jwt via Composer: `composer require firebase/php-jwt`
- [x] 1.2 Update `.env.example` with required variables: `JWT_SECRET`, `CORS_ALLOWED_ORIGINS`, `APP_ENV`
- [x] 1.3 Verify `.gitignore` includes `.env` file

## 2. Database Singleton and DBAbstractModel

- [x] 2.1 Review and enhance `app/Models/DBAbstractModel.php` to implement proper Singleton pattern for PDO connection
- [x] 2.2 Configure PDO with `ERRMODE_EXCEPTION`, `charset=utf8mb4`, and prepared statement emulation disabled
- [x] 2.3 Add connection error handling that throws `App\\Exceptions\\DatabaseException`
- [x] 2.4 Verify `app/Exceptions/DatabaseException.php` exists with appropriate message handling

## 3. Core Infrastructure Classes

- [x] 3.1 Create `app/Core/ApiResponse.php` with methods: `success()`, `error()`, `setStatusCode()`, `send()`
- [x] 3.2 Implement JSON response format with `success`, `data`/`error`, `message`, `timestamp` fields
- [x] 3.3 Create `app/Core/Request.php` wrapper to access sanitized GET, POST, JSON body inputs

## 4. Middleware Implementation

- [x] 4.1 Create `app/Middleware/JwtMiddleware.php` with `handle()` method that validates Authorization header and JWT token
- [x] 4.2 Implement JWT validation using `firebase/php-jwt` with HS256 algorithm and `JWT_SECRET` from env
- [x] 4.3 Create `app/Middleware/CorsMiddleware.php` with `handle()` method that sets CORS headers based on `CORS_ALLOWED_ORIGINS`
- [x] 4.4 Create `app/Middleware/RequestSanitizer.php` with `handle()` method that sanitizes input using `filter_var()`, `htmlspecialchars()`, and validates required fields
- [x] 4.5 Update `app/Core/Dispatcher.php` to add `addGlobalMiddleware()` method and execute global middleware before route-specific middleware

## 5. Models - Usuarios

- [x] 5.1 Create `app/Models/UsuariosModel.php` extending `DBAbstractModel` with properties: `id`, `username`, `email`, `telefono`, `password`, `nombre`, `apellido`, `created_at`
- [x] 5.2 Implement `create($data)` method with password hashing using `password_hash()` and duplicate email/username validation
- [x] 5.3 Implement `read($id)` method to fetch single user by ID (excluding password field)
- [x] 5.4 Implement `readAll($page, $limit)` method with pagination support using `SHPORPAGINA` constant
- [x] 5.5 Implement `update($id, $data)` method to update user fields (excluding password - handled separately)
- [x] 5.6 Implement `delete($id)` method to delete user by ID
- [x] 5.7 Implement `findByEmail($email)` method for login authentication
- [x] 5.8 Implement `findByUsername($username)` method for duplicate validation

## 6. Models - Mascotas

- [x] 6.1 Create `app/Models/MascotasModel.php` extending `DBAbstractModel` with properties: `id`, `nombre`, `especie`, `raza`, `fecha_nac`, `imagen`, `usuario_id`
- [x] 6.2 Implement `create($data)` method that sets `usuario_id` from authenticated user and validates required fields (`nombre`, `especie`)
- [x] 6.3 Implement `read($id)` method to fetch single pet with owner information (JOIN with usuarios table)
- [x] 6.4 Implement `readAll($page, $limit, $filters)` method with pagination and optional filtering by `especie`, `raza`
- [x] 6.5 Implement `update($id, $data, $usuario_id)` method that validates ownership before updating
- [x] 6.6 Implement `delete($id, $usuario_id)` method that validates ownership before deleting
- [x] 6.7 Implement `findByUsuarioId($usuario_id)` method to fetch pets owned by a specific user

## 7. Controllers - Usuarios

- [x] 7.1 Create `app/Controllers/UsuariosController.php` extending `BaseController` with constructor that initializes `UsuariosModel`
- [x] 7.2 Implement `register()` method (POST `/api/usuarios`) with input validation, duplicate checking, and return 201 on success
- [x] 7.3 Implement `login()` method (POST `/api/auth/login`) using `findByEmail()` and `password_verify()`, return JWT token on success
- [x] 7.4 Implement `show($id)` method (GET `/api/usuarios/{id}`) returning user data without password
- [x] 7.5 Implement `index()` method (GET `/api/usuarios`) with pagination support
- [x] 7.6 Implement `update($id)` method (PUT `/api/usuarios/{id}`) validating authenticated user owns the resource
- [x] 7.7 Implement `delete($id)` method (DELETE `/api/usuarios/{id}`) validating authenticated user owns the resource

## 8. Controllers - Mascotas

- [x] 8.1 Create `app/Controllers/MascotasController.php` extending `BaseController` with constructor that initializes `MascotasModel`
- [x] 8.2 Update existing `index()` method (GET `/api/mascotas`) to use `MascotasModel::readAll()` with pagination and filtering
- [x] 8.3 Implement `show($id)` method (GET `/api/mascotas/{id}`) returning pet data with owner information
- [x] 8.4 Implement `create()` method (POST `/api/mascotas`) with authentication check, input validation, and associate with authenticated user
- [x] 8.5 Implement `update($id)` method (PUT `/api/mascotas/{id}`) validating ownership before update
- [x] 8.6 Implement `delete($id)` method (DELETE `/api/mascotas/{id}`) validating ownership before delete
- [x] 8.7 Update `health()` method (GET `/health`) to return JSON response using `ApiResponse`

## 9. Routing and Bootstrap Updates

- [x] 9.1 Update `public/index.php` to register all new routes: auth/login, usuarios CRUD, mascotas CRUD with appropriate middleware
- [x] 9.2 Configure protected routes with `JwtMiddleware`: all `/api/usuarios` and `/api/mascotas` routes except login
- [x] 9.3 Update `app/bootstrap.php` to initialize global middleware (CorsMiddleware, RequestSanitizer) via Dispatcher
- [x] 9.4 Add global error handler in `bootstrap.php` that catches exceptions and returns JSON error responses

## 10. Testing and Documentation

- [ ] 10.1 Test POST `/api/auth/login` with valid and invalid credentials using curl/Postman
- [ ] 10.2 Test JWT protection: access protected endpoints with and without valid token
- [ ] 10.3 Test CRUD operations for `/api/usuarios` with ownership validation
- [ ] 10.4 Test CRUD operations for `/api/mascotas` with ownership validation
- [ ] 10.5 Test pagination: `/api/mascotas?page=1&limit=3` and verify `SHPORPAGINA` default
- [ ] 10.6 Test input sanitization: send HTML tags and SQL injection attempts
- [ ] 10.7 Test CORS headers: make OPTIONS request and verify headers
- [x] 10.8 Update `README.md` with API documentation: endpoints, authentication flow, request/response examples
