<?php

    use App\Http\Controllers\AirQuoController;
    use App\Http\Controllers\Esp32Controller;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\QualityOfLifeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::resource('/patients', PatientController::class);
Route::post('/patient', [PatientController::class, 'updatePatient']);
Route::resource('/users', UserController::class);
Route::get('/qol', [QualityOfLifeController::class, 'index']);
Route::get('/get-air-data', [AirQuoController::class, 'index']);
Route::get('/data', [AirQuoController::class, 'data']);
Route::post('/qol', [QualityOfLifeController::class, 'update']);
Route::post('/firestore', [QualityOfLifeController::class, 'firestore']);
Route::post('/toggle-fan', [QualityOfLifeController::class, 'toggleFan']);
Route::post('/toggle-alarm', [QualityOfLifeController::class, 'toggleAlarm']);
Route::get('/actual-data', [AirQuoController::class, 'actual']);
Route::get('/key', [AirQuoController::class, 'key']);

Route::post('/login', [UserController::class, 'login']);
Route::post('/delete-patient', [PatientController::class, 'destroy']);
Route::post('/esp32', [Esp32Controller::class, 'post']);
Route::get('/user', [Esp32Controller::class, 'getUserId']);
