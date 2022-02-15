# Features have to do

- Dashboard: table-1: customer-list for top-5-due, table-2: invoice-list for top-5-amount status-due/pending
- Dashboard: Chart-purchase/sale: monthly/yearly
- Need to test: amount 2 decimal
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
