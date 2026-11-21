<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hospitals', function (Blueprint $table) {
            $table->id();

            // Hospital details
            $table->string('hospital_name')->nullable();
            $table->string('registration_number')->nullable();

            // Contact person
            $table->string('contact_person')->nullable();
            $table->string('mobile', 15)->nullable();
            $table->string('email')->nullable();

            // Address
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pincode', 10)->nullable();

            // Hospital logo
            $table->string('logo')->nullable();

            // OTP verification
            $table->boolean('is_mobile_verified')->default(false);
            $table->timestamp('mobile_verified_at')->nullable();

            // Admin approval
            $table->enum('approval_status', [
                'pending',
                'approved',
                'rejected',
                'suspended'
            ])->default('pending');

            $table->bigInteger('approved_by')
                ->nullable();

            $table->timestamp('approved_at')->nullable();
            $table->text('rejection_reason')->nullable();

            // Login and account status
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_login_at')->nullable();

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hospitals');
    }
};
