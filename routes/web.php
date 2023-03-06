<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LogicController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

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
    if(Auth::user()){
        return redirect()->route('dashboard');
    }else{
        return redirect()->route('login');
    }
});

Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('post-login', [LoginController::class, 'postLogin'])->name('login.post'); 
Route::post('post-registration', [LoginController::class, 'postRegistration'])->name('register.post'); 
Route::prefix('admin')->namespace('Admin')->middleware('auth')->group(function(){
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/user', '\App\Http\Controllers\UserController');
    Route::get('logic',[LogicController::class,'index'])->name('logic-index');
    Route::post('logic-store',[LogicController::class,'store_dummy'])->name('logic-store');
    Route::post('logic-create',[LogicController::class,'create_dummy'])->name('logic-create');
    Route::delete('logic-destroy/{id}',[LogicController::class,'destroy'])->name('logic-destroy');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});