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
        Schema::table('products', function (Blueprint $table) {
            // SEO
            $table->string('meta_title')->nullable()->after('name');
            $table->text('meta_description')->nullable()->after('meta_title');
            
            // Visibility & Deals
            $table->boolean('is_featured')->default(false)->after('status');
            $table->boolean('is_flash_deal')->default(false)->after('is_featured');
            $table->timestamp('flash_deal_start')->nullable()->after('is_flash_deal');
            $table->timestamp('flash_deal_end')->nullable()->after('flash_deal_start');
            
            $table->index('is_featured');
            $table->index('is_flash_deal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'meta_title', 'meta_description', 
                'is_featured', 'is_flash_deal', 
                'flash_deal_start', 'flash_deal_end'
            ]);
        });
    }
};
