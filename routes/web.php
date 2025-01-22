<?php

use App\Http\Controllers\AboutPdrrmcController;
use App\Http\Controllers\AboutPdrrmoController;
use App\Http\Controllers\OperationsCenterController;
use App\Http\Controllers\PdrrmoController;
use App\Http\Controllers\ProgramServicesController;
use App\Http\Controllers\ResourcesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pdrrmo-home.index');
});

// PdrrmoController
Route::get('/pdrrmo-home/index', [PdrrmoController::class, 'index'])->name('pdrrmo-home.index');

// AboutPdrrmcController
Route::get('/about-pdrrmc/index', [AboutPdrrmcController::class, 'index'])->name('about-pdrrmc.index');

// AboutPdrrmoController
Route::get('/about-pdrrmo/index', [AboutPdrrmoController::class, 'index'])->name('about-pdrrmo.index');

// ProgramServicesController
Route::get('/programs-services/index', [ProgramServicesController::class, 'index'])->name('programs-services.index');

// OperationsCenter
Route::get('/operations-center/index', [OperationsCenterController::class, 'index'])->name('operations-center.index');

// ResourcesController
Route::get('/resources/index', [ResourcesController::class, 'index'])->name('resources.index');
