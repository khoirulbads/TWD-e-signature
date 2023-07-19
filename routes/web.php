<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubmissionsController;
use App\Http\Controllers\SettingController;
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
Route::post('/docs', [DashboardController::class, 'docs']);
Route::get('/subdocs', [DashboardController::class, 'subDocs']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/dashboard', [DashboardController::class, 'index']);

    
    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::group(['prefix' => 'submissions', 'as' => 'submissions.'], function () {
            Route::get('/', [SubmissionsController::class, 'adminIndex']);    
            Route::get('/{id}', [SubmissionsController::class, 'detail']);        
        });
    });

    Route::group(['prefix' => 'signee', 'as' => 'signee.'], function () {
        Route::group(['prefix' => 'submissions', 'as' => 'submissions.'], function () {
            Route::get('/', [SubmissionsController::class, 'signeeIndex']);    
            Route::get('/{id}', [SubmissionsController::class, 'detail']);   
            Route::post('/', [SubmissionsController::class, 'signeeCreate']);
            Route::get('/delete/{id}', [SubmissionsController::class, 'signeeDelete']);   
            Route::post('/update/{id}', [SubmissionsController::class, 'signeeUpdate']);        
            Route::post('/reupload/{id}', [SubmissionsController::class, 'signeeReupload']);   
        });
    });

    Route::group(['prefix' => 'signer', 'as' => 'signer.'], function () {
        Route::group(['prefix' => 'submissions', 'as' => 'submissions.'], function () {
            Route::get('/', [SubmissionsController::class, 'signerIndex']);    
            Route::get('/{id}', [SubmissionsController::class, 'detail']);   
            Route::post('/reject/{submission_id}', [SubmissionsController::class, 'reject']);   
            Route::get('/approve/{submission_id}', [SubmissionsController::class, 'approve']);
            
            // Route::post('/', [SubmissionsController::class, 'signeeCreate']);
            // Route::get('/delete/{id}', [SubmissionsController::class, 'signeeDelete']);   
            // Route::post('/update/{id}', [SubmissionsController::class, 'signeeUpdate']);        
        });
        Route::get('/setting', [SettingController::class, 'index']);   
        Route::post('/setting/save', [SettingController::class, 'save']);   
    
    });


});
