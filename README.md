# Package ACL pour Laravel 5.3 #

### Installation ###

* Ajouter les lignes dans le composer.json

```shell
"require": {
  ...
  "ngiraud1/acl": "dev-master",
  ...²
},
"repositories": [{
  "type": "vcs",
  "url": "https://ngiraud1@bitbucket.org/ngiraud1/laravel_packages-acl.git"
}],
```
et faire la commande :
```shell
composer update
```

* Ajouter le ServiceProvider dans app.php

```php
NGiraud\ACL\ACLServiceProvider::class,
```

* Publier les vues, traductions et assets

```shell
php artisan vendor:publish --provider="NGiraud\News\NewsServiceProvider" --tag=news
```

* Migrer les tables

```shell
php artisan migrate
```

* Le menu pour les news peut être ajouté grâce à l'inclusion suivante
```php
@include('acl::admin.acl.menu')
```