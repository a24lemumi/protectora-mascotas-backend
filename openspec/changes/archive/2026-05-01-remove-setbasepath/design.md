## Context

`setBasePath()` was added to Router to handle subdirectory deployments, but it wasn't part of the original design. We need to remove it entirely.

## Goals / Non-Goals

**Goals:**
- Remove `setBasePath()` method from Router
- Remove `$basePath` property and normalization logic
- Remove `cleanUri()` basePath stripping
- Remove `$router->setBasePath()` from index.php

**Non-Goals:**
- Adding alternative subdirectory handling
- Modifying route definitions
- Changing middleware or controllers

## Decisions

### 1. Remove BasePath Logic Completely

**Decision**: Strip all basePath-related code from Router.php.

**Rationale**: User explicitly stated it never existed from the beginning and should be removed.

## Risks / Trade-offs

**[Risk] Routes break in subdirectory** → Ensure deployment environment matches route definitions (use virtual hosts or adjust document root)

## Migration Plan

1. Remove `$basePath` property from Router
2. Remove `setBasePath()` method
3. Simplify `addRoute()` to not normalize path
4. Simplify `cleanUri()` to not strip basePath
5. Remove `$router->setBasePath()` from index.php
