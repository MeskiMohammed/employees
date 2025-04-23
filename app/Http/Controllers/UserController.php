<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRole;
use App\Models\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['role', 'status']);
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        if ($request->has('role')) {
            $query->where('user_role_id', $request->role);
        }
        
        if ($request->has('status')) {
            $query->where('user_status_id', $request->status);
        }
        
        $users = $query->paginate(10);
        $roles = UserRole::all();
        $statuses = UserStatus::all();
        
        return view('users.index', compact('users', 'roles', 'statuses'));
    }

    public function create()
    {
        $roles = UserRole::all();
        $statuses = UserStatus::all();
        
        return view('users.create', compact('roles', 'statuses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', Password::defaults()],
            'user_role_id' => 'required|exists:user_roles,id',
            'user_status_id' => 'required|exists:user_statuses,id',
        ]);
        
        $validated['password'] = Hash::make($validated['password']);
        
        User::create($validated);
        
        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        $user->load(['role', 'status', 'employee']);
        
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = UserRole::all();
        $statuses = UserStatus::all();
        
        return view('users.edit', compact('user', 'roles', 'statuses'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', Password::defaults()],
            'user_role_id' => 'required|exists:user_roles,id',
            'user_status_id' => 'required|exists:user_statuses,id',
        ]);
        
        if (isset($validated['password']) && $validated['password']) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
        
        $user->update($validated);
        
        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->employee) {
            return redirect()->route('users.index')
                ->with('error', 'Cannot delete user with associated employee.');
        }
        
        $user->delete();
        
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }
}
