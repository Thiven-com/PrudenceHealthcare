<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lead_status_histories', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('hospital_id')->nullable();
            $table->unsignedBigInteger('lead_id')->nullable();

            // Previous and new status
            $table->string('old_status')->nullable();
            $table->string('new_status')->nullable();

            // Status updated by
            $table->unsignedBigInteger('changed_by')->nullable();
            $table->string('changed_by_type')->nullable();

            // Change details
            $table->text('remarks')->nullable();
            $table->timestamp('changed_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lead_status_histories');
    }
};
