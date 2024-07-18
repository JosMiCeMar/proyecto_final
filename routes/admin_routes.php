<?php

use App\Http\Controllers\AdministradoreController;
use App\Http\Controllers\CentroController;
use App\Http\Middleware\CheckAdmin;
use Illuminate\Support\Facades\Route;

Route::middleware([CheckAdmin::class, 'auth'])->group(function () {
    //Rutas para Codigos de Registro
    Route::get('/admin_generar_codigo', [AdministradoreController::class, 'genCode'])->name('admin.genCode');
    Route::post('/admin_generar_codigo', [AdministradoreController::class, 'showCode']);
    Route::get('/admin_codigo_registro', [AdministradoreController::class, 'indexCode'])->name('admin.indexCode');
    Route::get('/admin_eliminar_codigo', [AdministradoreController::class, 'listCode'])->name('admin.delCode');
    Route::post('/admin_eliminar_codigo', [AdministradoreController::class, 'deleteCode']);

    //Rutas para Centros Asociados
    Route::get('/admin_centros_asociados', [CentroController::class, 'index'])->name('admin.indexCenter');
    Route::get('/admin_crear_centro',[CentroController::class,'create'])->name('admin.createCenter');
    Route::post('/admin_crear_centro',[CentroController::class,'store']);
    Route::get('/admin_mod_centro',[CentroController::class,'edit'])->name('admin.modCenter');
    Route::post('/admin_mod_centro',[CentroController::class,'update']);
    Route::get('/admin_del_centro',[CentroController::class,'list'])->name('admin.delCenter');
    Route::post('/admin_del_centro',[CentroController::class,'delete']);
});
