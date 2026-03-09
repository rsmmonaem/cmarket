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
            $table->foreignId('merchant_id')->nullable()->change();
            $table->string('status')->default('pending')->change();
            $table->text('admin_feedback')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('merchant_id')->nullable(false)->change();
            $table->enum('status', ['active', 'inactive', 'out_of_stock'])->default('active')->change();
            $table->dropColumn('admin_feedback');
        });
    }
};
