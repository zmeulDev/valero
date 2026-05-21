<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;


class SettingServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $appName = config('app.name');
        $appDescription = config('app.description', 'Discover the latest articles, insights, and updates.');

        if (!App::runningInConsole() && Schema::hasTable('settings')) {
            $settings = Setting::all()->pluck('value', 'key')->toArray();
            $logo = Setting::getLogo();
            config($settings);
            config(['app_logo_path' => $logo]);

            $appName = $settings['app_name'] ?? $appName;
            $appDescription = $settings['app_seo_description'] ?? $appDescription;
        }

        // Ensure app_name is always available, even in console or when DB is empty
        if (!config('app_name')) {
            config(['app_name' => $appName]);
        }

        if (!config('app_seo_description')) {
            config(['app_seo_description' => $appDescription]);
        }

        // Update SEO config with dynamic app name
        config(['seo.title.suffix' => ' | ' . config('app_name')]);
        config(['seo.site_name' => config('app_name')]);
        config(['seo.author.fallback' => config('app_name')]);

        // Set homepage title so seo() helper produces the correct title on the home page
        config(['seo.title.homepage_title' => config('app_name') . ' - ' . config('app_seo_title')]);
    }
}