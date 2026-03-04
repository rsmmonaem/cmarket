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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('referred_by')->nullable()->after('id')->constrained('users')->onDelete('set null');
            $table->string('referral_code')->nullable()->unique()->after('status');
            $table->foreignId('designation_id')->nullable()->after('referral_code')->constrained('designations')->onDelete('set null');
            $table->timestamp('designation_achieved_at')->nullable()->after('designation_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['referred_by']);
            $table->dropForeign(['designation_id']);
            $table->dropColumn(['referred_by', 'referral_code', 'designation_id', 'designation_achieved_at']);
        });
    }
};
