<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;





//Merchant Outbound
//Convert non Snap -> Snap
Route::controller(\App\Http\Controllers\NonSnapToSnapController::class)
    ->group(function () {
        Route::post('/PaymentRegister', 'createVa');
        Route::post('/PaymentQuery', 'queryStatus');
        Route::post('/PostAuth', 'voidTransaction');
    })->middleware([\App\Http\Middleware\RequestLogger::class]);


//Merchant Inbound
//Convert Snap -> Non Snap
$currentVersion = env("APP_VERSION", "v1.0");
Route::prefix("$currentVersion/transfer-va")
    ->group(function () {
        Route::post('/payment', [\App\Http\Controllers\SnapToNonSnapController::class, 'payment']);
        Route::post('/inquiry', [\App\Http\Controllers\SnapToNonSnapController::class, 'inquiry']);
    })->middleware([\App\Http\Middleware\RequestLogger::class, \App\Http\Middleware\SnapAuthentication::class]);
