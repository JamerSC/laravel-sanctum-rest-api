### Tasks & Activities for Sept 2 & 3

1. Create project `composer create-project laravel/laravel task-manager-api`

2. Environment setup - update logging to daily & database

3. Setup Database

-   Update db name
-   Run migration `php artisan migrate`
-   Install Authentication (Sanctum) `composer require laravel/sanctum`
-   Add Sanctum middleware in app/Http/Kernel.php under api ` \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class`

4. Laravel Basics - Done
5. Database & Models - Create Models & Migrations

-   `php artisan make:model Task -m`
-   Update migration file
-   Run migration `php artisan migrate`

6. Controllers

-   Authentication (Register & Login) create Auth controller `php artisan make:controller Api\V1\AuthController`
-   AuthController create 3 functions `register()`, `login()`, & `logout()`
-   Create TaskController `php artisan make:controller Api\V1\TaskController --api`
-   Complete the functions in TaskController class

7. Routes

-   Add routes for login, register, logout, & tasks (w/o apiResource)
-   Add route prefix V1
-   Add Sanctum Middleware for Authentication

8. CRUD API (hands-on practice) - Done

9. Postman updated auth > bearer token > paste login token details

### Tasks & Activities for Sept 4

1. Middleware & Error Handling

-   Create task resource `php artisan make:resource V1\TaskResoure`
-   Create task request `php artisan make:request V1\StoreTaskRequest`

2.
