<?php

use App\Http\Controllers\ClienteController;
use App\Http\Middleware\CheckClient;
use Illuminate\Support\Facades\Route;

Route::middleware([CheckClient::class, 'auth'])->group(function () {
  
    //Rutas editar perfil
  Route::get('/perfil_cliente', [ClienteController::class, 'edit'])->name('client.profileEdit');
  Route::patch('/perfil_cliente', [ClienteController::class, 'update'])->name('client.profileUpdate');
});