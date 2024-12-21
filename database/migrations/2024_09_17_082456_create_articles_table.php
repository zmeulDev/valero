<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            // Primary key
            $table->id();
            
            // Foreign keys
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Core article information
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('tags');
            $table->text('excerpt')->nullable();
            $table->longText('content');
            
            // Media
            $table->string('featured_image')->nullable();
            
            // Metrics and stats
            $table->unsignedBigInteger('views')->default(0);
            $table->unsignedBigInteger('likes_count')->default(0);
            
            // Publishing
            $table->timestamp('scheduled_at')->nullable();
            
            // Timestamps
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('articles');
    }
};