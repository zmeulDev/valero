## Cpanel Installation
https://medium.com/@abuabdirohman/step-by-step-guide-deploying-and-installing-laravel-10-on-cpanel-3387b6bd7cc5

# GitClone with cPanel
- clone in /home/user/repositories/valero
- copy all files from /public/ to /public_html/
- update index.php with bellow content

```
<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../repositories/valero/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../repositories/valero/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__.'/../repositories/valero/bootstrap/app.php')
    ->handleRequest(Request::capture());
```

# storage link with cron

ln -s /home/valeroap/repositories/valero/storage/app/public /home/valeroap/public_html/storage


# storage link with route
Add this route to your routes file and run it on browser
```
    Route::get('/valero_storage_link', function () {
        Artisan::call('storage:link');
});
```


# GitClone with cPanel
- clone in /home/user/repositories/valero
- copy all files from /public/ to /public_html/
- update index.php with bellow content

```
<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../repositories/valero/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../repositories/valero/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__.'/../repositories/valero/bootstrap/app.php')
    ->handleRequest(Request::capture());
```