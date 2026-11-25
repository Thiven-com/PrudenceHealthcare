<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('staff_daily_reports', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('hospital_id')->nullable();
            $table->unsignedBigInteger('staff_id')->nullable();

            $table->date('report_date')->nullable();

            $table->enum('working_status', [
                'present',
                'half_day',
                'leave',
            ])->default('present')->nullable();

            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();

            $table->text('work_summary')->nullable();
            $table->text('achievements')->nullable();
            $table->text('challenges')->nullable();
            $table->text('pending_work')->nullable();
            $table->text('tomorrow_plan')->nullable();

            $table->enum('status', [
                'draft',
                'submitted',
                'revision_requested',
                'approved',
            ])->default('draft')->nullable();

            $table->dateTime('submitted_at')->nullable();
            $table->dateTime('approved_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_daily_reports');
    }
};
