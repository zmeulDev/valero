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
            $table->string('tags')->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            
            // Metrics and stats
            $table->boolean('is_featured')->default(false);
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