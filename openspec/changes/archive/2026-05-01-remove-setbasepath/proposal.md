## Why

`setBasePath()` was added to handle XAMPP subdirectory deployment, but it wasn't part of the original codebase. The user wants to remove it entirely since it never existed from the beginning.

## What Changes

- Remove `setBasePath()` method from `app/Core/Router.php`
- Remove `$basePath` property and all related logic from Router
- Remove `$router->setBasePath()` call from `public/index.php`
- Remove `cleanUri()` method's basePath stripping logic

## Capabilities

### New Capabilities
<!-- No new capabilities -->

### Modified Capabilities
<!-- No capability changes -->

## Impact

- **Modified files**: `app/Core/Router.php`, `public/index.php`
- **Breaking change**: Routes will no longer strip subdirectory prefix - must ensure deployment matches route definitions
- **No database changes**
- **Testing required**: Verify routes work without basePath logic
