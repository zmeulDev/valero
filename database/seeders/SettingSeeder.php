<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{

    public function run(): void
    {
        $settings = [
            ['key' => 'app_name', 'value' => 'Valero'],
            ['key' => 'app_url', 'value' => 'http://localhost/'],
            ['key' => 'app_timezone', 'value' => 'EST'],
            ['key' => 'app_logo_path', 'value' => 'storage/brand/logo.png'],
            ['key' => 'app_logo_version', 'value' => '1'],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->updateOrInsert(
                ['key' => $setting['key']],
                ['value' => $setting['value']]
            );
        }
    }
}