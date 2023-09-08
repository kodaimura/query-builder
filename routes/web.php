<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QbProjectController;
use App\Http\Controllers\QbProjectDashboardController;
use App\Http\Controllers\QbTableSchemaController;
use App\Http\Controllers\QbTableApiController;
use App\Http\Controllers\QbColumnApiController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    //Route::get('/projects', [QbProjectController::class, 'index']);
    Route::get('/projects/create', [QbProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [QbProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project_id}', [QbProjectDashboardController::class, 'show'])->name('projectDashboard');
    Route::post('/projects/{project_id}/ddl', [QbTableSchemaController::class, 'uploadDdl'])->name('uploadDdl');

    Route::get('/api/projects/{project_id}/tables', [QbTableApiController::class, 'getTables']);
    Route::post('/api/projects/{project_id}/tables', [QbTableApiController::class, 'createTable']);
    Route::put('/api/projects/{project_id}/tables/{table_id}', [QbTableApiController::class, 'updateTable']);
    Route::delete('/api/projects/{project_id}/tables/{table_id}', [QbTableApiController::class, 'deleteTable']);
    Route::get('/api/tables/{table_id}/columns', [QbColumnApiController::class, 'getColumns']);
    Route::post('/api/tables/{table_id}/columns', [QbColumnApiController::class, 'createColumn']);
    Route::put('/api/tables/{table_id}/columns/{column_id}', [QbColumnApiController::class, 'updateColumn']);
    Route::delete('/api/tables/{table_id}/columns/{column_id}', [QbColumnApiController::class, 'deleteColumn']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
