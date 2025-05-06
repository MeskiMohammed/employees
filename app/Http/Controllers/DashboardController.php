<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Leave;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEmployees = Employee::count();
        $totalDepartments = Department::count();
        $totalUsers = User::count();
        $totalPayments = Payment::count();

        $recentEmployees = Employee::with('employeeDepartments', 'status')
            ->latest()
            ->take(5)
            ->get();

        $recentLeaves = Leave::with('employee')
            ->latest()
            ->take(5)
            ->get();

        $departmentEmployees = Department::withCount('employeeDepartments')
            ->get()
            ->pluck('employee_departments_count', 'name')
            ->toArray();

        $monthlyPayments = Payment::select(
                DB::raw('MONTH(date) as month'),
                DB::raw('SUM(net) as total')
            )
            ->whereYear('date', date('Y'))
            ->groupBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        $startDate = now()->startOfDay(); // Start of today at 00:00:00
        $endDate = now()->addDays(2)->endOfDay(); // End of the day 2 days from now at 23:59:59

        $employeesToPay = Employee::whereBetween('created_at', [$startDate, $endDate])->get();


        return view('dashboard.index', compact(
            'totalEmployees',
            'totalDepartments',
            'totalUsers',
            'totalPayments',
            'recentEmployees',
            'recentLeaves',
            'departmentEmployees',
            'monthlyPayments',
            'employeesToPay'
        ));
    }
}
