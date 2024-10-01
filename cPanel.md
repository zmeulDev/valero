## Cpanel Installation
https://medium.com/@abuabdirohman/step-by-step-guide-deploying-and-installing-laravel-10-on-cpanel-3387b6bd7cc5

# .htaccess
```
RewriteEngine on
RewriteCond %{HTTP_HOST} ^domain.com$ [NC,OR]
RewriteCond %{HTTP_HOST} ^domain.com$
RewriteCond %{REQUEST_URI} !public/
RewriteRule (.*) /public/$1 [L]
```

# storage link
Add this route to your routes file and run it on browser
```
    Route::get('/valero_storage_link', function () {
        Artisan::call('storage:link');
});
```