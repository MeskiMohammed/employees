<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\FreelancerProject;
use App\Models\Leave;
use App\Models\Payment;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeProfileController extends Controller
{
    public function dashboard()
    {
        $employee = Auth::user()->employee;

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
        $employee = Auth::user()->employee;

        $leaves = Leave::where('employee_id', $employee->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('employee.leaves', compact('employee', 'leaves'));
    }

    public function leaveRequest()
    {
        $employee = Auth::user()->employee;
        return view('employee.leaves.request', compact('employee'));
    }

    public function attachments()
    {
        $employee = Auth::user()->employee;
        return view('employee.attachments', compact('employee'));
    }

    public function payments()
    {
        $employee = Auth::user()->employee;

        $payments = Payment::where('employee_id', $employee->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('employee.payments', compact('employee', 'payments'));
    }

    public function Projects(Request $request)
    {
        $query = FreelancerProject::with('employee.user');
    
    
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }
        
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }
    
        $projects = $query->paginate(10);

        $employee = Auth::user()->employee;
        
        return view('employee.projects', compact('employee','projects'));

    }
}
