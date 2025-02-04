<?php

use App\Http\Controllers\AboutPdrrmcController;
use App\Http\Controllers\AboutPdrrmoController;
use App\Http\Controllers\OperationsCenterController;
use App\Http\Controllers\PdrrmoController;
use App\Http\Controllers\ProgramServicesController;
use App\Http\Controllers\ResourcesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HeroCarouselController;


Route::get('/admin/hero-carousel', [HeroCarouselController::class, 'index'])->name('hero-carousel.index');
Route::post('/admin/hero-carousel', [HeroCarouselController::class, 'store'])->name('hero-carousel.store');
Route::delete('/admin/hero-carousel/{carousel}', [HeroCarouselController::class, 'destroy'])->name('hero-carousel.destroy');


Route::get('/', function () {
    return view('pdrrmo-home.index');
});


// PdrrmoController
Route::get('/pdrrmo-home/index', [PdrrmoController::class, 'index'])->name('pdrrmo-home.index');
Route::get('/pdrrmo-home/edit', [PdrrmoController::class, 'edit'])->name('pdrrmo-home.edit');
Route::put('/pdrrmo-home/banner', [PdrrmoController::class, 'updateBanner'])->name('pdrrmo-home.update');
Route::put('/pdrrmo-home/carousel', [PdrrmoController::class, 'updateCarousel'])->name('pdrrmo-home.carousel');

// AboutPdrrmcController
Route::get('/about-pdrrmc/index', [AboutPdrrmcController::class, 'index'])->name('about-pdrrmc.index');


// AboutPdrrmoController
Route::get('/about-pdrrmo/index', [AboutPdrrmoController::class, 'index'])->name('about-pdrrmo.index');
Route::get('/about-pdrrmo', [AboutPDRRMOController::class, 'index']);
Route::post('/about-pdrrmo/{section}', [AboutPDRRMOController::class, 'update'])->name('about.update');

// ProgramServicesController
Route::get('/programs-services/index', [ProgramServicesController::class, 'index'])->name('programs-services.index');
Route::get('/programs-services/external-services.index', [ProgramServicesController::class, 'external'])->name('programs-services.external-services.index');
Route::get('/programs-services/internal-services.index', [ProgramServicesController::class, 'internal'])->name('programs-services.internal-services.index');

// OperationsCenter
Route::get('/operations-center/index', [OperationsCenterController::class, 'index'])->name('operations-center.index');

// ResourcesController
Route::get('/resources/index', [ResourcesController::class, 'index'])->name('resources.index');
