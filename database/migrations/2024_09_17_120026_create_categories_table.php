<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            // Primary key
            $table->id();
            
            // Core category information
            $table->string('name')->unique();
            $table->string('slug')->unique();
            
            // Timestamps
            $table->timestamps();
        });

        // Add category relationship to articles
        Schema::table('articles', function (Blueprint $table) {
            // Foreign keys
            $table->foreignId('category_id')->after('user_id')->constrained('categories')->onDelete('cascade');
        });
    }

    public function down()
    {
        // Remove category relationship from articles
        Schema::table('articles', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });

        Schema::dropIfExists('categories');
    }
}
