<?php

namespace App\Http\Controllers;

use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserRoleController extends Controller
{
    public function index(Request $request)
    {
        $query = UserRole::withCount('users');
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('role', 'like', "%{$search}%");
        }
        
        $userRoles = $query->paginate(10);
        
        return view('user-roles.index', compact('userRoles'));
    }

    public function create()
    {
        return view('user-roles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'role' => 'required|string|max:255|unique:user_roles',
        ]);
        
        UserRole::create($validated);
        
        return redirect()->route('user-roles.index')
            ->with('success', 'User role created successfully.');
    }

    public function show(UserRole $userRole)
    {
        $userRole->load('users');
        
        return view('user-roles.show', compact('userRole'));
    }

    public function edit(UserRole $userRole)
    {
        return view('user-roles.edit', compact('userRole'));
    }

    public function update(Request $request, UserRole $userRole)
    {
        $validated = $request->validate([
            'role' => ['required', 'string', 'max:255', Rule::unique('user_roles')->ignore($userRole->id)],
        ]);
        
        $userRole->update($validated);
        
        return redirect()->route('user-roles.index')
            ->with('success', 'User role updated successfully.');
    }

    public function destroy(UserRole $userRole)
    {
        if ($userRole->users()->count() > 0) {
            return redirect()->route('user-roles.index')
                ->with('error', 'Cannot delete user role with associated users.');
        }
        
        $userRole->delete();
        
        return redirect()->route('user-roles.index')
            ->with('success', 'User role deleted successfully.');
    }
}
