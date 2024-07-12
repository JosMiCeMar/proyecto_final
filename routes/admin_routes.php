<?php

use App\Http\Controllers\AdministradoreController;
use App\Http\Middleware\CheckAdmin;
use Illuminate\Support\Facades\Route;

Route::middleware([CheckAdmin::class, 'auth'])->group(function () {
    Route::get('/generar_codigo', [AdministradoreController::class, 'genCode'])->name('admin.genCode');
    Route::post('/generar_codigo', [AdministradoreController::class, 'showCode']);
    Route::get('/codigo_registro', [AdministradoreController::class, 'indexCode'])->name('admin.indexCode');
    Route::get('/eliminar_codigo', [AdministradoreController::class, 'listCode'])->name('admin.delCode');
    Route::post('/eliminar_codigo', [AdministradoreController::class, 'deleteCode']);
});
