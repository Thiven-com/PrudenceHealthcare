<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hospital_otps', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('hospital_id')
                ->nullable();

            $table->string('mobile', 15)->nullable();
            $table->string('otp_hash')->nullable();

            $table->enum('purpose', [
                'registration',
                'login'
            ])->default('registration');

            $table->timestamp('expires_at');
            $table->timestamp('verified_at')->nullable();

            $table->unsignedTinyInteger('attempts')->default(0);
            $table->timestamp('last_sent_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hospital_otps');
    }
};
