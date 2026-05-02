## Why

The Router class only supports GET and POST methods, but `public/index.php` references non-existent `put()` and `delete()` methods. Since HTML forms and many clients don't support PUT/DELETE natively, we need to refactor routes to use POST and implement method spoofing via a `_method` field in the request payload.

## What Changes

- Remove all `put()` and `delete()` route definitions from `public/index.php`
- Change update/delete routes to use `post()` method instead
- Add method spoofing support in Router's `match()` method to detect `_method` field
- Refactor `MascotasController` and `UsuariosController` to check for spoofed method in POST requests
- Controllers will inspect request payload for `_method` field (values: PUT, DELETE) and route to appropriate handler logic

## Capabilities

### New Capabilities
<!-- No new capabilities -->

### Modified Capabilities
- `mascotas-api`: Update/delete routes now use POST with method spoofing
- `usuarios-api`: Update/delete routes now use POST with method spoofing

## Impact

- **Modified files**: `public/index.php`, `app/Core/Router.php`, `app/Controllers/MascotasController.php`, `app/Controllers/UsuariosController.php`
- **Breaking change**: Routes change from PUT/DELETE to POST (clients must send `_method=PUT` or `_method=DELETE` in POST data)
- **No database changes**
- **Testing required**: All update/delete endpoints must be tested with `_method` spoofing
