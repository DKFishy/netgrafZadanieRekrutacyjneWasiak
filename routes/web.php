<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

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

Route::get('/pets', [ApiController::class, 'fetchData'])->name('pets');
//dodawanie zwierzaków
Route::get('/pets/add', [ApiController::class, 'createForm'])->name('pets.add');
Route::post('/pets', [ApiController::class, 'store'])->name('pets.store');
//edycja zwierzaka
Route::get('/pets/{petId}/edit', [ApiController::class, 'editForm'])->name('pets.editForm');
Route::put('/pets/{petId}', [ApiController::class, 'update'])->name('pets.update');
//usuwanie pozycji
Route::delete('/pets/{petId}', [ApiController::class, 'destroy'])->name('pets.destroy');

