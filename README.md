# Protectora de Mascotas - Backend API

API RESTful para la gestión de una protectora de mascotas, desarrollada en PHP 8.2 vanilla siguiendo el patrón MVC.

## Requisitos

- PHP 8.2+
- MySQL 5.7+
- Composer

## Instalación

1. Clonar el repositorio
2. Ejecutar `composer install`
3. Copiar `.env.example` a `.env` y configurar las variables:
   - `DBHOST`, `DBNAME`, `DBUSER`, `DBPASS`: Configuración de base de datos
   - `JWT_SECRET`: Clave secreta para tokens JWT (cambiar en producción)
   - `CORS_ALLOWED_ORIGINS`: Orígenes permitidos (e.g., `http://localhost:3000` o `*` para desarrollo)

4. Importar `database.sql` en MySQL:
   ```bash
   mysql -u root -p < database.sql
   ```

5. Servidor web: Colocar en directorio público o usar servidor interno:
   ```bash
   php -S localhost:8000 -t public
   ```

## Autenticación

La API usa JWT (JSON Web Tokens). Obtener token vía login y enviarlo en header:
```
Authorization: Bearer <token>
```

## Endpoints

### Autenticación
- `POST /api/auth/login` - Obtener token (público)
  ```json
  {"email": "user@email.com", "password": "password"}
  ```

### Usuarios
- `POST /api/usuarios` - Registrar usuario (público)
- `GET /api/usuarios?page=1&limit=5` - Listar usuarios (protegido)
- `GET /api/usuarios/{id}` - Ver usuario (protegido)
- `PUT /api/usuarios/{id}` - Actualizar usuario (protegido, solo propietario)
- `DELETE /api/usuarios/{id}` - Eliminar usuario (protegido, solo propietario)

### Mascotas
- `GET /api/mascotas?page=1&limit=5&especie=perro` - Listar mascotas con filtros (protegido)
- `GET /api/mascotas/{id}` - Ver mascota (protegido)
- `POST /api/mascotas` - Crear mascota (protegido, asigna usuario autenticado)
- `PUT /api/mascotas/{id}` - Actualizar mascota (protegido, solo propietario)
- `DELETE /api/mascotas/{id}` - Eliminar mascota (protegido, solo propietario)

### Otros
- `GET /health` - Health check (público)

## Formato de Respuesta

Éxito:
```json
{
  "success": true,
  "data": { ... },
  "message": "Mensaje opcional",
  "timestamp": "2026-05-01T12:00:00+00:00"
}
```

Error:
```json
{
  "success": false,
  "error": {
    "code": "ERROR_CODE",
    "message": "Descripción del error"
  },
  "timestamp": "2026-05-01T12:00:00+00:00"
}
```

## Estructura del Proyecto

```
app/
├── Controllers/     # Controladores MVC
├── Core/           # Router, Dispatcher, ApiResponse, Request
├── Exceptions/     # Excepciones personalizadas
├── Middleware/      # JWT, CORS, RequestSanitizer
├── Models/         # Modelos (DBAbstractModel, Usuarios, Mascotas)
└── config/         # Configuración
```

## Características de Seguridad

- Autenticación JWT con HS256
- Protección contra XSS (sanitización de entrada)
- Protección contra SQL Injection (prepared statements)
- CORS configurrable
- Headers de seguridad
- Password hashing con `password_hash()`
