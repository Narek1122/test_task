Test Task

1: set up apache or nginx
2: composer install
3: cp .env.example .env 
4: set up a database config .env
5: php artisan key:generate
6: php artisan passport:install and copy the second Cliend ID, Client Secret to .env  PASSPORT_CLIENT_ID PASSPORT_CLIENT_SECRET
7: php artisan migrate --seed
