<?php

namespace App\Http\Controllers;

use App\Models\Reason;
use Illuminate\Http\Request;

class ReasonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reasons = Reason::orderBy('reason')->paginate(10);
        return view('reasons.index', compact('reasons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('reasons.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'reason' => 'required|string|max:255|unique:reasons',
        ]);

        Reason::create($request->all());

        return redirect()->route('reasons.index')
            ->with('success', 'Reason created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reason $reason)
    {
        return view('reasons.show', compact('reason'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reason $reason)
    {
        return view('reasons.edit', compact('reason'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reason $reason)
    {
        $request->validate([
            'reason' => 'required|string|max:255|unique:reasons,reason,' . $reason->id,
        ]);

        $reason->update($request->all());

        return redirect()->route('reasons.index')
            ->with('success', 'Reason updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reason $reason)
    {
        $reason->delete();

        return redirect()->route('reasons.index')
            ->with('success', 'Reason deleted successfully.');
    }
}
