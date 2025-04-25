<?php

namespace App\Http\Controllers;

use App\Models\EmployeePost;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmployeePostController extends Controller
{
    public function index(Request $request)
    {
        $query = EmployeePost::withCount('postEmployees');
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('post', 'like', "%{$search}%");
        }
        
        $employeePosts = $query->paginate(10);
        return view('employee-posts.index', compact('employeePosts'));
    }

    public function create()
    {
        return view('employee-posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'post' => 'required|string|max:255|unique:employee_posts',
        ]);
        
        EmployeePost::create($validated);
        
        return redirect()->route('employee-posts.index')
            ->with('success', 'Employee post created successfully.');
    }

    public function show(EmployeePost $employeePost)
    {
        $employeePost->load('postEmployees.employee.user');
        
        return view('employee-posts.show', compact('employeePost'));
    }

    public function edit(EmployeePost $employeePost)
    {
        return view('employee-posts.edit', compact('employeePost'));
    }

    public function update(Request $request, EmployeePost $employeePost)
    {
        $validated = $request->validate([
            'post' => ['required', 'string', 'max:255', Rule::unique('employee_posts')->ignore($employeePost->id)],
        ]);
        
        $employeePost->update($validated);
        
        return redirect()->route('employee-posts.index')
            ->with('success', 'Employee post updated successfully.');
    }

    public function destroy(EmployeePost $employeePost)
    {
        if ($employeePost->postEmployees()->count() > 0) {
            return redirect()->route('employee-posts.index')
                ->with('error', 'Cannot delete employee post with associated records.');
        }
        
        $employeePost->delete();
        
        return redirect()->route('employee-posts.index')
            ->with('success', 'Employee post deleted successfully.');
    }
}
