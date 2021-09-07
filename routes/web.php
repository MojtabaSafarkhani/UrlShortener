<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ForgetPasswordController;
use App\Http\Controllers\LinksController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\VerificationEmailController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
})->name('welcome');/*Welcome Page*/
Route::middleware('guest')->group(function () {

    Route::get('/register', [RegisterController::class, 'create'])->name('register.create');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
    Route::get('/login', [AuthenticationController::class, 'create'])->name('login.create');
    Route::post('/login', [AuthenticationController::class, 'store'])->name('login.store');
    Route::get('/forget', [ForgetPasswordController::class, 'create'])->name('forget.create');
    Route::post('/forget', [ForgetPasswordController::class, 'store'])->name('forget.store');
    Route::get('/reset/{token}', [ForgetPasswordController::class, 'reSetPassword'])->name('reset.password.create');
    Route::post('/reset/{token}', [ForgetPasswordController::class, 'reSetPasswordStore'])->name('reset.password.store');

});

Route::delete('/logout', [AuthenticationController::class, 'destroy'])->name('login.destroy');


Route::get('/links/create', [LinksController::class, 'create'])->name('links.create');/*create a new short link*/
Route::post('/links/', [LinksController::class, 'store'])->name('links.store');/*store a new short link in database*/
Route::get('/links/', [LinksController::class, 'index'])->name('links.index');/*list of all links*/
Route::delete('/links/{link}', [LinksController::class, 'destroy'])->name('links.destroy');/*delete link*/
Route::get('/{link}', [LinksController::class, 'handle'])->name('links.handle');/*redirect to user's link*/

/*verify email*/
Route::get('/verify/email', [VerificationEmailController::class, 'show'])->middleware('auth')->name('verification.notice');
Route::get('/verify/email/{id}/{hash}', [VerificationEmailController::class, 'verify'])->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/verify/email/verification-notification', [VerificationEmailController::class, 'notify'])->middleware(['auth'])->name('verification.send');
/*end verify email*/

/*user profile */
Route::get('/profile/{user}', [ProfilesController::class, 'show'])->name('profile.show');
Route::get('/profile/{user}/edit', [ProfilesController::class, 'edit'])->name('profile.edit');
Route::patch('/profile/', [ProfilesController::class, 'update'])->name('profile.update');
/*user profile end*/


