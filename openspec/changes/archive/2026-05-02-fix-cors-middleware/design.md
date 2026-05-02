## Context

The backend API is built with PHP 8.2 vanilla (no framework) using MVC architecture. The `CorsMiddleware.php` exists and correctly reads `CORS_ALLOWED_ORIGINS` from `$_ENV` (which matches the `.env` file variable). However, this middleware is not registered globally in `app/bootstrap.php`, so CORS headers are never sent to the frontend SPA.

## Goals / Non-Goals

**Goals:**
- Register `CorsMiddleware` as a global middleware in `app/bootstrap.php`
- Verify that `CorsMiddleware.php` correctly reads the `CORS_ALLOWED_ORIGINS` environment variable
- Ensure preflight `OPTIONS` requests are handled before reaching controllers

**Non-Goals:**
- No changes to the CORS logic itself (already correctly implemented)
- No changes to the `.env` file (already has `CORS_ALLOWED_ORIGINS=*`)

## Decisions

1. **Global middleware registration in bootstrap.php**
   - **Decision**: Add `CorsMiddleware::handle()` call near the top of `bootstrap.php` after session and env loading
   - **Rationale**: Ensures all requests (including OPTIONS preflight) are intercepted before any controller logic
   - **Alternative considered**: Registering in `.htaccess` or `index.php` - rejected as less portable

2. **Middleware placement in bootstrap.php**
   - **Decision**: Place after Dotenv load (line ~38) and before error handling configuration
   - **Rationale**: CORS headers must be sent before any other output; env must be loaded first to read `CORS_ALLOWED_ORIGINS`

## Risks / Trade-offs

- **CORS too permissive in production** → `CORS_ALLOWED_ORIGINS=*` should be changed to specific origins before production deployment
- **Middleware execution order** → CorsMiddleware must run before any controller logic; verified by placement in bootstrap.php
