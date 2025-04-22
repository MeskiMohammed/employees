<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Leave;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $dev = Department::create(['name' => 'Development', 'description' => 'Dev team']);
        $hr = Department::create(['name' => 'HR', 'description' => 'Human Resources']);

        $emp1 = Employee::create([
            'employee_code' => 'EMP001',
            'cin' => 'AB123456',
            'adress' => 'Casablanca',
            'department_id' => $dev->id
        ]);

        $emp2 = Employee::create([
            'employee_code' => 'EMP002',
            'cin' => 'XY987654',
            'adress' => 'Rabat',
            'department_id' => $hr->id
        ]);

        Leave::create([
            'start_date' => now(),
            'end_date' => now()->addDays(5),
            'reason' => 'Vacation',
            'employee_id' => $emp1->id
        ]);
    }
}
