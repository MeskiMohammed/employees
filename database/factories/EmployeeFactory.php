<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Type;
use App\Models\Operator;
use App\Models\TypeEmployee;
use App\Models\Employee;
use App\Models\EmployeeDepartment;
use App\Models\Attachment;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
        $user = User::factory()->create();
        $user->assignRole('employee');
        return [
            'user_id' => $user->id,
            'profile_picture' => 'profile_pictures/' . uniqid() . '_profile.jpg',
            'personal_num' => $this->faker->numerify('PN####'),
            'address' => $this->faker->address,
            'status_id' => 1,
            'cin' => $this->faker->bothify('??#######'),
            'cin_attachment' => 'cin_attachments/' . uniqid() . '_cin.pdf',
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Employee $employee) {
            // Random Type
            $type = Type::inRandomOrder()->first();

            $typeEmployee = TypeEmployee::create([
                'employee_id' => $employee->id,
                'type_id' => $type->id,
                'in_date' => now(),
            ]);

            // Optionally create 1–2 department associations
            EmployeeDepartment::factory()->count(rand(1, 2))->create([
                'employee_id' => $employee->id,
            ]);

            // Basic attachment for all types (adjust per type if needed)
            Attachment::create([
                'name' => 'Default Document',
                'attachment' => 'attachments/' . uniqid() . '_default.pdf',
                'type_employee_id' => $typeEmployee->id,
            ]);
        });
    }

    public function employee(): static
    {
        return $this->state(function () {
            return [
                'employee_code' => 'EMP' . strtoupper($this->faker->bothify('###??')),
                'salary' => $this->faker->numberBetween(5000, 10000),
                'professional_num' => $this->faker->numerify('PROF####'),
                'professional_email' => $this->faker->unique()->safeEmail,
                'pin' => $this->faker->numerify('####'),
                'puk' => $this->faker->numerify('####'),
                'operator_id' => Operator::inRandomOrder()->value('id'),
                'cnss' => $this->faker->numerify('CNSS####'),
                'assurance' => $this->faker->word,
                'is_anapec' => $this->faker->boolean,
            ];
        });
    }

    public function freelancer(): static
    {
        return $this->state(fn() => [
            'ice' => $this->faker->numerify('ICE#######'),
            'is_project' => $this->faker->boolean,
            'hourly_salary' => $this->faker->randomFloat(2, 100, 300),
        ])->afterCreating(function (Employee $employee) {
            $type = Type::where('type', 'freelancer')->inRandomOrder()->first() ?? Type::inRandomOrder()->first();

            $typeEmployee = TypeEmployee::create([
                'employee_id' => $employee->id,
                'type_id' => $type->id,
                'in_date' => now(),
            ]);

            Attachment::create([
                'name' => 'Entrepreneur Identification Card',
                'attachment' => 'attachments/' . uniqid() . '_eic.pdf',
                'type_employee_id' => $typeEmployee->id,
            ]);
        });
    }

    public function trainee(): static
    {
        return $this->state(fn() => [
            'training_type' => $this->faker->randomElement(['PFE', 'Stage d\'initiation', 'Stage d\'application']),
            'school' => $this->faker->company . ' School',
        ])->afterCreating(function (Employee $employee) {
            $type = Type::where('type', 'trainee')->inRandomOrder()->first() ?? Type::inRandomOrder()->first();

            $typeEmployee = TypeEmployee::create([
                'employee_id' => $employee->id,
                'type_id' => $type->id,
                'in_date' => now(),
            ]);

            Attachment::insert([
                ['name' => 'Internship Agreement', 'attachment' => 'attachments/' . uniqid() . '_agreement.pdf', 'type_employee_id' => $typeEmployee->id],
                ['name' => 'Internship Application', 'attachment' => 'attachments/' . uniqid() . '_application.pdf', 'type_employee_id' => $typeEmployee->id],
                ['name' => 'Insurance', 'attachment' => 'attachments/' . uniqid() . '_insurance.pdf', 'type_employee_id' => $typeEmployee->id],
                ['name' => 'Resume', 'attachment' => 'attachments/' . uniqid() . '_resume.pdf', 'type_employee_id' => $typeEmployee->id],
                ['name' => 'Transcript', 'attachment' => 'attachments/' . uniqid() . '_transcript.pdf', 'type_employee_id' => $typeEmployee->id],
            ]);
        });
    }
}
