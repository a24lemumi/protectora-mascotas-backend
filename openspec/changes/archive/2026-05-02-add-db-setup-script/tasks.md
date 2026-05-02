## 1. Create setup_db.php script

- [x] 1.1 Create `public/setup_db.php` file
- [x] 1.2 Require `app/bootstrap.php` at the start of the script
- [x] 1.3 Get PDO connection using `DBAbstractModel::getConnection()` (leverage hybrid connection)
- [x] 1.4 Read contents of `database_pg.sql` using `file_get_contents()`
- [x] 1.5 Execute SQL using `getConnection()->exec()` method
- [x] 1.6 Return JSON response with success message and list of tables created
- [x] 1.7 Handle errors with try-catch and return JSON error response

## 2. Security considerations

- [x] 2.1 Add comment at top of file warning to delete after use
- [x] 2.2 Document in README.md that script should be deleted after deployment

## 3. Testing

- [ ] 3.1 Test script on local PostgreSQL (if available)
- [ ] 3.2 Test JSON response format (success case)
- [ ] 3.3 Test JSON response format (error case - invalid SQL)
- [ ] 3.4 Verify script creates all tables from `database_pg.sql`
