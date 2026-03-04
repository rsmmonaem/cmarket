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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('points')->default(0)->after('status');
            $table->integer('total_points')->default(0)->after('points');
            $table->integer('voucher_points')->default(0)->after('total_points');
        });

        Schema::table('designations', function (Blueprint $table) {
            $table->integer('required_points')->default(0)->after('criteria');
            $table->integer('required_voucher_points')->default(0)->after('required_points');
            $table->decimal('sales_target', 15, 2)->default(0)->after('required_voucher_points');
            $table->integer('referral_target')->default(0)->after('sales_target');
            $table->integer('team_building_target')->default(0)->after('referral_target');
            $table->decimal('percentage', 5, 2)->default(0)->after('commission_rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['points', 'total_points', 'voucher_points']);
        });

        Schema::table('designations', function (Blueprint $table) {
            $table->dropColumn([
                'required_points', 'required_voucher_points', 'sales_target', 
                'referral_target', 'team_building_target', 'percentage'
            ]);
        });
    }
};
