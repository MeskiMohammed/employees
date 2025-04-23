<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Leave;
use App\Models\User;
use App\Models\UserRole;
use App\Models\UserStatus;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // $dev = Department::create(['name' => 'Development', 'description' => 'Dev team']);
        // $hr = Department::create(['name' => 'HR', 'description' => 'Human Resources']);

        // $emp1 = Employee::create([
        //     'employee_code' => 'EMP001',
        //     'cin' => 'AB123456',
        //     'adress' => 'Casablanca',
        //     'department_id' => $dev->id
        // ]);

        // $emp2 = Employee::create([
        //     'employee_code' => 'EMP002',
        //     'cin' => 'XY987654',
        //     'adress' => 'Rabat',
        //     'department_id' => $hr->id
        // ]);

        // Leave::create([
        //     'start_date' => now(),
        //     'end_date' => now()->addDays(5),
        //     'reason' => 'Vacation',
        //     'employee_id' => $emp1->id
        // ]);

        $status = UserStatus::create(['status'=>'chef']);
        $role = UserRole::create(['role'=>'admin']);
        User::create([
            'first_name' => 'salma',
            'last_name' => 'salhi',
            'email' => 'salmasalhi@gmail.com',
            'password' => 'salma',
            'user_role_id' => $role->id,
            'user_status_id' => $status->id,
        ]);
    }
}
