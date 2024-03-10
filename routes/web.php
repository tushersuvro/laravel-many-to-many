<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/doctors/edit/{doctor}', [App\Http\Controllers\DoctorController::class, 'edit'])->name('doctors.edit');
Route::get('/doctors/delete/{doctor}', [App\Http\Controllers\DoctorController::class, 'delete'])->name('doctors.delete');
Route::get('/doctors/create', [App\Http\Controllers\DoctorController::class, 'create'])->name('doctors.create');
Route::get('/doctors', [App\Http\Controllers\DoctorController::class, 'index'])->name('doctors.index');
