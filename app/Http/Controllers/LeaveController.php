<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Leave;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function index(Request $request)
    {
        $query = Leave::with('employee.user');
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('employee', function($q) use ($search) {
                $q->whereHas('user', function($qu) use ($search) {
                    $qu->where('first_name', 'like', "%{$search}%")
                       ->orWhere('last_name', 'like', "%{$search}%");
                });
            });
        }
        
        if ($request->has('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }
        
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->has('start_date')) {
            $query->whereDate('start_date', '>=', $request->start_date);
        }
        
        if ($request->has('end_date')) {
            $query->whereDate('end_date', '<=', $request->end_date);
        }
        
        $leaves = $query->paginate(10);
        $employees = Employee::with('user')->get();
        $statuses = ['pending', 'approved', 'rejected'];
        
        return view('leaves.index', compact('leaves', 'employees', 'statuses'));
    }

    public function create()
    {
        $employees = Employee::with('user')->get();
        $statuses = ['pending', 'approved', 'rejected'];
        
        return view('leaves.create', compact('employees', 'statuses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string',
            'status' => 'required|in:pending,approved,rejected',
            'employee_id' => 'required|exists:employees,id',
        ]);
        
        Leave::create($validated);
        
        return redirect()->route('leaves.index')
            ->with('success', 'Leave created successfully.');
    }

    public function show(Leave $leave)
    {
        $leave->load('employee.user');
        
        return view('leaves.show', compact('leave'));
    }

    public function edit(Leave $leave)
    {
        $employees = Employee::with('user')->get();
        $statuses = ['pending', 'approved', 'rejected'];
        
        return view('leaves.edit', compact('leave', 'employees', 'statuses'));
    }

    public function update(Request $request, Leave $leave)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string',
            'status' => 'required|in:pending,approved,rejected',
            'employee_id' => 'required|exists:employees,id',
        ]);
        
        $leave->update($validated);
        
        return redirect()->route('leaves.index')
            ->with('success', 'Leave updated successfully.');
    }

    public function destroy(Leave $leave)
    {
        $leave->delete();
        
        return redirect()->route('leaves.index')
            ->with('success', 'Leave deleted successfully.');
    }
}
