<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lead_activities', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('hospital_id')->nullable();
            $table->unsignedBigInteger('lead_id')->nullable();

            // Activity performed by
            $table->unsignedBigInteger('performed_by')->nullable();
            $table->string('performed_by_type')->nullable();

            // Activity information
            $table->string('activity_type')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();

            // Previous and new values
            $table->text('old_value')->nullable();
            $table->text('new_value')->nullable();

            // Additional information
            $table->json('activity_data')->nullable();
            $table->timestamp('performed_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lead_activities');
    }
};
