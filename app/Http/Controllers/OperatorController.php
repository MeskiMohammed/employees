<?php

namespace App\Http\Controllers;

use App\Models\Operator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OperatorController extends Controller
{
    public function index(Request $request)
    {
        $query = Operator::withCount('employees');
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('operator', 'like', "%{$search}%");
        }
        
        $operators = $query->paginate(10);
        
        return view('operators.index', compact('operators'));
    }

    public function create()
    {
        return view('operators.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'operator' => 'required|string|max:255|unique:operators',
        ]);
        
        Operator::create($validated);
        
        return redirect()->route('operators.index')
            ->with('success', 'Operator created successfully.');
    }

    public function show(Operator $operator)
    {
        $operator->load('employees');
        
        return view('operators.show', compact('operator'));
    }

    public function edit(Operator $operator)
    {
        return view('operators.edit', compact('operator'));
    }

    public function update(Request $request, Operator $operator)
    {
        $validated = $request->validate([
            'operator' => ['required', 'string', 'max:255', Rule::unique('operators')->ignore($operator->id)],
        ]);
        
        $operator->update($validated);
        
        return redirect()->route('operators.index')
            ->with('success', 'Operator updated successfully.');
    }

    public function destroy(Operator $operator)
    {
        if ($operator->employees()->count() > 0) {
            return redirect()->route('operators.index')
                ->with('error', 'Cannot delete operator with associated employees.');
        }
        
        $operator->delete();
        
        return redirect()->route('operators.index')
            ->with('success', 'Operator deleted successfully.');
    }
}
