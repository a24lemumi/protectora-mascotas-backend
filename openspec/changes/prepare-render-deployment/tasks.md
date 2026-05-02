## 1. Modify DBAbstractModel for hybrid connections

- [x] 1.1 Modify `DBAbstractModel::__construct()` to detect `DATABASE_URL` environment variable
- [x] 1.2 Parse `DATABASE_URL` using `parse_url()` to extract host, port, user, pass, path (dbname)
- [x] 1.3 Set PDO driver to `pgsql:` (change from `mysql:`)
- [x] 1.4 Fall back to individual `.env` variables if `DATABASE_URL` not present
- [x] 1.5 Update DSN format for PostgreSQL: `pgsql:host=%s;dbname=%s;port=%s`

## 2. Create PostgreSQL SQL file

- [x] 2.1 Create `database_pg.sql` in project root
- [x] 2.2 Replace `INT AUTO_INCREMENT PRIMARY KEY` with `SERIAL PRIMARY KEY`
- [x] 2.3 Keep `VARCHAR`, `DATE`, `TIMESTAMP` types (compatible)
- [x] 2.4 Adjust foreign key syntax if needed (`ON DELETE SET NULL ON UPDATE CASCADE`)

## 3. Create Render configuration

- [x] 3.1 Create `render.yaml` in project root
- [x] 3.2 Define web service with PHP environment
- [x] 3.3 Set Document Root to `/public` for the web service
- [x] 3.4 Define managed PostgreSQL database service
- [x] 3.5 Add environment variables (JWT_SECRET, etc.) to web service config

## 4. Update composer.json

- [x] 4.1 Add `ext-pdo_pgsql` to `require` section in `composer.json`

## 5. Update .env.example

- [x] 5.1 Add `DB_DRIVER=pgsql` to `.env.example`
- [x] 5.2 Add `DATABASE_URL` example (Render standard) to `.env.example`
- [x] 5.3 Keep or update individual DB variables (DB_HOST, DB_USER, etc.) for local fallback

## 6. Testing

- [ ] 6.1 Test `DBAbstractModel` connects with `DATABASE_URL` present
- [ ] 6.2 Test `DBAbstractModel` falls back to individual `.env` variables
- [ ] 6.3 Verify `database_pg.sql` can be imported to PostgreSQL
- [ ] 6.4 Verify `render.yaml` syntax is valid for Render.com
