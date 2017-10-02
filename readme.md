# Hesto MultiAuth for Laravel 5.3, 5.4, 5.5 (see version guidance)

- `php artisan multi-auth:install {guard} -f`
- `php artisan multi-auth:install {guard} -f --domain`
- `php artisan multi-auth:install {guard} {service} -f --lucid`

## Version Guidance

| Version | Laravel version |  Status         | Branch | Install                                  |
|---------|-----------------|-----------------|--------|------------------------------------------|
| 1.x     | 5.3 and 5.4     | EOL             | 1.0    | composer require hesto/multi-auth 1.*    |
| 2.x     | 5.5             | Latest          | 2.0    | composer require hesto/multi-auth        |


## What it does?
With one simple command you can setup multi auth for your Laravel project. The package installs:

- Model
- Migration
- Controllers
- Notification
- Routes
  - routes/web.php
    - {guard}/login
    - {guard}/register
    - {guard}/logout
    - Password Reset Routes
      - {guard}/password/reset
      - {guard}/password/email
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

```shell
composer require hesto/multi-auth --dev
```

### Step 2: Add the Service Provider (only for laravel lower than 5.5)

Laravel 5.5 uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider. You'll only want to use these package for local development, so this package will be included in require-dev section. When your site is deployed to production you will remove dev packages.

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

Using it like so: `['domain' => '{guard}.' . env('APP_DOMAIN')]`

### Step 4: Migrate new model table

```
php artisan migrate
```

### Step 5: Try it

Go to: `http://project_url/GuardName/login`

Example: `http://myproject.dev/customer/login`

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
If you want to change the redirect path for once your `guard` is logged out. Add and override the following method in
your {GuardName}Auth\LoginController:

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
  - Add guards, providers, passwords

- app/Http/Providers/RouteServiceProvider.php
  - Register routes

- app/Http/Kernel.php
  - Register middleware

- app/Http/Middleware/
  - Middleware for each guard

- app/Http/Controllers/{Guard}Auth/
  - New controllers

- app/{Guard}.php
  - New Model

- app/Notifications/{Guard}ResetPassword.php
  - Reset password notification

- database/migrations/
  - Migration for new model

- routes/web.php
  - Register routes

- routes/{guard}.php
  - Routes file for given guard

- resources/views/{guard}/

- Views for given guard

## Support on Beerpay
Hey dude! Help me out for a couple of :beers:!

[![Beerpay](https://beerpay.io/Hesto/multi-auth/badge.svg?style=beer-square)](https://beerpay.io/Hesto/multi-auth)  [![Beerpay](https://beerpay.io/Hesto/multi-auth/make-wish.svg?style=flat-square)](https://beerpay.io/Hesto/multi-auth?focus=wish)
