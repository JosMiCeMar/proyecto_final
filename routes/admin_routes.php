<?php

use App\Http\Controllers\AdministradoreController;
use App\Http\Controllers\CentroController;
use App\Http\Controllers\CodRegistroController;
use App\Http\Controllers\DiaController;
use App\Http\Controllers\ZonaController;
use App\Http\Middleware\CheckAdmin;
use Illuminate\Support\Facades\Route;

Route::middleware([CheckAdmin::class, 'auth', 'verified'])->group(function () {

    //Rutas editar perfil
    Route::get('/admin_profile', [AdministradoreController::class, 'edit'])->name('admin.profileEdit');
    Route::patch('/admin_profile', [AdministradoreController::class, 'update'])->name('admin.profileUpdate');

    //Rutas para Codigos de Registro
    Route::get('/admin_generar_codigo', [CodRegistroController::class, 'genCodeAdmin'])->name('admin.genCode');
    Route::post('/admin_generar_codigo', [CodRegistroController::class, 'showCodeAdmin']);
    Route::get('/admin_codigo_registro', [CodRegistroController::class, 'indexCodeAdmin'])->name('admin.indexCode');
    Route::get('/admin_eliminar_codigo', [CodRegistroController::class, 'listCodeAdmin'])->name('admin.delCode');
    Route::post('/admin_eliminar_codigo', [CodRegistroController::class, 'deleteCodeAdmin']);

    //Rutas para Centros Asociados
    Route::get('/admin_centros_asociados', [CentroController::class, 'index'])->name('admin.indexCenter');
    Route::get('/admin_crear_centro',[CentroController::class,'create'])->name('admin.createCenter');
    Route::post('/admin_crear_centro',[CentroController::class,'store']);
    Route::get('/admin_lista_centro',[CentroController::class,'list'])->name('admin.listCenter');
    Route::get('/admin_mod_centro/{id}',[CentroController::class,'mod'])->name('admin.modCenter');
    Route::post('/admin_mod_centro',[CentroController::class,'update'])->name('admin.updateCenter');
    Route::post('/admin_del_centro',[CentroController::class,'delete'])->name('admin.delCenter');

    //Rutas para zonas de tratamiento
    Route::get('admin_zonas_tratamiento',[ZonaController::class, 'index'])->name('admin.indexZona');
    Route::get('/admin_crear_zona',[ZonaController::class,'create'])->name('admin.createZona');
    Route::post('/admin_crear_zona',[ZonaController::class,'store']);
    Route::get('/admin_lista_zona',[ZonaController::class,'list'])->name('admin.listZona');
    Route::get('/admin_mod_zona/{id}',[ZonaController::class,'mod'])->name('admin.modZona');
    Route::post('/admin_mod_zona',[ZonaController::class,'update'])->name('admin.updateZona');
    Route::post('/admin_del_zona',[ZonaController::class,'delete'])->name('admin.delZona');

    //Rutas para dias asignados
    Route::get('admin_dias',[DiaController::class, 'index'])->name('admin.indexDias');
    Route::get('/admin_asignar_dia',[DiaController::class,'create'])->name('admin.createDias');
    Route::post('/admin_asignar_dia',[DiaController::class,'store']);
    Route::get('/admin_lista_dias',[DiaController::class,'list'])->name('admin.listDias');
    Route::get('/admin_mod_dia/{id}',[DiaController::class,'mod'])->name('admin.modDias');
    Route::post('/admin_mod_dia',[DiaController::class,'update'])->name('admin.updateDias');
    Route::post('/admin_del_dia',[DiaController::class,'delete'])->name('admin.delDias');
    
});
