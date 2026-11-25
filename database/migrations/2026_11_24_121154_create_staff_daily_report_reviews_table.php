<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('staff_daily_report_reviews', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('hospital_id')->nullable();
            $table->unsignedBigInteger('staff_daily_report_id')->nullable();

            $table->unsignedBigInteger('reviewer_id')->nullable();

            $table->string('reviewer_type')->nullable();

            $table->string('status')->default('pending')->nullable();

            $table->text('remarks')->nullable();

            $table->dateTime('reviewed_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_daily_report_reviews');
    }
};
