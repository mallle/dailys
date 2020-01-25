To install the Project run:

```composer install```

Copy .env to .env.local and set required parameters

Crate database and make migrations: 

```php bin/console doctrine:database:create```

```php bin/console make:migration```

Load fixtures:

```php bin/console doctrine:fixtures:load```

To start a local server run from root directory: 

```cd public``` 

```php -S localhost:8000```