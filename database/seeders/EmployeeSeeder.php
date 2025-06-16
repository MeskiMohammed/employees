<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        // Seed regular employees
        Employee::factory()->count(10)->employee()->create();

        // Seed freelancers
        Employee::factory()->count(10)->freelancer()->create();

        // Seed trainees
        Employee::factory()->count(10)->trainee()->create();
    }
}
