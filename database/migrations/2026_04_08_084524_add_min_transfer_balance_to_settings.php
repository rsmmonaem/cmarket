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
        if (Schema::hasTable('system_settings')) {
            DB::table('system_settings')->insertOrIgnore([
                [
                    'key' => 'min_transfer_balance',
                    'value' => '500',
                    'type' => 'decimal',
                    'group' => 'finance',
                    'description' => 'Mandatory minimum balance required to initiate a fund transfer',
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
            DB::table('system_settings')->where('key', 'min_transfer_balance')->delete();
        }
    }
};
