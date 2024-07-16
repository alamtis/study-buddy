<?php

use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', [EvaluationController::class, 'index'])->name('home');
    Route::post('/evaluation/start', [EvaluationController::class, 'start'])->name('evaluation.start');
    Route::post('/evaluation/answer', [EvaluationController::class, 'answer'])->name('evaluation.answer');
//    Route::get('/report', [ReportController::class, 'show'])->name('report.show');
    Route::get('/report/{evaluation}', [ReportController::class, 'show'])->name('report.show');
});

Route::middleware('auth')->group(function () {
    Route::get('/user-management', [UserManagementController::class, 'index'])->name('user.management');
    Route::get('/users', [UserManagementController::class, 'getUsers'])->name('users.index');
    Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
    Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/{user}/reports', [UserManagementController::class, 'getUserReports'])->name('users.reports');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
require __DIR__.'/auth.php';
