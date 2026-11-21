<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personal_health_insurance_details', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('hospital_id')->nullable();
            $table->unsignedBigInteger('lead_id')->nullable();

            // Customer information
            $table->string('customer_name')->nullable();
            $table->string('alternate_mobile', 15)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->string('occupation')->nullable();

            // Address
            $table->text('customer_address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pincode', 10)->nullable();

            // Insurance information
            $table->string('insurance_provider')->nullable();
            $table->string('policy_type')->nullable();
            $table->string('policy_number')->nullable();

            $table->decimal('sum_insured', 15, 2)->nullable();
            $table->decimal('existing_premium', 15, 2)->nullable();

            $table->date('policy_start_date')->nullable();
            $table->date('renewal_date')->nullable();

            // Insurance requirement
            $table->enum('insurance_requirement', [
                'new',
                'renewal',
                'portability'
            ])->nullable();

            $table->string('interested_plan')->nullable();
            $table->decimal('budget', 15, 2)->nullable();

            // Additional information
            $table->text('current_insurance_details')->nullable();
            $table->text('remarks')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personal_health_insurance_details');
    }
};
