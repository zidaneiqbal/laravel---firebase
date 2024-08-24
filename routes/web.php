<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaterkitController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\PortfolioController;
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
Route::get('/portfolio', [DisplayController::class, 'portfolio'])->name('portfolio.display');
Route::get('/chatbot', [DisplayController::class, 'chatbot'])->name('chatbot.display');
Route::post('/chat/gemini-response', [DisplayController::class, 'getGeminiResponse'])->name('chat.gemini-response');

Route::group(['prefix'=>'admin'], function(){
    Route::get('about', [AboutController::class, 'index'])->name('about');
    Route::post('about', [AboutController::class, 'store'])->name('about.update');
    
    Route::group(['prefix'=>'certificates'], function() {
        Route::get('/', [CertificateController::class, 'index'])->name('certificates');
        Route::get('/add', [CertificateController::class, 'create'])->name('certificates.add');
        Route::get('/index', [CertificateController::class, 'getData'])->name('certificates.data');
        Route::get('/edit/{id}', [CertificateController::class, 'edit'])->name('certificates.edit');
        Route::post('/', [CertificateController::class, 'store'])->name('certificates.store');
        Route::post('/update/{id}', [CertificateController::class, 'update'])->name('certificates.update');
        Route::delete('/delete/{id}', [CertificateController::class, 'destroy'])->name('certificates.delete');
    });

    Route::group(['prefix'=>'portfolio'], function() {
        Route::get('/', [PortfolioController::class, 'index'])->name('portfolio');
        Route::get('/add', [PortfolioController::class, 'create'])->name('portfolio.add');
        Route::get('/index', [PortfolioController::class, 'getData'])->name('portfolio.data');
        Route::get('/edit/{id}', [PortfolioController::class, 'edit'])->name('portfolio.edit');
        Route::post('/', [PortfolioController::class, 'store'])->name('portfolio.store');
        Route::post('/update/{id}', [PortfolioController::class, 'update'])->name('portfolio.update');
        Route::delete('/delete/{id}', [PortfolioController::class, 'destroy'])->name('portfolio.delete');
    });
});
