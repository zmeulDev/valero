<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->index('scheduled_at', 'articles_scheduled_at_index');
            $table->index('views', 'articles_views_index');
        });

        Schema::table('media', function (Blueprint $table) {
            $table->index('article_id', 'media_article_id_index');
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropIndex('articles_scheduled_at_index');
            $table->dropIndex('articles_views_index');
        });

        Schema::table('media', function (Blueprint $table) {
            $table->dropIndex('media_article_id_index');
        });
    }
};

