<?php

use App\Http\Controllers\ClientesController;

use Illuminate\Support\Facades\Route;



Route::get('/', [ClientesController::class,'index'])->name('clientes.index');
Route::get('/clientes', [ClientesController::class,'create'])->name('clientes.create');
Route::get('/clientes/buscar', [ClientesController::class, 'buscar'])->name('clientes.buscar');
Route::get('/clientes/{id}/show', [ClientesController::class, 'show'])->name('clientes.show');
Route::post('/clientes', [ClientesController::class, 'store'])->name('clientes.store');
Route::delete('/clientes/{id}', [ClientesController::class, 'destroy'])->name('clientes.destroy');
Route::get('/clientes/{id}/edit', [ClientesController::class, 'edit'])->name('clientes.edit'); // Solo una ruta edit
Route::put('/clientes/{id}', [ClientesController::class, 'update'])->name('clientes.update');







