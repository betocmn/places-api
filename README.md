# Places API

The Places API is a [Phalcon PHP][1] web service providing search capabilities for places around the world

## Get Started

### Requirements

* PHP >= 5.6
* [Apache][2] Web Server with [mod_rewrite][3] enabled or [Nginx][4] Web Server
* Latest stable [Phalcon Framework release][5] extension enabled
* Latest stable [Phalcon Developer Tools release][6] enabled
* [PostgreSQL][7] >= 9.4

### Installation

First you need to clone this repository:

```
$ git clone git@github.com:humbertomn/places.git
```

Install [Composer][8] and update the dependencies:

```sh
$ curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
$ composer update
```

Create the database and initialize the schema:

```sh
$ psql 'CREATE DATABASE places WITH OWNER = postgres ENCODING = 'UTF8';'
$ psql places < src/schema/initial.sql
```

## API Methods

### Authenticate
Authenticates client app via HTTP Auth. You need username:password.

URL: /users/authenticate

Method: GET

Request Example:
```
Headers{
    "Authorization": "'Basic sd9u19221934y='"
}
```

Response Example:
```
{
    "token": "fdsajlk32j4kldfklashfklhasdf",
    "expires": "234234234234",
}
```

[1]: https://phalconphp.com/
[2]: http://httpd.apache.org/
[3]: http://httpd.apache.org/docs/current/mod/mod_rewrite.html
[4]: http://nginx.org/
[5]: https://github.com/phalcon/cphalcon/releases
[6]: https://docs.phalconphp.com/en/latest/reference/tools.html
[7]: http://www.postgresql.org/
[8]: https://getcomposer.org/