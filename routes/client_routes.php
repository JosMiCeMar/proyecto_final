<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ReservaController;
use App\Http\Middleware\CheckClient;
use Illuminate\Support\Facades\Route;

Route::middleware([CheckClient::class, 'auth', 'verified'])->group(function () {
  
  //RUTAS EDITAR PERFIL
  Route::get('/perfil_cliente', [ClienteController::class, 'edit'])->name('client.profileEdit');
  Route::patch('/perfil_cliente', [ClienteController::class, 'update'])->name('client.profileUpdate');

  //RUTAS MIS CITAS
  //-----Reservar cita
  Route::get('/mis_citas', [ReservaController::class, 'indexReservaCliente'])->name('client.indexCitas');
  Route::get('/reservar_cita', [ReservaController::class, 'createReservaCliente'])->name('client.createCitas');
  Route::post('/reservar_cita',[ReservaController::class, 'createHoraReservaCliente'])->name('client.createHoraCitas');
  Route::post('/guardar_cita',[ReservaController::class, 'storeReservaCliente'])->name('client.storeHoraCitas');
  //-----Tabla modificar-eliminar citas
  Route::get('/modificar_eliminar_cita', [ReservaController::class, 'listCliente'])->name('client.tableCitas');
  Route::post('/modificar_eliminar_cita', [ReservaController::class, 'deleteReservaCliente'])->name('client.delReser');
  Route::get('/modificar_cita/{id}', [ReservaController::class, 'modReservaCliente'])->name('client.modReser');
  Route::post('/cita_modificada', [ReservaController::class, 'modHoraCliente'])->name('client.modHoraReser');

  //RUTAS MIS TRATAMIENTOS
  Route::get('/mis_tratamientos', [ClienteController::class, 'indexTratamientos'])->name('client.indexTratamientos');
  Route::get('/ultimos_tratamientos', [ClienteController::class, 'ultimosTratamientos'])->name('client.ultimosTratamientos');
  Route::get('/informe_tratamientos', [ClienteController::class, 'informeTratamientos'])->name('client.informeTratamientos');
  Route::get('/personalizar_informes', [ClienteController::class, 'formularioPersonalizado'])->name('client.personalizarInforme');
  Route::post('/perzonalizar_informes', [ClienteController::class, 'mostrarInformePersonalizado'])->name('client.mostrarInforme');

});