<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TypeController extends Controller
{
    public function index(Request $request)
    {
        $query = Type::withCount('TypeEmployees');
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('type', 'like', "%{$search}%");
        }
        
        $types = $query->paginate(10);
        return view('types.index', compact('types'));
    }

    public function create()
    {
        return view('types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:255|unique:types',
        ]);
        
        Type::create($validated);
        
        return redirect()->route('types.index')
            ->with('success', 'Type created successfully.');
    }

    public function show(Type $type)
    {
        $type->load('typeEmployees.employee.user');
        
        return view('types.show', compact('type'));
    }

    public function edit(Type $type)
    {
        return view('types.edit', compact('type'));
    }

    public function update(Request $request, Type $type)
    {
        $validated = $request->validate([
            'type' => ['required', 'string', 'max:255', Rule::unique('types')->ignore($type->id)],
        ]);
        
        $type->update($validated);
        
        return redirect()->route('types.index')
            ->with('success', 'Type updated successfully.');
    }

    public function destroy(Type $type)
    {
        if ($type->typeEmployees()->count() > 0) {
            return redirect()->route('types.index')
                ->with('error', 'Cannot delete Type with associated records.');
        }
        
        $type->delete();
        
        return redirect()->route('types.index')
            ->with('success', 'Type deleted successfully.');
    }
}
