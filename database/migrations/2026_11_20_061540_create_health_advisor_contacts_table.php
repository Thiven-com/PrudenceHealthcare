<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('health_advisor_contacts', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('hospital_id')->nullable();
            $table->unsignedBigInteger('lead_id')->nullable();
            $table->unsignedBigInteger('health_advisor_detail_id')->nullable();

            // Contact information
            $table->string('name')->nullable();
            $table->string('mobile', 15)->nullable();
            $table->string('alternate_mobile', 15)->nullable();
            $table->string('email')->nullable();

            // Personal information
            $table->string('gender')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('occupation')->nullable();

            // Address
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pincode', 10)->nullable();

            // Additional information
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('health_advisor_contacts');
    }
};
