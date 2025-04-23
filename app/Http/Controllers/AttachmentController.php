<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Attachment::with('employee.user');
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhereHas('employee', function($q) use ($search) {
                      $q->whereHas('user', function($qu) use ($search) {
                          $qu->where('first_name', 'like', "%{$search}%")
                             ->orWhere('last_name', 'like', "%{$search}%");
                      });
                  });
        }
        
        if ($request->has('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }
        
        $attachments = $query->paginate(10);
        $employees = Employee::with('user')->get();
        
        return view('attachments.index', compact('attachments', 'employees'));
    }

    public function create()
    {
        $employees = Employee::with('user')->get();
        
        return view('attachments.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'attachment' => 'required|file|max:10240',
            'employee_id' => 'required|exists:employees,id',
        ]);
        
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('attachments', 'public');
            $validated['attachment'] = $path;
        }
        
        Attachment::create($validated);
        
        return redirect()->route('attachments.index')
            ->with('success', 'Attachment created successfully.');
    }

    public function show(Attachment $attachment)
    {
        $attachment->load('employee.user');
        
        return view('attachments.show', compact('attachment'));
    }

    public function edit(Attachment $attachment)
    {
        $employees = Employee::with('user')->get();
        
        return view('attachments.edit', compact('attachment', 'employees'));
    }

    public function update(Request $request, Attachment $attachment)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'attachment' => 'nullable|file|max:10240',
            'employee_id' => 'required|exists:employees,id',
        ]);
        
        if ($request->hasFile('attachment')) {
            if ($attachment->attachment) {
                Storage::disk('public')->delete($attachment->attachment);
            }
            $path = $request->file('attachment')->store('attachments', 'public');
            $validated['attachment'] = $path;
        }
        
        $attachment->update($validated);
        
        return redirect()->route('attachments.index')
            ->with('success', 'Attachment updated successfully.');
    }

    public function destroy(Attachment $attachment)
    {
        if ($attachment->attachment) {
            Storage::disk('public')->delete($attachment->attachment);
        }
        
        $attachment->delete();
        
        return redirect()->route('attachments.index')
            ->with('success', 'Attachment deleted successfully.');
    }
    
    public function download(Attachment $attachment)
    {
        return Storage::disk('public')->download($attachment->attachment, $attachment->name);
    }
}
