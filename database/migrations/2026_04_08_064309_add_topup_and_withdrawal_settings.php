<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Insert minimum settings into system_settings table if it exists
        if (Schema::hasTable('system_settings')) {
            DB::table('system_settings')->insertOrIgnore([
                [
                    'key' => 'min_topup_amount',
                    'value' => '100',
                    'group' => 'finance',
                    'type' => 'decimal',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'key' => 'min_withdrawal_amount',
                    'value' => '500',
                    'group' => 'finance',
                    'type' => 'decimal',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('system_settings')) {
            DB::table('system_settings')->whereIn('key', ['min_topup_amount', 'min_withdrawal_amount'])->delete();
        }
    }
};
