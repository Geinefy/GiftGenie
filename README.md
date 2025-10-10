# GiftGenie

GiftGenie is a web application built with Laravel that helps users find perfect gift suggestions based on their preferences.

## Prerequisites

Before you begin, ensure you have the following installed:
- [PHP](https://www.php.net/) (>= 8.1)
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/) (>= 16.x)
- [NPM](https://www.npmjs.com/)
- [SQLite](https://www.sqlite.org/index.html)

## Installation

1. Clone the repository
```bash
git clone https://github.com/Geinefy/GiftGenie.git
cd GiftGenie/giftgenie-laravel-combined-front-n-backend
```

2. Install PHP dependencies
```bash
composer install
```

3. Install Node.js dependencies
```bash
npm install
```

4. Create environment file
```bash
cp .env.example .env
```

5. Generate application key
```bash
php artisan key:generate
```

6. Create SQLite database
```bash
touch database/database.sqlite
```

7. Run database migrations and seeders
```bash
php artisan migrate
php artisan db:seed
```

## Running the Application

1. You can just run both frontend and backend using
```bash
composer run dev
```

### OR, you can run them separetly using the commands below

1. Start the Laravel development server
```bash
php artisan serve
```

2. In a separate terminal, compile and watch for asset changes
```bash
npm run dev
```

The application will be available at `http://localhost:8000`

## Development Commands

- Run tests
```bash
php artisan test
```

- Clear application cache
```bash
php artisan cache:clear
```

- Create a new controller
```bash
php artisan make:controller ControllerName
```

- Create a new model with migration
```bash
php artisan make:model ModelName -m
```

## Project Structure

- `app/` - Contains the core code of your application
  - `Http/Controllers/` - Controller classes
  - `Models/` - Eloquent model classes
  - `Providers/` - Service providers
- `database/` - Database migrations and seeders
- `public/` - Publicly accessible files
- `resources/` - Views, raw assets (SASS, JS, etc)
- `routes/` - Application routes
- `tests/` - Application tests

## Features

- User Authentication
- Gift Suggestions
- Search History
- Favorites Management
- User Dashboard
- Profile Management

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Additional Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Laravel News](https://laravel-news.com/)
- [Laracasts](https://laracasts.com/)
- [Laravel Blade Templates](https://laravel.com/docs/blade)
- [Laravel Eloquent](https://laravel.com/docs/eloquent)
