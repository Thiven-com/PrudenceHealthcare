<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();

            // Hospital and module
            $table->unsignedBigInteger('hospital_id')->nullable();
            $table->unsignedBigInteger('lead_module_id')->nullable();

            // Lead identification
            $table->string('leadcode')->nullable();

            // Common lead information
            $table->string('name')->nullable();
            $table->string('mobile', 15)->nullable();
            $table->string('alternate_mobile', 15)->nullable();
            $table->string('email')->nullable();

            // Address
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pincode', 10)->nullable();

            // Lead tracking
            $table->enum('status', [
                'new',
                'contacted',
                'follow_up',
                'interested',
                'converted',
                'not_interested',
                'closed'
            ])->default('new');

            $table->string('source')->nullable();
            $table->text('remarks')->nullable();

            // Lead ownership
            $table->unsignedBigInteger('created_by')->nullable();
            $table->string('created_by_type')->nullable();

            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->string('assigned_to_type')->nullable();

            $table->timestamp('assigned_at')->nullable();

            // Follow-up tracking
            $table->dateTime('next_follow_up_at')->nullable();

            // Conversion tracking
            $table->timestamp('converted_at')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
