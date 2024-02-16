<?php

use App\Http\Controllers\Api\DrugController;
use App\Http\Controllers\Api\DosageController;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\GenericController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Drug's API
Route::get('drugs',[DrugController::class,'index']);
Route::post('drugs',[DrugController::class,'store']);

//Dosage's API
Route::get('dosages',[DosageController::class,'index']);
Route::post('dosages',[DosageController::class,'store']);
Route::get('dosages/search/{search}',[DosageController::class,'search']);
Route::put('dosages/{id}',[DosageController::class,'update']);
Route::delete('dosages/{id}',[DosageController::class,'destroy']);

//Generic API
Route::get('/generics', [GenericController::class, 'index']);
Route::get('/generics/create', [GenericController::class, 'create']);
Route::post('/generics', [GenericController::class, 'store']);
Route::delete('/generics/{id}', [GenericController::class, 'destroy']);
Route::put('/generics/{id}', [GenericController::class, 'update']);
Route::get('/generics/{id}/edit', [GenericController::class, 'edit']);


