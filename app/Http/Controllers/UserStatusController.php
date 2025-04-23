<?php

namespace App\Http\Controllers;

use App\Models\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserStatusController extends Controller
{
    public function index(Request $request)
    {
        $query = UserStatus::withCount('users');
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('status', 'like', "%{$search}%");
        }
        
        $userStatuses = $query->paginate(10);
        
        return view('user-statuses.index', compact('userStatuses'));
    }

    public function create()
    {
        return view('user-statuses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|string|max:255|unique:users_status',
        ]);
        
        UserStatus::create($validated);
        
        return redirect()->route('user-statuses.index')
            ->with('success', 'User status created successfully.');
    }

    public function show(UserStatus $userStatus)
    {
        $userStatus->load('users');
        
        return view('user-statuses.show', compact('userStatus'));
    }

    public function edit(UserStatus $userStatus)
    {
        return view('user-statuses.edit', compact('userStatus'));
    }

    public function update(Request $request, UserStatus $userStatus)
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'max:255', Rule::unique('users_status')->ignore($userStatus->id)],
        ]);
        
        $userStatus->update($validated);
        
        return redirect()->route('user-statuses.index')
            ->with('success', 'User status updated successfully.');
    }

    public function destroy(UserStatus $userStatus)
    {
        if ($userStatus->users()->count() > 0) {
            return redirect()->route('user-statuses.index')
                ->with('error', 'Cannot delete user status with associated users.');
        }
        
        $userStatus->delete();
        
        return redirect()->route('user-statuses.index')
            ->with('success', 'User status deleted successfully.');
    }
}
