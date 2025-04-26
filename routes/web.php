<?php

use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeePostController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\FreelancerProjectController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentTypeController;
use App\Http\Controllers\PostEmployeeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\UserStatusController;
use App\Models\TypeEmployee;
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

    // Employee routes
    Route::resource('employees', EmployeeController::class);

    // Department routes
    Route::resource('departments', DepartmentController::class);

    // User routes
    Route::resource('users', UserController::class);

    // Payment routes
    Route::resource('payments', PaymentController::class);

    // Leave routes
    Route::resource('leaves', LeaveController::class);

    // Evaluation routes
    Route::resource('evaluations', EvaluationController::class);

    // Freelancer Project routes
    Route::resource('freelancer-projects', FreelancerProjectController::class);

    // Attachment routes
    // Route::resource('attachments', AttachmentController::class);
    Route::get('attachments/{attachment}/download', [AttachmentController::class, 'download'])->name('attachments.download');

    // Post Employee routes
    // Route::resource('post-employees', TypeEmployee::class);
    // Route::get('post-employees/{postEmployee}/download', [PostEmployeeController::class, 'download'])->name('post-employees.download');

    // Employee Post routes
    Route::resource('types', TypeController::class);

    // Settings routes
    Route::resource('payment-types', PaymentTypeController::class);
    Route::resource('operators', OperatorController::class);
    Route::resource('statuses', StatusController::class);
    Route::resource('user-roles', UserRoleController::class);
    Route::resource('user-statuses', UserStatusController::class);


    Route::get('/employee/dashboard', [App\Http\Controllers\EmployeeProfileController::class, 'dashboard'])->name('employee.dashboard');
    Route::get('/employee/profile/edit', [App\Http\Controllers\EmployeeProfileController::class, 'edit'])->name('employee.profile.edit');
    Route::put('/employee/profile/update', [App\Http\Controllers\EmployeeProfileController::class, 'update'])->name('employee.profile.update');
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/settings', [ProfileController::class, 'settings'])->name('profile.settings');
    Route::patch('/profile/settings', [ProfileController::class, 'updateSettings'])->name('profile.settings.update');
});

require __DIR__.'/auth.php';
