<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class EmployeeProfileController extends Controller
{
    public function dashboard()
    {
        $authUser = Auth::user();
        $employee = Employee::with(['department', 'posts', 'operator'])
            ->where('user_id', $authUser->id)
            ->firstOrFail();
            
        return view('employee.dashboard', compact('employee'));
    }
    
    public function edit()
    {
        $authUser = Auth::user();
        $employee = Employee::where('users_id', $authUser->id)->firstOrFail();
        
        return view('employee.profile.edit', compact('employee'));
    }
    
    public function update(Request $request)
    {
        $authUser = Auth::user();
        $user = \App\Models\User::find($authUser->id);
        $employee = Employee::where('users_id', $user->id)->firstOrFail();
        
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'personal_num' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
            'professional_email' => [
                'nullable',
                'email',
                Rule::requiredIf(function () use ($employee) {
                    return !$employee->is_freelancer;
                }),
            ],
            'professional_num' => [
                'nullable',
                'string',
                'max:255',
                Rule::requiredIf(function () use ($employee) {
                    return !$employee->is_freelancer;
                }),
            ],
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
        
        $user->save();
        
        // Update employee information
        $employee->first_name = $validated['first_name'];
        $employee->last_name = $validated['last_name'];
        $employee->email = $validated['email'];
        $employee->personal_num = $validated['personal_num'] ?? $employee->personal_num;
        $employee->address = $validated['address'] ?? $employee->address;
        
        if (!$employee->is_freelancer) {
            $employee->professional_email = $validated['professional_email'] ?? $employee->professional_email;
            $employee->professional_num = $validated['professional_num'] ?? $employee->professional_num;
        }
        
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
        
        return redirect()->route('employee.profile.edit')->with('success', 'Profile updated successfully.');
    }
}
