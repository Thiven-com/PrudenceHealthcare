<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('community_lead_details', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('hospital_id')->nullable();
            $table->unsignedBigInteger('lead_id')->nullable();

            // Community information
            $table->string('community_name')->nullable();

            $table->enum('community_type', [
                'residential',
                'social',
                'religious',
                'other'
            ])->nullable();

            $table->text('description')->nullable();
            $table->unsignedInteger('total_members')->nullable();

            // Community leadership
            $table->string('president_head')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact_designation')->nullable();

            // Community location
            $table->text('community_address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pincode', 10)->nullable();

            // Additional information
            $table->text('remarks')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('community_lead_details');
    }
};
