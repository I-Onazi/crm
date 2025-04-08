<?php

use App\Http\Controllers\contactController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [contactController::class, 'create']);
Route::get('/e', [contactController::class, 'edit']);
Route::resource('contacts', ContactController::class);