<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lead_follow_ups', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('hospital_id')->nullable();
            $table->unsignedBigInteger('lead_id')->nullable();

            // Follow-up performed by
            $table->unsignedBigInteger('followed_up_by')->nullable();
            $table->string('followed_up_by_type')->nullable();

            // Follow-up details
            $table->dateTime('follow_up_date')->nullable();
            $table->string('follow_up_type')->nullable();

            $table->enum('follow_up_status', [
                'scheduled',
                'completed',
                'missed',
                'cancelled'
            ])->default('scheduled');

            // Discussion and outcome
            $table->text('discussion')->nullable();
            $table->text('customer_response')->nullable();
            $table->text('remarks')->nullable();

            // Next follow-up
            $table->dateTime('next_follow_up_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lead_follow_ups');
    }
};
