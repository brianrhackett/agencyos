<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::view('/', 'landing');

Route::view('/dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('/clients', 'clients.index')
	->middleware(['auth'])
	->name('clients.index');

Route::view('/projects', 'projects.index')
	->middleware(['auth'])
	->name('projects.index');

Route::view('/tasks', 'tasks.index')
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
