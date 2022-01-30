# Features have to do

- Purchase, Purchase Item crud
- Table: payments-receipt_no,dues,received_by,created_by
- Invoice edit amount 2 decimal
- Email for due invoices of customer
- logo must from gmail doc
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
