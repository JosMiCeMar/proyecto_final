<?php

use App\Http\Controllers\ClienteController;
use App\Http\Middleware\CheckClient;
use Illuminate\Support\Facades\Route;

Route::middleware([CheckClient::class, 'auth'])->group(function () {

});