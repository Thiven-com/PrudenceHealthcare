<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hospital_facilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hospital_id')->nullable();

            $table->string('facility_name')->nullable();
            $table->string('facility_category')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_available')->default(1);
            $table->string('operating_hours')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('image')->nullable();
            $table->string('status')->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hospital_facilities');
    }
};