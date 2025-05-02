<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Department;
use App\Models\Operator;
use App\Models\PaymentType;
use App\Models\Status;
use App\Models\Type;
use App\Models\User;
use App\Models\Enterprise;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        $departments = [
            ['name' => 'IT', 'description' => 'Information Technology Department'],
            ['name' => 'Human Resources', 'description' => 'Personnel and Talent Management'],
            ['name' => 'Marketing', 'description' => 'Marketing Strategies and Communication'],
            ['name' => 'Finance', 'description' => 'Financial Management of the Company'],
            ['name' => 'Sales', 'description' => 'Responsible for selling products or services'],
            ['name' => 'Customer Service', 'description' => 'Support and Assistance to Clients'],
            ['name' => 'Production', 'description' => 'Management of the Manufacturing and Production of Goods'],
            ['name' => 'Logistics', 'description' => 'Management of Stocks and Distribution'],
            ['name' => 'Legal', 'description' => 'Management of Legal Affairs and Contracts'],
            ['name' => 'Communication', 'description' => 'Management of Public Relations and External Communication'],
            ['name' => 'Research and Development', 'description' => 'Innovation and Development of New Products'],
            ['name' => 'Purchasing', 'description' => 'Management of Procurement and Suppliers'],
            ['name' => 'Security', 'description' => 'Ensuring Physical and Cybersecurity for the Company'],
            ['name' => 'Project Management', 'description' => 'Coordination and Management of Projects within the Company'],
            ['name' => 'Business Development', 'description' => 'Development of Growth and Expansion Strategies'],
            ['name' => 'Risk Management', 'description' => 'Identification and Management of Risks for the Company'],
            ['name' => 'Audit', 'description' => 'Verification of Financial Statements and Internal Processes'],
            ['name' => 'Quality', 'description' => 'Ensuring the Quality of Products/Services Provided'],
            ['name' => 'After-Sales Service', 'description' => 'Support to Customers after Product Purchase'],
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
            ['type' => 'Bank Transfer'],
            ['type' => 'Paycheck'],
            ['type' => 'Cash'],
            ['type' => 'Direct Deposit'],
            ['type' => 'Wire Transfer'],
            ['type' => 'Mobile Payment'],
            ['type' => 'Cryptocurrency'],  // Some companies may offer this
            ['type' => 'Payroll Card'],
            ['type' => 'Gift Card'],
            ['type' => 'Voucher'],
            ['type' => 'Stock Options'],
            ['type' => 'Bonuses'],
            ['type' => 'Equity Compensation'],
            ['type' => 'Deferred Compensation'],
        ];

        foreach ($paymentTypes as $paymentType) {
            PaymentType::create($paymentType);
        }

        $statuse = ['active', 'inactive', 'rejeted', 'quited','fired'];
        foreach ($statuse as $status) {
            Status::create(['status' => $status]);
        }




        $types = [
            'trainee',
            'secretary',
            'director',
            'freelancer',
            'manager',
            'team_leader',
            'developer',
            'designer',
            'accountant',
            'human_resources',
            'marketing_specialist',
            'sales_representative',
            'business_analyst',
            'customer_support',
            'legal_advisor',
            'security_guard',
            'driver',
            'technician',
            'consultant',
            'intern',
            'project_manager',
            'content_creator',
            'qa_tester',  // Quality Assurance
            'operations_manager',
            'data_analyst'
        ];

        foreach ($types as $type) {
            Type::create(['type' => $type]);
        }




        // super admin creation
        User::create([
            'first_name' => 'salma',
            'last_name' => 'salhi',
            'email' => 'salmasalhi@gmail.com',
            'password' => Hash::make('salma'),
            'is_super_admin' => 1,
        ]);


        Enterprise::create([
            'name'=>'hi',
            'logo'=>null
        ]);
    }
}
