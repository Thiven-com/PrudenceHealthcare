<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('staff_daily_report_activities', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('hospital_id')->nullable();
            $table->unsignedBigInteger('staff_daily_report_id')->nullable();
            $table->unsignedBigInteger('staff_id')->nullable();

            $table->unsignedBigInteger('lead_id')->nullable();

            $table->enum('activity_type', [
                'lead_call',
                'lead_follow_up',
                'hospital_visit',
                'meeting',
                'new_lead',
                'other',
            ])->nullable();

            $table->string('organization_name')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('mobile', 20)->nullable();

            $table->text('description')->nullable();
            $table->text('outcome')->nullable();

            $table->dateTime('next_follow_up_at')->nullable();
            $table->dateTime('activity_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_daily_report_activities');
    }
};
