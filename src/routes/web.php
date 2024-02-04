<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CaptchaController;
use App\Http\Controllers\MainPageController;
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


Route::get('/', [MainPageController::class, 'index'])->middleware(['jwt.auth', 'redirectUnauthorized']);

Route::get('/reload-captcha', [CaptchaController::class, 'reloadCaptcha']);
Route::post('/captcha-validation', [CaptchaController::class, 'capthcaFormValidate']);

Route::get('/user-authentication', [AuthController::class, 'index'])->name('user-authentication');