<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // Buying options links
            $table->string('local_store_link')->nullable()->after('content');
            $table->string('youtube_link')->nullable()->after('local_store_link');
            $table->string('instagram_link')->nullable()->after('youtube_link');
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
