<?php

use Illuminate\Support\Facades\Cache;

if (!function_exists('cache_version')) {
    function cache_version() {
        return Cache::get('cache_version', 1);
    }
}

if (!function_exists('increment_cache_version')) {
    function increment_cache_version() {
        $version = cache_version();
        Cache::forever('cache_version', $version + 1);
        return $version + 1;
    }
} 