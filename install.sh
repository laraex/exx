composer update
npm install
php artisan key:generate
php artisan migrate:fresh
php artisan db:seed
php artisan exchanger:getrates
php artisan exchanger:defaultuser
php artisan refresh:coin
php artisan exchanger:redis --delete