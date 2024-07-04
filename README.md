
### envs

```sh
APP_NAME=larest
ADMIN_ROOT_USERNAME=root
ADMIN_ROOT_PASSWORD_HASH=''

DB_CONNECTION=mysql
DB_HOST=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
DB_PREFIX=

#TELESCOPE_PATH=
#HORIZON_PATH=
#ADMIN_DB_PREFIX=x_
#ADMIN_ROUTE_PREFIX=admin
#ADMIN_ENABLE_OMNI=true
```

### setup
```sh
php artisan key:generate
php artisan admin:install
# upgrade dcat. optional
composer upgrade dcat/laravel-admin
# php artisan vendor:publish --force
```
