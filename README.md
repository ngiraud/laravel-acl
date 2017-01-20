# Package ACL pour Laravel 5.3 #

### Requis ###
Il faut d'abord effectuer l'installation de l'authentification dans le projet Laravel. Cela peut-être fait grâce à la commande :
```shell
php artisan make:auth
```

### Installation ###

* Ajouter les lignes dans le composer.json

```shell
"require": {
  ...
  "ngiraud/laravel-acl": "^1.0.0",
  ...
},
```
et exécuter la commande :
```shell
composer update
```

* Ajouter le ServiceProvider dans app.php

```php
NGiraud\ACL\ACLServiceProvider::class,
```

* Publier la config et le seeder

```shell
php artisan vendor:publish --tag=acl
composer dump-autoload
```
* Ajouter le trait UserACL au model User

```php
use NGiraud\ACL\UserACL;

class User extends Authenticatable {
    use Notifiable, UserACL;
}
```

* Ajouter le route middleware dans Http/Kernel.php

```php
protected $routeMiddleware = [
    ...
    'acl' => \NGiraud\ACL\Middleware\CheckPermission::class,
    ...
]
```

* Ajouter une variable dans le .env pour les superadmin users (id user séparés par des virgules)

```php
SUPERADMIN_USERS=1,2,3,4,5
```

* On peut ajouter une règle dans les routes par exemple en faisant :
```php
Route::get('/admin/test', [ 'as' => 'admin.test', 'uses' => 'HomeController@test' ])->middleware('acl:manage_users');
```

* Migrer les tables et exécuter les seeds

```shell
php artisan migrate
php artisan db:seed --class=UserTableSeeder
php artisan db:seed --class=ACLSeeder
```
