## 1. Verify Current State

- [x] 1.1 Verify that `app/Middleware/CorsMiddleware.php` correctly reads `$_ENV['CORS_ALLOWED_ORIGINS']`
- [x] 1.2 Verify that `.env` file has `CORS_ALLOWED_ORIGINS=*` set correctly
- [x] 1.3 Confirm that `app/bootstrap.php` does NOT currently call `CorsMiddleware::handle()`

## 2. Register CorsMiddleware Globally

- [x] 2.1 Add `use App\Middleware\CorsMiddleware;` import in `app/bootstrap.php`
- [x] 2.2 Add `CorsMiddleware::handle();` call in `app/bootstrap.php` after Dotenv load (after line ~38) and before error handling configuration
- [x] 2.3 Verify the middleware is called before any controller logic executes

## 3. Testing

- [x] 3.1 Test that CORS headers are present on GET requests from frontend origin
- [x] 3.2 Test that preflight OPTIONS requests return HTTP 200 with appropriate CORS headers
- [x] 3.3 Verify that `Access-Control-Allow-Origin` header matches `CORS_ALLOWED_ORIGINS` value from `.env`
