## Context

The Router's `match()` method currently handles method spoofing by checking for `_method` in POST data. The user wants controllers to handle this logic internally instead, giving them full control over method detection.

## Goals / Non-Goals

**Goals:**
- Remove method spoofing logic from Router's `match()` method
- Add method spoofing detection in MascotasController and UsuariosController
- Controllers check for `_method` field in POST body or JSON payload
- Support both URL-based IDs (`/api/mascotas/{id}`) and POST data

**Non-Goals:**
- Changing route definitions (already use `post()` correctly)
- Adding PUT/DELETE HTTP method support to Router
- Modifying middleware or models

## Decisions

### 1. Controller-Based Method Detection

**Decision**: Each controller method (`update()`, `delete()`) checks for `_method` field in Request object.

**Rationale**: Controllers have full context about the request and can decide how to handle spoofed methods. This follows the user's request.

**Alternative considered**: Keeping logic in Router - rejected per user request.

### 2. Router Simplification

**Decision**: Revert Router's `match()` to original state (no method spoofing).

**Rationale**: Simplifies Router and follows single responsibility principle - Router matches routes, controllers handle business logic.

## Risks / Trade-offs

**[Risk] Duplicate logic in controllers** → Extract to base controller if pattern repeats

**[Risk] Breaking existing clients** → Document that `_method` must be sent in POST body/JSON

## Migration Plan

1. Revert Router `match()` to remove method spoofing
2. Modify MascotasController::update() and delete() to check Request for `_method`
3. Modify UsuariosController::update() and delete() to check Request for `_method`
4. Test with POST + `_method=PUT` and `_method=DELETE`
