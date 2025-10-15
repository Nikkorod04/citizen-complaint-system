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
            $table->enum('role', ['citizen', 'secretary', 'captain'])->default('citizen')->after('email');
            $table->string('national_id')->nullable()->unique()->after('role');
            $table->string('phone')->nullable()->after('national_id');
            $table->string('address')->nullable()->after('phone');
            $table->string('qr_code')->nullable()->after('address');
            $table->enum('verification_status', ['pending', 'approved', 'rejected'])->default('pending')->after('qr_code');
            $table->timestamp('verified_at')->nullable()->after('verification_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'national_id', 'phone', 'address', 'qr_code', 'verification_status', 'verified_at']);
        });
    }
};
