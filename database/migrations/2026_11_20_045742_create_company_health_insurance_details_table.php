<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('company_health_insurance_details', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('hospital_id')->nullable();
            $table->unsignedBigInteger('lead_id')->nullable();

            // Company information
            $table->string('company_name')->nullable();
            $table->string('industry')->nullable();
            $table->text('company_address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pincode', 10)->nullable();
            $table->string('website')->nullable();
            $table->unsignedInteger('employee_count')->nullable();

            // HR and contact information
            $table->string('hr_name')->nullable();
            $table->string('hr_designation')->nullable();
            $table->string('hr_mobile', 15)->nullable();
            $table->string('hr_email')->nullable();
            $table->string('alternate_contact', 15)->nullable();

            // Insurance information
            $table->string('insurance_provider')->nullable();
            $table->string('policy_type')->nullable();
            $table->string('policy_number')->nullable();
            $table->decimal('sum_insured', 15, 2)->nullable();
            $table->decimal('premium', 15, 2)->nullable();
            $table->date('policy_start_date')->nullable();
            $table->date('renewal_date')->nullable();
            $table->unsignedInteger('covered_employee_count')->nullable();

            // Additional information
            $table->text('current_insurance_details')->nullable();
            $table->text('remarks')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_health_insurance_details');
    }
};
