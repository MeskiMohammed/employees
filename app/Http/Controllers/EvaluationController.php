<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Evaluation;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function index(Request $request)
    {
        $query = Evaluation::with('employee.user');
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('employee', function($q) use ($search) {
                $q->whereHas('user', function($qu) use ($search) {
                    $qu->where('first_name', 'like', "%{$search}%")
                       ->orWhere('last_name', 'like', "%{$search}%");
                });
            });
        }
        
        if ($request->has('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }
        
        if ($request->has('score_min')) {
            $query->where('score', '>=', $request->score_min);
        }
        
        if ($request->has('score_max')) {
            $query->where('score', '<=', $request->score_max);
        }
        
        if ($request->has('date_from')) {
            $query->whereDate('date', '>=', $request->date_from);
        }
        
        if ($request->has('date_to')) {
            $query->whereDate('date', '<=', $request->date_to);
        }
        
        $evaluations = $query->paginate(10);
        $employees = Employee::with('user')->get();
        
        return view('evaluations.index', compact('evaluations', 'employees'));
    }

    public function create()
    {
        $employees = Employee::with('user')->get();
        
        return view('evaluations.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'score' => 'required|integer|min:0|max:100',
            'notes' => 'nullable|string',
            'employee_id' => 'required|exists:employees,id',
        ]);
        
        Evaluation::create($validated);
        
        return redirect()->route('evaluations.index')
            ->with('success', 'Evaluation created successfully.');
    }

    public function show(Evaluation $evaluation)
    {
        $evaluation->load('employee.user');
        
        return view('evaluations.show', compact('evaluation'));
    }

    public function edit(Evaluation $evaluation)
    {
        $employees = Employee::with('user')->get();
        
        return view('evaluations.edit', compact('evaluation', 'employees'));
    }

    public function update(Request $request, Evaluation $evaluation)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'score' => 'required|integer|min:0|max:100',
            'notes' => 'nullable|string',
            'employee_id' => 'required|exists:employees,id',
        ]);
        
        $evaluation->update($validated);
        
        return redirect()->route('evaluations.index')
            ->with('success', 'Evaluation updated successfully.');
    }

    public function destroy(Evaluation $evaluation)
    {
        $evaluation->delete();
        
        return redirect()->route('evaluations.index')
            ->with('success', 'Evaluation deleted successfully.');
    }
}
