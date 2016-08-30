# Hesto MultiAuth

- `php artisan multi-auth:install {guard} -f`

# TODO
- Test Passwords Controllers (im not sure if it works yet)
- Some code refactor (nothing to worry about)

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

//examples
php artisan multi-auth:install admin -f
php artisan multi-auth:install employee -f
php artisan multi-auth:install customer -f
```

Notice:
If you don't provide `-f` flag, it will not work. It is a protection against accidental activation.

### Step 4: Migrate new model table 

```
php artisan migrate
```

### Step 5: Try it

Go to: `http://url_to_your_proejct/guard/login`
Example: `http://project/admin/login`

### Step 4: Options

If you don't want model and migration use `-m` flag.
```
php artisan multi-auth:install admin -f -m
```

If you don't want views use `-v` flag.
```
php artisan multi-auth:install admin -f -v
```

If you don't routes in your `routes/web.php` file, use `-r` flag.

```
php artisan multi-auth:install admin -f -r
```

### Files which are changed and added by this package
- config/auth.php
  - add guards, providers, passwords

- app/Http/Providers/RouteServiceProvider.php
register routes

- app/Http/Kernel.php
  - register middleware

- app/Http/Middleware/
  - middleware for each guard

- app/Http/Controllers/{Guard}Auth/
  - new controllers

- app/Http/{Guard}.php
  - new Model

- database/migrations/
  - migration for new model

- routes/web.php
  - register routes

- routes/{guard}.php
  - routes file for given guard

- resources/views/{guard}/
  - views for given guard
