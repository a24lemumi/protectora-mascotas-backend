## 1. Create Form classes for Usuario

- [x] 1.1 Create `app/Forms/UsuarioForm.php` with submit() and getData() methods
- [x] 1.2 Create `app/Forms/UsuarioFormValidator.php` with validate($data) method returning errors array
- [x] 1.3 Create `app/Forms/UsuarioFormSanitizer.php` with sanitize($data) method
- [x] 1.4 UsuarioForm should handle both login (email, password) and register (username, email, password) fields
- [x] 1.5 UsuarioForm reads JSON input via `json_decode(file_get_contents('php://input'), true)`

## 2. Create Form classes for Mascota

- [x] 2.1 Create `app/Forms/MascotaForm.php` with submit() and getData() methods
- [x] 2.2 Create `app/Forms/MascotaFormValidator.php` with validate($data) method returning errors array
- [x] 2.3 Create `app/Forms/MascotaFormSanitizer.php` with sanitize($data) method
- [x] 2.4 MascotaForm should validate: nombre (required), especie (required), raza (optional), fecha_nac (optional), imagen (optional)
- [x] 2.5 MascotaForm reads JSON input via `json_decode(file_get_contents('php://input'), true)`

## 3. Refactor UsuariosController

- [x] 3.1 Refactor `login()` to use `UsuarioForm` for validation/sanitization
- [x] 3.2 Refactor `register()` to use `UsuarioForm` for validation/sanitization
- [x] 3.3 Remove manual field validation from UsuariosController
- [x] 3.4 Use direct JSON I/O for responses (no ApiResponse)

## 4. Refactor MascotasController

- [x] 4.1 Refactor `create()` to use `MascotaForm` for validation/sanitization
- [x] 4.2 Refactor `update()` to use `MascotaForm` for validation/sanitization
- [x] 4.3 Remove manual field validation from MascotasController
- [x] 4.4 Use direct JSON I/O for responses (no ApiResponse)

## 5. Delete RequestSanitizer

- [x] 5.1 Delete `app/Middleware/RequestSanitizer.php`
- [x] 5.2 Remove any references to RequestSanitizer from codebase

## 6. Testing

- [ ] 6.1 Test UsuarioForm login validation (missing email/password)
- [ ] 6.2 Test UsuarioForm register validation (missing required fields)
- [ ] 6.3 Test MascotaForm create validation (missing nombre/especie)
- [ ] 6.4 Test MascotaForm update with valid/invalid data
- [ ] 6.5 Test complete login flow with UsuarioForm
- [ ] 6.6 Test complete register flow with UsuarioForm
- [ ] 6.7 Test complete create mascota flow with MascotaForm
- [ ] 6.8 Test complete update mascota flow with MascotaForm
- [ ] 6.9 Verify RequestSanitizer.php is deleted
