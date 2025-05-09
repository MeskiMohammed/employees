<?php

namespace App\Http\Controllers;

use App\Models\Reason;
use Illuminate\Http\Request;

class ReasonController extends Controller
{
    public function index(Request $request)
    {
        $query = Reason::query(); 
    
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('reason', 'like', "%{$search}%");
        }
    
        $reasons = $query->orderBy('reason')->paginate(10); 
        return view('reasons.index', compact('reasons'));
    }
    

    public function create()
    {
        return view('reasons.create');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'reason' => 'required|string|max:255|unique:reasons',
        ]);

        Reason::create($request->all());

        return redirect()->route('reasons.index')
            ->with('success', 'Reason created successfully.');
    }

   
    public function show(Reason $reason)
    {
        return view('reasons.show', compact('reason'));
    }

    public function edit(Reason $reason)
    {
        return view('reasons.edit', compact('reason'));
    }

   
    public function update(Request $request, Reason $reason)
    {
        $request->validate([
            'reason' => 'required|string|max:255|unique:reasons,reason,' . $reason->id,
        ]);

        $reason->update($request->all());

        return redirect()->route('reasons.index')
            ->with('success', 'Reason updated successfully.');
    }

    public function destroy(Reason $reason)
    {
        $reason->delete();

        return redirect()->route('reasons.index')
            ->with('success', 'Reason deleted successfully.');
    }
}
