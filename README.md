# Features have to do

- dashboard
- Previous Balance in invoice preview

## command

php artisan db:seed --force
php artisan migrate:fresh --seed
php artisan db:seed --class=UserSeeder

## Procfile
web: vendor/bin/heroku-php-apache2 public/
## DB
heroku addons:create heroku-postgresql:hobby-dev
heroku config

## config  >>  database.php
$DATABASE_URL=parse_url('Your database URL');

heroku run php artisan migrate
