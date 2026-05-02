## Why

The current codebase uses manual validation in controllers and a simple `RequestSanitizer` middleware. The user wants to implement a proper Form-based validation system (similar to Symfony Forms) with separate classes for Form data, validation, and sanitization. This will clean up controllers and centralize validation logic.

## What Changes

- Delete `app/Middleware/RequestSanitizer.php`
- Create `app/Forms/` directory with Form classes:
  - `UsuarioForm`, `UsuarioFormValidator`, `UsuarioFormSanitizer` for login/register
  - `MascotaForm`, `MascotaFormValidator`, `MascotaFormSanitizer` for create/update
- Refactor `UsuariosController` to use `UsuarioForm` for login/register
- Refactor `MascotasController` to use `MascotaForm` for create/update
- Form classes process JSON input and return sanitized/validated data

## Capabilities

### New Capabilities
- `form-validation-system`: Form-based validation with separate Validator and Sanitizer classes

### Modified Capabilities
- `usuarios-api`: Refactor to use UsuarioForm
- `mascotas-api`: Refactor to use MascotaForm
- `request-sanitization`: Remove RequestSanitizer, replace with FormSanitizer classes

## Impact

- **Deleted files**: `app/Middleware/RequestSanitizer.php`
- **New files**: 6 Form classes in `app/Forms/`
- **Modified files**: `UsuariosController.php`, `MascotasController.php`
- **No schema changes**: Uses existing database structure
- **Testing required**: Test form validation, sanitization, and controller integration
