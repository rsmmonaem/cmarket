<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('designations', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // BP, ME, BC, Upazila, District, Division, Director
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->json('criteria'); // {sales_count: 100, referral_count: 10, team_levels: 3}
            $table->decimal('commission_rate', 5, 2)->default(0); // additional commission %
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('slug');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('designations');
    }
};
