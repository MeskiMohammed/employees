<?php

namespace App\Http\Controllers;

use App\Models\Enterprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EnterpriseController extends Controller
{
    /**
     * Show the form for editing the enterprise.
     */
    public function edit()
    {
        $enterprise = Enterprise::first() ?? new Enterprise();
        return view('enterprise.edit', compact('enterprise'));
    }

    /**
     * Update the enterprise in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $enterprise = Enterprise::first() ?? new Enterprise();
        $enterprise->name = $request->name;

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($enterprise->logo && Storage::exists('public/' . $enterprise->logo)) {
                Storage::delete('public/' . $enterprise->logo);
            }
            
            // Store new logo
            $path = $request->file('logo')->store('enterprise', 'public');
            $enterprise->logo = $path;
        }

        $enterprise->save();

        return redirect()->route('enterprise.edit')
            ->with('success', 'Enterprise information updated successfully.');
    }
}
