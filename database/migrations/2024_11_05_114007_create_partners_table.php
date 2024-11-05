<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('link');
            $table->string('image')->nullable();
            $table->text('text')->nullable();
            $table->enum('position', ['sidebar', 'header', 'footer'])->default('sidebar');
            $table->date('start_date')->nullable();
            $table->date('expiration_date')->nullable();
            $table->json('seo')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};