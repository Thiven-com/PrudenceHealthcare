<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lead_modules', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->text('description')->nullable();

            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();
        });

        DB::table('lead_modules')->insert([
            [
                'name' => 'Doctor',
                'slug' => 'doctor',
                'description' => 'Doctor leads',
                'is_active' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Community',
                'slug' => 'community',
                'description' => 'Community leads',
                'is_active' => true,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Company Health Insurance',
                'slug' => 'company-health-insurance',
                'description' => 'Company health insurance leads',
                'is_active' => true,
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Personal Health Insurance',
                'slug' => 'personal-health-insurance',
                'description' => 'Personal health insurance leads',
                'is_active' => true,
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cash Treatment',
                'slug' => 'cash-treatment',
                'description' => 'Cash treatment leads',
                'is_active' => true,
                'sort_order' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Credit Treatment',
                'slug' => 'credit-treatment',
                'description' => 'Credit treatment leads',
                'is_active' => true,
                'sort_order' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Health Advisor',
                'slug' => 'health-advisor',
                'description' => 'Health advisor leads',
                'is_active' => true,
                'sort_order' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('lead_modules');
    }
};
