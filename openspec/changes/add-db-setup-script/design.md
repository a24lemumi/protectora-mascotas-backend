## Context

The project is deployed on Render.com with PostgreSQL database and Docker configuration. To initialize the database, a temporary web-accessible script is needed since Render doesn't provide easy database initialization tools.

## Goals / Non-Goals

**Goals:**
- Create `public/setup_db.php` for database initialization
- Require `app/bootstrap.php` to load environment variables and database connection
- Get PDO instance from `DBAbstractModel` (using hybrid connection logic already implemented)
- Read and execute `database_pg.sql` file using `getConnection()->exec()`
- Return JSON response with success confirmation or error details
- Script accessible via browser at `/setup_db.php` URL (no route definition needed)

**Non-Goals:**
- Adding authentication to the setup script (should be deleted after use)
- Creating a permanent admin panel for database management
- Handling database migrations or versioning

## Decisions

### 1. Script Location

**Decision**: Place script in `public/setup_db.php`.
**Rationale**: Accessible via web browser at `/setup_db.php` without adding routes. Simple and temporary.

### 2. Database Connection

**Decision**: Use `DBAbstractModel::getConnection()` to get PDO instance.
**Rationale**: Leverages existing hybrid connection logic (DATABASE_URL or .env variables) already implemented.

### 3. SQL Execution

**Decision**: Use `file_get_contents()` to read `database_pg.sql` and `exec()` to run it.
**Rationale**: Simple approach for one-time setup. The SQL file contains DROP/CREATE statements.

### 4. Security Consideration

**Decision**: Document that script should be deleted after use.
**Rationale**: Temporary tool for deployment initialization, not a permanent feature.

## Risks / Trade-offs

**[Risk] Security exposure** → Script accessible to anyone who knows the URL. Must be deleted immediately after use.

**[Risk] Database wipe** → `database_pg.sql` starts with DROP DATABASE. Only run on fresh Render deployment.

## Migration Plan

1. Create `public/setup_db.php` with bootstrap require and DB connection
2. Read and execute `database_pg.sql` using PDO exec()
3. Return JSON response (success with tables created, or error details)
4. Document usage in README.md
5. Test on Render deployment (if available) or local PostgreSQL
