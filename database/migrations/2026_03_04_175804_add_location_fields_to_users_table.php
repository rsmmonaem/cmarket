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
            $table->string('address', 500)->nullable()->after('email');
            $table->string('upazila')->nullable()->after('address');
            $table->string('district')->nullable()->after('upazila');
            $table->string('division')->nullable()->after('district');
            
            $table->index('district');
            $table->index('division');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['district']);
            $table->dropIndex(['division']);
            $table->dropColumn(['address', 'upazila', 'district', 'division']);
        });
    }
};
