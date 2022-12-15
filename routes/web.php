<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CommonController;

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
    return view('home');
});

// Login Page
Route::get('/login', function () {
    return view('login');
});

Route::post('user/login', [CommonController::class, 'login']);



Route::prefix('/')->middleware(['user.auth'])->group(function () {
    // Dashboard Page
    Route::get('logout',  [CommonController::class, 'logout']);

    Route::get('dashboard', function () {
        return view('layouts.dashboard');
    });
    
    Route::get('/user/list', function () {
        return view('user.list');
    });
    Route::get('/list',[CommonController::class, 'list']);
    
});

Route::post('contact/number/validate/unique', [CommonController::class, 'validateUniqueContactNumber']);
Route::post('email/validate/unique', [CommonController::class, 'validateUniqueEmail']);



Route::post('/api/fetch-states', [CommonController::class, 'fetchState']);
Route::post('/api/fetch-cities', [CommonController::class, 'fetchCity']);
// Register Page with countries list
Route::get('/register', [CommonController::class, 'register']);
Route::post('/insert', [CommonController::class, 'insert']);


