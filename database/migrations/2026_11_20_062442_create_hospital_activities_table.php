<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hospital_activities', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('hospital_id')->nullable();

            // User who performed the action
            $table->unsignedBigInteger('performed_by')->nullable();
            $table->string('performed_by_type')->nullable();

            // Activity information
            $table->string('module')->nullable();
            $table->string('activity_type')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();

            // Record information
            $table->string('record_type')->nullable();
            $table->unsignedBigInteger('record_id')->nullable();

            // Old and new values
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();

            $table->timestamp('performed_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hospital_activities');
    }
};
