<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_designations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('designation_id')->constrained()->onDelete('cascade');
            $table->timestamp('achieved_at');
            $table->json('achievement_data')->nullable(); // snapshot of criteria when achieved
            $table->boolean('is_current')->default(true);
            $table->timestamps();
            
            $table->index(['user_id', 'is_current']);
            $table->index('designation_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_designations');
    }
};
