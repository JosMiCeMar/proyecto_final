<?php

use App\Http\Controllers\AdministradoreController;
use App\Http\Controllers\CodRegistroController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//Páginas públicas
Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('/quienes_somos', function () {
    return Inertia::render('Somos');
})->name('somos');

Route::get('/trabaja_con_nosotros', function () {
    return Inertia::render('Trabaja');
})->name('trabaja');

Route::get('/centros_asociados', function () {
    return Inertia::render('Centros');
})->name('centros');

//Ruta para pruebas --- ELIMINAR AL TERMINAR
Route::get('/pruebas', [AdministradoreController::class, 'pruebas'])->name('pruebas');

//Ruta código de registro
Route::get('/registro', [CodRegistroController::class, 'insertCode'])->name('cod_registro.check');
Route::post('/registro', [CodRegistroController::class, 'checkCode']);

//Ruta panel de usuario --- INTENTAR MOVER A /routes/auth.php
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//Rutas editar perfil ---- INTENTAR MOVER A /routes/auth.php
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Requires con los archivos con rutas con groups de middlewares
require __DIR__ . '/auth.php';
require __DIR__ . '/regcode.php';
