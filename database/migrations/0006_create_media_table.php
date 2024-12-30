<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id');
            $table->string('image_path');
            $table->string('filename')->nullable();
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('size')->nullable();
            $table->json('dimensions')->nullable();
            $table->string('alt_text')->nullable();
            $table->boolean('is_cover')->default(false);
            $table->string('type')->nullable();
            $table->string('caption')->nullable();
            $table->timestamps();

            // Remove any unique constraints that might cause issues
            // $table->unique(['article_id', 'is_cover']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('media');
    }
};
