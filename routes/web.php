<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubmissionsController;
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
    return view('index');
});

Route::get('/login',
    ['as' => 'login',
     'uses' =>  function () {
        return redirect('/auth/login');
        }
    ]);

Route::get('/auth/login', [AuthController::class, 'login']);
Route::get('/auth/register', [AuthController::class, 'register']);

Route::post('/auth/register', [AuthController::class, 'registerAction']);
Route::post('/auth/login', [AuthController::class, 'loginAction']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/logout', [AuthController::class, 'logout']);

    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::group(['prefix' => 'signee', 'as' => 'signee.'], function () {
        Route::group(['prefix' => 'submissions', 'as' => 'submissions.'], function () {
            Route::get('/', [SubmissionsController::class, 'signeeIndex']);    
            Route::get('/{id}', [SubmissionsController::class, 'Detail']);   
            Route::post('/', [SubmissionsController::class, 'signeeCreate']);
            Route::get('/delete/{id}', [SubmissionsController::class, 'signeeDelete']);   
            Route::post('/update/{id}', [SubmissionsController::class, 'signeeUpdate']);        
        });
    });

});
