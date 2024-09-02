<?php

use App\Http\Controllers\ResponsableController;
use App\Http\Middleware\CheckResp;
use Illuminate\Support\Facades\Route;

Route::middleware([CheckResp::class, 'auth'])->group(function () {

      //Rutas editar perfil
      Route::get('/perfil_responsable', [ResponsableController::class, 'edit'])->name('resp.profileEdit');
      Route::patch('/perfilResponsable', [ResponsableController::class, 'update'])->name('resp.profileUpdate');
});