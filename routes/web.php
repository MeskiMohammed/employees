<?php

use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeProfileController;
use App\Http\Controllers\EnterpriseController;
use App\Http\Controllers\EventController;
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
    Route::get('employees/create',[EmployeeController::class,'create'])->name('employees.create')->middleware('permission:create employees');
    Route::post('employees',[EmployeeController::class,'store'])->name('employees.store')->middleware('permission:create employees');
    Route::get('employees/{employee}',[EmployeeController::class,'show'])->name('employees.show')->middleware('permission:view employees');
    Route::get('employees/{employee}/edit',[EmployeeController::class,'edit'])->name('employees.edit')->middleware('permission:edit employees');
    Route::put('employees/{employee}',[EmployeeController::class,'update'])->name('employees.update')->middleware('permission:edit employees');
    Route::put('employees/{employee}/toggle-admin',[EmployeeController::class,'toggleAdmin'])->name('employees.toggleAdmin')->middleware('role:super_admin');
    Route::put('employees/{employee}/assign-permissions',[EmployeeController::class,'assignPermissions'])->name('employees.assignPermissions')->middleware('role:super_admin');
    Route::get('employees/{employee}/pay', [EmployeeController::class, 'payment'])->name('employees.payment');
    Route::post('employees/{employee}/pay', [EmployeeController::class, 'pay'])->name('employees.pay');
    Route::put('employees/{employee}/end-post', [EmployeeController::class, 'endPost'])->name('employees.end-post');
    Route::get('employees/{employee}/badge', [EmployeeController::class, 'badge'])->name('employees.badge');

    Route::get('departments',[DepartmentController::class,'index'])->name('departments.index')->middleware('permission:view departments');
    Route::get('departments/create',[DepartmentController::class,'create'])->name('departments.create')->middleware('permission:create departments');
    Route::post('departments',[DepartmentController::class,'store'])->name('departments.store')->middleware('permission:create departments');
    Route::get('departments/{department}/edit',[DepartmentController::class,'edit'])->name('departments.edit')->middleware('permission:edit departments');
    Route::put('departments/{department}',[DepartmentController::class,'update'])->name('departments.update')->middleware('permission:edit departments');
    Route::delete('departments/{department}',[DepartmentController::class,'destroy'])->name('departments.destroy')->middleware('permission:delete departments');

    Route::get('leaves', [LeaveController::class,'index'])->name('leaves.index')->middleware('permission:view leaves');
    Route::get('leaves/{leave}', [LeaveController::class,'update'])->name('leaves.update')->middleware('permission:edit leaves');

    Route::get('freelancer-projects',[FreelancerProjectController::class,'index'])->name('freelancer-projects.index')->middleware('permission:view freelancer_projects');
    Route::get('freelancer-projects/create',[FreelancerProjectController::class,'create'])->name('freelancer-projects.create')->middleware('permission:create freelancer_projects');
    Route::post('freelancer-projects',[FreelancerProjectController::class,'store'])->name('freelancer-projects.store')->middleware('permission:create freelancer_projects');
    Route::get('freelancer-projects/{freelancer_project}/edit',[FreelancerProjectController::class,'edit'])->name('freelancer-projects.edit')->middleware('permission:edit freelancer_projects');
    Route::put('freelancer-projects/{freelancer_project}',[FreelancerProjectController::class,'update'])->name('freelancer-projects.update')->middleware('permission:edit freelancer_projects');
    Route::delete('freelancer-projects/{freelancer_project}',[FreelancerProjectController::class,'destroy'])->name('freelancer-projects.destroy')->middleware('permission:delete freelancer_projects');
    Route::put('/freelancer-projects/{freelancer_project}', [FreelancerProjectController::class, 'done'])->name('freelancer-projects.done');


    Route::get('types',[TypeController::class,'index'])->name('types.index')->middleware('permission:view types');
    Route::get('types/create',[TypeController::class,'create'])->name('types.create')->middleware('permission:create types');
    Route::post('types',[TypeController::class,'store'])->name('types.store')->middleware('permission:create types');
    Route::get('types/{type}/edit',[TypeController::class,'edit'])->name('types.edit')->middleware('permission:edit types');
    Route::put('types/{type}',[TypeController::class,'update'])->name('types.update')->middleware('permission:edit types');
    Route::delete('types/{type}',[TypeController::class,'destroy'])->name('types.destroy')->middleware('permission:delete types');
    
    Route::get('payment-types',[PaymentTypeController::class,'index'])->name('payment-types.index')->middleware('permission:view payment_types');
    Route::get('payment-types/create',[PaymentTypeController::class,'create'])->name('payment-types.create')->middleware('permission:create payment_types');
    Route::post('payment-types',[PaymentTypeController::class,'store'])->name('payment-types.store')->middleware('permission:create payment_types');
    Route::get('payment-types/{payment_type}/edit',[PaymentTypeController::class,'edit'])->name('payment-types.edit')->middleware('permission:edit payment_types');
    Route::put('payment-types/{payment_type}',[PaymentTypeController::class,'update'])->name('payment-types.update')->middleware('permission:edit payment_types');
    Route::delete('payment-types/{payment_type}',[PaymentTypeController::class,'destroy'])->name('payment-types.destroy')->middleware('permission:delete payment_types');

    Route::get('operators',[OperatorController::class,'index'])->name('operators.index')->middleware('permission:view operators');
    Route::get('operators/create',[OperatorController::class,'create'])->name('operators.create')->middleware('permission:create operators');
    Route::post('operators',[OperatorController::class,'store'])->name('operators.store')->middleware('permission:create operators');
    Route::get('operators/{operator}/edit',[OperatorController::class,'edit'])->name('operators.edit')->middleware('permission:edit operators');
    Route::put('operators/{operator}',[OperatorController::class,'update'])->name('operators.update')->middleware('permission:edit operators');
    Route::delete('operators/{operator}',[OperatorController::class,'destroy'])->name('operators.destroy')->middleware('permission:delete operators');

    Route::get('statuses',[StatusController::class,'index'])->name('statuses.index')->middleware('permission:view statuses');
    Route::get('statuses/create',[StatusController::class,'create'])->name('statuses.create')->middleware('permission:create statuses');
    Route::post('statuses',[StatusController::class,'store'])->name('statuses.store')->middleware('permission:create statuses');
    Route::get('statuses/{status}/edit',[StatusController::class,'edit'])->name('statuses.edit')->middleware('permission:edit statuses');
    Route::put('statuses/{status}',[StatusController::class,'update'])->name('statuses.update')->middleware('permission:edit statuses');
    Route::delete('statuses/{status}',[StatusController::class,'destroy'])->name('statuses.destroy')->middleware('permission:delete statuses');

    Route::get('payments',[PaymentController::class,'index'])->name('payments.index')->middleware('permission:view payments');
    Route::get('payments/create',[PaymentController::class,'create'])->name('payments.create')->middleware('permission:create payments');
    Route::post('payments',[PaymentController::class,'store'])->name('payments.store')->middleware('permission:create payments');
    Route::get('payments/{payment}/edit',[PaymentController::class,'edit'])->name('payments.edit')->middleware('permission:edit payments');
    Route::put('payments/{payment}',[PaymentController::class,'update'])->name('payments.update')->middleware('permission:edit payments');
    Route::delete('payments/{payment}',[PaymentController::class,'destroy'])->name('payments.destroy')->middleware('permission:delete payments');
    
    Route::get('reasons',[ReasonController::class,'index'])->name('reasons.index')->middleware('permission:view reasons');
    Route::get('reasons/create',[ReasonController::class,'create'])->name('reasons.create')->middleware('permission:create reasons');
    Route::post('reasons',[ReasonController::class,'store'])->name('reasons.store')->middleware('permission:create reasons');
    Route::get('reasons/{reason}/edit',[ReasonController::class,'edit'])->name('reasons.edit')->middleware('permission:edit reasons');
    Route::put('reasons/{reason}',[ReasonController::class,'update'])->name('reasons.update')->middleware('permission:edit reasons');
    Route::delete('reasons/{reason}',[ReasonController::class,'destroy'])->name('reasons.destroy')->middleware('permission:delete reasons');
    
    Route::get('attachments/{attachment}/download', [AttachmentController::class, 'download'])->name('attachments.download');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('role:super_admin');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update')->middleware('role:super_admin');
  
    Route::get('/enterprise', [EnterpriseController::class, 'edit'])->name('enterprise.edit')->middleware('role:super_admin');
    Route::put('/enterprise', [EnterpriseController::class, 'update'])->name('enterprise.update')->middleware('role:super_admin');
    
    Route::get('/events', [EventController::class, 'index'])->name('events.index')->middleware('role:super_admin');
});


Route::middleware(['auth','role:employee'])->group(function () {
    Route::get('/employee/dashboard', [EmployeeProfileController::class, 'dashboard'])->name('employee.dashboard');
    Route::get('/employee/attachments', [EmployeeProfileController::class, 'attachments'])->name('employee.attachments');
    Route::get('/employee/leaves', [EmployeeProfileController::class, 'leaves'])->name('employee.leaves');
    Route::get('/employee/payments', [EmployeeProfileController::class, 'payments'])->name('employee.payments');
    Route::get('/employee/projects', [EmployeeProfileController::class, 'projects'])->name('employee.projects');
    Route::post('/employee/leaves/store', [LeaveController::class,'store'])->name('employee.leaves.store');
});
require __DIR__.'/auth.php';
