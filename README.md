
# Larelay

Larelay is a tool that allows you to define webhook endpoints and then forward the requests received by those endpoints to other URL targets.

Features:
  - Includes a built-in web-based control panel
  - Ability to fan out (forward) requests to multiple URL targets
  - Filtering rules
  - Customize the headers and body of forwarded requests using templates

## Install

### Using Docker

```sh
docker run --name larelay -p 8000:80 \
    -e ADMIN_ROOT_PASSWORD=your-password \
    ghcr.io/joy2fun/larelay:master

# generate app key
docker exec -it larelay php artisan key:generate

# run admin database migration and seeding
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

# locale
LOCALE: "en"

# timezone
TZ: "UTC"
```
