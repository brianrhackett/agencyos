<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\TasksController;

Route::view('/', 'landing');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/clients', [ClientsController::class, 'index'])
	->middleware(['auth'])
	->name('clients.index');

Route::get('/projects', [ProjectsController::class, 'index'])
	->middleware(['auth'])
	->name('projects.index');

Route::get('/tasks', [TasksController::class, 'index'])
	->middleware(['auth'])
	->name('tasks.index');

Route::view('/calendar', 'calendar.index')
	->middleware(['auth'])
	->name('calendar.index');

Route::view('/team', 'team.index')
	->middleware(['auth'])
	->name('team.index');

    
Route::view('/files', 'files.index')
	->middleware(['auth'])
	->name('files.index');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
