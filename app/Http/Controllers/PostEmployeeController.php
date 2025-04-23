<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeePost;
use App\Models\PostEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostEmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = PostEmployee::with(['employee.user', 'employeePost']);
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('employee', function($q) use ($search) {
                $q->whereHas('user', function($qu) use ($search) {
                    $qu->where('first_name', 'like', "%{$search}%")
                       ->orWhere('last_name', 'like', "%{$search}%");
                });
            })->orWhereHas('employeePost', function($q) use ($search) {
                $q->where('post', 'like', "%{$search}%");
            });
        }
        
        if ($request->has('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }
        
        if ($request->has('employee_post_id')) {
            $query->where('employee_post_id', $request->employee_post_id);
        }
        
        if ($request->has('in_date_from')) {
            $query->whereDate('in_date', '>=', $request->in_date_from);
        }
        
        if ($request->has('in_date_to')) {
            $query->whereDate('in_date', '<=', $request->in_date_to);
        }
        
        $postEmployees = $query->paginate(10);
        $employees = Employee::with('user')->get();
        $employeePosts = EmployeePost::all();
        
        return view('post-employees.index', compact('postEmployees', 'employees', 'employeePosts'));
    }

    public function create()
    {
        $employees = Employee::with('user')->get();
        $employeePosts = EmployeePost::all();
        
        return view('post-employees.create', compact('employees', 'employeePosts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_post_id' => 'required|exists:employee_posts,id',
            'employee_id' => 'required|exists:employees,id',
            'attachment' => 'nullable|file|max:10240',
            'in_date' => 'required|date',
            'out_date' => 'nullable|date|after_or_equal:in_date',
        ]);
        
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('post_attachments', 'public');
            $validated['attachment'] = $path;
        }
        
        PostEmployee::create($validated);
        
        return redirect()->route('post-employees.index')
            ->with('success', 'Post employee record created successfully.');
    }

    public function show(PostEmployee $postEmployee)
    {
        $postEmployee->load(['employee.user', 'employeePost']);
        
        return view('post-employees.show', compact('postEmployee'));
    }

    public function edit(PostEmployee $postEmployee)
    {
        $employees = Employee::with('user')->get();
        $employeePosts = EmployeePost::all();
        
        return view('post-employees.edit', compact('postEmployee', 'employees', 'employeePosts'));
    }

    public function update(Request $request, PostEmployee $postEmployee)
    {
        $validated = $request->validate([
            'employee_post_id' => 'required|exists:employee_posts,id',
            'employee_id' => 'required|exists:employees,id',
            'attachment' => 'nullable|file|max:10240',
            'in_date' => 'required|date',
            'out_date' => 'nullable|date|after_or_equal:in_date',
        ]);
        
        if ($request->hasFile('attachment')) {
            if ($postEmployee->attachment) {
                Storage::disk('public')->delete($postEmployee->attachment);
            }
            $path = $request->file('attachment')->store('post_attachments', 'public');
            $validated['attachment'] = $path;
        }
        
        $postEmployee->update($validated);
        
        return redirect()->route('post-employees.index')
            ->with('success', 'Post employee record updated successfully.');
    }

    public function destroy(PostEmployee $postEmployee)
    {
        if ($postEmployee->attachment) {
            Storage::disk('public')->delete($postEmployee->attachment);
        }
        
        $postEmployee->delete();
        
        return redirect()->route('post-employees.index')
            ->with('success', 'Post employee record deleted successfully.');
    }
    
    public function download(PostEmployee $postEmployee)
    {
        if (!$postEmployee->attachment) {
            return redirect()->back()->with('error', 'No attachment found.');
        }
        
        return Storage::disk('public')->download($postEmployee->attachment, 'attachment');
    }
}
