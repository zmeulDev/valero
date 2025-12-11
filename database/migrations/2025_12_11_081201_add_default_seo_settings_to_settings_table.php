<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $defaultSeoSettings = [
            [
                'key' => 'app_seo_title',
                'value' => 'Latest Articles & Insights',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'app_seo_description',
                'value' => 'Discover the latest articles, insights, and updates. Browse our collection of curated content covering various topics and categories.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'app_seo_keywords',
                'value' => 'articles, blog, news, insights, content',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($defaultSeoSettings as $setting) {
            DB::table('settings')->updateOrInsert(
                ['key' => $setting['key']],
                $setting
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('settings')->whereIn('key', [
            'app_seo_title',
            'app_seo_description',
            'app_seo_og_title',
            'app_seo_og_description',
            'app_seo_keywords',
        ])->delete();
    }
};
