<h1 align="center">🌄 <code>goodmoment.tw</code></h1>

----

![BUILT WITH LOVE](https://forthebadge.com/images/badges/built-with-love.svg)

[![PHP 8.1](https://img.shields.io/badge/PHP-8.1-8892BF?logo=php)](https://php.net/) [![Laravel 9](https://img.shields.io/badge/Laravel-9-FF2D20?logo=laravel)](https://laravel.com/) [![Vue.js 3](https://img.shields.io/badge/Vue.js%20-3-4fc08d?logo=vue.js)](https://vuejs.org) [![Inertia.js](https://img.shields.io/badge/Made%20with-Inertia.js-6B45C1)](https://inertiajs.com/)

`goodmoment.tw` is a branding website made for "好時・左鎮公舘."

## Installation

Install dependencies:
```
$ composer install
$ npm ci
```

Copy and edit .env:
```
$ php -r "file_exists('.env') || copy('.env.example', '.env');"
$ vim .env
```

Install application:

```
$ php artisan key:generate
$ php artisan migrate # or migrate:fresh to re-install
$ php artisan install
$ php artisan db:seed
```

## Deployment

The deployment process is done through GitHub Actions. See [the deploy workflow file](.github/workflows/deploy.yml) for details.

To run the website, you must set up following softwares on the host:

- PHP 8.1
- MySQL 8

Most of the configuration files can be found inside `etc` folder of this repository, along with the systemd unit files.

## Tests

### Unit Test / Feature Test
``` 
$ php artisan test
```

## Features

<!-- @TODO: list features -->

## License

`AGPL-3.0-or-later`  
[See LICENSE for details.](LICENSE)
