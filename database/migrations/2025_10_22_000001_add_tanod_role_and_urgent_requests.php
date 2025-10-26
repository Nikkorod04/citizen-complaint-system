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
        // Create urgent_requests table
        Schema::create('urgent_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('citizen_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->longText('description');
            $table->string('location');
            $table->enum('category', ['medical', 'accident', 'fire', 'security', 'disaster', 'other']);
            $table->enum('priority', ['high', 'urgent']);
            $table->enum('status', ['submitted', 'assigned', 'in_progress', 'on_the_way', 'resolved', 'cancelled'])->default('submitted');
            $table->foreignId('tanod_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->text('tanod_response')->nullable();
            $table->text('resolution_notes')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();

            $table->index('citizen_id');
            $table->index('tanod_id');
            $table->index('status');
            $table->index('submitted_at');
        });

        // Create urgent_request_updates table (for tracking status changes)
        Schema::create('urgent_request_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('urgent_request_id')->constrained('urgent_requests')->cascadeOnDelete();
            $table->foreignId('tanod_id')->constrained('users')->cascadeOnDelete();
            $table->enum('status', ['in_progress', 'on_the_way', 'resolved']);
            $table->text('message')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamps();

            $table->index('urgent_request_id');
            $table->index('tanod_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('urgent_request_updates');
        Schema::dropIfExists('urgent_requests');
    }
};
