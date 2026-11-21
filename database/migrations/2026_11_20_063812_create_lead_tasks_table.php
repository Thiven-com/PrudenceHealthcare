<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lead_tasks', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('hospital_id')->nullable();
            $table->unsignedBigInteger('lead_id')->nullable();

            $table->unsignedBigInteger('assigned_by')->nullable();
            $table->string('assigned_by_type')->nullable();

            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->string('assigned_to_type')->nullable();

            $table->string('title')->nullable();
            $table->text('description')->nullable();

            $table->string('priority')->default('medium');
            $table->string('status')->default('pending');

            $table->timestamp('due_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lead_tasks');
    }
};