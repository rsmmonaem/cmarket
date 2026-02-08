<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('share_purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('chain_shop_id')->constrained()->onDelete('cascade');
            $table->integer('shares');
            $table->decimal('price_per_share', 15, 2);
            $table->decimal('total_amount', 15, 2);
            $table->string('transaction_reference')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'chain_shop_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('share_purchases');
    }
};
