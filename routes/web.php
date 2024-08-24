<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaterkitController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\DisplayController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth::routes();
Auth::routes();

Route::get('/', [DisplayController::class, 'about'])->name('about.display');
Route::get('/about', [DisplayController::class, 'about'])->name('about.display');
Route::get('/certificates', [DisplayController::class, 'certificates'])->name('certificates.display');
Route::get('/chatbot', [DisplayController::class, 'chatbot'])->name('chatbot.display');

Route::group(['prefix'=>'admin'], function(){
    Route::get('about', [AboutController::class, 'index'])->name('about');
    Route::post('about', [AboutController::class, 'store'])->name('about.update');
    
    Route::get('certificates', [CertificateController::class, 'index'])->name('certificates');
    Route::get('certificates/add', [CertificateController::class, 'create'])->name('certificates.add');
    Route::get('certificates/index', [CertificateController::class, 'getData'])->name('certificates.data');
    Route::get('certificates/edit/{id}', [CertificateController::class, 'edit'])->name('certificates.edit');
    Route::post('certificates', [CertificateController::class, 'store'])->name('certificates.store');
    Route::post('certificates/update/{id}', [CertificateController::class, 'update'])->name('certificates.update');
    Route::delete('certificates/delete/{id}', [CertificateController::class, 'destroy'])->name('certificates.delete');
});
