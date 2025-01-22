<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ColorSettingController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\IpsController;
use App\Http\Controllers\OccupationController;
use App\Http\Controllers\OutOfServiceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'index']);
Route::post('auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('auth/logout', [AuthController::class, 'logout'])->name('auth.logout');


Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {

    Route::get('dashboard',  [DashBoardController::class, 'index'])->name('admin.dashboard');

    Route::resource('users', UserController::class);
    Route::put('users/updatePassword/{user}', [UserController::class, 'updatePassword'])->name('users.updatePassword');

    Route::resource('roles', RoleController::class);
    Route::get('filter_roles/{id}', [RoleController::class, 'filterRolByRol']);
    Route::get('permissions_user/{id}', [RoleController::class, 'getPermissions']);

    Route::resource('ips', IpsController::class);
    Route::post('ips/load_file', [IpsController::class, 'loadFile']);
    Route::post('ips/to_create', [IpsController::class, 'toCreate']);

    Route::resource('occupations', OccupationController::class);
    Route::post('occupations/load_file', [OccupationController::class, 'loadFile']);
    Route::post('occupations/insert_occupations', [OccupationController::class, 'insertOccupations']);
    Route::post('occupations/insert_out_of_service', [OccupationController::class, 'insertOutOfService']);


    Route::resource('out_of_services', OutOfServiceController::class);

    Route::post('color_settings/save', [ColorSettingController::class, 'save']);
});
