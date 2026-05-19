# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Commands

### Setup
To set up the project for the first time, run:
```bash
composer run setup
```
This command will install PHP and Node.js dependencies, set up the environment, generate an application key, and run database migrations.

### Local Development
To run the local development server (PHP backend, queue listener, logs, and Vite frontend assets), use:
```bash
composer run dev
```

### Build Frontend Assets
To compile frontend assets for production:
```bash
npm run build
```

### Run Tests
To run all PHPUnit tests:
```bash
composer run test
```
This command clears the config cache and then runs the tests.

To run a single PHPUnit test (example: `tests/Unit/ExampleTest.php`):
```bash
php artisan test --testsuite=Unit --filter=ExampleTest
```
Adjust the `--testsuite` and `--filter` flags based on the specific test you want to run.

### Linting
The project uses `laravel/pint` for PHP code style. To run Pint:
```bash
php artisan pint
```
To automatically fix linting issues:
```bash
php artisan pint --preset=laravel
```
You might need to adjust the preset based on configuration.

## High-Level Architecture

This project is a Laravel application, which follows a Model-View-Controller (MVC) architectural pattern.

### Backend (PHP/Laravel)
*   **`app/`**: Contains the core application logic.
    *   `app/Http/Controllers`: Handles incoming HTTP requests and returns responses.
    *   `app/Models`: Eloquent ORM models representing database tables and business logic.
    *   `app/Providers`: Service providers for bootstrapping services.
*   **`routes/web.php`**: Defines web routes for the application.
*   **`database/`**: 
    *   `database/migrations`: Manages database schema changes.
    *   `database/seeders`: Populates the database with initial data.
*   **`config/`**: Stores application configuration files.
*   **`resources/views`**: Blade templates for server-rendered HTML.
*   **Filament**: The project utilizes Filament (`filament/filament`) for an admin panel. This typically involves custom pages, resources, and forms defined within the Filament ecosystem, often located within the `app/Filament/` directory if custom resources are present.

### Frontend (JavaScript/Vite/TailwindCSS)
*   **`resources/js`**: Contains JavaScript assets, likely using a modern framework (e.g., Alpine.js, as indicated by `package.json`).
*   **`resources/css`**: Contains CSS assets, primarily using Tailwind CSS.
*   **`vite.config.js`**: Configuration for Vite, the frontend build tool, which bundles and compiles JavaScript and CSS.
*   **`package.json`**: Manages Node.js dependencies and frontend build scripts.

### Database
The application interacts with a relational database, managed through Laravel Eloquent ORM. Database schema changes are handled via migrations in `database/migrations`.

### Testing
PHPUnit is used for backend testing, with test files located in the `tests/` directory.
