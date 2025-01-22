<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdrrmoController;

Route::get('/', function () {
    return view('pdrrmo-home.index');
});

Route::get('/pdrrmo-home/index', [PdrrmoController::class, 'index'])->name('pdrrmo-home.index');