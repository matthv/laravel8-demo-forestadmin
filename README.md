# LARAVEL DEMO FOREST ADMIN

![HOME](https://s3-eu-west-1.amazonaws.com/blog.forestadmin.com/2021/11/FA-article-buildAdminPanel@2x.png)

* [Requirements](#Requirements)
* [Configuration](#Configuration)
* [Forest Admin](#Forest-Admin)
* [Serving Laravel](#Serving-Laravel)


# Requirements

- php >= 7.4

# Configuration

### composer
update the repositories/url section and add your local forest admin package.  
example : */Users/johndoe/.../laravel-forestadmin*  

```
composer install
```

### .env file
```
cp .env.example.com .env
php artisan key:generate
```
set your database connection (DB section)

### migrate & seed
```
php artisan migrate && php artisan db:seed
```

### Assets
```
npm install && npm run production
```

## Forest Admin
Start your onboarding on Forest Admin.
```
composer require forestadmin/laravel-forestadmin
php artisan vendor:publish --provider="ForestAdmin\LaravelForestAdmin\ForestServiceProvider" --tag="config"
php artisan forest:setup-keys YOUR-FOREST-KEY
```

## Serving Laravel
```
php artisan serve
```
