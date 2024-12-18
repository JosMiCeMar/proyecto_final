<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\InformeController;
use App\Http\Controllers\ReservaController;
use App\Http\Middleware\CheckClient;
use Illuminate\Support\Facades\Route;

Route::middleware([CheckClient::class, 'auth', 'verified'])->group(function () {
  
  //RUTAS EDITAR PERFIL
  Route::get('/perfil_cliente', [ClienteController::class, 'edit'])->name('client.profileEdit');
  Route::patch('/perfil_cliente', [ClienteController::class, 'update'])->name('client.profileUpdate');

  //RUTAS MIS CITAS
  //-----Reservar cita
  Route::get('/mis_citas', [ReservaController::class, 'indexCliente'])->name('client.indexCitas');
  Route::get('/reservar_cita', [ReservaController::class, 'createCliente'])->name('client.createCitas');
  Route::post('/reservar_cita',[ReservaController::class, 'createHoraCliente'])->name('client.createHoraCitas');
  Route::post('/guardar_cita',[ReservaController::class, 'storeCliente'])->name('client.storeHoraCitas');
  //-----Tabla modificar-eliminar citas
  Route::get('/modificar_eliminar_cita', [ReservaController::class, 'listCliente'])->name('client.tableCitas');
  Route::post('/modificar_eliminar_cita', [ReservaController::class, 'deleteCliente'])->name('client.delReser');
  Route::get('/modificar_cita/{id}', [ReservaController::class, 'modCliente'])->name('client.modReser');
  Route::post('/cita_modificada', [ReservaController::class, 'modHoraCliente'])->name('client.modHoraReser');

  //RUTAS MIS TRATAMIENTOS
  Route::get('/mis_tratamientos', [InformeController::class, 'clienteIndexTratamientos'])->name('client.indexTratamientos');
  Route::get('/ultimos_tratamientos', [InformeController::class, 'clienteUltimosTratamientos'])->name('client.ultimosTratamientos');
  Route::get('/informe_tratamientos', [InformeController::class, 'clienteInformeTratamientos'])->name('client.informeTratamientos');
  Route::get('/personalizar_informes', [InformeController::class, 'clienteFormularioPersonalizado'])->name('client.personalizarInforme');
  Route::post('/informe_personalizado', [InformeController::class, 'clienteInformePersonalizado'])->name('client.mostrarInforme');
});