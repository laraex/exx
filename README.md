# Exchange  Script

#### Version 0.1

## Features

To be documented

## How to Install

1. Pull the Repo from the GitLab
2. Run "composer update"
3. Run "npm install"
4. Duplicate .env.example file as .env
5. Add your mysql db details there
6. php artisan key:generate
7. Run Migration as -- "php artisan migrate"
8. Populate Data as -- "php artisan db:seed"
9. Setup the Exchange Rates as -- "php artisan exchanger:getrates"
10. Setup the Root User as -- "php artisan exchanger:defaultuser"
11. Get Market Data-- "php artisan refresh:coins"

#Set Queue Order
php artisan queue:work --queue=trade,order,tradeevent
