<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('performance_records', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('hospital_id')->nullable();
            $table->unsignedBigInteger('staff_id')->nullable();
            $table->unsignedBigInteger('designation_id')->nullable();
            $table->unsignedBigInteger('performance_target_id')->nullable();

            $table->unsignedInteger('target_quantity')->default(0)->nullable();
            $table->unsignedInteger('achieved_quantity')->default(0)->nullable();

            $table->date('period_start')->nullable();
            $table->date('period_end')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('performance_records');
    }
};
