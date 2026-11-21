<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeadModule;

class LeadModuleSeeder extends Seeder
{
    public function run(): void
    {
        $modules = [
            ['name' => 'Doctor', 'slug' => 'doctor'],
            ['name' => 'Community', 'slug' => 'community'],
            ['name' => 'Company Health Insurance', 'slug' => 'company-health-insurance'],
            ['name' => 'Personal Health Insurance', 'slug' => 'personal-health-insurance'],
            ['name' => 'Cash Treatment', 'slug' => 'cash-treatment'],
            ['name' => 'Credit Treatment', 'slug' => 'credit-treatment'],
            ['name' => 'Health Advisor', 'slug' => 'health-advisor'],
        ];

        foreach ($modules as $module) {
            LeadModule::updateOrCreate(
                ['slug' => $module['slug']],
                [
                    'name' => $module['name'],
                    'is_active' => 1,
                ]
            );
        }
    }
}