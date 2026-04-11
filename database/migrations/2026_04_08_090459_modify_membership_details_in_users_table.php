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
        Schema::table('users', function (Blueprint $table) {
            // Check if columns exist before adding
            if (!Schema::hasColumn('users', 'member_id')) {
                $table->string('member_id')->nullable()->unique()->after('id');
            }
            if (!Schema::hasColumn('users', 'has_membership_card')) {
                $table->boolean('has_membership_card')->default(false)->after('status');
            }
            if (!Schema::hasColumn('users', 'membership_purchased_at')) {
                $table->timestamp('membership_purchased_at')->nullable()->after('has_membership_card');
            }
        });

        if (Schema::hasTable('system_settings')) {
            DB::table('system_settings')->insertOrIgnore([
                [
                    'key' => 'membership_card_price',
                    'value' => '1000',
                    'type' => 'decimal',
                    'group' => 'finance',
                    'description' => 'Price for a membership card',
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['member_id', 'has_membership_card', 'membership_purchased_at']);
        });

        DB::table('system_settings')->where('key', 'membership_card_price')->delete();
    }
};
