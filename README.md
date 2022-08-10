
LARAVEL 8 

2 langkah mudah untuk optimize laravel di production, berikut langkah langkahnya :



## About Laravel

1. pada saat install vendor di laravel gunakan option --no-dev agar depedency untuk development tidak ikut terinstall.
------------------------------------------------------------------------------
composer install --optimize-autoloader --no-dev
------------------------------------------------------------------------------
2. gunakan artisan optimize
-----------------------------------------------
php artisan optimize
-----------------------------------------------.
