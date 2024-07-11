<?php

use App\Http\Controllers\AdministradoreController;
use App\Http\Middleware\CheckAdmin;
use Illuminate\Support\Facades\Route;

Route::middleware([CheckAdmin::class, 'auth'])->group(function () {
    Route::get('/generarCodigo', [AdministradoreController::class, 'genCode'])->name('genCode');
    Route::post('/generarCodigo', [AdministradoreController::class, 'showCode']);
    Route::get('/codigo_registro', [AdministradoreController::class, 'indexCode'])->name('indexCode');
    Route::get('/eliminar_codigo', [AdministradoreController::class, 'listCode'])->name('delCode');
    Route::post('/eliminar_codigo', [AdministradoreController::class, 'deleteCode']);
});
