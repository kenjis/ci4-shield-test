# CodeIgniter4 Shield Test

This repository includes:

- CodeIgniter v4.2.11
- CodeIgniter Shield v1.0.0-beta.3

## Requirements

- PHP 7.4 or later
- `composer` command (See [Composer Installation](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos))
- Git

## How to Use

### Install

```console
$ git clone https://github.com/kenjis/ci4-shield-test.git
$ cd ci4-shield-test/
$ composer install
```

### Create Database

```mysql
CREATE DATABASE `ci_shield` DEFAULT CHARACTER SET utf8mb4;
CREATE USER dbuser@localhost IDENTIFIED WITH mysql_native_password BY 'dbpasswd';
GRANT ALL PRIVILEGES ON ci_shield.* TO dbuser@localhost;
```

### Configure

```console
$ cp env.sample .env
```

### Run Database Migration

```console
$ php spark migrate --all
```

### Run Development Server

```console
$ php spark serve
```

### Defined Routes

```console
+--------+-------------------------+--------------------------------------------------------------------+----------------+---------------+
| Method | Route                   | Handler                                                            | Before Filters | After Filters |
+--------+-------------------------+--------------------------------------------------------------------+----------------+---------------+
| GET    | /                       | \App\Controllers\Home::index                                       |                | toolbar       |
| GET    | register                | \CodeIgniter\Shield\Controllers\RegisterController::registerView   |                | toolbar       |
| GET    | login                   | \CodeIgniter\Shield\Controllers\LoginController::loginView         |                | toolbar       |
| GET    | login/magic-link        | \CodeIgniter\Shield\Controllers\MagicLinkController::loginView     |                | toolbar       |
| GET    | login/verify-magic-link | \CodeIgniter\Shield\Controllers\MagicLinkController::verify        |                | toolbar       |
| GET    | logout                  | \CodeIgniter\Shield\Controllers\LoginController::logoutAction      |                | toolbar       |
| GET    | auth/a/show             | \CodeIgniter\Shield\Controllers\ActionController::show             |                | toolbar       |
| POST   | register                | \CodeIgniter\Shield\Controllers\RegisterController::registerAction |                | toolbar       |
| POST   | login                   | \CodeIgniter\Shield\Controllers\LoginController::loginAction       |                | toolbar       |
| POST   | login/magic-link        | \CodeIgniter\Shield\Controllers\MagicLinkController::loginAction   |                | toolbar       |
| POST   | auth/a/handle           | \CodeIgniter\Shield\Controllers\ActionController::handle           |                | toolbar       |
| POST   | auth/a/verify           | \CodeIgniter\Shield\Controllers\ActionController::verify           |                | toolbar       |
| CLI    | ci(.*)                  | \CodeIgniter\CLI\CommandRunner::index/$1                           |                |               |
+--------+-------------------------+--------------------------------------------------------------------+----------------+---------------+
```

## References

- https://github.com/codeigniter4/CodeIgniter4
- https://github.com/codeigniter4/shield
