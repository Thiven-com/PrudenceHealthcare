
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctor_lead_details', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('hospital_id')->nullable();
            $table->unsignedBigInteger('lead_id')->nullable();

            // Doctor information
            $table->string('doctor_name')->nullable();
            $table->string('alternate_mobile', 15)->nullable();
            $table->string('gender')->nullable();
            $table->date('date_of_birth')->nullable();

            // Professional details
            $table->string('qualification')->nullable();
            $table->string('specialization')->nullable();
            $table->string('medical_registration_number')->nullable();
            $table->unsignedInteger('experience_years')->nullable();

            // Consultation details
            $table->enum('consultation_type', [
                'online',
                'offline',
                'both'
            ])->nullable();

            $table->string('hospital_clinic_name')->nullable();

            // Location
            $table->text('clinic_address')->nullable();
            $table->string('clinic_city')->nullable();
            $table->string('clinic_state')->nullable();
            $table->string('clinic_pincode', 10)->nullable();

            // Lead details
            $table->string('reference_source')->nullable();
            $table->text('interested_services')->nullable();
            $table->text('remarks')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_lead_details');
    }
};