<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Leave;
use App\Models\Payment;
use App\Models\Event;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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
    
    public function profile()
    {
        $user = Auth::user();
        $employee = Employee::with(['department', 'post', 'manager'])
            ->where('users_id', $user->id)
            ->firstOrFail();
            
        return view('employee.profile', compact('employee'));
    }
    
    public function profileEdit()
    {
        $user = Auth::user();
        $employee = Employee::where('users_id', $user->id)->firstOrFail();
        
        return view('employee.profile.edit', compact('employee'));
    }
    
    public function profileUpdate(Request $request)
    {
        $user = Auth::user();
        $employee = Employee::where('users_id', $user->id)->firstOrFail();
        
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'personal_num' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'professional_email' => 'nullable|email|max:255',
            'professional_num' => 'nullable|string|max:255',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_relationship' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:255',
            'emergency_contact_email' => 'nullable|email|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);
        
        // Update user information
        $user->first_name = $validated['first_name'];
        $user->last_name = $validated['last_name'];
        $user->email = $validated['email'];
        
        // Update password if provided
        if (isset($validated['current_password']) && isset($validated['new_password'])) {
            if (!Hash::check($validated['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'The current password is incorrect.'])->withInput();
            }
            
            $user->password = Hash::make($validated['new_password']);
        }
        
        Auth::save();
        
        // Update employee information
        $employee->first_name = $validated['first_name'];
        $employee->last_name = $validated['last_name'];
        $employee->email = $validated['email'];
        $employee->personal_num = $validated['personal_num'] ?? $employee->personal_num;
        $employee->address = $validated['address'] ?? $employee->address;
        $employee->professional_email = $validated['professional_email'] ?? $employee->professional_email;
        $employee->professional_num = $validated['professional_num'] ?? $employee->professional_num;
        
        // Update emergency contact information
        $employee->emergency_contact_name = $validated['emergency_contact_name'] ?? $employee->emergency_contact_name;
        $employee->emergency_contact_relationship = $validated['emergency_contact_relationship'] ?? $employee->emergency_contact_relationship;
        $employee->emergency_contact_phone = $validated['emergency_contact_phone'] ?? $employee->emergency_contact_phone;
        $employee->emergency_contact_email = $validated['emergency_contact_email'] ?? $employee->emergency_contact_email;
        
        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($employee->profile_picture) {
                Storage::disk('public')->delete($employee->profile_picture);
            }
            
            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $employee->profile_picture = $path;
        }
        
        $employee->save();
        
        return redirect()->route('employee.profile')->with('success', 'Profile updated successfully.');
    }
    
    public function leaves()
    {
        $user = Auth::user();
        $employee = Employee::where('users_id', $user->id)->firstOrFail();
        
        $leaves = Leave::where('employee_id', $employee->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('employee.leaves', compact('employee', 'leaves'));
    }
    
    public function leaveRequest()
    {
        $user = Auth::user();
        $employee = Employee::where('users_id', $user->id)->firstOrFail();
        
        return view('employee.leaves.request', compact('employee'));
    }
    
    public function documents()
    {
        $user = Auth::user();
        $employee = Employee::where('users_id', $user->id)->firstOrFail();
        
        $documents = $employee->attachments()
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('employee.documents', compact('employee', 'documents'));
    }
    
    public function payments()
    {
        $user = Auth::user();
        $employee = Employee::where('users_id', $user->id)->firstOrFail();
        
        $payments = Payment::where('employee_id', $employee->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('employee.payments', compact('employee', 'payments'));
    }
    
    public function attendance()
    {
        $user = Auth::user();
        $employee = Employee::where('users_id', $user->id)->firstOrFail();
        
        // Mock attendance data
        $attendances = collect();
        
        return view('employee.attendance', compact('employee', 'attendances'));
    }
    
    public function settings()
    {
        $user = Auth::user();
        $employee = Employee::where('users_id', $user->id)->firstOrFail();
        
        return view('employee.settings', compact('employee'));
    }
    
    public function clockIn(Request $request)
    {
        // Mock clock in functionality
        return response()->json(['success' => true]);
    }
    
    public function clockOut(Request $request)
    {
        // Mock clock out functionality
        return response()->json(['success' => true]);
    }
}
