## Context

The Router class only has `get()` and `post()` methods. The `public/index.php` references non-existent `put()` and `delete()` methods. Since HTML forms don't support PUT/DELETE methods natively, we'll use method spoofing via a `_method` field in POST requests.

## Goals / Non-Goals

**Goals:**
- Remove references to non-existent `put()` and `delete()` methods in Router
- Implement method spoofing in Router's `match()` method
- Refactor controllers to handle spoofed PUT/DELETE in POST actions
- Maintain backward compatibility for clients sending actual PUT/DELETE requests

**Non-Goals:**
- Adding actual PUT/DELETE HTTP method support to Router
- Changing the middleware architecture
- Modifying the database layer

## Decisions

### 1. Method Spoofing Strategy

**Decision**: Use `_method` field in POST data to spoof PUT/DELETE requests.

**Rationale**: This is a common pattern (used by Laravel, Rails, etc.). Clients send POST request with `_method=PUT` or `_method=DELETE` in the request body.

**Alternative considered**: Using `X-HTTP-Method-Override` header - rejected because the user specifically requested `_method` field.

### 2. Router.match() Enhancement

**Decision**: Modify `match()` to check for `_method` POST field and override the HTTP method if present.

**Rationale**: Centralizing method spoofing logic in the Router ensures all routes benefit from this feature without controller modifications.

### 3. Controller Refactoring

**Decision**: Keep controller methods named `update()` and `delete()`, but have them handle both POST with spoofing and direct PUT/DELETE (if ever supported).

**Rationale**: Preserves existing controller structure while adding spoofing support.

## Risks / Trade-offs

**[Risk] Breaking existing clients** → Document that update/delete now requires POST with `_method` field

**[Risk] Method spoofing bypass** → Validate that only POST requests can be spoofed, not GET requests

## Migration Plan

1. Update `public/index.php`: Change all `put()` and `delete()` to `post()`
2. Modify `Router::match()` to detect `_method` in POST data
3. Refactor controllers to handle POST requests with method spoofing
4. Test all update/delete endpoints with `_method` field
