# CodeIgniter4 Shield Test

This repository includes:

- CodeIgniter v4.4.3
- CodeIgniter Shield v1.0.0-beta.7

## Requirements

- PHP 8.1 or later
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
CREATE DATABASE `ci_shield` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
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

### How to Test JSON Web Token (JWT) Authentication

#### 1. Register a User

Navigate to <http://localhost:8080/register>.

#### 2. Get a JWT

```console
$ curl --location 'http://localhost:8080/auth/jwt' \
--header 'Content-Type: application/json' \
--data-raw '{"email":"admin@example.jp","password":"passw0rd!"}'
```

```console
{
    "message": "User authenticated successfully",
    "user": {
        "id": 1,
        "username": "admin",
        "status": null,
        "status_message": null,
        "active": true,
        "last_active": {
            "date": "2023-04-18 05:41:44.000000",
            "timezone_type": 3,
            "timezone": "UTC"
        },
        "created_at": {
            "date": "2023-04-14 00:17:00.000000",
            "timezone_type": 3,
            "timezone": "UTC"
        },
        "updated_at": {
            "date": "2023-04-18 05:41:44.000000",
            "timezone_type": 3,
            "timezone": "UTC"
        },
        "deleted_at": null
    },
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJTaGllbGQgVGVzdCBBcHAiLCJzdWIiOiIxIiwiaWF0IjoxNjgxODA1OTMwLCJleHAiOjE2ODE4MDk1MzB9.DGpOmRPOBe45whVtEOSt53qJTw_CpH0V8oMoI_gm2XI"
}
```

#### 3. Access with the JWT

```console
$ curl --location --request GET 'http://localhost:8080/jwt/api/users' \
--header 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJTaGllbGQgVGVzdCBBcHAiLCJzdWIiOiIxIiwiaWF0IjoxNjgxODA1OTMwLCJleHAiOjE2ODE4MDk1MzB9.DGpOmRPOBe45whVtEOSt53qJTw_CpH0V8oMoI_gm2XI'
```

### Defined Routes

```console
+--------+-------------------------+--------------------+--------------------------------------------------------------------+----------------+---------------+
| Method | Route                   | Name               | Handler                                                            | Before Filters | After Filters |
+--------+-------------------------+--------------------+--------------------------------------------------------------------+----------------+---------------+
| GET    | /                       | »                  | \App\Controllers\Home::index                                       |                | toolbar       |
| GET    | register                | register           | \CodeIgniter\Shield\Controllers\RegisterController::registerView   |                | toolbar       |
| GET    | login                   | login              | \CodeIgniter\Shield\Controllers\LoginController::loginView         |                | toolbar       |
| GET    | login/magic-link        | magic-link         | \CodeIgniter\Shield\Controllers\MagicLinkController::loginView     |                | toolbar       |
| GET    | login/verify-magic-link | verify-magic-link  | \CodeIgniter\Shield\Controllers\MagicLinkController::verify        |                | toolbar       |
| GET    | logout                  | logout             | \CodeIgniter\Shield\Controllers\LoginController::logoutAction      |                | toolbar       |
| GET    | auth/a/show             | auth-action-show   | \CodeIgniter\Shield\Controllers\ActionController::show             |                | toolbar       |
| GET    | api/users               | »                  | \App\Controllers\Api\User::index                                   | jwt            | jwt toolbar   |
| POST   | register                | »                  | \CodeIgniter\Shield\Controllers\RegisterController::registerAction |                | toolbar       |
| POST   | login                   | »                  | \CodeIgniter\Shield\Controllers\LoginController::loginAction       |                | toolbar       |
| POST   | login/magic-link        | »                  | \CodeIgniter\Shield\Controllers\MagicLinkController::loginAction   |                | toolbar       |
| POST   | auth/a/handle           | auth-action-handle | \CodeIgniter\Shield\Controllers\ActionController::handle           |                | toolbar       |
| POST   | auth/a/verify           | auth-action-verify | \CodeIgniter\Shield\Controllers\ActionController::verify           |                | toolbar       |
| POST   | auth/jwt                | »                  | \App\Controllers\Auth\LoginController::jwtLogin                    |                | toolbar       |
+--------+-------------------------+--------------------+--------------------------------------------------------------------+----------------+---------------+
```

## References

- https://github.com/codeigniter4/CodeIgniter4
- https://github.com/codeigniter4/shield
