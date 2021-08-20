<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\forgetpasswordController;
use App\Http\Controllers\LinksController;
use App\Http\Controllers\profilesController;

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

Route::middleware(['guest'])->group(function () {
    Route::get('/authentication/login', [AuthenticationController::class, 'user_login'])->name('user.login');/*login page*/
    Route::get('/forgetpassword/create', [forgetpasswordController::class, 'create'])->name('forget.create');/*forget password page*/
    Route::post('/forgetpassword/check', [forgetpasswordController::class, 'check'])->name('forget.check');/*forget password check email and send email*/
    Route::get('/forgetpassword/changepassword/{user}/', [forgetpasswordController::class, 'change_password'])->name('change.password');/*enter code from your email page*/
    Route::post('/forgetpassword/changepassword/{user}', [forgetpasswordController::class, 'login_with_forget_password'])->name('login.with.forget.password');/*store new password for forget password*/
    Route::post('/authentication/login', [AuthenticationController::class, 'user_check_login'])->name('user.check.login');/*check email and password for login*/
    Route::get('/authentication/signin', [AuthenticationController::class, 'user_create'])->name('user.create');/*user sign_in page*/
});


Route::post('/authentication/signin', [AuthenticationController::class, 'user_store'])->name('user.store');/*user sign_in store*/

Route::middleware(['auth'])->group(function () {
    Route::get('/authentication/verifyemail/', [AuthenticationController::class, 'verifyemail'])->name('user.verifyemail');/*verify email page*/
    Route::post('/authentication/verifyemail/', [AuthenticationController::class, 'verifyemail_store'])->name('user.verifyemail.store');/*verify email Comparison code*/
    Route::delete('/authentication/logout/', [AuthenticationController::class, 'logout'])->name('user.logout');/*user logout*/
    Route::get('/authentication/logout/');/* forbidden for Route::get logout*/

});

Route::resource('/profile', profilesController::class);/*user profile*/


Route::get('/links/create', [LinksController::class, 'create'])->name('links.create');/*create a new short link*/
Route::post('/links/', [LinksController::class, 'store'])->name('links.store');/*store a new short link in database*/
Route::get('/links/', [LinksController::class, 'index'])->name('links.index');/*list of all links*/
Route::delete('/links/{link}', [LinksController::class, 'destroy'])->name('links.destroy');/*delete link*/
Route::get('/{link}', [LinksController::class, 'handle'])->name('links.handle');/*redirect to user's link*/






