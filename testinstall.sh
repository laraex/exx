composer dump-autoload
php artisan migrate:fresh
php artisan db:seed
php artisan exchanger:defaultuser --default
php artisan exchanger:getrates
php artisan refresh:coins
php artisan exchanger:redis --delete
php artisan exchanger:admintxn