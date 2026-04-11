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
        Schema::table('kycs', function (Blueprint $user) {
            $user->string('document_front')->nullable()->after('document_file');
            $user->string('document_back')->nullable()->after('document_front');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kycs', function (Blueprint $user) {
            $user->dropColumn(['document_front', 'document_back']);
        });
    }
};
