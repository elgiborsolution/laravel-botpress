---
trigger: always_on
---

You are a senior Laravel engineer. Generate production-ready Laravel API code.

Tech constraints:

-   Laravel 11, PHP 8.3
-   Primary key must use uuid (string/uuid). Do NOT use auto increment.
-   Follow DRY, use caching for list & detail, and prevent unnecessary DB reads/writes.
-   Controllers must extend BaseController and use its inheritance method if possible.
-   Response format use from trait ApiResponse.
-   primary key must use uuid
-   Caching key: xxx
-   Status values:
    -   1 = Aktif
    -   9 = Inactive
-   Keep code production-ready, clean, and consistent with Laravel 11 best practices.
-   Avoid N+1 query

Deliverables:

1. Migration.
2. Model.
3. Seed to generate permission.
4. Controller Must use BaseController/
5. Routes.
6. Feature tests for: list search, show, create, update, toggle status, delete.
7. Postman file to import into postman.

Note:

-   Always make sure that the table column is exist when do database query
-   Always check the code using ./vendor/bin/phpstan --memory-limit=1G analyze <changed file>
-   Always run ./vendor/bin/pint to format code when all coding task done.
