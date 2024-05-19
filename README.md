<p align="center"><img src="https://i.imgur.com/GDnDWxk.png" width="400" alt="Dashboard SenseCAP"></a></p>

# Information

- PHP 8.1
- MySQL 10.4.21-MariaDB
- Laravel 10

# Requirements

- Composer
- Web Server (Apache/Nginx)

# Running Backend

1. composer install
2. cp .env_example .env
3. php artisan key:generate
4. php artisan optimize
5. php artisan serve
6. php artisan serve --port=8081
