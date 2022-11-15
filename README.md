
default server runs on 5173 port


### Installation

#### Prerequisites
    - PHP 8.1 > 
    - Swoole (for octane backend server)

#### Install App packages and laravel
```shell
composer install
```

### install octane and choose swoole for application server
    - Configure database connection in .env
```shell
php artisan migrate
php artisan db:seed

php artisan octane:install
```
When octane installer asks about backend server choose Swoole 

### Run application

```shell
 # add --watch for watch file changes.  if you  start using this parameter make sure you have installed chokidar and node
 # npm install --save-dev chokidar
 php artisan octane:start
```


### Commands

```shell
php artisan fetch:countries

php artisan fetch:statistics
```

#### Start Scheduling country statistic 
```shell
php artisan schedule:work  # every 1 hour scheduling fetch:statistics command
```
