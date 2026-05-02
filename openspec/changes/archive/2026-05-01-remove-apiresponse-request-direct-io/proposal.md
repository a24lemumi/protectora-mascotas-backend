## Why

The user wants to eliminate `App\Core\ApiResponse.php` and `App\Core\Request.php` classes entirely. All input reading should use `json_decode(file_get_contents('php://input'), true)` or `$_POST` directly. All API responses should use `header('Content-Type: application/json'); echo json_encode([...]); exit;` with `http_response_code()` for status codes. This simplifies the codebase by removing intermediate classes.

## What Changes

- Delete `app/Core/ApiResponse.php` completely
- Delete `app/Core/Request.php` completely  
- Refactor `MascotasController` to use direct input/output (no ApiResponse, no Request)
- Refactor `UsuariosController` to use direct input/output (no ApiResponse, no Request)
- Refactor `Dispatcher` to not use ApiResponse in error handling
- Refactor `JwtMiddleware` to use direct JSON responses
- Refactor `CorsMiddleware` to keep working without Request class
- Refactor `RequestSanitizer` to work without the Request class
- All JSON responses: `header('Content-Type: application/json'); http_response_code(); echo json_encode(); exit;`
- All input reading: `json_decode(file_get_contents('php://input'), true)` or `$_POST`

## Capabilities

### New Capabilities
<!-- No new capabilities -->

### Modified Capabilities
- `jwt-auth`: Middleware uses direct JSON responses instead of ApiResponse
- `cors-handling`: Middleware works without Request class
- `request-sanitization`: Works without Request class, validates directly
- `mascotas-api`: Controller uses direct I/O without wrapper classes
- `usuarios-api`: Controller uses direct I/O without wrapper classes
- `error-handling`: Dispatcher uses direct JSON responses

## Impact

- **Deleted files**: `app/Core/ApiResponse.php`, `app/Core/Request.php`
- **Modified files**: All controllers (MascotasController, UsuariosController), Dispatcher, all Middleware (JwtMiddleware, CorsMiddleware, RequestSanitizer)
- **Breaking change**: All response/request patterns change from OOP to procedural style
- **No database changes**
- **Testing required**: All endpoints must be tested with new I/O pattern
