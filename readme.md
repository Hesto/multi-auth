# Hesto MultiAuth for Laravel 5.3

- `php artisan multi-auth:install {guard} -f`
- `php artisan multi-auth:install {guard} -f --domain`
- `php artisan multi-auth:install {guard} {service} -f --lucid`

## What it does?
With one simple command you can setup multi auth for your Laravel 5.3 project. The package installs:
- Model
- Migration
- Controllers
- Notification
- Routes
  - routes/web.php
    - {guard}/login
    - {guard}/register
    - {guard}/logout
    - password reset routes
  - routes/{guard}.php
    - {guard}/home
- Middleware
- Views
- Guard
- Provider
- Password Broker
- Settings 

## Usage

### Step 1: Install Through Composer

```
composer require hesto/multi-auth
```

### Step 2: Add the Service Provider

You'll only want to use these package for local development, so you don't want to update the production `providers` array in `config/app.php`. Instead, add the provider in `app/Providers/AppServiceProvider.php`, like so:

```php
public function register()
{
	if ($this->app->environment() == 'local') {
		$this->app->register('Hesto\MultiAuth\MultiAuthServiceProvider');
	}
}
```

### Step 3: Install Multi-Auth files in your project

```
php artisan multi-auth:install {singular_lowercase_name_of_guard} -f

// Examples
php artisan multi-auth:install admin -f
php artisan multi-auth:install employee -f
php artisan multi-auth:install customer -f
```

Notice:
If you don't provide `-f` flag, it will not work. It is a protection against accidental activation.

Alternative:

If you want to install Multi-Auth files in a subdomain you must pass the option `--domain`.
```
php artisan multi-auth:install admin -f --domain
php artisan multi-auth:install employee -f --domain
php artisan multi-auth:install customer -f --domain
```

To be able to use this feature properly, you should add a key to your .env file:
```
APP_DOMAIN=yourdomain.com
```
This will allow us to use it in the routes file, prefixing it with the domain feature from Laravel routing system.

Using it like so: `['domain' => '{guard}.' . env('APP_DOMAIN')]`.

### Step 4: Migrate new model table 

```
php artisan migrate
```

### Step 5: Try it

Go to: `http://url_to_your_proejct/guard/login`
Example: `http://project/admin/login`

## Options

If you don't want model and migration use `--model` flag.
```
php artisan multi-auth:install admin -f --model
```

If you don't want views use `--views` flag.
```
php artisan multi-auth:install admin -f --views
```

If you don't want routes in your `routes/web.php` file, use `--routes` flag.

```
php artisan multi-auth:install admin -f --routes
```

## Note
If you want to adapt the redirect path once your `guard` is logged out, add and override the following method in
your {guard}Auth\LoginController:

```php
/**
 * Get the path that we should redirect once logged out.
 * Adaptable to user needs.
 *
 * @return string
 */
public function logoutToPath() {
    return '/';
}
```

## Files which are changed and added by this package
- config/auth.php
  - add guards, providers, passwords

- app/Http/Providers/RouteServiceProvider.php
  - register routes

- app/Http/Kernel.php
  - register middleware

- app/Http/Middleware/
  - middleware for each guard

- app/Http/Controllers/{Guard}Auth/
  - new controllers

- app/Http/{Guard}.php
  - new Model
  
- app/Notifications/{Guard}ResetPassword.php
  - reset password notification

- database/migrations/
  - migration for new model

- routes/web.php
  - register routes

- routes/{guard}.php
  - routes file for given guard

- resources/views/{guard}/
  - views for given guard
  
## Changelog

### Note: Never install configurations with same guard again after installed new version of package. So if you already installed your `admin` guard, don't install it again after you update package to latest version. 

### v1.0.7
- changed {guard}/logout route method from `get` to `post`
- added `{guard}.guest` middleware to redirect from login page if user is already logged in
- added home view after login

### v1.0.6
- added `auth:{guard}` middleware to `app\Providers\RouteServiceProvider.php`. If you have installed multi-auth guard with old version add middleware manually:
```php
Route::group([
    'middleware' => ['web', 'admin', 'auth:admin'], //you need to add the last middleware to array to fix it (version < v.1.0.6)
    'prefix' => 'admin',
    'as' => 'admin.',
    'namespace' => $this->namespace,
], function ($router) {
    require base_path('routes/admin.php');
});
```

### v1.0.5
- composer.json fix

### v1.0.4
- added name and prefix to route group configuration in `RouteServiceProvider`

```php
Route::group([
    'prefix' => 'admin', //if you have older version of package ( < v1.0.4) add this line manually,
    'as' => 'admin.', //if you have older version of package ( < v1.0.4) add this line manually (the DOT at the end is important), 
    'middleware' => ['web', 'admin'],
    'namespace' => $this->namespace,
], function ($router) {
    require base_path('routes/admin.php');
});
```

- Now you will be able to name your routes without adding guard's name to route name in your `routes/{guard}.php` and your routes will be named (its important)

```php
//New way
Route::get('/home', function () { // <- no {guard} prefix and it has proper name (admin.home)
    //content
})->name('home'); // http://your-project/admin/home

//Old way
Route::get('/admin/home', function () { // <- with {guard} prefix
    //content
})->name('admin.home'); // http://your-project/admin/home
```

### v1.0.3
- changed deafult auth's layout name from `app.blade.php` to `auth.blade.php` 
