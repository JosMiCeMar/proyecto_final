<?php

use App\Http\Controllers\ResponsableController;
use App\Http\Middleware\CheckResp;
use Illuminate\Support\Facades\Route;

Route::middleware([CheckResp::class, 'auth'])->group(function () {

});