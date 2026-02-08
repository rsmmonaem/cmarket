<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('affiliates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('affiliate_code')->unique();
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->decimal('total_earnings', 15, 2)->default(0);
            $table->integer('total_clicks')->default(0);
            $table->integer('total_conversions')->default(0);
            $table->timestamps();
            
            $table->index(['user_id', 'status']);
            $table->index('affiliate_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('affiliates');
    }
};
