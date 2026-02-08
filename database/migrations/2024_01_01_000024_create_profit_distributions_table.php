<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profit_distributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chain_shop_id')->constrained()->onDelete('cascade');
            $table->decimal('total_profit', 15, 2);
            $table->decimal('profit_per_share', 15, 2);
            $table->string('period'); // 2024-Q1, 2024-01, etc.
            $table->date('distribution_date');
            $table->enum('status', ['pending', 'distributed'])->default('pending');
            $table->timestamps();
            
            $table->index(['chain_shop_id', 'period']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profit_distributions');
    }
};
