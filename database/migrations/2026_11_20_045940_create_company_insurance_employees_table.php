<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('company_insurance_employees', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('hospital_id')->nullable();
            $table->unsignedBigInteger('lead_id')->nullable();
            $table->unsignedBigInteger('company_health_insurance_detail_id')->nullable();

            // Employee information
            $table->string('employee_id')->nullable();
            $table->string('employee_name')->nullable();
            $table->string('mobile', 15)->nullable();
            $table->string('email')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->string('designation')->nullable();

            // Dependent information
            $table->unsignedInteger('dependent_count')->default(0);
            $table->text('dependent_details')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_insurance_employees');
    }
};
