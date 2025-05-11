<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\EmployeeDepartment;
use App\Models\Operator;
use App\Models\Status;
use App\Models\Type;
use App\Models\TypeEmployee;
use App\Models\User;
use App\Models\PaymentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Attachment;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::with(['status', 'user'])->where('user_id', '<>', Auth::id());

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('employee_code', 'like', "%{$search}%")
                    ->orWhere('cin', 'like', "%{$search}%")
                    ->orWhere('professional_email', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($qu) use ($search) {
                        $qu->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%");
                    });
            });
            if ($request->department != null) {
                $query->where('department_id', $request->department);
            }

            if ($request->status != null) {
                $query->where('status_id', $request->status);
            }

            if ($request->filled('type')) {
                $query->whereHas('typeEmployees', function ($q) use ($request) {
                    $q->where('type_id', $request->type);
                });
            }
        }

        $employees = $query->paginate(10);
        $departments = Department::all();
        $statuses = Status::all();

        return view('employees.index', compact('employees', 'departments', 'statuses'));
    }

    public function create()
    {
        $departments = Department::all();
        $operators = Operator::all();
        $types = Type::all();

        return view('employees.create', compact('departments', 'operators', 'types'));
    }

    public function store(StoreEmployeeRequest $request)
    {
        DB::beginTransaction();

        // Store Files with uniqid
        $picPath = $request->file('profile_picture')->storeAs(
            'profile_pictures',
            uniqid() . '_' . $request->file('profile_picture')->getClientOriginalName(),
            'public'
        );

        $cinPath = $request->file('cin_attachment')->storeAs(
            'cin_attachments',
            uniqid() . '_' . $request->file('cin_attachment')->getClientOriginalName(),
            'public'
        );

        // Base Employee Data
        $data = [
            'profile_picture' => $picPath,
            'personal_num' => $request->personal_num,
            'address' => $request->address,
            'status_id' => 1,
            'cin' => $request->cin,
            'cin_attachment' => $cinPath,
        ];

        // Freelancer Specific
        if ($request->is_freelancer === 'freelancer') {
            $data['ice'] = $request->ice;
            $data['is_project'] = $request->has('is_project') ? true : false;

            if (!$data['is_project']) {
                $data['hourly_salary'] = $request->hourly_salary;
            }
        }
        // Employee Specific
        elseif ($request->is_freelancer === 'employee') {
            $data = array_merge($data, [
                'employee_code' => $this->generateEmployeeCode(),
                'salary' => $request->salary,
                'professional_num' => $request->professional_num,
                'professional_email' => $request->professional_email,
                'pin' => $request->pin,
                'puk' => $request->puk,
                'operator_id' => $request->operator_id,
                'cnss' => $request->cnss,
                'assurance' => $request->assurance,
                'is_anapec' => $request->has('is_anapec') ? true : false,
            ]);
        }else{
            $data = array_merge($data,[
                'training_type'=>$request->training_type,
                'school'=>$request->school
            ]);
        }

        // Create User
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $user->assignRole('employee');

        $data['user_id'] = $user->id;

        // Create Employee
        $employee = Employee::create($data);

        // Attach Departments
        foreach ($request->department_ids as $id) {
            EmployeeDepartment::create([
                'employee_id' => $employee->id,
                'department_id' => $id,
            ]);
        }

        // Determine Type
        $type = match ($request->is_freelancer) {
            'freelancer', 'trainee' => Type::where('type', $request->is_freelancer)->first(),
            default => Type::find($request->type_id),
        };

        // Create TypeEmployee
        $typeEmployee = new TypeEmployee([
            'in_date' => now(),
        ]);

        $typeEmployee->employee()->associate($employee);
        $typeEmployee->type()->associate($type);
        $typeEmployee->save();

        if ($request->is_freelancer === 'freelancer') {

            $eicPath = $request->file('eic')->storeAs('attachments', uniqid() . '_' . $request->file('eic')->getClientOriginalName(), 'public');

            Attachment::create([
                'name' => 'Entrepreneur Identification Card',
                'attachment' => $eicPath,
                'type_employee_id' => $typeEmployee->id,
            ]);
        } elseif ($request->is_freelancer === 'employee') {

            $ecPath = $request->file('employment_contract')->storeAs('attachments', uniqid() . '_' . $request->file('employment_contract')->getClientOriginalName(), 'public');
            $jaPath = $request->file('job_application')->storeAs('attachments', uniqid() . '_' . $request->file('job_application')->getClientOriginalName(), 'public');
            $iPath = $request->file('insurance')->storeAs('attachments', uniqid() . '_' . $request->file('insurance')->getClientOriginalName(), 'public');
            $rPath = $request->file('resume')->storeAs('attachments', uniqid() . '_' . $request->file('resume')->getClientOriginalName(), 'public');
            $ccPath = $request->file('cnss_certificate')->storeAs('attachments', uniqid() . '_' . $request->file('cnss_certificate')->getClientOriginalName(), 'public');

            $data = [
                ['name' => 'employment_contract', 'attachment' => $ecPath, 'type_employee_id' => $typeEmployee->id],
                ['name' => 'job_application', 'attachment' => $jaPath, 'type_employee_id' => $typeEmployee->id],
                ['name' => 'insurance', 'attachment' => $iPath, 'type_employee_id' => $typeEmployee->id],
                ['name' => 'resume', 'attachment' => $rPath, 'type_employee_id' => $typeEmployee->id],
                ['name' => 'cnss_certificate', 'attachment' => $ccPath, 'type_employee_id' => $typeEmployee->id],
            ];

            Attachment::insert($data);
        } else {

            $iagPath = $request->file('internship_agreement')->storeAs('attachments', uniqid() . '_' . $request->file('internship_agreement')->getClientOriginalName(), 'public');
            $iapPath = $request->file('internship_application')->storeAs('attachments', uniqid() . '_' . $request->file('internship_application')->getClientOriginalName(), 'public');
            $iPath = $request->file('insurance_int')->storeAs('attachments', uniqid() . '_' . $request->file('insurance_int')->getClientOriginalName(), 'public');
            $rPath = $request->file('resume_int')->storeAs('attachments', uniqid() . '_' . $request->file('resume_int')->getClientOriginalName(), 'public');
            $tPath = $request->file('transcript')->storeAs('attachments', uniqid() . '_' . $request->file('transcript')->getClientOriginalName(), 'public');

            $data = [
                ['name' => 'internship_agreement', 'attachment' => $iagPath, 'type_employee_id' => $typeEmployee->id],
                ['name' => 'internship_application', 'attachment' => $iapPath, 'type_employee_id' => $typeEmployee->id],
                ['name' => 'insurance', 'attachment' => $iPath, 'type_employee_id' => $typeEmployee->id],
                ['name' => 'resume', 'attachment' => $rPath, 'type_employee_id' => $typeEmployee->id],
                ['name' => 'transcript', 'attachment' => $tPath, 'type_employee_id' => $typeEmployee->id],
            ];

            Attachment::insert($data);
        }

        DB::commit();

        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }


    public function show(Employee $employee)
    {
        $employee->load([
            'user',
            'employeeDepartments.department',
            'typeEmployees.type',
            'operator',
        ]);

        $modules = [
            'employees',
            'departments',

            'leaves',
            'freelancer_projects',
            'types',

            'payment_types',
            'operators',
            'statuses',
            'reasons',
        ];

        return view('employees.show', compact('employee', 'modules'));
    }

    public function edit(Employee $employee)
    {
        $departments = Department::all();
        $operators = Operator::all();
        $types = Type::all();

        return view('employees.edit', compact('employee', 'departments', 'operators', 'types'));
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        DB::beginTransaction();

        // Get the associated user
        $user = User::findOrFail($employee->user_id);

        // Update user data
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
        ]);

        // Update password only if provided
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
            $user->save();
        }

        // Prepare employee data for update
        $data = [
            'personal_num' => $request->personal_num,
            'address' => $request->address,
            'status_id' => Status::where('status', 'active')->first()->id,
        ];

        // Handle profile picture update if provided
        if ($request->hasFile('profile_picture')) {
            // Delete old file if exists
            if ($employee->profile_picture && Storage::disk('public')->exists($employee->profile_picture)) {
                Storage::disk('public')->delete($employee->profile_picture);
            }

            $picPath = $request->file('profile_picture')->storeAs(
                'profile_pictures',
                uniqid() . '_' . $request->file('profile_picture')->getClientOriginalName(),
                'public'
            );

            $data['profile_picture'] = $picPath;
        }

        // Handle CIN attachment update if provided
        if ($request->hasFile('cin_attachment')) {
            // Delete old file if exists
            if ($employee->cin_attachment && Storage::disk('public')->exists($employee->cin_attachment)) {
                Storage::disk('public')->delete($employee->cin_attachment);
            }

            $cinPath = $request->file('cin_attachment')->storeAs(
                'cin_attachments',
                uniqid() . '_' . $request->file('cin_attachment')->getClientOriginalName(),
                'public'
            );

            $data['cin_attachment'] = $cinPath;
            $data['cin'] = $request->cin;
        }

        // Freelancer Specific
        if ($request->is_freelancer === 'freelancer') {
            $data['ice'] = $request->ice;
            $data['is_project'] = $request->has('is_project') ? $request->is_project : false;

            if (!$data['is_project']) {
                $data['hourly_salary'] = $request->hourly_salary;
            }
        }
        // Employee Specific
        elseif ($request->is_freelancer === 'employee') {
            $data = array_merge($data, [
                'employee_code' => is_null($employee->employee_code) ? $this->generateEmployeeCode() : $employee->employee_code,
                'salary' => $request->salary,
                'professional_num' => $request->professional_num,
                'professional_email' => $request->professional_email,
                'pin' => $request->pin,
                'puk' => $request->puk,
                'operator_id' => $request->operator_id,
                'cnss' => $request->cnss,
                'assurance' => $request->assurance,
                'is_anapec' => $request->has('is_anapec') ? $request->is_anapec : false,
            ]);
        }else{
            $data = array_merge($data,[
                'training_type'=>$request->training_type,
                'school'=>$request->school
            ]);
        }

        // Update Employee
        $employee->update($data);

        // Update Departments - first delete existing relationships
        EmployeeDepartment::where('employee_id', $employee->id)->delete();

        // Then create new department relationships
        foreach ($request->department_ids as $id) {
            EmployeeDepartment::create([
                'employee_id' => $employee->id,
                'department_id' => $id,
            ]);
        }

        // Get current TypeEmployee
        $typeEmployee = TypeEmployee::where('employee_id', $employee->id)
            ->orderBy('in_date', 'desc')
            ->first();

        // Determine Type
        $type = match ($request->is_freelancer) {
            'freelancer', 'trainee' => Type::where('type', $request->is_freelancer)->first(),
            default => Type::find($request->type_id),
        };

        // If type has changed, create a new TypeEmployee record
        if ($typeEmployee->type_id != $type->id) {
            // Set out_date for the old record
            $typeEmployee->out_date = now();
            $typeEmployee->save();

            // Create new TypeEmployee
            $newTypeEmployee = new TypeEmployee([
                'in_date' => now(),
            ]);

            $newTypeEmployee->employee()->associate($employee);
            $newTypeEmployee->type()->associate($type);
            $newTypeEmployee->save();

            $typeEmployee = $newTypeEmployee;
        }

        // Handle attachments based on employee type
        if ($request->is_freelancer === 'freelancer' && $request->hasFile('eic')) {
            // Find existing attachment or create new one
            $attachment = Attachment::where('type_employee_id', $typeEmployee->id)
                ->where('name', 'Entrepreneur Identification Card')
                ->first();

            // Delete old file if exists
            if ($attachment && Storage::disk('public')->exists($attachment->attachment)) {
                Storage::disk('public')->delete($attachment->attachment);
            }

            $eicPath = $request->file('eic')->storeAs(
                'attachments',
                uniqid() . '_' . $request->file('eic')->getClientOriginalName(),
                'public'
            );

            if ($attachment) {
                $attachment->update(['attachment' => $eicPath]);
            } else {
                Attachment::create([
                    'name' => 'Entrepreneur Identification Card',
                    'attachment' => $eicPath,
                    'type_employee_id' => $typeEmployee->id,
                ]);
            }
        } elseif ($request->is_freelancer === 'employee') {
            // Handle employee attachments
            $attachmentTypes = [
                'employment_contract' => 'employment_contract',
                'job_application' => 'job_application',
                'insurance' => 'insurance',
                'resume' => 'resume',
                'cnss_certificate' => 'cnss_certificate'
            ];

            foreach ($attachmentTypes as $fileKey => $attachmentName) {
                if ($request->hasFile($fileKey)) {
                    // Find existing attachment
                    $attachment = Attachment::where('type_employee_id', $typeEmployee->id)
                        ->where('name', $attachmentName)
                        ->first();

                    // Delete old file if exists
                    if ($attachment && Storage::disk('public')->exists($attachment->attachment)) {
                        Storage::disk('public')->delete($attachment->attachment);
                    }

                    $filePath = $request->file($fileKey)->storeAs(
                        'attachments',
                        uniqid() . '_' . $request->file($fileKey)->getClientOriginalName(),
                        'public'
                    );

                    if ($attachment) {
                        $attachment->update(['attachment' => $filePath]);
                    } else {
                        Attachment::create([
                            'name' => $attachmentName,
                            'attachment' => $filePath,
                            'type_employee_id' => $typeEmployee->id,
                        ]);
                    }
                }
            }
        } else { // Trainee
            // Handle trainee attachments
            $attachmentTypes = [
                'internship_agreement' => 'internship_agreement',
                'internship_application' => 'internship_application',
                'insurance_int' => 'insurance',
                'resume_int' => 'resume',
                'transcript' => 'transcript'
            ];

            foreach ($attachmentTypes as $fileKey => $attachmentName) {
                if ($request->hasFile($fileKey)) {
                    // Find existing attachment
                    $attachment = Attachment::where('type_employee_id', $typeEmployee->id)
                        ->where('name', $attachmentName)
                        ->first();

                    // Delete old file if exists
                    if ($attachment && Storage::disk('public')->exists($attachment->attachment)) {
                        Storage::disk('public')->delete($attachment->attachment);
                    }

                    $filePath = $request->file($fileKey)->storeAs(
                        'attachments',
                        uniqid() . '_' . $request->file($fileKey)->getClientOriginalName(),
                        'public'
                    );

                    if ($attachment) {
                        $attachment->update(['attachment' => $filePath]);
                    } else {
                        Attachment::create([
                            'name' => $attachmentName,
                            'attachment' => $filePath,
                            'type_employee_id' => $typeEmployee->id,
                        ]);
                    }
                }
            }
        }


        DB::commit();
        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }


    public function destroy(Employee $employee)
    {
        DB::transaction(function () use ($employee) {
            if ($employee->profile_picture) {
                Storage::disk('public')->delete($employee->profile_picture);
            }
            $id = $employee->user_id;

            $employee->delete();

            User::where('id', $id)->delete();
        });

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }

    private function generateEmployeeCode()
    {
        do {
            $number = mt_rand(10000000, 99999999);
        } while (Employee::where('employee_code', $number)->exists());

        return $number;
    }

    public function toggleAdmin(Employee $employee)
    {
        $usr = $employee->user;
        if ($usr->hasRole('admin')) {
            $usr->removeRole('admin');
        } else {
            $usr->assignRole('admin');
        }
        return redirect()->back()->with('success', 'User has been modifier successfully');
    }

    public function assignPermissions(Request $request, Employee $employee)
    {
        $permissions = $request->permissions;
        $employee->user->syncPermissions($permissions);
        return redirect()->back()->with('success', 'permissions has been assigned successfully');
    }

    public function payment(Employee $employee)
    {
        $grossSalary = $employee->salary;

        $cnssRate = 0.0674;
        $cnssDeduction = $grossSalary * $cnssRate;

        $taxRate = match (true) {
            $grossSalary <= 3000 => 0,
            $grossSalary <= 5000 => 0.10,
            $grossSalary <= 10000 => 0.20,
            $grossSalary <= 15000 => 0.30,
            $grossSalary <= 20000 => 0.34,
            default => 0.38,
        };

        $incomeTaxDeduction = $employee->salary * $taxRate;

        $netSalary = $employee->salary - $cnssDeduction - $incomeTaxDeduction;

        $previousPayments = $employee->payments->sortByDesc('created_at');

        $paymentTypes = PaymentType::all();

        $hasBeenPayedThisMonth = $employee->payments()
            ->where('created_at', '>=', now()->startOfMonth())
            ->where('created_at', '<=', now()->endOfMonth())
            ->exists();

        return view('employees.pay', compact('employee', 'grossSalary', 'cnssDeduction', 'taxRate', 'incomeTaxDeduction', 'netSalary', 'previousPayments', 'paymentTypes', 'hasBeenPayedThisMonth'));
    }

    public function pay(Request $request, Employee $employee)
    {
        $grossSalary = $employee->salary;

        $cnssRate = 0.0674;
        $cnssDeduction = $grossSalary * $cnssRate;

        $taxRate = match (true) {
            $grossSalary <= 3000 => 0,
            $grossSalary <= 5000 => 0.10,
            $grossSalary <= 10000 => 0.20,
            $grossSalary <= 15000 => 0.30,
            $grossSalary <= 20000 => 0.34,
            default => 0.38,
        };

        $incomeTaxDeduction = $employee->salary * $taxRate;

        $netSalary = $employee->salary - $cnssDeduction - $incomeTaxDeduction;

        Payment::create([
            'employee_id' => $employee->id,
            'payment_type_id' => $request->payment_type_id,
            'gross' => $grossSalary,
            'cnss' => $cnssDeduction,
            'tax_rate' => $taxRate,
            'income_tax' => $incomeTaxDeduction,
            'net' => $netSalary,
        ]);

        return redirect()->back()->with('success', 'Payment has been made successfully');
    }

    public function endPost(Employee $employee)
    {
        $employee->typeEmployees()->latest()->first()->update([
            'out_date' => now(),
        ]);
        $employee->update([
            'status_id' => Status::where('status', 'inactive')->first()->id,
        ]);

        return redirect()->route('employees.show', $employee)->with('success', 'Post has been ended successfully');
    }

    public function badge(Employee $employee)
    {
        return view('employees.badge', compact('employee'));
    }

    public function cin(Employee $employee)
    {
        $usr = $employee->user;
        $name = $usr->first_name.' '.$usr->last_name;
        return Storage::disk('public')->download($employee->cin_attachment, $name.' cin.'.pathinfo($employee->cin_attachment,PATHINFO_EXTENSION));
    }
}
