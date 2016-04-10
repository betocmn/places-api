# Places API

The Places API is a [Phalcon PHP][1] web service providing search capabilities for places around the world

Demo: http://api-places.us-west-2.elasticbeanstalk.com/

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

Create the database:

```sh
$ psql 'CREATE DATABASE places WITH OWNER = postgres ENCODING = 'UTF8';'
```

## API Methods

### Authenticate
Authenticates client app via HTTP Auth. You need username:password.

URL: /users/authenticate

Method: POST

Request Example:
```
Headers{
    "Authorization": "'Basic ZGVtbzpUNzgzWXVhaHdtTzk4VXkxMWtsM0dIag=='"
}
```

Response Example:
```
{
  "data": {
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ1c2VybmFtZSIsInN1YiI6IjEiLCJpYXQiOjE0NjAzMjkyMzQsImV4cCI6MjkyMTI2MzI2OH0.LevTDdUf8qzyVRpccdZn1dhmbrUsBbTTG-S9nIVchwk",
    "expires": 1460934034
  }
}
```

### Find Nearby Places by Type
Searches for nearby places by type

URL: /places/search?type={type}&location={location}&token={your-authentication-token}

Method: GET

Response Example:
```
{
    "place": {
        "name": "Manly Cafe",
        "address": "33 Herald St, Manly 2018",
        ...
    },
    "place": {
        "name": "Manly Pizza",
        "address": "11 Herald St, Manly 2018",
        ...
    },

}
```

### Get Recommendations
Searches for nearby places accordingly to the preferences of each person of a group

URL: /places/recommendations?location={location}&token={your-authentication-token}

Method: POST

Request Example:
```
[
  {
    "name": "Bob",
    "title": "executive",
    "likes": [
      "indian",
      "chinese",
      "malaysian"
    ],
    "dislikes": [
      "Australian"
    ],
    "requirements": "gluten free"
  },
  {
    "name": "Jose",
    "title": "developer",
    "likes": [
      "indian",
      "chinese"
    ],
    "dislikes": [
      "thai"
    ]
  },
  {
    "name": "Aloysia",
    "title": "evangelist",
    "likes": [
      "chinese"
    ],
    "dislikes": [
      "Australian"
    ],
    "requirements": "gluten free"
  }
]
```

Response Example:
```
{
    "place": {
        "name": "Manly Cafe",
        "address": "33 Herald St, Manly 2018",
        ...
    },
    "place": {
        "name": "Manly Pizza",
        "address": "11 Herald St, Manly 2018",
        ...
    },

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