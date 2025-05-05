<?php

use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeProfileController;
use App\Http\Controllers\EnterpriseController;
use App\Http\Controllers\FreelancerProjectController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentTypeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReasonController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if(Auth::user()){
        if(Auth::user()->hasRole('super_admin')){
            return redirect()->route('dashboard');
        }else{
            return redirect()->route('employee.dashboard');
        }
    }else{
        return redirect()->route('login');
    }
});

Route::middleware(['auth','role:super_admin|admin'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('employees',[EmployeeController::class,'index'])->name('employees.index')->middleware('permission:view employees');
    Route::post('employees',[EmployeeController::class,'store'])->name('employees.store')->middleware('permission:create employees');
    Route::get('employees/create',[EmployeeController::class,'create'])->name('employees.create')->middleware('permission:create employees');
    Route::get('employees/{employee}',[EmployeeController::class,'show'])->name('employees.show')->middleware('permission:view employees');
    Route::get('employees/{employee}/edit',[EmployeeController::class,'edit'])->name('employees.edit')->middleware('permission:edit employees');
    Route::put('employees/{employee}',[EmployeeController::class,'update'])->name('employees.update')->middleware('permission:edit employees');
    Route::put('employees/{employee}/toggle-admin',[EmployeeController::class,'toggleAdmin'])->name('employees.toggleAdmin')->middleware('role:super_admin');
    Route::put('employees/{employee}/assign-permissions',[EmployeeController::class,'assignPermissions'])->name('employees.assignPermissions')->middleware('role:super_admin');


    Route::resource('departments', DepartmentController::class);
    Route::resource('users', UserController::class);
    Route::resource('payments', PaymentController::class);
    Route::resource('freelancer-projects', FreelancerProjectController::class);
    Route::resource('payment-types', PaymentTypeController::class);
    Route::resource('operators', OperatorController::class);
    Route::resource('statuses', StatusController::class);
    Route::resource('reasons', ReasonController::class);
    Route::resource('types', TypeController::class);

    Route::get('leaves', [LeaveController::class,'index'])->name('leaves.index');
    Route::get('leaves/{leave}', [LeaveController::class,'update'])->name('leaves.update');

    Route::get('attachments/{attachment}/download', [AttachmentController::class, 'download'])->name('attachments.download');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('role:super_admin');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update')->middleware('role:super_admin');
    Route::get('/profile/settings', [ProfileController::class, 'settings'])->name('profile.settings');
    Route::patch('/profile/settings', [ProfileController::class, 'updateSettings'])->name('profile.settings.update');

    Route::get('/enterprise', [EnterpriseController::class, 'edit'])->name('enterprise.edit')->middleware('role:super_admin');
    Route::put('/enterprise', [EnterpriseController::class, 'update'])->name('enterprise.update')->middleware('role:super_admin');

});


Route::middleware(['auth','role:employee'])->group(function () {
    Route::get('/employee/dashboard', [EmployeeProfileController::class, 'dashboard'])->name('employee.dashboard');
    Route::get('/employee/attachments', [EmployeeProfileController::class, 'attachments'])->name('employee.attachments');
    Route::get('/employee/leaves', [EmployeeProfileController::class, 'leaves'])->name('employee.leaves');
    Route::get('/employee/payments', [EmployeeProfileController::class, 'payments'])->name('employee.payments');
    Route::post('/employee/leaves/store', [LeaveController::class,'store'])->name('employee.leaves.store');
});
require __DIR__.'/auth.php';
