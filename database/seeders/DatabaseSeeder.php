<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Department;
use App\Models\Employee;
use App\Models\EmployeePost;
use App\Models\Leave;
use App\Models\Operator;
use App\Models\PaymentType;
use App\Models\Status;
use App\Models\User;
use App\Models\UserRole;
use App\Models\UserStatus;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Rôles
        $roles = ['super admin', 'admin', 'employee'];
        foreach ($roles as $role) {
            UserRole::create(['role' => $role]);
        }

        // Statuts utilisateur
        $statuses = ['owner', 'chef', 'directeur'];
        foreach ($statuses as $status) {
            UserStatus::create(['status' => $status]);
        }

        // Utilisateur de test
        User::create([
            'first_name' => 'salma',
            'last_name' => 'salhi',
            'email' => 'salmasalhi@gmail.com',
            'password' => Hash::make('salma'),
            'user_role_id' => 1,
            'user_status_id' => 1,
        ]);

        // Départements
        $departments = [
            ['name' => 'Informatique', 'description' => 'Département des technologies de l\'information'],
            ['name' => 'Ressources Humaines', 'description' => 'Gestion du personnel et des talents'],
            ['name' => 'Marketing', 'description' => 'Stratégies marketing et communication'],
            ['name' => 'Finance', 'description' => 'Gestion financière de l’entreprise'],
        ];
        foreach ($departments as $department) {
            Department::create($department);
        }

        // Opérateurs
        $operators = [
            ['operator' => 'Orange'],
            ['operator' => 'Inwi'],
            ['operator' => 'Maroc Telecom'],
        ];
        foreach ($operators as $operator) {
            Operator::create($operator);
        }

        // Types de paiement
        $paymentTypes = [
            ['type' => 'Virement bancaire'],
            ['type' => 'Chèque'],
            ['type' => 'Espèces'],
            ['type' => 'Carte bancaire'],
        ];
        foreach ($paymentTypes as $paymentType) {
            PaymentType::create($paymentType);
        }

        // Statuts employés
        $statuse = ['actif', 'inactif', 'rejete', 'demission'];
        foreach ($statuse as $status) {
            Status::create(['status' => $status]);
        }

        // Postes employés
        $posts = [
            ['post' => 'Software Engineer'],
            ['post' => 'Project Manager'],
            ['post' => 'HR Specialist'],
            ['post' => 'Accountant'],
            ['post' => 'IT Support'],
            ['post' => 'UX Designer'],
            ['post' => 'Marketing Lead'],
            ['post' => 'Data Analyst'],
        ];
        foreach ($posts as $post) {
            EmployeePost::create($post);
        }
    }
}
