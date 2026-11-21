<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lead_assignments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('hospital_id')->nullable();
            $table->unsignedBigInteger('lead_id')->nullable();

            // Assignment information
            $table->unsignedBigInteger('assigned_by')->nullable();
            $table->string('assigned_by_type')->nullable();

            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->string('assigned_to_type')->nullable();

            // Assignment tracking
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->enum('status', [
                'assigned',
                'accepted',
                'in_progress',
                'completed',
                'reassigned',
                'cancelled'
            ])->default('assigned');

            $table->text('remarks')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lead_assignments');
    }
};
