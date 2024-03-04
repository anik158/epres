<?php

use App\Http\Controllers\DosageController;
use App\Http\Controllers\GenericController;
use App\Http\Controllers\PharmaceuticalController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DrugController;
use App\Http\Controllers\AuthController;


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

/*Bootstrap Route
---------------------*/

Route::get('/dashboard',function (){
    return view('auth.dashboard');
})->name('dashboard')->middleware('auth');

Route::get('/login',[AuthController::class,'login'])->name('login');
Route::post('/login',[AuthController::class,'loginPost'])->name('login-user');
Route::post('/logout',[AuthController::class,'logout'])->name('logout');


Route::get('/signup',[AuthController::class,'signup'])->name('signup');
Route::post('/signup',[AuthController::class,'store'])->name('create-user');


Route::get('/', function () {
    return redirect()->route('drug-list');
});



//Routing Dosage
Route::get('/dosages', [DosageController::class, 'index'])->name('dosage-list');
Route::get('/dosages/create', [DosageController::class, 'create'])->name('dosage-create');
Route::post('/dosages',[DosageController::class,'store']);
Route::delete('/dosages/{id}',[DosageController::class,'destroy']);
Route::get('/dosages_edit/{id}', [DosageController::class, 'edit']);
Route::put('/dosages_update/{id}',[DosageController::class,'update']);

//Routing Generic
Route::get('/generics', [GenericController::class, 'index'])->name('generic-list');
Route::get('/generics/create', [GenericController::class, 'create'])->name('generic-create');
Route::post('/generics', [GenericController::class, 'store']);
Route::get('/generic_edit/{id}', [GenericController::class, 'edit']);
Route::put('/generics_update/{id}', [GenericController::class, 'update']);
Route::delete('/generic/{id}', [GenericController::class, 'destroy']);

Route::get('/companies', [PharmaceuticalController::class, 'index']);

//Routing Drugs
//Route::get('/create-index', 'YourController@createIndexAndAddData');
Route::get('/create-index-elastic', [DrugController::class, 'createIndexAndAddData'])->name('create-index-elastic');
Route::get('/drugs/create', [DrugController::class, 'create'])->name('drug-create');
Route::post('/drugs', [DrugController::class, 'store']);
Route::get('/drugs', [DrugController::class, 'index'])->name('drug-list');
Route::get('/drugs_edit/{id}',[DrugController::class,'edit']);
Route::delete('/drugs/{id}', [DrugController::class, 'destroy']);
//Elastic
Route::get('/drugs-search', [DrugController::class, 'search'])->name('drugs-search');
//Elequent
//Route::get('/drugs-search', [DrugController::class, 'searchDrugs'])->name('drugs-search');

