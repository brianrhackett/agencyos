<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\MilestoneController;
use App\Http\Controllers\CommentController;

Route::view('/', 'landing');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::resource('clients', ClientController::class)
	->middleware('auth');

Route::resource('projects', ProjectController::class)
	->middleware('auth');

Route::get('/projects/{project}/milestones/create', [MilestoneController::class, 'create'])
	->name('projects.milestones.create');

Route::post('/projects/{project}/milestones', [MilestoneController::class, 'store'])
	->name('projects.milestones.store');

Route::resource('milestones', MilestoneController::class)
	->only(['show', 'edit', 'update', 'destroy'])
	->middleware('auth');

Route::get('/projects/{project}/tasks/create', [TaskController::class, 'createForProject'])
	->middleware('auth')
	->name('projects.tasks.create');

Route::post('/projects/{project}/tasks', [TaskController::class, 'storeForProject'])
	->middleware('auth')
	->name('projects.tasks.store');

Route::get('/milestones/{milestone}/tasks/create', [TaskController::class, 'createForMilestone'])
	->middleware('auth')
	->name('milestones.tasks.create');

Route::post('/milestones/{milestone}/tasks', [TaskController::class, 'storeForMilestone'])
	->middleware('auth')
	->name('milestones.tasks.store');

Route::resource('tasks', TaskController::class)
	->middleware('auth');

Route::post('/tasks/{task}/comments', [CommentController::class, 'store'])
	->name('tasks.comments.store');

Route::post('/tasks/{task}/files', [FileController::class, 'store'])
	->name('tasks.files.store');

Route::get('/calendar', [CalendarController::class, 'index'])
	->middleware(['auth'])
	->name('calendar.index');

Route::resource('team', TeamController::class)
	->parameters(['team' => 'user']);

    
Route::get('/files', [FileController::class, 'index'])
	->middleware(['auth'])
	->name('files.index');

Route::get('/files/{file}/download', [FileController::class, 'download'])
	->name('files.download');

Route::delete('/files/{file}', [FileController::class, 'destroy'])
	->name('files.destroy');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
