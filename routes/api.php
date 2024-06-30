<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::controller(App\Http\Controllers\Api\AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('logout', 'logout');
    // Route::post('register', 'register');
    // Route::post('refresh', 'refresh');
});

Route::controller(App\Http\Controllers\Api\SettingController::class)->group(function () {
    Route::get('setting', 'index');
    Route::get('setting/{id}', 'show');
    Route::post('setting', 'store');
    Route::put('setting/{id}', 'update');
    Route::delete('setting/{id}', 'destroy');
});
Route::controller(App\Http\Controllers\Api\SliderController::class)->group(function () {
    Route::get('slider', 'index');
    Route::get('slider/{id}', 'show');
    Route::post('slider', 'store');
    Route::put('slider/{id}', 'update');
    Route::delete('slider/{id}', 'destroy');
});
Route::controller(App\Http\Controllers\Api\ElectionController::class)->group(function () {
    Route::get('election', 'index');
    Route::get('election/{id}', 'show');
    Route::post('election', 'store');
    Route::put('election/{id}', 'update');
    Route::delete('election/{id}', 'destroy');
});
Route::controller(App\Http\Controllers\Api\FinanceController::class)->group(function () {
    Route::get('finance', 'index');
    Route::get('finance/{id}', 'show');
    Route::post('finance', 'store');
    Route::put('finance/{id}', 'update');
    Route::delete('finance/{id}', 'destroy');
});
Route::controller(App\Http\Controllers\Api\InventoryController::class)->group(function () {
    Route::get('inventory', 'index');
    Route::get('inventory/{id}', 'show');
    Route::post('inventory', 'store');
    Route::put('inventory/{id}', 'update');
    Route::delete('inventory/{id}', 'destroy');
});
Route::controller(App\Http\Controllers\Api\QuickCountController::class)->group(function () {
    Route::get('quick_count', 'index');
    Route::get('quick_count/{id}', 'show');
    Route::post('quick_count', 'store');
    Route::put('quick_count/{id}', 'update');
    Route::delete('quick_count/{id}', 'destroy');
});
Route::controller(App\Http\Controllers\Api\ReportController::class)->group(function () {
    Route::get('report', 'index');
    Route::get('report/{id}', 'show');
    Route::post('report', 'store');
    Route::put('report/{id}', 'update');
    Route::delete('report/{id}', 'destroy');
});
Route::controller(App\Http\Controllers\Api\RoleController::class)->group(function () {
    Route::get('role', 'index');
    Route::get('role/{id}', 'show');
    Route::post('role', 'store');
    Route::put('role/{id}', 'update');
    Route::delete('role/{id}', 'destroy');
});
Route::controller(App\Http\Controllers\Api\SurveyController::class)->group(function () {
    Route::get('survey', 'index');
    Route::get('survey/{id}', 'show');
    Route::post('survey', 'store');
    Route::put('survey/{id}', 'update');
    Route::delete('survey/{id}', 'destroy');
});
Route::controller(App\Http\Controllers\Api\SurveyAnswerController::class)->group(function () {
    Route::get('survey_answer', 'index');
    Route::get('survey_answer/{id}', 'show');
    Route::post('survey_answer', 'store');
    Route::put('survey_answer/{id}', 'update');
    Route::delete('survey_answer/{id}', 'destroy');
});
Route::controller(App\Http\Controllers\Api\SurveyQuestionController::class)->group(function () {
    Route::get('survey_question', 'index');
    Route::get('survey_question/{id}', 'show');
    Route::post('survey_question', 'store');
    Route::put('survey_question/{id}', 'update');
    Route::delete('survey_question/{id}', 'destroy');
});
Route::controller(App\Http\Controllers\Api\UserController::class)->group(function () {
    Route::get('user', 'index');
    Route::get('user/{id}', 'show');
    Route::post('user', 'store');
    Route::put('user/{id}', 'update');
    Route::delete('user/{id}', 'destroy');
    Route::get('user_dashboard', 'dashboard');
});
Route::controller(App\Http\Controllers\Api\VoterController::class)->group(function () {
    Route::get('voter', 'index');
    Route::get('voter/{id}', 'show');
    Route::post('voter', 'store');
    Route::put('voter/{id}', 'update');
    Route::delete('voter/{id}', 'destroy');
    Route::get('voter_nik/{nik}', 'nik');
});
Route::controller(App\Http\Controllers\Api\UploadController::class)->group(function () {
    Route::post('upload', 'upload');
});
Route::controller(App\Http\Controllers\Api\AreaProvinsiController::class)->group(function () {
    Route::get('area_provinsi', 'index');
    Route::get('area_provinsi/{id}', 'show');
});
Route::controller(App\Http\Controllers\Api\AreaKotaController::class)->group(function () {
    Route::get('area_kota', 'index');
    Route::get('area_kota/{id}', 'show');
});
Route::controller(App\Http\Controllers\Api\AreaKecamatanController::class)->group(function () {
    Route::get('area_kecamatan', 'index');
    Route::get('area_kecamatan/{id}', 'show');
});
Route::controller(App\Http\Controllers\Api\AreaKelurahanController::class)->group(function () {
    Route::get('area_kelurahan', 'index');
    Route::get('area_kelurahan/{id}', 'show');
});
Route::controller(App\Http\Controllers\Api\DashboardController::class)->group(function () {
    Route::get('dashboard/home/{id}', 'home');
    Route::get('dashboard/voters/{id}', 'voters');
    Route::get('dashboard/report/{id}', 'report');
    Route::get('dashboard/finance/{id}', 'finance');
    Route::get('dashboard/inventory/{id}', 'inventory');
});

Route::fallback(function(){
    return response()->json(
        [
            'status' => false,
            'message' => 'Page Not Found',
            'data' => []
        ],
    404);
});
