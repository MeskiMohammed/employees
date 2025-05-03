<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Leave;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class EmployeeProfileController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $employee = Employee::where('user_id', $user->id)->firstOrFail();
        
        // Get clock in status (mock data)
        $clockedIn = rand(0, 1) == 1;
        $clockedInTime = $clockedIn ? now()->subHours(rand(1, 8))->format('h:i A') : null;
        
        // Get leave balance (mock data)
        $leaveBalance = (object)[
            'annual' => 15,
            'annual_total' => 21,
            'annual_percentage' => (15 / 21) * 100,
            'sick' => 7,
            'sick_total' => 10,
            'sick_percentage' => (7 / 10) * 100
        ];
        
        // Get recent leaves
        $leaves = Leave::where('employee_id', $employee->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Get recent payments
        $payments = Payment::where('employee_id', $employee->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Get upcoming events (mock data)
        $events = collect([
            (object)[
                'title' => 'Team Meeting',
                'date' => now()->addDays(2),
                'time' => '10:00 AM'
            ],
            (object)[
                'title' => 'Project Deadline',
                'date' => now()->addDays(5),
                'time' => '5:00 PM'
            ],
            (object)[
                'title' => 'Company Holiday',
                'date' => now()->addDays(10),
                'time' => 'All Day'
            ]
        ]);
        
        // Get announcements (mock data)
        $announcements = collect([
            (object)[
                'title' => 'Office Closure',
                'content' => 'The office will be closed on May 25th for maintenance.',
                'created_at' => now()->subDays(1)
            ],
            (object)[
                'title' => 'New Health Benefits',
                'content' => 'We are pleased to announce new health benefits starting next month.',
                'created_at' => now()->subDays(3)
            ]
        ]);
        
        return view('employee.dashboard', compact(
            'employee', 
            'clockedIn', 
            'clockedInTime', 
            'leaveBalance', 
            'leaves', 
            'payments', 
            'events', 
            'announcements'
        ));
    }
    
    public function leaves()
    {
        $user = Auth::user();
        $employee = Employee::where('user_id', $user->id)->firstOrFail();
        
        $leaves = Leave::where('employee_id', $employee->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('employee.leaves', compact('employee', 'leaves'));
    }
    
    public function leaveRequest()
    {
        $user = Auth::user();
        $employee = Employee::where('user_id', $user->id)->firstOrFail();
        
        return view('employee.leaves.request', compact('employee'));
    }
    
    public function documents()
    {
        $user = Auth::user();
        $employee = Employee::where('user_id', $user->id)->firstOrFail();
        
       
            
        return view('employee.documents', compact('employee'));
    }
    
    public function payments()
    {
        $user = Auth::user();
        $employee = Employee::where('user_id', $user->id)->firstOrFail();
        
        $payments = Payment::where('employee_id', $employee->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('employee.payments', compact('employee', 'payments'));
    }
    
}
