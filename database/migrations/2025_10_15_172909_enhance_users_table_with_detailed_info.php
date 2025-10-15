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
            // Remove the old 'name' column
            $table->dropColumn('name');
            
            // Add separate name fields
            $table->string('first_name')->after('id');
            $table->string('middle_name')->nullable()->after('first_name');
            $table->string('last_name')->after('middle_name');
            $table->string('suffix')->nullable()->after('last_name'); // Jr, Sr, III, etc.
            
            // Add demographic information
            $table->date('date_of_birth')->nullable()->after('national_id');
            $table->integer('age')->nullable()->after('date_of_birth');
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('age');
            $table->enum('civil_status', ['single', 'married', 'widowed', 'separated', 'divorced'])->nullable()->after('gender');
            
            // Enhanced address fields
            $table->string('house_number')->nullable()->after('address');
            $table->string('street')->nullable()->after('house_number');
            $table->string('barangay')->nullable()->after('street');
            $table->string('city')->nullable()->after('barangay');
            $table->string('province')->nullable()->after('city');
            $table->string('zip_code')->nullable()->after('province');
            
            // Additional information
            $table->string('occupation')->nullable()->after('zip_code');
            $table->string('emergency_contact_name')->nullable()->after('occupation');
            $table->string('emergency_contact_number')->nullable()->after('emergency_contact_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Restore the original name column
            $table->string('name')->after('id');
            
            // Drop the new columns
            $table->dropColumn([
                'first_name',
                'middle_name',
                'last_name',
                'suffix',
                'date_of_birth',
                'age',
                'gender',
                'civil_status',
                'house_number',
                'street',
                'barangay',
                'city',
                'province',
                'zip_code',
                'occupation',
                'emergency_contact_name',
                'emergency_contact_number',
            ]);
        });
    }
};
