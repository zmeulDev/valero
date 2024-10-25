<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // Import Carbon for date handling

class SettingSeeder extends Seeder
{

    public function run(): void
    {
        $now = Carbon::now(); // Get the current timestamp

        $settings = [
            ['key' => 'app_name', 'value' => env('APP_NAME', 'Default App Name'), 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'app_url', 'value' => 'http://localhost/', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'app_timezone', 'value' => 'EST', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'app_logo_path', 'value' => 'storage/brand/logo.png', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'app_logo_version', 'value' => '1', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'app_googlesearchmeta', 'value' => 'https://search.google.com/search-console/ownership', 'created_at' => $now, 'updated_at' => $now],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->updateOrInsert(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'created_at' => $setting['created_at'],
                    'updated_at' => $setting['updated_at']
                ]
            );
        }
    }
}