GiftGenie Laravel scaffold

This is a minimal scaffold created from the existing React `GiftGenie` frontend. It is not a full Laravel installation — it's a starter structure (routes, controllers, Blade views, public entry) to help you convert/expand the project into a real Laravel application.

Quick start

1. cd into this folder:

```powershell
cd .\giftgenie-laravel
```

2. Install Laravel dependencies (you need Composer installed):

```powershell
composer install
```

3. Copy `.env.example` to `.env` and set APP_KEY and DB settings:

```powershell
copy .env.example .env
php artisan key:generate
```

4. Serve the app:

```powershell
php artisan serve --host=127.0.0.1 --port=8000
```

Notes
- This scaffold contains routes, basic controllers and Blade views that mirror the React pages in `../src/pages`.
- To make this a working Laravel app, run `composer create-project laravel/laravel .` or install the missing framework files. This scaffold is intended as a mapping & starting point.
