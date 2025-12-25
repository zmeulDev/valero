<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // Buying options links
            if (!Schema::hasColumn('articles', 'local_store_link')) {
                $table->string('local_store_link', 500)->nullable()->after('content');
            }
            if (!Schema::hasColumn('articles', 'youtube_link')) {
                $table->string('youtube_link', 500)->nullable()->after('local_store_link');
            }
            if (!Schema::hasColumn('articles', 'instagram_link')) {
                $table->string('instagram_link', 500)->nullable()->after('youtube_link');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn([
                'local_store_link',
                'youtube_link',
                'instagram_link'
            ]);
        });
    }
};
