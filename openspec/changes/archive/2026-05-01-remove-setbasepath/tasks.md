## 1. Remove BasePath from Router

- [x] 1.1 Remove `$basePath` property from Router class
- [x] 1.2 Remove `setBasePath()` method from Router
- [x] 1.3 Remove basePath normalization from `addRoute()` method
- [x] 1.4 Simplify `cleanUri()` to not strip basePath

## 2. Update index.php

- [x] 2.1 Remove `$router->setBasePath()` call from public/index.php

## 3. Testing

- [ ] 3.1 Verify Router.php has no setBasePath or basePath references
- [ ] 3.2 Verify routes work without basePath (direct URL matching)
