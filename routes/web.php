<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommentLikeController;
use App\Http\Controllers\EmployeeRequestController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\landingpageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('payrolls', PayrollController::class);

Route::resource('home', landingpageController::class);

Route::get('/home', function () {
    return view('home');
})->middleware(['auth'])->name('home');

Route::get('/dashboard', function () {
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:user|admin'])->group(function () {
    Route::resource('employee-requests', EmployeeRequestController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::resource('payrolls', PayrollController::class)->only(['index', 'show']);
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('payrolls', PayrollController::class)->except(['index', 'show']);
});

Route::get('/employee-requests/{employee_request}/update-status', [EmployeeRequestController::class, 'editStatus'])
    ->name('employee-requests.editStatus')
    ->middleware('role:admin');
Route::put('/employee-requests/{employee_request}/update-status', [EmployeeRequestController::class, 'updateStatus'])
    ->name('employee-requests.updateStatus')
    ->middleware('role:admin');
Route::get('employee-requests.export', [EmployeeRequestController::class, 'export'])->name('employee-requests.export');
Route::get('payrolls.export', [PayrollController::class, 'export'])->name('payrolls.export');
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::post('/comments/{comment}/like', [CommentLikeController::class, 'like'])->name('comments.like');
Route::post('/comments/{comment}/dislike', [CommentLikeController::class, 'dislike'])->name('comments.dislike');
Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

require __DIR__ . '/auth.php';
