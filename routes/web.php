<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;


Route::get('/',[ContactController::class, 'index']);
Route::get('/contact/{id}',[ContactController::class, 'show'])->name('show');
Route::post('contact/',[ContactController::class, 'store'])->name('store');
Route::delete('/destroy/{id}', [ContactController::class, 'destroy'])->name('destroy');
Route::get('/create', [ContactController::class, 'create'])->name('create');
Route::get('/search', [ContactController::class, 'search'])->name('search');
Route::get('/update/{id}', [ContactController::class, 'update'])->name('update');
