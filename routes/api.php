<?php

use Illuminate\Http\Request;
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

Route::group(['prefix' => 'v1'], function(){
    Route::get('simple/archive', [App\Http\Controllers\SimpleCrudController::class,'archive'])->name('simple.archive');
    Route::post('simple/{simple}/restore', [App\Http\Controllers\SimpleCrudController::class,'restore'])->name('simple.restore');
    Route::delete('simple/{simple}/permanent/delete', [App\Http\Controllers\SimpleCrudController::class,'permanentDelete'])->name('simple.permanent.delete');
    Route::apiResource('simple', App\Http\Controllers\SimpleCrudController::class);
});