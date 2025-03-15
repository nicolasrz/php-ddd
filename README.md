# PHP-DDD
Exemple of Domain-Driven Design project with vanilla PHP only


# How to install
```
cd php-ddd 
composer install
composer dump-autoload 
```

# How to run
- `cd /php-ddd`
- `php -S localhost:8000 -t src`
- go on http://localhost:8000

# Routes availables
- /register
- /login (admin/Password123)
- /logout
- /missions (can only list missions)

# Run tests
```
cd /php-ddd. 
vendor/bin/phpunit tests
```