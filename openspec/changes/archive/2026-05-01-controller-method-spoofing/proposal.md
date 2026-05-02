## Why

The current implementation uses Router's `match()` method to detect `_method` spoofing, but the user wants controllers to handle this logic internally. This gives controllers full control over method detection and makes the Router simpler.

## What Changes

- Revert Router's `match()` method to original state (remove method spoofing logic)
- Refactor `MascotasController::update()` and `delete()` to check for `_method` field in POST/JSON data
- Refactor `UsuariosController::update()` and `delete()` to check for `_method` field in POST/JSON data
- Controllers will check if POST request contains `_method=PUT` or `_method=DELETE` and act accordingly
- All update/delete routes already use `post()` in Router (no route changes needed)

## Capabilities

### New Capabilities
<!-- No new capabilities -->

### Modified Capabilities
- `mascotas-api`: Controllers handle method spoofing internally
- `usuarios-api`: Controllers handle method spoofing internally

## Impact

- **Modified files**: `app/Core/Router.php`, `app/Controllers/MascotasController.php`, `app/Controllers/UsuariosController.php`
- **No route changes**: Routes already use `post()` correctly
- **Backward compatible**: Controllers still work with direct PUT/DELETE if Router supports it in future
- **Testing required**: Verify `_method` spoofing works from controller level
