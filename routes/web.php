<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware([\App\Http\Middleware\AutoCreateLogs::class])->group(function () {
    Route::get('/', [App\Http\Controllers\Client\HomeController::class, 'index']);
    Route::get('/download', [App\Http\Controllers\Client\DownloadController::class, 'index']);
    Route::get('/page/{id}', [App\Http\Controllers\Client\PageController::class, 'detail']);
});

Route::group(['prefix' => 'admin', 'middleware' => [\App\Http\Middleware\AutoCreateLogs::class]], function() {
    Route::get('/',[App\Http\Controllers\Admin\AuthController::class, 'index']);

    Route::get('login',[App\Http\Controllers\Admin\AuthController::class, 'index']);
    Route::get('auth',[App\Http\Controllers\Admin\AuthController::class, 'index']);
    Route::get('auth/login',[App\Http\Controllers\Admin\AuthController::class, 'login'])->name('admin.login');
    Route::post('auth/action_login',[App\Http\Controllers\Admin\AuthController::class, 'action_login']);
    Route::get('auth/logout',[App\Http\Controllers\Admin\AuthController::class, 'logout']);
    Route::get('auth/forgot',[App\Http\Controllers\Admin\AuthController::class, 'forgot']);
    Route::get('auth/error',[App\Http\Controllers\Admin\AuthController::class, 'error'])->name('admin.error');

    Route::get('profile',[App\Http\Controllers\Admin\ProfileController::class, 'index']);
    Route::get('dashboard',[App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('slider', App\Http\Controllers\Admin\SliderController::class);
    Route::resource('feature', App\Http\Controllers\Admin\FeatureController::class);
    Route::resource('download', App\Http\Controllers\Admin\DownloadController::class);
    Route::resource('pages', App\Http\Controllers\Admin\PagesController::class);
    Route::resource('upload', App\Http\Controllers\Admin\UploadController::class);
    Route::resource('setting', App\Http\Controllers\Admin\SettingController::class);
    Route::resource('user', App\Http\Controllers\Admin\UserController::class);

    Route::resource('attendance', App\Http\Controllers\Admin\AttendanceController::class);
    Route::resource('permit', App\Http\Controllers\Admin\PermitController::class);
    Route::resource('activity', App\Http\Controllers\Admin\ActivityController::class);
    Route::resource('announcement', App\Http\Controllers\Admin\AnnouncementController::class);
    Route::resource('agenda', App\Http\Controllers\Admin\AgendaController::class);
    Route::resource('division', App\Http\Controllers\Admin\DivisionController::class);
    Route::resource('role', App\Http\Controllers\Admin\RoleController::class);
    Route::resource('department', App\Http\Controllers\Admin\DepartmentController::class);
});

Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});
