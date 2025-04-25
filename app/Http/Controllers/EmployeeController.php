<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\EmployeePost;
use App\Models\Operator;
use App\Models\Status;
use App\Models\User;
use App\Models\UserRole;
use App\Models\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::with(['department', 'status', 'user']);

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
        $posts = EmployeePost::all();

        return view('employees.create', compact('departments', 'operators','posts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8',

            'department_id' => 'required|exists:departments,id',
            'profile_picture' => ['required','image','mimes:jpeg,png,jpg','dimensions:width=1080,height=1080,ratio=1/1'],
            'personal_num' => 'required|string|max:255',
            'salary' => 'required|numeric',
            'address' => 'required|string|max:255',
            'cin' => 'required|string|max:8|unique:employees',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => $request->password,
            'user_role_id' => 3,
        ]);

        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            // $validated['profile_picture'] = $path;
            $pic_path = $path;
        }

        $data = [
            'department_id' => $request->department_id,
            'profile_picture' => $pic_path,
            'personal_num' => $request->personal_num,
            'salary' => $request->salary,
            'address' => $request->address,
            'status_id' => 1,
            'user_id' => $user->id,
            'cin' => $request->cin
        ];

        if ($request->is_freelancer === 'freelancer') {
            $request->validate([
                'ice' => 'required|string|max:255',
            ]);

            $data['ice'] = $request->ice;
            $data['is_project'] = $request->is_project ? true : false;
            $data['hours'] = 0;
        } else {
            $request->validate([
                'employee_code' => 'required|string|max:255|unique:employees',
                'professional_num' => 'required|string|max:255',
                'pin' => 'required|string|max:255',
                'puk' => 'required|string|max:255',
                'operator_id' => 'required|exists:operators,id',
                'professional_email' => 'required|email|max:255',
                'cnss' => 'required|string|max:255',
                'assurance' => 'required|string|max:255',
            ]);

            $data['employee_code'] = $request->employee_code;
            $data['professional_num'] = $request->professional_num;
            $data['professional_email'] = $request->professional_email;
            $data['pin'] = $request->pin;
            $data['puk'] = $request->puk;
            $data['operator_id'] = $request->operator_id;
            $data['cnss'] = $request->cnss;
            $data['assurance'] = $request->assurance;
        }
        Employee::create($data);

        return redirect()->route('employees.index')
            ->with('success', 'Employee created successfully.');
    }

    public function show(Employee $employee)
    {
        $employee->load(['department', 'status', 'user', 'operator', 'payments', 'leaves', 'attachments', 'evaluations', 'freelancerProjects', 'posts']);

        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $departments = Department::all();
        $operators = Operator::all();
        $posts = EmployeePost::all();

        return view('employees.edit', compact('employee','departments', 'operators','posts'));
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

        return redirect()->route('employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        if ($employee->profile_picture) {
            Storage::disk('public')->delete($employee->profile_picture);
        }

        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', 'Employee deleted successfully.');
    }
}
