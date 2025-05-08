<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::with('user')
            ->when($request->filled('action'), function($query) use ($request) {
                return $query->where('action', $request->action);
            })
            ->when($request->filled('date'), function($query) use ($request) {
                return $query->whereDate('created_at', $request->date);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();
    
        return view('events.index', compact('events'));
    }
}
