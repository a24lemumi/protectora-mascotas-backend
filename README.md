# Protectora de Mascotas - Backend API

API RESTful para la gestión de una protectora de mascotas, desarrollada en PHP 8.2 vanilla siguiendo el patrón MVC y una arquitectura moderna basada en Formularios.

## Requisitos

- PHP 8.2+
- PostgreSQL 16+ (para Render.com) o MySQL 5.7+ (local)
- Composer
- Entorno local como XAMPP (Apache)

## Instalación

1. Clonar el repositorio.
2. Ejecutar `composer install` para descargar las dependencias.
3. Crear `.env.example` y `.env` y configurar las variables:
   - `DB_DRIVER`: `pgsql` para Render.com, `mysql` para local
   - `DATABASE_URL`: (Render.com automático) o `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS` para local
   - `JWT_SECRET`: Clave secreta para tokens JWT.
   - `CORS_ALLOWED_ORIGINS`: Orígenes permitidos (`*` para desarrollo).

4. **Local (MySQL)**: Importar `database.sql` en phpMyAdmin o MySQL:
   ```bash
   mysql -u root -p < database.sql
   ```

5. **Render.com (PostgreSQL)**:
   - El proyecto usa `render.yaml` + `Dockerfile` para despliegue automático.
   - **Inicialización**: Acceder a `https://tu-app.onrender.com/setup_db.php` para crear las tablas.
   - **⚠️ IMPORTANTE**: Borrar `public/setup_db.php` inmediatamente después de usarlo.

6. **Configuración de Ruteo (Local/XAMPP)**:
   Si ejecutas el proyecto en una subcarpeta de XAMPP, el Router lo detecta automáticamente (`$router->setBasePath(dirname($_SERVER['SCRIPT_NAME']))`). También puedes configurar un VirtualHost en Apache (ej: `http://protectora.local`) apuntando a la carpeta `/public` del proyecto.

## Autenticación

La API usa **JWT (JSON Web Tokens)**. Para consumir las rutas protegidas, primero debes obtener un token vía login y enviarlo en las cabeceras de cada petición:

```http
Authorization: Bearer <tu_token_aqui>
```

## Endpoints

| Método   | Endpoint                     | Descripción                                         | Protegido (JWT) |
| :------- | :--------------------------- | :-------------------------------------------------- | :-------------: |
| **POST** | `/api/auth/register`         | Registrar un nuevo usuario                          |      ❌ No      |
| **POST** | `/api/auth/login`            | Iniciar sesión y obtener token JWT                  |      ❌ No      |
| **GET**  | `/api/mascotas`              | Listar mascotas                                     |      🔒 Sí      |
| **GET**  | `/api/mascotas/{id}`         | Ver ficha detallada de una mascota                  |      🔒 Sí      |
| **POST** | `/api/mascotas`              | Crear mascota (se asigna al usuario logueado)       |      🔒 Sí      |
| **POST** | `/api/mascotas/{id}`         | Actualizar mascota (`method="PUT"`)                 |      🔒 Sí      |
| **POST** | `/api/mascotas/{id}`         | Eliminar mascota (`method="DELETE"`)                |      🔒 Sí      |
| **POST** | `/api/mascotas/{id}/adoptar` | Adoptar una mascota disponible (asigna al logueado) |      🔒 Sí      |
| **GET**  | `/health`                    | Health check para comprobar que la API funciona     |      ❌ No      |

## Formato de Respuesta

**Éxito:**

```json
{
  "success": true,
  "timestamp": "2026-05-02T12:00:00+00:00",
  "data": { ... },
  "message": "Mensaje de éxito opcional"
}
```

**Error:**

```json
{
  "success": false,
  "timestamp": "2026-05-02T12:00:00+00:00",
  "error": {
    "code": "ERROR_CODE",
    "message": "Descripción legible del error"
  }
}
```

## Estructura de la Arquitectura

Para mantener un código limpio y escalable, el proyecto separa responsabilidades estrictamente:

```text
app/
├── Controllers/  # Controladores MVC (Lógica HTTP, delega la limpieza a Forms)
├── Core/         # Router y Dispatcher (Motor de enrutamiento)
├── Forms/        # Clases de Formulario, Validator y Sanitizer (Limpieza y validación de datos)
├── Middleware/   # Filtros previos (JwtMiddleware, CorsMiddleware)
├── Models/       # Modelos (Consultas PDO a Base de Datos)
└── config/       # Constantes y directorios base
```

## Características de Seguridad

- **Autenticación robusta**: JWT (HS256) validado por Middleware en todas las rutas protegidas.
- **Autorización por propiedad**: En actualización y borrado se verifica que el `usuario_id` del token coincida con el de la mascota.
- **Validación estricta**: Capa `Forms` dedicada a sanear (`trim`, `htmlspecialchars`) y validar datos antes de llegar al modelo.
- **Protección SQL Injection**: Uso exclusivo de Prepared Statements (`PDO`) en `DBAbstractModel`.
- **CORS Configurable**: Middleware para proteger el consumo desde orígenes no autorizados.
- **Contraseñas seguras**: Encriptadas en base de datos mediante `password_hash()`.
