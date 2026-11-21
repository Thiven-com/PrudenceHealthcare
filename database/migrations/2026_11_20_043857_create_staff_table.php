<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();

            // Hospital and organizational details
            $table->unsignedBigInteger('hospital_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('designation_id')->nullable();
            $table->unsignedBigInteger('reporting_manager_id')->nullable();

            // Staff information
            $table->string('employee_code')->nullable();
            $table->string('name')->nullable();
            $table->string('mobile', 15)->nullable();
            $table->string('email')->nullable();

            // Personal information
            $table->string('gender')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->text('address')->nullable();

            // Login details
            $table->string('password')->nullable();
            $table->string('profile_image')->nullable();

            // Employment details
            $table->string('staff_type')->nullable();
            $table->date('joining_date')->nullable();
            $table->date('leaving_date')->nullable();

            // Account status
            $table->enum('status', [
                'active',
                'inactive',
                'suspended'
            ])->default('active');

            $table->timestamp('last_login_at')->nullable();

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
