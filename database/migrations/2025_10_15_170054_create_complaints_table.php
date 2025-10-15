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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('complaint_number')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('complaint_category_id')->constrained()->onDelete('cascade');
            $table->string('subject');
            $table->text('description');
            $table->string('location')->nullable();
            $table->enum('status', ['pending', 'validated', 'in_progress', 'resolved', 'rejected'])->default('pending');
            $table->text('secretary_notes')->nullable();
            $table->text('captain_resolution')->nullable();
            $table->text('recommendation')->nullable();
            $table->timestamp('validated_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->foreignId('validated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('resolved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
