<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
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
            $query->where(function($q) use ($search) {
                $q->where('employee_code', 'like', "%{$search}%")
                  ->orWhere('cin', 'like', "%{$search}%")
                  ->orWhere('professional_email', 'like', "%{$search}%")
                  ->orWhereHas('user', function($qu) use ($search) {
                      $qu->where('first_name', 'like', "%{$search}%")
                         ->orWhere('last_name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->has('department')) {
            $query->where('department_id', $request->department);
        }

        if ($request->has('status')) {
            $query->where('status_id', $request->status);
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
        $statuses = Status::all();
        $user_roles = UserRole::all();
        $user_statuses = UserStatus::all();

        return view('employees.create', compact('departments', 'operators', 'statuses','user_statuses','user_roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_code' => 'required|string|max:255|unique:employees',
            'cin' => 'required|string|max:255|unique:employees',
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
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $validated['profile_picture'] = $path;
        }

        Employee::create($validated);

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
        $statuses = Status::all();
        $users = User::whereDoesntHave('employee')->orWhere('id', $employee->users_id)->get();

        return view('employees.edit', compact('employee', 'departments', 'operators', 'statuses', 'users'));
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
