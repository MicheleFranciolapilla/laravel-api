<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminController as AdminController;
use App\Http\Controllers\Admin\ProjectController as ProjectController;

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

//localhost:8000
Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () 
{
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //localhost:8000/admin
    Route::get('/', [AdminController::class, 'basics'])->name('dashboard');
    Route::delete('/projects/delete_all', [ProjectController::class, 'delete_all'])->name('projects.delete_all');
    Route::resource('/projects', ProjectController::class)->parameters(['projects' => 'project:slug']);
});

require __DIR__.'/auth.php';
