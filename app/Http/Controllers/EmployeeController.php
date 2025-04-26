<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\EmployeeDepartment;
use App\Models\EmployeeDepartments;
use App\Models\EmployeePost;
use App\Models\Operator;
use App\Models\Status;
use App\Models\Type;
use App\Models\TypeEmployee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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


    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:8',
                'department_ids' => 'required|array|min:1',
                'profile_picture' => ['required', 'image', 'mimes:jpeg,png,jpg', 'dimensions:width=1080,height=1080,ratio=1/1'],
                'personal_num' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'cin' => 'required|string|max:8|unique:employees',
                'cin_attachment' => 'required|image|mimes:jpeg,png,jpg',
                'type_id' => 'required',
            ]);

            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'user_role_id' => 3,
            ]);

            $pic = $request->file('profile_picture')->store('profile_pictures', 'public');

            $cin = $request->file('cin_attachment')->store('cin_attachments', 'public');

            $data = [
                'profile_picture' => $pic,
                'personal_num' => $request->personal_num,
                'address' => $request->address,
                'status_id' => 1,
                'user_id' => $user->id,
                'cin' => $request->cin,
                'cin_attachment' => $cin
            ];

            if ($request->is_freelancer === 'freelancer') {

                if($request->is_project){

                    $request->validate([
                        'ice' => 'required|string|max:255',
                    ]);
                    
                    $data['is_project'] = true;

                }else{

                    $request->validate([
                        'ice' => 'required|string|max:255',
                        'salary' => 'required|numeric',
                    ]);

                    $data['is_project'] = false;
                    $data['salary'] = $request->salary;
                    $data['hours'] = 0;
                }

                $data['ice'] = $request->ice;
            } else {
                $request->validate([
                    'salary' => 'required|numeric',
                    'professional_num' => 'required|string|max:255',
                    'pin' => 'required|string|max:255',
                    'puk' => 'required|string|max:255',
                    'operator_id' => 'required|exists:operators,id',
                    'professional_email' => 'required|email|max:255',
                    'cnss' => 'required|string|max:255',
                    'assurance' => 'required|string|max:255',
                ]);

                $data['employee_code'] = $this->generateEmployeeCode();
                $data['salary'] = $request->salary;
                $data['professional_num'] = $request->professional_num;
                $data['professional_email'] = $request->professional_email;
                $data['pin'] = $request->pin;
                $data['puk'] = $request->puk;
                $data['operator_id'] = $request->operator_id;
                $data['cnss'] = $request->cnss;
                $data['assurance'] = $request->assurance;
            }
            
            $emp = Employee::create($data);

            foreach($request->department_ids as $id){
                EmployeeDepartment::create([
                    'employee_id' => $emp->id,
                    'department_id' => $id,
                ]);
            }

            TypeEmployee::create([
                'description' => 'test',
                'in_date' => now(),
                'employee_id' => $emp->id,
                'type_id' => $request->type_id,
            ]);

            DB::commit();

            return redirect()->route('employees.index')->with('success', 'Employee created successfully.');

        } catch (\Exception $e) {
            DB::rollback();

            return back()->withErrors(['error' => 'Something went wrong: ' . $e->getMessage()]);
        }
    }

    public function show(Employee $employee)
    {
        $employee->load(['status', 'user', 'operator', 'payments', 'leaves', 'evaluations', 'freelancerProjects', 'posts']);

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

        return redirect()->route('employees.index')
            ->with('success', 'Employee updated successfully.');
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
