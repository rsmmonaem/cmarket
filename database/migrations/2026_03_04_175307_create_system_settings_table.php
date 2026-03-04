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
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('string'); // string, float, integer, json
            $table->string('group')->default('general'); // general, commission, payment
            $table->string('description')->nullable();
            $table->timestamps();

            $table->index('group');
        });

        // Seed initial commission settings
        DB::table('system_settings')->insert([
            [
                'key' => 'distributable_profit_percentage',
                'value' => '10.00',
                'type' => 'float',
                'group' => 'commission',
                'description' => 'Percentage of order total that is considered profit for 9-level distribution.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'default_affiliate_commission_percentage',
                'value' => '5.00',
                'type' => 'float',
                'group' => 'commission',
                'description' => 'Default percentage for affiliate commissions.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'merchant_commission_percentage',
                'value' => '2.00',
                'type' => 'float',
                'group' => 'commission',
                'description' => 'The cut platform takes from merchant sales.',
                'created_at' => now(),
                'updated_at' => now(),
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
