<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'guest'], function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::resources([
        'tasks' => TaskController::class,
    ], ['except' => ['create', 'edit']]);
});
