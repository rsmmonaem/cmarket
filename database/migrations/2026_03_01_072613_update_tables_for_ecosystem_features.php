<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('otp')->nullable()->after('password');
            $table->timestamp('otp_expires_at')->nullable()->after('otp');
            $table->integer('login_attempts')->default(0)->after('otp_expires_at');
            $table->timestamp('locked_until')->nullable()->after('login_attempts');
            $table->string('ip_address')->nullable()->after('locked_until');
            $table->string('device_info')->nullable()->after('ip_address');
            
            // Re-defining status enum with all roles
            $table->string('status')->default('free')->change();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->enum('type', ['product', 'package'])->default('product')->after('merchant_id');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->text('admin_note')->nullable()->after('notes');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['otp', 'otp_expires_at', 'login_attempts', 'locked_until', 'ip_address', 'device_info']);
            // Revert status to enum if needed, though usually not recommended in down()
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('type');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('admin_note');
        });
    }
};
