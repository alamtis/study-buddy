<?php

use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return Inertia::render('Welcome', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
//});
//
//Route::get('/dashboard', function () {
//    return Inertia::render('Dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');
//
//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});

Route::middleware('auth')->group(function () {
    Route::get('/', [EvaluationController::class, 'index'])->name('home');
    Route::post('/evaluation/start', [EvaluationController::class, 'start'])->name('evaluation.start');
    Route::post('/evaluation/answer', [EvaluationController::class, 'answer'])->name('evaluation.answer');
//    Route::get('/report', [ReportController::class, 'show'])->name('report.show');
    Route::get('/report/{evaluation}', [ReportController::class, 'show'])->name('report.show');
});
require __DIR__.'/auth.php';
