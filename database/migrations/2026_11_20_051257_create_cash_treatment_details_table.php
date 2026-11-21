<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cash_treatment_details', function (Blueprint $table) {
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
            $table->string('disease')->nullable();
            $table->text('treatment_description')->nullable();

            // Doctor and hospital
            $table->string('doctor_name')->nullable();
            $table->string('hospital_name')->nullable();

            // Appointment information
            $table->date('appointment_date')->nullable();
            $table->time('appointment_time')->nullable();
            $table->string('appointment_status')->nullable();

            // Treatment amounts
            $table->decimal('estimated_amount', 15, 2)->nullable();
            $table->decimal('final_amount', 15, 2)->nullable();
            $table->decimal('advance_amount', 15, 2)->nullable();
            $table->decimal('balance_amount', 15, 2)->nullable();

            // Payment information
            $table->enum('payment_status', [
                'pending',
                'partial',
                'paid'
            ])->default('pending')->nullable();

            // Additional information
            $table->string('reference_source')->nullable();
            $table->text('remarks')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cash_treatment_details');
    }
};
