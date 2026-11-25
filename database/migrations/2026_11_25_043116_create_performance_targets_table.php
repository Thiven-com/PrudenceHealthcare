<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('performance_targets', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('hospital_id')->nullable();
            $table->unsignedBigInteger('designation_id')->nullable();

            $table->string('target_name')->nullable();
            $table->string('target_type')->nullable();
            $table->unsignedInteger('target_quantity')->nullable();

            $table->string('target_period')->default('monthly')->nullable();

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->string('created_by_type')->nullable();

            $table->string('status')->default('active')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('performance_targets');
    }
};
