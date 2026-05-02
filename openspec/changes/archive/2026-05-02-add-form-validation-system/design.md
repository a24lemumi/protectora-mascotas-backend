## Context

The current codebase has validation logic scattered in controllers (manual field checking) and a simple `RequestSanitizer` middleware. The user wants to implement a Form-based validation system with separate classes for Form data handling, validation, and sanitization - similar to Symfony Forms but simplified for this MVC project.

## Goals / Non-Goals

**Goals:**
- Delete `app/Middleware/RequestSanitizer.php`
- Create `app/Forms/` directory with Form classes
- `UsuarioForm`, `UsuarioFormValidator`, `UsuarioFormSanitizer` for login/register
- `MascotaForm`, `MascotaFormValidator`, `MascotaFormSanitizer` for create/update
- Refactor `UsuariosController` to use `UsuarioForm`
- Refactor `MascotasController` to use `MascotaForm`
- Form classes handle JSON input processing via `json_decode(file_get_contents('php://input'), true)`

**Non-Goals:**
- Implementing a full Symfony Forms clone
- Adding CSRF protection
- Adding file upload handling to forms

## Decisions

### 1. Form Class Structure

**Decision**: Each form has 3 classes: `Form`, `FormValidator`, `FormSanitizer`.

**Rationale**: Separation of concerns - Form handles data binding, Validator handles rules, Sanitizer handles cleaning.

**Structure:**
```
app/Forms/
├── UsuarioForm.php
├── UsuarioFormValidator.php
├── UsuarioFormSanitizer.php
├── MascotaForm.php
├── MascotaFormValidator.php
└── MascotaFormSanitizer.php
```

### 2. Form Data Processing

**Decision**: Form classes use `json_decode(file_get_contents('php://input'), true)` to read JSON input.

**Rationale**: Consistent with existing codebase pattern of direct I/O.

### 3. Controller Integration

**Decision**: Controllers instantiate Form, call `submit()` or `validate()`, get sanitized data back.

**Rationale**: Simplifies controllers by moving validation/sanitization out.

## Risks / Trade-offs

**[Risk] Breaking existing validation** → Test thoroughly after refactoring

**[Risk] Form classes may be overkill** → Acceptable for learning/consistency with "contactos" reference

## Migration Plan

1. Create `app/Forms/` directory
2. Create `UsuarioForm`, `UsuarioFormValidator`, `UsuarioFormSanitizer`
3. Create `MascotaForm`, `MascotaFormValidator`, `MascotaFormSanitizer`
4. Refactor `UsuariosController` to use `UsuarioForm`
5. Refactor `MascotasController` to use `MascotaForm`
6. Delete `app/Middleware/RequestSanitizer.php`
7. Test all endpoints
