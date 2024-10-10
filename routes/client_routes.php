<?php

use App\Http\Controllers\ClienteController;
use App\Http\Middleware\CheckClient;
use Illuminate\Support\Facades\Route;

Route::middleware([CheckClient::class, 'auth', 'verified'])->group(function () {
  
    //Rutas editar perfil
  Route::get('/perfil_cliente', [ClienteController::class, 'edit'])->name('client.profileEdit');
  Route::patch('/perfil_cliente', [ClienteController::class, 'update'])->name('client.profileUpdate');

  //Rutas Mis Citas
  Route::get('/mis_citas', [ClienteController::class, 'indexCitas'])->name('client.indexCitas');
  Route::get('/reservar_cita', [ClienteController::class, 'createCitas'])->name('client.createCitas');

  //Rutas Mis Tratamientos
  Route::get('/mis_tratamientos', [ClienteController::class, 'indexTratamientos'])->name('client.indexTratamientos');

});