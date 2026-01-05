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
        if (!App::runningInConsole() && Schema::hasTable('settings')) {
            $settings = Setting::all()->pluck('value', 'key')->toArray();
            $logo = Setting::getLogo();
            config($settings);
            config(['app_logo_path' => $logo]);

            // Update SEO config with dynamic app name
            if (isset($settings['app_name'])) {
                config(['seo.title.suffix' => ' | ' . $settings['app_name']]);
                config(['seo.site_name' => $settings['app_name']]);
                config(['seo.author.fallback' => $settings['app_name']]);
            }
        }
    }
}