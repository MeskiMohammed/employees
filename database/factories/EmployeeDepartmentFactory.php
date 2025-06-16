<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employee;
use App\Models\Department;

class EmployeeDepartmentFactory extends Factory
{
    protected $model = \App\Models\EmployeeDepartment::class;

    public function definition(): array
    {
        return [
            'employee_id' => Employee::factory(),
            'department_id' => Department::inRandomOrder()->value('id'),
        ];
    }
}
