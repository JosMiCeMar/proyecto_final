<?php

use App\Http\Controllers\ResponsableController;
use App\Http\Middleware\CheckResp;
use Illuminate\Support\Facades\Route;

Route::middleware([CheckResp::class, 'auth', 'verified'])->group(function () {

      //Rutas editar perfil
      Route::get('/perfil_responsable', [ResponsableController::class, 'edit'])->name('resp.profileEdit');
      Route::patch('/perfil_responsable', [ResponsableController::class, 'update'])->name('resp.profileUpdate');
});