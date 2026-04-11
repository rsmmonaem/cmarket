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
        Schema::dropIfExists('system_settings');
        
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('string'); // string, text, number, boolean, decimal
            $table->string('group')->default('general');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Seed initial data
        DB::table('system_settings')->insert([
            [
                'key' => 'min_topup_amount',
                'value' => '100',
                'type' => 'decimal',
                'group' => 'finance',
                'description' => 'Minimum amount for top-up request',
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'key' => 'min_withdrawal_amount',
                'value' => '500',
                'type' => 'decimal',
                'group' => 'finance',
                'description' => 'Minimum balance required for withdrawal',
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'key' => 'topup_methods',
                'value' => 'bKash,Nagad,Rocket,Bank Transfer',
                'type' => 'text',
                'group' => 'finance',
                'description' => 'Available payment methods for top-up',
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'key' => 'site_name',
                'value' => 'CMarket',
                'type' => 'string',
                'group' => 'general',
                'description' => 'The name of the platform',
                'created_at' => now(), 'updated_at' => now()
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};
