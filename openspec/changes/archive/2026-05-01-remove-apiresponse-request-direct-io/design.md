## Context

The user wants to eliminate `App\Core\ApiResponse` and `App\Core\Request` classes completely. Controllers and middleware currently depend on these classes. All input reading should use `json_decode(file_get_contents('php://input'), true)` or `$_POST` directly. All JSON responses should use `header('Content-Type: application/json'); http_response_code(); echo json_encode(); exit;`.

## Goals / Non-Goals

**Goals:**
- Delete `app/Core/ApiResponse.php` and `app/Core/Request.php`
- Refactor all controllers to use direct I/O (no wrapper classes)
- Refactor all middleware to use direct I/O
- Refactor Dispatcher to not use ApiResponse
- Use `json_decode(file_get_contents('php://input'), true)` for JSON input
- Use `header('Content-Type: application/json'); echo json_encode(); exit;` for responses

**Non-Goals:**
- Changing route definitions
- Adding new endpoints
- Modifying database layer
- Changing JWT logic (just the I/O pattern)

## Decisions

### 1. Direct I/O Pattern

**Decision**: Replace all `new ApiResponse()` calls with direct `header/json_encode/exit` pattern. Replace all `new Request()` with `json_decode(file_get_contents('php://input'), true)` or `$_POST`.

**Rationale**: User explicitly requested this simplification. Removes intermediate classes.

**Alternative considered**: Keeping classes but modifying them - rejected per user request.

### 2. Error Response Format

**Decision**: Maintain the same JSON structure (`success`, `data`/`error`, `message`, `timestamp`) but output directly.

**Rationale**: Keeps API response format consistent for clients.

### 3. Dispatcher Error Handling

**Decision**: Modify `handleNotFound()` and `handleError()` to use direct JSON output instead of ApiResponse.

**Rationale**: Dispatcher currently uses ApiResponse. Need to refactor to direct I/O.

## Risks / Trade-offs

**[Risk] Breaking all endpoints during refactoring** → Test each endpoint after refactoring

**[Risk] Losing Request sanitization** → RequestSanitizer middleware still sanitizes, but needs to work without Request class

**[Trade-off] Less OOP, more procedural** → Acceptable per user request for simplicity

## Migration Plan

1. Delete `app/Core/ApiResponse.php` and `app/Core/Request.php`
2. Refactor `MascotasController` - all methods use direct I/O
3. Refactor `UsuariosController` - all methods use direct I/O
4. Refactor `Dispatcher` - remove ApiResponse usage
5. Refactor `JwtMiddleware` - use direct JSON responses
6. Refactor `CorsMiddleware` - remove Request dependency (if any)
7. Refactor `RequestSanitizer` - work without Request class
8. Test all endpoints
