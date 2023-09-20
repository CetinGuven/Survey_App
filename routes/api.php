<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SurveyController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
   
});

Route::post('/signUp',[UserController::class,'signUp']);
Route::post('/login',[UserController::class,'login']);
Route::post('/logout',[UserController::class,'logout']);
Route::post('/refresh',[UserController::class,'refresh']);
Route::get('/userProfile',[UserController::class,'userProfile']);
Route::post('/creta',[SurveyController::class,'creta']);
Route::post('/update',[SurveyController::class,'update']);
Route::post('/show',[SurveyController::class,'show']);
Route::post('/delete',[SurveyController::class,'delete']);

