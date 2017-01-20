# Package ACL pour Laravel 5.3 #

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

* Publier les la config et le seeder

```shell
php artisan vendor:publish --tag=acl
```

* Ajouter le trait UserACL au model User

```php
class User extends Authenticatable {
    use Notifiable, UserACL;
}
```

* Ajouter le le route middlewrae dans Http/Kernel.php

```php
protected $routeMiddleware = [
    ...
    'acl' => \NGiraud\ACL\Middleware\CheckPermission::class,
    ...
]
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
