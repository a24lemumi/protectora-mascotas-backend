## Context

The project currently uses MySQL with PDO for local XAMPP development. To deploy professionally on Render.com with their managed PostgreSQL database, the codebase needs hybrid database support (detecting `DATABASE_URL` environment variable) and PostgreSQL-compatible SQL syntax.

## Goals / Non-Goals

**Goals:**
- Modify `DBAbstractModel.php` to support hybrid connections (PostgreSQL via `DATABASE_URL` or MySQL via `.env`)
- Change PDO driver to `pgsql` (PostgreSQL)
- Create `database_pg.sql` with PostgreSQL syntax adaptations
- Create `render.yaml` for Render.com infrastructure definition
- Update `composer.json` to require `ext-pdo_pgsql` extension
- Update `.env.example` with `DB_DRIVER=pgsql` and `DATABASE_URL` example

**Non-Goals:**
- Migrating existing MySQL data to PostgreSQL (separate task)
- Configuring frontend deployment (separate phase)
- Adding database migration system

## Decisions

### 1. Hybrid Database Connection

**Decision**: Modify `DBAbstractModel.php` to detect `DATABASE_URL` (Render standard) and parse it automatically, falling back to individual `.env` variables.

**Rationale**: Render.com provides `DATABASE_URL` as a single connection string. Local development uses individual variables. This approach supports both seamlessly.

**Implementation**: Use `parse_url()` to extract components from `DATABASE_URL` if present, otherwise use `$_ENV` variables.

### 2. PostgreSQL Syntax in SQL File

**Decision**: Create `database_pg.sql` with PostgreSQL syntax:
- Replace `INT AUTO_INCREMENT` with `SERIAL`
- Use `TIMESTAMP DEFAULT CURRENT_TIMESTAMP` (already compatible)
- Adjust string types if needed (`VARCHAR` is compatible)
- Use `ON DELETE SET NULL ON UPDATE CASCADE` (syntax adjustment)

### 3. Render Configuration

**Decision**: Create `render.yaml` defining:
- Web service: PHP with Document Root `/public`
- Managed PostgreSQL database
- Environment variables for JWT_SECRET, etc.

## Risks / Trade-offs

**[Risk] Breaking change for local MySQL development** → Document in README that local setup now requires PostgreSQL or `DATABASE_URL` override.

**[Risk] SQL syntax differences** → Test thoroughly on PostgreSQL before deploying.

## Migration Plan

1. Modify `DBAbstractModel.php` for hybrid connection support
2. Create `database_pg.sql` with PostgreSQL syntax
3. Create `render.yaml` with infrastructure definition
4. Update `composer.json` with `ext-pdo_pgsql` requirement
5. Update `.env.example` with PostgreSQL variables
6. Test connection with PostgreSQL locally (if available) or on Render
