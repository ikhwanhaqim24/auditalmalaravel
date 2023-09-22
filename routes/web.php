<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\PizzaController;
use App\Http\Controllers\HomeController;

// audit controller
use App\Http\Controllers\EntryCategoryController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\LogsFilesystemController;
use App\Http\Controllers\LogsUserActivityController;
use App\Http\Controllers\UploadedFilesController;
use App\Http\Controllers\VenueController;

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

// get
Route::get('/', function () {
    return view('welcome');
});

Route::get('/pizzas', [PizzaController::class, 'index'])->name('pizzas.index')->middleware('auth');

Route::get('/pizzas/create', [PizzaController::class, 'create'])->name('pizzas.create');

Route::get('/pizzas/{id}', [PizzaController::class, 'show'])->name('pizzas.show')->middleware('auth');

// post
Route::post('/pizzas', [PizzaController::class, 'store'])->name('pizzas.store');

// delete
Route::delete('/pizzas/{id}', [PizzaController::class, 'destroy'])->name('pizzas.destroy')->middleware('auth');

Auth::routes([
    'register' => true
]);

Route::get('/home', [HomeController::class, 'index'])->name('home');

// audit parts
Route::get('/audit', [EntryController::class, 'index'])->name('entry.index');

Route::get('/audit/{id}', [EntryController::class, 'show'])->name('entry.show');

Route::post('/audit', [EntryController::class, 'postMethod'])->name('entry.postMethod');

Route::get('/restore/{id}', [EntryController::class, 'restore'])->name('entry.restore');