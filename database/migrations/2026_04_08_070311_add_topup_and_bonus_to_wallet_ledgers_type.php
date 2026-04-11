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
        // Enums in MySQL are tricky to modify without a direct query or string column change
        // We will add 'topup' and 'bonus' to the allowed types
        DB::statement("ALTER TABLE wallet_ledgers MODIFY COLUMN type ENUM('order', 'commission', 'withdraw', 'transfer', 'profit', 'refund', 'cashback', 'topup', 'bonus') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE wallet_ledgers MODIFY COLUMN type ENUM('order', 'commission', 'withdraw', 'transfer', 'profit', 'refund', 'cashback') NOT NULL");
    }
};
