<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CacheServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Clear cache when database changes
        DB::listen(function ($query) {
            if (str_contains(strtolower($query->sql), 'insert') ||
                str_contains(strtolower($query->sql), 'update') ||
                str_contains(strtolower($query->sql), 'delete')) {
                Cache::tags(['articles', 'homepage'])->flush();
            }
        });
    }
} 