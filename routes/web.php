<?php

use App\Http\Controllers\LinkController;
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

Route::get('/links/create', [LinkController::class, 'create'])->name('links.create');/*create a new short link*/
Route::post('/links/', [LinkController::class, 'store'])->name('links.store');/*store a new short link in database*/
Route::get('/links/', [LinkController::class, 'index'])->name('links.index');/*list of all links*/
Route::delete('/links/{link}', [LinkController::class, 'destroy'])->name('links.destroy');/*delete link*/
Route::get('/{link}', [LinkController::class, 'handle'])->name('links.handle');/*redirect to user's link*/

