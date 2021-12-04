<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Homecontroller;


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
});

Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/teacher/all', [Homecontroller::class, 'alldata']);
Route::post('teacher/store', [Homecontroller::class, 'storedata']);
Route::get('teacher/edit/{id}', [Homecontroller::class, 'editdata']);
Route::post('teacher/update/{id}', [Homecontroller::class, 'updatedata']);
Route::delete('teacher/delete/{id}', [Homecontroller::class, 'deletedata']);
