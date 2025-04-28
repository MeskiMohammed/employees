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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Http\Requests\StoreEmployeeRequest;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::with(['status', 'user']);

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

    // public function store(Request $request){
    //     dd($request);
    // }



    public function store(StoreEmployeeRequest $request)
    {
        DB::beginTransaction();

        // Store Files with uniqid
        $picPath = $request->file('profile_picture')->storeAs(
            'profile_pictures',
            uniqid().'_'.$request->file('profile_picture')->getClientOriginalName(),
            'public'
        );

        $cinPath = $request->file('cin_attachment')->storeAs(
            'cin_attachments',
            uniqid().'_'.$request->file('cin_attachment')->getClientOriginalName(),
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
                $data['salary'] = $request->salary;
                $data['hours'] = 0;
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
            ]);
        }

        // Create User
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

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
        $type = match($request->is_freelancer) {
        'freelancer', 'trainee' => Type::where('type', $request->is_freelancer)->first(),
        default => Type::find($request->type_id),
        };

        // Create TypeEmployee
        $typeEmployee = new TypeEmployee([
            'description' => 'test',
            'in_date' => now(),
        ]);

        $typeEmployee->employee()->associate($employee);
        $typeEmployee->type()->associate($type);
        $typeEmployee->save();

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

        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $departments = Department::all();
        $operators = Operator::all();
        $types = Type::all();

        return view('employees.edit', compact('employee', 'departments', 'operators', 'types'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'employee_code' => ['required', 'string', 'max:255', Rule::unique('employees')->ignore($employee->id)],
            'cin' => ['required', 'string', 'max:255', Rule::unique('employees')->ignore($employee->id)],
            'profile_picture' => 'nullable|image|max:2048',
            'adress' => 'nullable|string|max:255',
            'personal_num' => 'nullable|string|max:255',
            'professional_num' => 'nullable|string|max:255',
            'pin' => 'nullable|string|max:255',
            'puk' => 'nullable|string|max:255',
            'salary' => 'nullable|numeric',
            'is_project' => 'boolean',
            'houres' => 'nullable|integer',
            'ice' => 'nullable|string|max:255',
            'professional_email' => 'nullable|email|max:255',
            'cnss' => 'nullable|string|max:255',
            'assurance' => 'nullable|string|max:255',
            'users_id' => 'required|exists:users,id',
            'operator_id' => 'nullable|exists:operators,id',
            'department_id' => 'required|exists:departments,id',
            'status_id' => 'required|exists:status,id',
        ]);

        if ($request->hasFile('profile_picture')) {
            if ($employee->profile_picture) {
                Storage::disk('public')->delete($employee->profile_picture);
            }
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $validated['profile_picture'] = $path;
        }

        $employee->update($validated);

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

}
