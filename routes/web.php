<?php

use App\Http\Controllers\EmailTemplatesController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\EmailTemplatesController::class, 'index'])->name('dashboard');
    Route::delete('/dashboard', [App\Http\Controllers\EmailTemplatesController::class, 'destroy']);
    Route::prefix('email-templates')->group(function () {
        Route::get('/create', [App\Http\Controllers\EmailTemplatesController::class, 'create'])->name('email-templates.create');
        Route::post('/store', [App\Http\Controllers\EmailTemplatesController::class, 'store'])->name('email-templates.store');
        Route::get('/edit/{id}', [App\Http\Controllers\EmailTemplatesController::class, 'edit'])->name('email-templates.edit');
        Route::post('/update', [App\Http\Controllers\EmailTemplatesController::class, 'update'])->name('email-templates.update');
        Route::delete('/delete/{id}', [App\Http\Controllers\EmailTemplatesController::class, 'destroy'])->name('email-templates.delete');
    });
});
