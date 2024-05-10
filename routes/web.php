<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeesTableController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserTableController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserControllers\UserEditController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;


/**General user routes **/
Route::middleware(['auth', 'verified'])->get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

/**Moderator routes **/
Route::middleware('moderatorAuth')->prefix('moderator')->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'moderatorDashboard'])->name('moderatorDashboard'); // Define the moderatorDashboard route
});

/**Admin routes **/
Route::middleware('adminAuth')->prefix('admin')->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('adminDashboard');
});

Route::post('login', [AuthenticatedSessionController::class, 'store']);


Route::get('/', function () {
    return view('welcome');
});

//Route::get('/dashboard', function () {
//    return view('userDashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/employees', function () {
    return view('users.employees');
})->middleware(['auth', 'verified'])->name('users.employees');

//Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Username
Route::match(['get', 'post'],'/check-username', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'checkUsername'])->name('check-username');
Route::match(['get', 'post'],'/generate-username', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'generateUniqueUsername'])->name('generate-username');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');

//Employees table
Route::get('/employees', [EmployeesTableController::class, 'index'])->middleware(['auth', 'verified'])->name('users.employees');

//CRUD
Route::get('/users/create', [\App\Http\Controllers\UserControllers\UserStoreController::class, 'create'])->middleware(['auth', 'verified'])->name('users.create');
Route::post('/users/store', [\App\Http\Controllers\UserControllers\UserStoreController::class, 'store'])->middleware(['auth', 'verified'])->name('users.store');
Route::put('/users/{id}/update', [\App\Http\Controllers\UserControllers\UserUpdateController::class, 'update'])->middleware(['auth', 'verified'])->name('users.update');
Route::get('/users/{id}/edit', [\App\Http\Controllers\UserControllers\UserUpdateController::class, 'edit'])->middleware(['auth', 'verified'])->name('users.edit');
Route::get('/users/{id}/fetch', [\App\Http\Controllers\UserControllers\UserUpdateController::class, 'fetch'])->middleware(['auth', 'verified'])->name('users.fetch');
Route::delete('/users/{id}/delete', [\App\Http\Controllers\UserControllers\UserDestroyController::class, 'destroy'])->middleware(['auth', 'verified'])->name('users.delete');

//Users table
Route::match(['get', 'post'], '/table', [UserTableController::class, 'index'])->middleware(['auth', 'verified'])->name('users.table');


require __DIR__ . '/auth.php';
