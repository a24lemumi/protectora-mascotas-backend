## 1. Delete Wrapper Classes

- [x] 1.1 Delete `app/Core/ApiResponse.php` completely
- [x] 1.2 Delete `app/Core/Request.php` completely

## 2. Refactor JwtMiddleware

- [x] 2.1 Remove `use App\Core\ApiResponse` import
- [x] 2.2 Replace all `(new ApiResponse())->error()->setStatusCode()->send()` with direct `header/json_encode/exit` pattern
- [x] 2.3 Keep JWT validation logic the same, only change output format
- [x] 2.4 Test that JWT middleware still returns correct JSON responses

## 3. Refactor CorsMiddleware

- [x] 3.1 Remove any `use App\Core\Request` import
- [x] 3.2 Use `$_SERVER['HTTP_ORIGIN']` directly instead of Request::header()
- [ ] 3.3 Test CORS headers still work correctly

## 4. Refactor RequestSanitizer

- [x] 4.1 Remove `use App\Core\Request` import
- [x] 4.2 Modify `validateRequired()` to read input directly from `$_POST`, `$_GET`, or `json_decode(file_get_contents('php://input'), true)`
- [ ] 4.3 Test validation still works without Request class

## 5. Refactor MascotasController

- [x] 5.1 Remove `use App\Core\ApiResponse` and `use App\Core\Request` imports
- [x] 5.2 Replace all `(new ApiResponse())->success()->send()` with `header(); http_response_code(); echo json_encode(); exit;`
- [x] 5.3 Replace all `(new ApiResponse())->error()->send()` with direct JSON error output
- [x] 5.4 Replace all `$request->json()` and `$request->post()` with `json_decode(file_get_contents('php://input'), true)` or `$_POST`
- [ ] 5.5 Test all mascotas endpoints work with new I/O pattern

## 6. Refactor UsuariosController

- [x] 6.1 Remove `use App\Core\ApiResponse` and `use App\Core\Request` imports
- [x] 6.2 Replace all `(new ApiResponse())->success()->send()` with `header(); http_response_code(); echo json_encode(); exit;`
- [x] 6.3 Replace all `(new ApiResponse())->error()->send()` with direct JSON error output
- [x] 6.4 Replace all `$request->json()` and `$request->post()` with `json_decode(file_get_contents('php://input'), true)` or `$_POST`
- [ ] 6.5 Test all usuarios endpoints work with new I/O pattern

## 7. Refactor Dispatcher

- [x] 7.1 Remove `use App\Core\ApiResponse` import
- [x] 7.2 Replace `handleNotFound()` to use direct JSON output
- [x] 7.3 Replace `handleError()` to use direct JSON output
- [ ] 7.4 Test error responses work correctly

## 8. Testing

- [ ] 8.1 Test GET `/api/mascotas` returns JSON with direct output
- [ ] 8.2 Test POST `/api/auth/login` returns JWT with direct output
- [ ] 8.3 Test protected endpoints return 401 without JWT
- [ ] 8.4 Verify no references to ApiResponse or Request in any file
