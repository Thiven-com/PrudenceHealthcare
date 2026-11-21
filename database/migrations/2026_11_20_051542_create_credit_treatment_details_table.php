<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_treatment_details', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('hospital_id')->nullable();
            $table->unsignedBigInteger('lead_id')->nullable();

            // Patient information
            $table->string('patient_name')->nullable();
            $table->string('alternate_mobile', 15)->nullable();
            $table->string('patient_email')->nullable();
            $table->unsignedInteger('age')->nullable();
            $table->string('gender')->nullable();

            // Treatment information
            $table->string('treatment_type')->nullable();
            $table->string('specialization')->nullable();
            $table->string('hospital_name')->nullable();
            $table->string('doctor_name')->nullable();
            $table->text('treatment_description')->nullable();

            // Estimated treatment amount
            $table->decimal('estimated_amount', 15, 2)->nullable();

            // Credit information
            $table->string('credit_provider')->nullable();
            $table->decimal('credit_amount_required', 15, 2)->nullable();
            $table->string('credit_type')->nullable();

            // Application information
            $table->string('application_reference')->nullable();
            $table->date('application_date')->nullable();

            // Credit approval
            $table->enum('approval_status', [
                'not_submitted',
                'documents_pending',
                'application_submitted',
                'approval_pending',
                'approved',
                'rejected'
            ])->default('not_submitted');

            $table->decimal('approved_amount', 15, 2)->nullable();
            $table->text('rejection_reason')->nullable();

            // Treatment progress
            $table->enum('treatment_status', [
                'not_started',
                'in_progress',
                'completed',
                'cancelled'
            ])->default('not_started');

            // Additional information
            $table->text('remarks')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_treatment_details');
    }
};
