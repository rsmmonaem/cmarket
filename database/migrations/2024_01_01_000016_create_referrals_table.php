<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referrer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('referred_id')->constrained('users')->onDelete('cascade');
            $table->integer('level')->default(1); // 1 = direct, 2 = level 2, etc.
            $table->string('referral_code')->nullable();
            $table->timestamps();
            
            $table->unique(['referrer_id', 'referred_id']);
            $table->index('referrer_id');
            $table->index('referred_id');
            $table->index('level');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('referrals');
    }
};
