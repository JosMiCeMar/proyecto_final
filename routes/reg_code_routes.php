<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ResponsableController;
use App\Http\Middleware\CheckCode;
use Illuminate\Support\Facades\Route;


Route::middleware(CheckCode::class)->group(function(){
    Route::get('/cliente_registro',[ClienteController::class,'create'])->name('cliente.create');
    Route::post('/cliente_registro',[ClienteController::class,'store']);

    Route::get('/responsable_registro',[ResponsableController::class,'create'])->name('responsable.create');
    Route::post('/responsable_registro',[ResponsableController::class,'store']);
});