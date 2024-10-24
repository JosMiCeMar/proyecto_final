<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ReservaController;
use App\Http\Middleware\CheckClient;
use Illuminate\Support\Facades\Route;

Route::middleware([CheckClient::class, 'auth', 'verified'])->group(function () {
  
    //Rutas editar perfil
  Route::get('/perfil_cliente', [ClienteController::class, 'edit'])->name('client.profileEdit');
  Route::patch('/perfil_cliente', [ClienteController::class, 'update'])->name('client.profileUpdate');

  //Rutas Mis Citas
  //-----Reservar cita
  Route::get('/mis_citas', [ReservaController::class, 'indexReservaCliente'])->name('client.indexCitas');
  Route::get('/reservar_cita', [ReservaController::class, 'createReservaCliente'])->name('client.createCitas');
  Route::post('/reservar_cita',[ReservaController::class, 'createHoraReservaCliente'])->name('client.createHoraCitas');
  Route::post('/guardar_cita',[ReservaController::class, 'storeReservaCliente'])->name('client.storeHoraCitas');
  //-----Tabla citas
  Route::get('/modificar_eliminar_cita', [ReservaController::class, 'listCliente'])->name('client.tableCitas');

  //Rutas Mis Tratamientos
  Route::get('/mis_tratamientos', [ClienteController::class, 'indexTratamientos'])->name('client.indexTratamientos');

});