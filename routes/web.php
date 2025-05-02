<?php

use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeProfileController;
use App\Http\Controllers\EnterpriseController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\FreelancerProjectController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentTypeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReasonController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\UserStatusController;
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
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('employees', EmployeeController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('users', UserController::class);
    Route::resource('payments', PaymentController::class);
    Route::resource('leaves', LeaveController::class);
    Route::resource('evaluations', EvaluationController::class);
    Route::resource('freelancer-projects', FreelancerProjectController::class);
    Route::resource('payment-types', PaymentTypeController::class);
    Route::resource('operators', OperatorController::class);
    Route::resource('statuses', StatusController::class);
    Route::resource('user-roles', UserRoleController::class);
    Route::resource('user-statuses', UserStatusController::class);
    Route::resource('reasons', ReasonController::class);
    
    Route::get('attachments/{attachment}/download', [AttachmentController::class, 'download'])->name('attachments.download');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/settings', [ProfileController::class, 'settings'])->name('profile.settings');
    Route::patch('/profile/settings', [ProfileController::class, 'updateSettings'])->name('profile.settings.update');
    
    Route::get('/enterprise', [EnterpriseController::class, 'edit'])->name('enterprise.edit');
    Route::put('/enterprise', [EnterpriseController::class, 'update'])->name('enterprise.update');   
    


    // Route::get('/employee/dashboard', function(){return view('employee.dashboard');});

    Route::get('/employee/dashboard', [EmployeeProfileController::class, 'dashboard'])->name('employee.dashboard');
    Route::get('/employee/profile', [EmployeeProfileController::class, 'profile'])->name('employee.profile');
    Route::get('/employee/leaves', [EmployeeProfileController::class, 'leaves'])->name('employee.leaves');
    Route::get('/employee/attendance', [EmployeeProfileController::class, 'attendance'])->name('employee.attendance');
    Route::get('/employee/documents', [EmployeeProfileController::class, 'documents'])->name('employee.documents');
    Route::get('/employee/payments', [EmployeeProfileController::class, 'payments'])->name('employee.payments');
    Route::get('/employee/performance', [EmployeeProfileController::class, 'performance'])->name('employee.performance');
    Route::get('/employee/settings', [EmployeeProfileController::class, 'settings'])->name('employee.settings');
    Route::get('/employee/profile/edit', [EmployeeProfileController::class, 'edit'])->name('employee.profile.edit');
    Route::put('/employee/profile/update', [EmployeeProfileController::class, 'update'])->name('employee.profile.update');
});

require __DIR__.'/auth.php';
