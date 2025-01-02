<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::view('register','register')->name('register');
Route::view('login','login')->name('login');
Route::post('registersave',[UserController::class,'register'])->name('registersave');
Route::post('loginsave',[UserController::class,'login'])->name('loginsave');
Route::get('dashboard', [UserController::class,'dashboard'])->name('dashboard');
Route::get('logout',[usercontroller::class,'logout'])->name('logout');
Route::get('forgot-password', [UserController::class, 'showForgotPasswordForm'])->name('forgot-password');
Route::post('forgot-password', [UserController::class, 'sendResetLinkEmail'])->name('forgot-password.send');
Route::get('reset-password/{token}', [UserController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('reset-password', [UserController::class, 'resetPassword'])->name('reset-password.update');