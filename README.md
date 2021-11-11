# Features have to do

- spaces must be reduced
- Invoice edit amount 2 decimal
- Email for due invoices of customer
- logo must from gmail doc
- logo space should be reduce
- Invoice create 2 menu
- dashboard
- customer report - search by balance gt/0

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
