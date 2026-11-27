<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortfolioController::class, 'index'])->name('portfolio.index');
Route::get('/projects/{project:slug}', [PortfolioController::class, 'show'])->name('portfolio.show');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::post('/sync-github', [DashboardController::class, 'syncGithub'])->name('sync-github');

Route::middleware('auth')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('projects', ProjectController::class)->except(['show']);
        Route::resource('skills', SkillController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::resource('experiences', ExperienceController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::resource('messages', MessageController::class)->only(['index', 'show', 'destroy']);
        Route::post('/sync-github', [DashboardController::class, 'syncGithub'])->name('sync-github');

    });

Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contact.store');

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
    })->middleware(['auth'])->name('dashboard');



require __DIR__ . '/auth.php';
