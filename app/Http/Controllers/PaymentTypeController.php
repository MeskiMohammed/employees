<?php

namespace App\Http\Controllers;

use App\Models\PaymentType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PaymentTypeController extends Controller
{
    public function index(Request $request)
    {
        $query = PaymentType::withCount('payments');
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('type', 'like', "%{$search}%");
        }
        
        $paymentTypes = $query->paginate(10);
        
        return view('payment-types.index', compact('paymentTypes'));
    }

    public function create()
    {
        return view('payment-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:255|unique:payment_types',
        ]);
        
        PaymentType::create($validated);
        
        return redirect()->route('payment-types.index')
            ->with('success', 'Payment type created successfully.');
    }

    public function show(PaymentType $paymentType)
    {
        $paymentType->load('payments');
        
        return view('payment-types.show', compact('paymentType'));
    }

    public function edit(PaymentType $paymentType)
    {
        return view('payment-types.edit', compact('paymentType'));
    }

    public function update(Request $request, PaymentType $paymentType)
    {
        $validated = $request->validate([
            'type' => ['required', 'string', 'max:255', Rule::unique('payment_types')->ignore($paymentType->id)],
        ]);
        
        $paymentType->update($validated);
        
        return redirect()->route('payment-types.index')
            ->with('success', 'Payment type updated successfully.');
    }

    public function destroy(PaymentType $paymentType)
    {
        if ($paymentType->payments()->count() > 0) {
            return redirect()->route('payment-types.index')
                ->with('error', 'Cannot delete payment type with associated payments.');
        }
        
        $paymentType->delete();
        
        return redirect()->route('payment-types.index')
            ->with('success', 'Payment type deleted successfully.');
    }
}
