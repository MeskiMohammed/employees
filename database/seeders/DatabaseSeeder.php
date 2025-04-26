<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Department;
use App\Models\EmployeePost;
use App\Models\Operator;
use App\Models\PaymentType;
use App\Models\Status;
use App\Models\Type;
use App\Models\User;
use App\Models\UserRole;
use App\Models\UserStatus;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        $departments = [
            ['name' => 'Informatique', 'description' => 'Département des technologies de l\'information'],
            ['name' => 'Ressources Humaines', 'description' => 'Gestion du personnel et des talents'],
            ['name' => 'Marketing', 'description' => 'Stratégies marketing et communication'],
            ['name' => 'Finance', 'description' => 'Gestion financière de l’entreprise'],
        ];
        foreach ($departments as $department) {
            Department::create($department);
        }

        $operators = [
            ['operator' => 'Orange'],
            ['operator' => 'Inwi'],
            ['operator' => 'Maroc Telecom'],
        ];
        foreach ($operators as $operator) {
            Operator::create($operator);
        }

        $paymentTypes = [
            ['type' => 'Virement bancaire'],
            ['type' => 'Chèque'],
            ['type' => 'Espèces'],
            ['type' => 'lettre de charge'],
        ];
        foreach ($paymentTypes as $paymentType) {
            PaymentType::create($paymentType);
        }

        $statuse = ['active', 'inactive', 'rejeted', 'quited','fired'];
        foreach ($statuse as $status) {
            Status::create(['status' => $status]);
        }









        $roles = ['super admin', 'admin', 'employee'];
        foreach ($roles as $role) {
            UserRole::create(['role' => $role]);
        }

        $types = ['stagiaire', 'chef', 'directeur','freelancer'];
        foreach ($types as $type) {
            Type::create(['type' => $type]);
        }

        

        // Postes employés
        $posts = [
            ['status' => 'Software Engineer'],
            ['status' => 'Project Manager'],
            ['status' => 'HR Specialist'],
            ['status' => 'Accountant'],
            ['status' => 'IT Support'],
            ['status' => 'UX Designer'],
            ['status' => 'Marketing Lead'],
            ['status' => 'Data Analyst'],
        ];
        foreach ($posts as $post) {
            UserStatus::create($post);
        }


        // super admin creation
        User::create([
            'first_name' => 'salma',
            'last_name' => 'salhi',
            'email' => 'salmasalhi@gmail.com',
            'password' => Hash::make('salma'),
            'user_role_id' => 1,
        ]);
    }
}
