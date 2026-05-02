## Why

The CORS middleware exists in the backend but is not registered as a global middleware in `app/bootstrap.php`, causing the frontend SPA to fail on cross-origin requests. The `.env` variable `CORS_ALLOWED_ORIGINS` is correctly set to `*` for development, but the middleware is never called.

## What Changes

- Register `CorsMiddleware` as a global middleware in `app/bootstrap.php` to intercept all incoming requests
- Verify that `CorsMiddleware.php` correctly reads `CORS_ALLOWED_ORIGINS` from `$_ENV` (currently uses `$_ENV['CORS_ALLOWED_ORIGINS']` which matches the `.env` file)
- Ensure the middleware handles preflight `OPTIONS` requests properly before reaching the controller

## Capabilities

### New Capabilities
- `cors-global-middleware`: Register CorsMiddleware globally in bootstrap.php to handle all cross-origin requests

### Modified Capabilities

## Impact

- **Code**: `app/bootstrap.php` (add middleware call), `app/Middleware/CorsMiddleware.php` (verification only)
- **Environment**: `.env` file already has `CORS_ALLOWED_ORIGINS=*` for development
- **API**: All endpoints will now include CORS headers automatically
- **Frontend**: Fixes cross-origin requests from frontend SPA to backend API
