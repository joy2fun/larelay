
# Larelay

Larelay is a tool that allows you to define webhook endpoints and then forward the requests received by those endpoints to other URL targets.

Features:
  - Includes a built-in web-based control panel
  - Ability to fan out (forward) requests to multiple URL targets
  - Filtering rules
  - Customize the headers and body of forwarded requests using templates

## Installation

### Using Docker

```sh
docker run --name larelay -p 8000:80 \
    -e ADMIN_ROOT_PASSWORD=YOUR-PASSWORD \
    ghcr.io/joy2fun/larelay:master

# generate app key
docker exec -it larelay php artisan key:generate

# run database migration and seeding
docker exec -it larelay php artisan admin:install
```

Now you can head to `http://localhost:8000/admin` and login using default account: `admin` .

### Available Enviroment Variables

```sh
# default administrator account
ADMIN_ROOT_USERNAME=admin
ADMIN_ROOT_PASSWORD=admin

# default administrator panel route path prefix
ADMIN_ROUTE_PREFIX=admin

# set to true if larelay is behind reverse proxy and accessed via https
ADMIN_HTTPS=false

# timezone
TZ=UTC
```

## Filterting rules

If any filtering rule has been defined for an endpoint target, Larelay will skip forwarding the request to that target when the rule expression evaluates to `false`, `null` or `0` etc.

Larelay's filtering rules are powered by [Symfony Expression Language](https://symfony.com/doc/current/reference/formats/expression_language.html). The following examples can help you quickly understand the basic usage and application of these filtering rules.

Forward the request to the target only if the `log_level` parameter in the request is equal to "error" :
```js
req.input('log_level') == "error"
```
**You can access any `GET` or `POST` parameter using `input` method on `req` [object](https://laravel.com/docs/11.x/requests#input).**

```js
req.input('log_level') in ["error", "warning"]
```
Checks if `log_level` parameter is either "error" or "warning".

```js
now.format('N') in [1, 2, 3, 4, 5]
```
Checks if the current day is a weekday. `now` is a [Carbon](https://carbon.nesbot.com/docs/) object, which is a PHP library that provides robust date and time manipulation capabilities, including the ability to convert dates and times to many different [formats](https://www.php.net/manual/en/datetime.format.php#refsect1-datetime.format-parameters).

## Override request headers and body using templates

Rename the `message` parameter to `error` before forwarding the request to the target.
```json
{
  "error": "{{ req.input('message') }}"
}
```

## Debugging

Larelay is shipped with integration for [Laravel Telescope](https://laravel.com/docs/11.x/telescope)
, which allows you to easily inspect all incoming requests and forwarded requests (HTTP Client requests in Laravel).
