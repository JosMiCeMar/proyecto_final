<?php

use App\Http\Controllers\AdministradoreController;
use App\Http\Controllers\CodRegistroController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//En caso de no existir la ruta, retorna al inicio
Route::fallback(function () {
    return redirect('/');
});

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

Route::get('/sin_acceso', function(){
    return Inertia::render('SinAcceso');
})->name('sin_acceso');


//Ruta código de registro
Route::get('/registro', [CodRegistroController::class, 'insertCode'])->name('cod_registro.check');
Route::post('/registro', [CodRegistroController::class, 'checkCode']);


//Requires con los archivos con rutas con groups de middlewares
require __DIR__ . '/auth.php';
require __DIR__ . '/reg_code_routes.php';
require __DIR__ . '/admin_routes.php';