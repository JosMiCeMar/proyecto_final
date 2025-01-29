<?php

use App\Http\Controllers\CodRegistroController;
use App\Http\Controllers\InformeController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\ResponsableController;
use App\Http\Middleware\CheckResp;
use Illuminate\Support\Facades\Route;

Route::middleware([CheckResp::class, 'auth', 'verified','throttle:user-actions'])->group(function () {

      //Rutas editar perfil
      Route::get('/perfil_responsable', [ResponsableController::class, 'edit'])->name('resp.profileEdit');
      Route::patch('/perfil_responsable', [ResponsableController::class, 'update'])->name('resp.profileUpdate');

      //Rutas de codigos de registro
      Route::get('/respon_codigo_registro', [CodRegistroController::class, 'indexCodeRespon'])->name('respon.indexCode');
      Route::get('/respon_gen_codigo_registro', [CodRegistroController::class, 'createCodeRespon'])->name('respon.createCode');
      Route::post('/respon_gen_codigo_registro', [CodRegistroController::class, 'storeCodeRespon'])->name('respon.storeCode');
      Route::get('/respon_lista_codigo_registro', [CodRegistroController::class, 'listCodeRespon'])->name('respon.listCode');

      //Rutas de informes
      Route::get('/respon_informes', [InformeController::class, 'responIndexInforme'])->name('respon.indexInforme');
      Route::get('/respon_informes_ultimo_mes', [InformeController::class, 'responInformeUltimoMes'])->name('respon.ultimoMesInforme');
      Route::get('/respon_total_informes', [InformeController::class, 'responInformeGeneral'])->name('respon.informeGeneral');
      Route::get('/respon_personalizar_informes', [InformeController::class, 'responFormularioPersonalizado'])->name('respon.personalizarInforme');
      Route::post('/respon_informe_personalizado', [InformeController::class, 'responInformePersonalizado'])->name('respon.mostrarInforme');

      //Rutas gestión reservas
      Route::get('/respon_reservas', [ReservaController::class, 'indexRespon'])->name('respon.indexReservas');
      Route::get('/respon_lista_reservas', [ReservaController::class, 'listRespon'])->name('respon.listReservas');
      Route::get('/respon_mod_dia_reservas/{id}', [ReservaController::class, 'formRespon'])->name('respon.formReservas');
      Route::get('/respon_mostrar_reservas/{id}', [ReservaController::class, 'showRespon'])->name('respon.showReservas');
      Route::post('/respon_eliminar_reserva', [ReservaController::class, 'delRespon'])->name('respon.delReservas');
      Route::get('/respon_modificar_reserva/{id_dia}/{id_reserva}', [ReservaController::class, 'modrespon'])->name('respon.modReservas');
      Route::post('/respon_modificar_reserva', [ReservaController::class, 'modHourRespon'])->name('respon.modHourReservas');
      Route::get('/respon_lista_pasadas', [ReservaController::class, 'listPastRespon'])->name('respon.listPastReservas');
      Route::get('/respon_mostrar_reservas_pasadas/{id}', [ReservaController::class, 'showPastRespon'])->name('respon.showPastReservas');
});
