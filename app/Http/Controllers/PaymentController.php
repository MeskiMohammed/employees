<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payment;
use App\Models\PaymentType;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['employee', 'paymentType']);
        
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
        
        if ($request->has('payment_type')) {
            $query->where('payment_types_id', $request->payment_type);
        }
        
        if ($request->has('date_from')) {
            $query->whereDate('date', '>=', $request->date_from);
        }
        
        if ($request->has('date_to')) {
            $query->whereDate('date', '<=', $request->date_to);
        }
        
        $payments = $query->paginate(10);
        $employees = Employee::with('user')->get();
        $paymentTypes = PaymentType::all();
        
        return view('payments.index', compact('payments', 'employees', 'paymentTypes'));
    }

    public function create()
    {
        $employees = Employee::with('user')->get();
        $paymentTypes = PaymentType::all();
        
        return view('payments.create', compact('employees', 'paymentTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'payment_types_id' => 'required|exists:payment_types,id',
            'salary' => 'required|numeric',
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'tax' => 'required|numeric',
            'net' => 'required|numeric',
        ]);
        
        Payment::create($validated);
        
        return redirect()->route('payments.index')
            ->with('success', 'Payment created successfully.');
    }

    public function show(Payment $payment)
    {
        $payment->load(['employee', 'paymentType']);
        
        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $employees = Employee::with('user')->get();
        $paymentTypes = PaymentType::all();
        
        return view('payments.edit', compact('payment', 'employees', 'paymentTypes'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'payment_types_id' => 'required|exists:payment_types,id',
            'salary' => 'required|numeric',
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'tax' => 'required|numeric',
            'net' => 'required|numeric',
        ]);
        
        $payment->update($validated);
        
        return redirect()->route('payments.index')
            ->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        
        return redirect()->route('payments.index')
            ->with('success', 'Payment deleted successfully.');
    }
}
