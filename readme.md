# Hesto MultiAuth

- `multi-auth:install`

## Usage

### Step 1: Install Through Composer

```
composer require hesto/adminlte
```

### Step 2: Add the Service Provider

You'll only want to use these package for local development, so you don't want to update the production  `providers` array in `config/app.php`. Instead, add the provider in `app/Providers/AppServiceProvider.php`, like so:

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
php artisan multi-auth:install
```

### Step 4: Add new guards