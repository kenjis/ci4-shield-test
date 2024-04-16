# CodeIgniter4 Shield Test

This repository includes:

- CodeIgniter v4.5.1
- CodeIgniter Shield v1.0.3

## Requirements

- PHP 8.2 or later
- `composer` command (See [Composer Installation](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos))
- Git

## How to Use

### Install

```console
$ git clone https://github.com/kenjis/ci4-shield-test.git
$ cd ci4-shield-test/
$ composer install
```

### (Optional) Create Database

By default, this project uses SQLite3.

If you use MySQL, create a database:

```mysql
CREATE DATABASE `ci_shield` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
CREATE USER dbuser@localhost IDENTIFIED WITH mysql_native_password BY 'dbpasswd';
GRANT ALL PRIVILEGES ON ci_shield.* TO dbuser@localhost;
```

### Configure

```console
$ cp env.sample .env
```

If you use MySQL, change the configuration.

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

### How to Test HMAC SHA256 Token Authentication

#### 1. Register a User

Navigate to <http://localhost:8080/register>.

#### 2. Get a HMAC Token

```console
$ curl --location 'http://localhost:8080/auth/hmac' \
--header 'Content-Type: application/json' \
--data-raw '{"email":"admin@example.jp","password":"passw0rd!","token_name":"MacBook Air"}'
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
            "date": "2023-11-16 02:52:04.000000",
            "timezone_type": 3,
            "timezone": "UTC"
        },
        "created_at": {
            "date": "2023-11-16 02:49:49.000000",
            "timezone_type": 3,
            "timezone": "UTC"
        },
        "updated_at": {
            "date": "2023-11-16 02:52:04.000000",
            "timezone_type": 3,
            "timezone": "UTC"
        },
        "deleted_at": null
    },
    "hmac_token": {
        "name": "MacBook Air",
        "key": "9f6ea7ab9f78f33d3a3465d75bf76c16",
        "secretKey": "Dg2g47PAfHQjlJYFYGHRt4MedNqNnSj5/u5zHyVu6jA="
    }
}
```

#### 3. Access with the HMAC Token

```console
$ php spark hmac:request 9f6ea7ab9f78f33d3a3465d75bf76c16 \
Dg2g47PAfHQjlJYFYGHRt4MedNqNnSj5/u5zHyVu6jA= \
GET 'http://localhost:8080/hmac/api/users' ''
```

### Defined Routes

```console
+--------+-------------------------+--------------------+--------------------------------------------------------------------+----------------+---------------+
| Method | Route                   | Name               | Handler                                                            | Before Filters | After Filters |
+--------+-------------------------+--------------------+--------------------------------------------------------------------+----------------+---------------+
| GET    | /                       | »                  | \App\Controllers\Home::index                                       |                | toolbar       |
| GET    | register                | »                  | \CodeIgniter\Shield\Controllers\RegisterController::registerView   |                | toolbar       |
| GET    | login                   | »                  | \CodeIgniter\Shield\Controllers\LoginController::loginView         |                | toolbar       |
| GET    | login/magic-link        | magic-link         | \CodeIgniter\Shield\Controllers\MagicLinkController::loginView     |                | toolbar       |
| GET    | login/verify-magic-link | verify-magic-link  | \CodeIgniter\Shield\Controllers\MagicLinkController::verify        |                | toolbar       |
| GET    | logout                  | »                  | \CodeIgniter\Shield\Controllers\LoginController::logoutAction      |                | toolbar       |
| GET    | auth/a/show             | auth-action-show   | \CodeIgniter\Shield\Controllers\ActionController::show             |                | toolbar       |
| GET    | jwt/api/users           | »                  | \App\Controllers\Api\User::index                                   | jwt            | jwt toolbar   |
| GET    | hmac/api/users          | »                  | \App\Controllers\Api\User::index                                   | hmac           | hmac toolbar  |
| POST   | register                | »                  | \CodeIgniter\Shield\Controllers\RegisterController::registerAction |                | toolbar       |
| POST   | login                   | »                  | \CodeIgniter\Shield\Controllers\LoginController::loginAction       |                | toolbar       |
| POST   | login/magic-link        | »                  | \CodeIgniter\Shield\Controllers\MagicLinkController::loginAction   |                | toolbar       |
| POST   | auth/a/handle           | auth-action-handle | \CodeIgniter\Shield\Controllers\ActionController::handle           |                | toolbar       |
| POST   | auth/a/verify           | auth-action-verify | \CodeIgniter\Shield\Controllers\ActionController::verify           |                | toolbar       |
| POST   | auth/jwt                | »                  | \App\Controllers\Auth\LoginController::jwtLogin                    |                | toolbar       |
| POST   | auth/hmac               | »                  | \App\Controllers\Auth\LoginController::hmacLogin                   |                | toolbar       |
+--------+-------------------------+--------------------+--------------------------------------------------------------------+----------------+---------------+
```

## References

- https://github.com/codeigniter4/CodeIgniter4
- https://github.com/codeigniter4/shield
