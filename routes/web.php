<?php

use App\Http\Controllers\DosageController;
use App\Http\Controllers\GenericController;
use App\Http\Controllers\PharmaceuticalController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DrugController;

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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dosages', [DosageController::class, 'index'])->name('dosage-list');
Route::get('/dosages/create', [DosageController::class, 'create'])->name('dosage-create');
Route::post('/dosages',[DosageController::class,'store']);
Route::delete('/dosages/{id}',[DosageController::class,'destroy']);
Route::get('/dosages_edit/{id}', [DosageController::class, 'edit']);
Route::put('/dosages_update/{id}',[DosageController::class,'update']);


Route::get('/generics', [GenericController::class, 'index']);

Route::get('/companies', [PharmaceuticalController::class, 'index']);


Route::get('/drugs/create', [DrugController::class, 'create'])->name('drug-create');
Route::post('/drugs', [DrugController::class, 'store']);
Route::get('/drugs', [DrugController::class, 'index'])->name('drug-list');


