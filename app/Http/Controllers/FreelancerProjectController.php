<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\FreelancerProject;
use App\Models\Payment;
use App\Models\PaymentType;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FreelancerProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = FreelancerProject::with('employee.user');

        // Name or employee's user search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhereHas('employee.user', function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%");
                });
        }

        // Employee filter
        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        // Price range filters
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        $projects = $query->paginate(10);
        $employees = Employee::with('user')->get();
        $paymentTypes = PaymentType::all();

        return view('freelancer-projects.index', compact('projects', 'employees', 'paymentTypes'));


    }


    public function create()
    {
        $employees = Type::where('type', 'freelancer')->with('typeEmployees.employee')->first()->typeEmployees->pluck('employee')->where('is_project', true);

        return view('freelancer-projects.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'employee_id' => 'required|exists:employees,id',
        ]);

        FreelancerProject::create([
            'name' => $request->name,
            'status' => false,
            'price' => $request->price,
            'employee_id' => $request->employee_id,
        ]);

        return redirect()->route('freelancer-projects.index')
            ->with('success', 'Freelancer project created successfully.');
    }

    public function show(FreelancerProject $freelancerProject)
    {
        $freelancerProject->load('employee.user');

        return view('freelancer-projects.show', compact('freelancerProject'));
    }

    public function edit(FreelancerProject $freelancerProject)
    {
        $employees = Employee::with('user')->get();

        return view('freelancer-projects.edit', compact('freelancerProject', 'employees'));
    }

    public function update(Request $request, FreelancerProject $freelancerProject)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'employee_id' => 'required|exists:employees,id',
        ]);

        $freelancerProject->update($validated);

        return redirect()->route('freelancer-projects.index')
            ->with('success', 'Freelancer project updated successfully.');
    }



    public function destroy(FreelancerProject $freelancerProject)
    {
        $freelancerProject->delete();

        return redirect()->route('freelancer-projects.index')
            ->with('success', 'Freelancer project deleted successfully.');
    }

    public function done(Request $request, FreelancerProject $freelancerProject)
    {
        DB::beginTransaction();
        try {
            $freelancerProject->status = true;
            $freelancerProject->save();

            Payment::create([
                'employee_id' => $freelancerProject->employee->id,
                'payment_type_id' => $request->payment_type_id,
                'gross' => $freelancerProject->price,
                'net' => $freelancerProject->price,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'An error occurred while updating the project.');
        }

        return redirect()->route('freelancer-projects.index')->with('success', 'Project marked as done and payment recorded.');
    }
}
