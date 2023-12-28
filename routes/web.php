<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\HomeController;

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

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/', [HomeController::class, 'home'])->name('home');

Route::resource('attendences', AttendanceController::class);


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('employees', EmployeeController::class);

    Route::group(['prefix'=>'reports'], function(){
        Route::get('/daily', [ReportController::class, 'daily'])->name('reports.daily');
        Route::get('/weekly', [ReportController::class, 'weekly'])->name('reports.weekly');
        Route::get('/thisWeek', [ReportController::class, 'thisWeek'])->name('reports.thisWeek');
        Route::get('/lastWeek', [ReportController::class, 'lastWeek'])->name('reports.lastWeek');
        Route::get('/monthly', [ReportController::class, 'monthly'])->name('reports.monthly');
        Route::get('/yearly', [ReportController::class, 'yearly'])->name('reports.yearly');
        Route::get('/range', [ReportController::class, 'range'])->name('reports.range');
    });

    // Route::controller(ReportController::class)->group(function () {
    //     Route::get('/orders/{id}', 'daily')->name('reports.daily');
    // });
});

require __DIR__.'/auth.php';
