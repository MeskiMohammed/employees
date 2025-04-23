<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StatusController extends Controller
{
    public function index(Request $request)
    {
        $query = Status::withCount('employees');
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('status', 'like', "%{$search}%");
        }
        
        $statuses = $query->paginate(10);
        
        return view('statuses.index', compact('statuses'));
    }

    public function create()
    {
        return view('statuses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|string|max:255|unique:statuses',
        ]);
        
        Status::create($validated);
        
        return redirect()->route('statuses.index')
            ->with('success', 'Status created successfully.');
    }

    public function show(Status $status)
    {
        $status->load('employees');
        
        return view('statuses.show', compact('status'));
    }

    public function edit(Status $status)
    {
        return view('statuses.edit', compact('status'));
    }

    public function update(Request $request, Status $status)
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'max:255', Rule::unique('statuses')->ignore($status->id)],
        ]);
        
        $status->update($validated);
        
        return redirect()->route('statuses.index')
            ->with('success', 'Status updated successfully.');
    }

    public function destroy(Status $status)
    {
        if ($status->employees()->count() > 0) {
            return redirect()->route('statuses.index')
                ->with('error', 'Cannot delete status with associated employees.');
        }
        
        $status->delete();
        
        return redirect()->route('statuses.index')
            ->with('success', 'Status deleted successfully.');
    }
}
