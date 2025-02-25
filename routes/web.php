<?php

use App\Http\Controllers\AboutPdrrmcController;
use App\Http\Controllers\AboutPdrrmoController;
use App\Http\Controllers\ActivitiesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarouselImageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactInfoController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\OperationsCenterController;
use App\Http\Controllers\PdrrmoController;
use App\Http\Controllers\ProgramServicesExternalController;
use App\Http\Controllers\ProgramServicesInternalController;
use App\Http\Controllers\RescueOperationController;
use App\Http\Controllers\ResourcesController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('pdrrmo-home.index');
});

Route::get('/super-admin-login', function () {
    return view('super-admin.login');
});

Route::get('dashboard', function () {
    return view('pdrrmo-home.index');
})->name('dashboard')->middleware('auth');

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// SuperAdminController
Route::post('/super-admin-login', 'SuperAdminController@authenticate')->name('super-admin.authenticate');

// CarouselImageController
Route::post('/carousel-images', [CarouselImageController::class, 'store'])->name('carousel-image.store');
Route::delete('/carousel-images/delete', [CarouselImageController::class, 'delete'])->name('carousel-images.delete');

// PdrrmoController
Route::get('/pdrrmo-home', [PdrrmoController::class, 'index'])->name('pdrrmo-home.index');
Route::post('/pdrrmo-home/upload', [PdrrmoController::class, 'upload'])->name('pdrrmo-home.upload');
Route::get('/pdrrmo-home/edit/{id}', [PdrrmoController::class, 'edit'])->name('pdrrmo-home.edit');
Route::put('/pdrrmo-home/update/{id}', [PdrrmoController::class, 'update'])->name('pdrrmo-home.update');
Route::delete('/pdrrmo-home/destroy{id}', [PdrrmoController::class, 'destroy'])->name('pdrrmo-home.destroy');
Route::post('/programs-services/upload', [ProgramServicesExternalController::class, 'store'])->name('programs-services.external-services.store');

// ProgramServicesExternalController
Route::get('/programs-services/external', [ProgramServicesExternalController::class, 'index'])->name('programs-services.external-services.index');
Route::post('/programs-services/external/upload', [ProgramServicesExternalController::class, 'store'])->name('programs-services.external.store');
Route::put('/programs-services/external/{id}', [ProgramServicesExternalController::class, 'update'])->name('programs-services.external.update');
Route::delete('/programs-services/external/{id}', [ProgramServicesExternalController::class, 'destroy'])->name('programs-services.external.destroy');

// ProgramServicesInternalController
Route::get('/programs-services/internal', [ProgramServicesInternalController::class, 'index'])->name('programs-services.internal-services.index');
Route::post('/programs-services/internal/upload', [ProgramServicesInternalController::class, 'store'])->name('programs-services.internal.store');
Route::put('/programs-services/internal/{id}', [ProgramServicesInternalController::class, 'update'])->name('programs-services.internal.update');
Route::delete('/programs-services/internal/{id}', [ProgramServicesInternalController::class, 'destroy'])->name('programs-services.internal.destroy');

// OperationsCenter
Route::get('/operations-center/index', [OperationsCenterController::class, 'index'])->name('operations-center.index');

// ResourcesController
Route::get('/resources/index', [ResourcesController::class, 'index'])->name('resources.index');

// FileUploadController
Route::post('/file/upload', [FileUploadController::class, 'upload'])->name('file.upload.submit');
Route::delete('/file/{id}', [FileUploadController::class, 'destroy'])->name('file.delete');

// ActivitiesController
Route::post('/activities', [ActivitiesController::class, 'store'])->name('activities.store');
Route::get('/activities/{id}', [ActivitiesController::class, 'show'])->name('activities.show');
Route::post('/activities/delete', [ActivitiesController::class, 'deleteImages'])->name('activities.delete');

// AboutPdrrmcController
Route::get('/about-pdrrmc/index', [AboutPdrrmcController::class, 'index'])->name('about-pdrrmc.index');
Route::get('/about-pdrrmc', [AboutPdrrmcController::class, 'index']);
Route::post('/about-pdrrmc/{section}', [AboutPdrrmcController::class, 'update'])->name('about-pdrrmc.update');

// AboutPdrrmoController
Route::get('/about-pdrrmo/index', [AboutPdrrmoController::class, 'index'])->name('about-pdrrmo.index');
Route::get('/about-pdrrmo', [AboutPdrrmoController::class, 'index']);
Route::post('/about-pdrrmo/{section}', [AboutPdrrmoController::class, 'update'])->name('about-pdrrmo.update');

// ContactController
Route::get('/contact/index', [ContactController::class, 'index'])->name('contact.index');

// RescueOperationController
Route::get('/programs-services/rescue-operations', [RescueOperationController::class, 'index'])->name('programs-services.rescue-operations.index');
Route::post('/programs-services/rescue-operations/store', [RescueOperationController::class, 'store'])->name('programs-services.rescue-operations.store');
Route::post('/programs-services/rescue-operations/content', [RescueOperationController::class, 'content'])->name('programs-services.rescue-operations.content');
Route::put('/programs-services/rescue-operations/{id}', [RescueOperationController::class, 'update'])->name('programs-services.rescue-operations.update');
Route::get('/programs-services/rescue-operations/{category}', [RescueOperationController::class, 'show'])->name('programs-services.rescue-operations.show');
Route::delete('/programs-services/rescue-operations/{id}', [RescueOperationController::class, 'destroy'])->name('programs-services.rescue-operations.destroy');
Route::delete('/programs-services/rescue-operations/{id}', [RescueOperationController::class, 'contentDestroy'])->name('programs-services.rescue-operations.destroy');

// OperationsCenter
Route::get('/operations-center/index', [OperationsCenterController::class, 'index'])->name('operations-center.index');
Route::resource('operation-center', OperationsCenterController::class);

// ContactController
Route::post('/contact/store', [ContactController::class, 'store'])->name('contact.store');
Route::get('/contact/edit/{id}', [ContactController::class, 'edit'])->name('contact.edit');
Route::put('/contact/update/{id}', [ContactController::class, 'update'])->name('contact.update');
Route::delete('/contact/{id}', [ContactController::class, 'destroy'])->name('contact.destroy');

// VideoController
Route::post('/video/store', [VideoController::class, 'store'])->name('video.store');

// ContactInfoController
Route::get('/contact-info', [ContactInfoController::class, 'show'])->name('contact-info.show');
Route::put('/contact-info/{id}', [ContactInfoController::class, 'update'])->name('contact-info.update');
Route::post('/contact-info', [ContactInfoController::class, 'store'])->name('contact-info.store');
Route::get('/contact-info/index', [ContactInfoController::class, 'index'])->name('contact-info.index');
