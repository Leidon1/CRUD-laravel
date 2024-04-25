<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\UserTableController;
use App\Http\Controllers\EmployeesTableController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/users', function () {
    return view('users.table');
})->middleware(['auth', 'verified'])->name('users.table');
Route::get('/users', function () {
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

Route::get('/users/data', [UserTableController::class, 'userData'])->name('users.table');

Route::get('/employees', [EmployeesTableController::class, 'index'])->middleware(['auth', 'verified'])->name('users.employees');



require __DIR__ . '/auth.php';
