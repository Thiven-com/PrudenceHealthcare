<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('health_advisor_details', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('hospital_id')->nullable();
            $table->unsignedBigInteger('lead_id')->nullable();

            // Advisor information
            $table->string('advisor_name')->nullable();
            $table->string('advisor_code')->nullable();
            $table->string('advisor_type')->nullable();

            // Professional details
            $table->string('qualification')->nullable();
            $table->string('experience')->nullable();
            $table->text('description')->nullable();

            // Address
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pincode', 10)->nullable();

            // Additional information
            $table->date('joining_date')->nullable();
            $table->string('reference_source')->nullable();
            $table->text('remarks')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('health_advisor_details');
    }
};
