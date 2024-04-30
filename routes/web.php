<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\UserTableController;
use App\Http\Controllers\EmployeesTableController;
use App\Http\Controllers\UserController;



use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/table', function () {
    return view('users.table');
})->middleware(['auth', 'verified'])->name('users.table');
Route::get('/employees', function () {
    return view('users.employees');
})->middleware(['auth', 'verified'])->name('users.employees');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::match(['get', 'post'],'/check-username', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'checkUsername'])->name('check-username');
Route::match(['get', 'post'],'/generate-username', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'generateUniqueUsername'])->name('generate-username');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');

Route::get('/table', [UserTableController::class, 'userData'])->middleware(['auth', 'verified'])->name('users.table');
Route::get('/employees', [EmployeesTableController::class, 'index'])->middleware(['auth', 'verified'])->name('users.employees');

//CRUD
//Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserStoreController::class, 'create'])->name('users.create');
Route::post('/users/store', [UserStoreController::class, 'store'])->name('users.store');
//Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
//Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
//Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');



require __DIR__ . '/auth.php';
