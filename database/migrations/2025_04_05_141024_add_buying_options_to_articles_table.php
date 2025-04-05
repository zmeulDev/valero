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
            $table->string('amazon_link')->nullable()->after('content');
            $table->string('ebay_link')->nullable()->after('amazon_link');
            $table->string('local_store_link')->nullable()->after('ebay_link');
            
            // Price information
            $table->decimal('lowest_price', 10, 2)->nullable()->after('local_store_link');
            $table->decimal('average_price', 10, 2)->nullable()->after('lowest_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn([
                'amazon_link',
                'ebay_link',
                'local_store_link',
                'lowest_price',
                'average_price'
            ]);
        });
    }
};
