<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    public function index(Request $request)
    {
        $query = Leave::with('employee.user')->latest();
        
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


    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'reason_id' => 'required|exists:reasons,id',
        ]);
        
        Leave::create([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason_id' => $request->reason_id,
            'status' => 'pending',
            'employee_id' => Auth::user()->employee->id,
        ]);
        
        return redirect()->back()->with('success', 'Leave Has been requested successfully.');
    }


    public function update(Request $request, Leave $leave)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);
        
        $leave->update($request->only('status'));
        
        return redirect()->back()->with('success', 'Leave updated successfully.');
    }

   

}