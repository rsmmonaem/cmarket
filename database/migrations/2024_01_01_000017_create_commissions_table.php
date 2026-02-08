<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // who receives commission
            $table->foreignId('source_user')->constrained('users')->onDelete('cascade'); // who generated the sale
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->decimal('order_amount', 15, 2);
            $table->decimal('commission_amount', 15, 2);
            $table->decimal('commission_percentage', 5, 2);
            $table->integer('level'); // referral level
            $table->enum('status', ['pending', 'approved', 'paid'])->default('pending');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'status']);
            $table->index('order_id');
            $table->index('source_user');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commissions');
    }
};
