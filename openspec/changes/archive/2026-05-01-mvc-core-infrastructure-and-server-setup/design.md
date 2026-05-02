## Context

The pet adoption platform backend has a basic MVC skeleton with Router, Dispatcher, and BaseController. The database schema is defined with `usuarios` and `mascotas` tables. Currently missing: authentication system, security middleware, proper API response formatting, and complete model/controller implementations. The project uses PHP 8.2 vanilla (no framework), PSR-4 autoloading, and needs to integrate with a frontend in a later phase.

## Goals / Non-Goals

**Goals:**

- Implement JWT-based authentication with login endpoint and token validation middleware
- Create reusable middleware system (JWT, CORS, RequestSanitizer) that integrates with existing Router/Dispatcher
- Build PDO-based models using Singleton pattern for database operations
- Establish standardized JSON API response format across all endpoints
- Implement complete CRUD for `usuarios` and `mascotas` resources
- Add input validation and XSS protection on all incoming requests
- Configure CORS headers for frontend integration

**Non-Goals:**

- Frontend development (deferred to later phase)
- File upload handling for pet images (future iteration)
- Email verification or password reset functionality
- Role-based authorization (all authenticated users have same permissions)
- Database migrations or schema changes (use existing schema)

## Decisions

### 1. JWT Library: Firebase JWT vs Custom Implementation

**Decision**: Use `firebase/php-jwt` library via Composer.

**Rationale**: Established library with active maintenance, proper algorithm support (HS256), and built-in timestamp validation. Custom JWT implementation risks security vulnerabilities.

**Alternative considered**: Custom JWT implementation - rejected due to security complexity and maintenance burden.

### 2. Database Pattern: Singleton PDO vs Repository Pattern

**Decision**: Implement Singleton pattern for PDO connection as specified in project requirements.

**Rationale**: Project explicitly requires "MySQL gestionado con PDO, patrón Singleton". Aligns with existing vanilla PHP approach and keeps dependencies minimal.

**Alternative considered**: Repository pattern with dependency injection - would be more testable but deviates from project specs and adds complexity.

### 3. Middleware Architecture: Enhance Existing Dispatcher vs New Middleware Stack

**Decision**: Enhance existing `Dispatcher::executeMiddlewares()` to support both global and route-specific middleware.

**Rationale**: Dispatcher already has middleware execution logic (lines 46-67 in Dispatcher.php). Adding global middleware support and improving the middleware interface maintains consistency with existing code.

**Implementation**:
- Add `protected $globalMiddlewares = []` array to Dispatcher
- Add `addGlobalMiddleware()` method to Dispatcher
- Middleware interface: `handle()` returns `true` to continue, `false` to stop, or sends response and exits
- Global middleware runs before route-specific middleware

### 4. API Response Format: Custom Response Class vs Controller Methods

**Decision**: Create `App\Core\ApiResponse` class for standardized JSON responses.

**Rationale**: Centralizes response logic, ensures consistent format, simplifies controller code. BaseController can use this class.

**Format**:
```json
{
  "success": true,
  "data": { ... },
  "message": "Optional message",
  "timestamp": "2026-05-01T12:00:00Z"
}
```

**Error format**:
```json
{
  "success": false,
  "error": {
    "code": "ERROR_CODE",
    "message": "Human readable message"
  },
  "timestamp": "2026-05-01T12:00:00Z"
}
```

### 5. Model Layer: Active Record vs Data Mapper

**Decision**: Use Active Record pattern with `DBAbstractModel` as base class.

**Rationale**: `DBAbstractModel` already exists in codebase. Extending it for `Usuarios` and `Mascotas` models aligns with existing structure. Each model handles its own CRUD operations.

**Implementation**:
- `UsuariosModel` extends `DBAbstractModel`
- `MascotasModel` extends `DBAbstractModel`
- Add methods: `create()`, `read()`, `update()`, `delete()`, `findByEmail()`, `findByUsername()`

### 6. Input Validation: Separate Validator Class vs Inline Validation

**Decision**: Create `App\Core\RequestSanitizer` middleware for input sanitization and basic validation.

**Rationale**: Centralizing validation in middleware ensures all inputs are sanitized before reaching controllers. Combines XSS protection with basic validation rules.

**Responsibilities**:
- Sanitize `$_POST`, `$_GET`, and JSON body inputs
- Validate required fields for specific endpoints
- Return structured error responses for validation failures

## Risks / Trade-offs

**[Risk] JWT secret exposure** → Store JWT secret in `.env` file, add `.env` to `.gitignore`, document required env variables in `.env.example`

**[Risk] SQL injection via dynamic queries** → Use prepared statements exclusively in models; `DBAbstractModel` should enforce this

**[Risk] CORS misconfiguration** → Default to restrictive CORS policy; explicitly whitelist allowed origins via environment variable `CORS_ALLOWED_ORIGINS`

**[Risk] Singleton pattern makes testing difficult** → Accept trade-off for simplicity; document that unit testing will require integration test approach or future refactoring

**[Risk] Large response payloads** → Implement pagination for list endpoints (`/api/mascotas`, `/api/usuarios`) using `SHPORPAGINA` constant

**[Trade-off] No refresh token mechanism** → Simpler implementation but requires re-login when JWT expires. Acceptable for MVP phase.

**[Trade-off] Middleware returns false vs throws exception** → Current design uses return values. Less idiomatic but consistent with existing Dispatcher code.

## Migration Plan

1. **Install dependencies**: `composer require firebase/php-jwt`
2. **Create core infrastructure files** (ApiResponse, DB Singleton, RequestSanitizer)
3. **Create middleware classes** (JwtMiddleware, CorsMiddleware)
4. **Update Dispatcher** to support global middleware
5. **Create models** (UsuariosModel, MascotasModel)
6. **Create controllers** with full CRUD implementations
7. **Update routes** in `public/index.php`
8. **Update bootstrap** to initialize middleware and error handling
9. **Test all endpoints** with Postman/curl
10. **Rollback plan**: Keep backups of modified files; revert with `git checkout -- <file>` if needed

## Open Questions

- Should mascota ownership be enforced (users can only modify their own pets)? **Decision**: Yes, MascotasController will validate `usuario_id` matches JWT `user_id`
- Should we implement rate limiting? **Decision**: Not for MVP; can be added as middleware later
- Pagination strategy for list endpoints? **Decision**: Query params `?page=1&limit=10`, default to `SHPORPAGINA` constant
