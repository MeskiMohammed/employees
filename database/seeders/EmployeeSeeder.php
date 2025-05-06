<?php

namespace Database\Seeders;

use App\Models\Attachment;
use App\Models\Department;
use App\Models\Employee;
use App\Models\EmployeeDepartment;
use App\Models\Operator;
use App\Models\Type;
use App\Models\TypeEmployee;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Faker\Factory as Faker;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();



        // Ensure directories exist
        $this->ensureDirectoriesExist();

        // Create 3 regular employees
        $this->createEmployees($faker, Department::all()->toArray(), Operator::all()->toArray());

        // Create 3 freelancers with projects
        $this->createFreelancersWithProjects($faker, Department::all());

        // Create 3 freelancers without projects
        $this->createFreelancersWithoutProjects($faker, Department::all());
    }

    private function ensureDirectoriesExist(): void
    {
        $directories = [
            'public/profile_pictures',
            'public/cin_attachments',
            'public/attachments',
        ];

        foreach ($directories as $directory) {
            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory);
            }
        }
    }

    private function createSampleFile($directory, $filename): string
    {
        $path = $directory . '/' . uniqid() . '_' . $filename;
        $content = 'Sample file content for ' . $filename;
        Storage::put($path, $content);
        return $path;
    }

    private function createEmployees($faker, $departments, $operators): void
    {
        $employeeType = Type::where('type', 'employee')->first();

        for ($i = 0; $i < 3; $i++) {
            DB::beginTransaction();

            try {
                // Create profile picture and CIN attachment
                $picPath = $this->createSampleFile('public/profile_pictures', 'employee_' . ($i + 1) . '_profile.jpg');
                $cinPath = $this->createSampleFile('public/cin_attachments', 'employee_' . ($i + 1) . '_cin.pdf');

                // Create user
                $user = User::create([
                    'first_name' => $faker->firstName,
                    'last_name' => $faker->lastName,
                    'email' => $faker->unique()->safeEmail,
                    'password' => Hash::make('password'),
                ]);
                $user->assignRole('employee');

                // Create employee
                $employee = Employee::create([
                    'user_id' => $user->id,
                    'profile_picture' => $picPath,
                    'personal_num' => $faker->phoneNumber,
                    'address' => $faker->address,
                    'status_id' => 1,
                    'cin' => strtoupper($faker->randomLetter . $faker->randomNumber(6)),
                    'cin_attachment' => $cinPath,
                    'employee_code' => 'EMP' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                    'salary' => $faker->numberBetween(5000, 20000),
                    'professional_num' => $faker->phoneNumber,
                    'professional_email' => $faker->companyEmail,
                    'pin' => $faker->randomNumber(4),
                    'puk' => $faker->randomNumber(8),
                    'operator_id' => array_rand([1,2,3]),
                    'cnss' => $faker->randomNumber(8),
                    'assurance' => $faker->randomNumber(8),
                ]);


                foreach ([1,2] as $departmentId) {
                    EmployeeDepartment::create([
                        'employee_id' => $employee->id,
                        'department_id' => $departmentId,
                    ]);
                }

                // Create type employee
                $typeEmployee = new TypeEmployee([
                    'in_date' => now()->subDays(rand(30, 365)),
                ]);

                $typeEmployee->employee()->associate($employee);
                $typeEmployee->type()->associate($employeeType);
                $typeEmployee->save();

                // Create attachments
                $attachmentTypes = [
                    'employment_contract',
                    'job_application',
                    'insurance',
                    'resume',
                    'cnss_certificate'
                ];

                foreach ($attachmentTypes as $type) {
                    $path = $this->createSampleFile('public/attachments', 'employee_' . ($i + 1) . '_' . $type . '.pdf');

                    Attachment::create([
                        'name' => str_replace('_', ' ', $type),
                        'attachment' => $path,
                        'type_employee_id' => $typeEmployee->id,
                    ]);
                }

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        }
    }

    private function createFreelancersWithProjects($faker, $departments): void
    {
        $freelancerType = Type::where('type', 'freelancer')->first();

        for ($i = 0; $i < 3; $i++) {
            DB::beginTransaction();

            try {
                // Create profile picture and CIN attachment
                $picPath = $this->createSampleFile('public/profile_pictures', 'freelancer_project_' . ($i + 1) . '_profile.jpg');
                $cinPath = $this->createSampleFile('public/cin_attachments', 'freelancer_project_' . ($i + 1) . '_cin.pdf');

                // Create user
                $user = User::create([
                    'first_name' => $faker->firstName,
                    'last_name' => $faker->lastName,
                    'email' => $faker->unique()->safeEmail,
                    'password' => Hash::make('password'),
                ]);
                $user->assignRole('employee');

                // Create employee (freelancer)
                $employee = Employee::create([
                    'user_id' => $user->id,
                    'profile_picture' => $picPath,
                    'personal_num' => $faker->phoneNumber,
                    'address' => $faker->address,
                    'status_id' => 1,
                    'cin' => strtoupper($faker->randomLetter . $faker->randomNumber(6)),
                    'cin_attachment' => $cinPath,
                    'ice' => $faker->randomNumber(8),
                    'is_project' => true,
                    'hours' => 0,
                ]);

                // Attach departments (1-2 random departments)
                $departmentCount = rand(1, 2);
                $selectedDepartments = array_rand(array_flip($departments), $departmentCount);

                if (!is_array($selectedDepartments)) {
                    $selectedDepartments = [$selectedDepartments];
                }

                foreach ($selectedDepartments as $departmentId) {
                    EmployeeDepartment::create([
                        'employee_id' => $employee->id,
                        'department_id' => $departmentId,
                    ]);
                }

                // Create type employee
                $typeEmployee = new TypeEmployee([
                    'in_date' => now()->subDays(rand(30, 365)),
                ]);

                $typeEmployee->employee()->associate($employee);
                $typeEmployee->type()->associate($freelancerType);
                $typeEmployee->save();

                // Create EIC attachment
                $eicPath = $this->createSampleFile('public/attachments', 'freelancer_project_' . ($i + 1) . '_eic.pdf');

                Attachment::create([
                    'name' => 'Entrepreneur Identification Card',
                    'attachment' => $eicPath,
                    'type_employee_id' => $typeEmployee->id,
                ]);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        }
    }

    private function createFreelancersWithoutProjects($faker, $departments): void
    {
        $freelancerType = Type::where('type', 'freelancer')->first();

        for ($i = 0; $i < 3; $i++) {
            DB::beginTransaction();

            try {
                // Create profile picture and CIN attachment
                $picPath = $this->createSampleFile('public/profile_pictures', 'freelancer_salary_' . ($i + 1) . '_profile.jpg');
                $cinPath = $this->createSampleFile('public/cin_attachments', 'freelancer_salary_' . ($i + 1) . '_cin.pdf');

                // Create user
                $user = User::create([
                    'first_name' => $faker->firstName,
                    'last_name' => $faker->lastName,
                    'email' => $faker->unique()->safeEmail,
                    'password' => Hash::make('password'),
                ]);
                $user->assignRole('employee');

                // Create employee (freelancer without project)
                $employee = Employee::create([
                    'user_id' => $user->id,
                    'profile_picture' => $picPath,
                    'personal_num' => $faker->phoneNumber,
                    'address' => $faker->address,
                    'status_id' => 1,
                    'cin' => strtoupper($faker->randomLetter . $faker->randomNumber(6)),
                    'cin_attachment' => $cinPath,
                    'ice' => $faker->randomNumber(8),
                    'is_project' => false,
                    'salary' => $faker->numberBetween(5000, 20000),
                    'hours' => $faker->numberBetween(20, 40),
                ]);

                // Attach departments (1-2 random departments)
                $departmentCount = rand(1, 2);
                $selectedDepartments = array_rand(array_flip($departments), $departmentCount);

                if (!is_array($selectedDepartments)) {
                    $selectedDepartments = [$selectedDepartments];
                }

                foreach ($selectedDepartments as $departmentId) {
                    EmployeeDepartment::create([
                        'employee_id' => $employee->id,
                        'department_id' => $departmentId,
                    ]);
                }

                // Create type employee
                $typeEmployee = new TypeEmployee([
                    'in_date' => now()->subDays(rand(30, 365)),
                ]);

                $typeEmployee->employee()->associate($employee);
                $typeEmployee->type()->associate($freelancerType);
                $typeEmployee->save();

                // Create EIC attachment
                $eicPath = $this->createSampleFile('public/attachments', 'freelancer_salary_' . ($i + 1) . '_eic.pdf');

                Attachment::create([
                    'name' => 'Entrepreneur Identification Card',
                    'attachment' => $eicPath,
                    'type_employee_id' => $typeEmployee->id,
                ]);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        }
    }
}
