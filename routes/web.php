<?php

use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Guest\HomeController as GuestHomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\Guest\ProjectController as GuestProjectController;
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

// Rotta home guest
Route::get('/', GuestHomeController::class)->name('guest.home');
// rotta show guest
Route::get('/projects/{project}', [GuestProjectController::class, 'show'])->name('guest.projects.show');



Route::prefix('/admin')->name('admin.')->middleware('auth')->group(function () {
    // Rotta Admin home
    Route::get('', AdminHomeController::class)->name('home');

    // Rotte per il cestino
    route::get('/projects/trash', [AdminProjectController::class, 'trash'])->name('projects.trash');
    route::patch('/projects/{project}/restore', [AdminProjectController::class, 'restore'])->name('projects.restore');
    route::delete('/projects/{project}/drop', [AdminProjectController::class, 'drop'])->name('projects.drop');

    // Rotte Admin project CRUD
    Route::get('/projects', [AdminProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/create', [AdminProjectController::class, 'create'])->name('projects.create');
    Route::get('/projects/{project}', [AdminProjectController::class, 'show'])->name('projects.show')->withTrashed();
    Route::post('/projects', [AdminProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}/edit', [AdminProjectController::class, 'edit'])->name('projects.edit')->withTrashed();
    Route::put('/projects/{project}', [AdminProjectController::class, 'update'])->name('projects.update')->withTrashed();
    Route::delete('/projects/{project}', [AdminProjectController::class, 'destroy'])->name('projects.destroy');

    // Rotta Admin project CRUD generale
    // Route::resource('projects', AdminProjectController::class);

    // Rotte per il cestino dei tipi
    route::get('/types/trash', [TypeController::class, 'trash'])->name('types.trash');
    route::patch('/types/{type}/restore', [TypeController::class, 'restore'])->name('types.restore');
    route::delete('/types/{type}/drop', [TypeController::class, 'drop'])->name('types.drop');

    // Rotta Admin type CRUD generale
    Route::resource('types', TypeController::class)->withTrashed(['show', 'edit', 'update']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
