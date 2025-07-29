<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParcelleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {


});
