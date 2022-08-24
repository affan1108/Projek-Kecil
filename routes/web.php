<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
Route::group(['middelware' => ['example']], function() {
    Route::get('login', [AuthController::class, 'index'])->name('login');
    Route::get('login_admin', [AuthController::class, 'login_admin'])->name('login_admin');
    Route::post('login', [AuthController::class, 'processLogin']); 
    Route::post('login_admin', [AuthController::class, 'processLoginAdmin']); 
    Route::get('register', [AuthController::class, 'registration'])->name('register');
    Route::post('register', [AuthController::class, 'processRegister']); 
    Route::get('layout_main', [AuthController::class, 'layoutMain'])->name('layout_main');
    Route::get('home', [AuthController::class, 'home'])->name('home');
    Route::get('home_admin', [AuthController::class, 'home_admin'])->name('home_admin');
    Route::get('upload', [AuthController::class, 'upload'])->name('upload');
    Route::get('diagram', [AuthController::class, 'diagram'])->name('diagram');
    Route::get('list_mahasiswa', [AuthController::class, 'list'])->name('list_mahasiswa');
    Route::get('mahasiswa', [AuthController::class, 'mahasiswa'])->name('mahasiswa');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('mahasiswa_add', [AuthController::class, 'add']);
    Route::post('mahasiswa_add', [AuthController::class, 'processAdd']);
    Route::get('mahasiswa_update/{id}', [AuthController::class, 'update']);
    Route::post('mahasiswa_update/{id}', [AuthController::class, 'processUpdate']);
    Route::get('mahasiswa/delete/{id}', [AuthController::class, 'delete']);
    Route::get('pdf', [AuthController::class, 'pdf']);
    Route::get('/upload', [AuthController::class, 'upload']);
    Route::post('/upload/proses', [AuthController::class, 'proses_upload']);
    Route::get('dokumen', [AuthController::class, 'dokumen'])->name('dokumen');
    Route::get('dokumen/delete/{id}', [AuthController::class, 'hapus']);
    Route::get('/download/{file}', [AuthController::class, 'download']);
    Route::get('/view/{id}', [AuthController::class, 'view']);
});

Route::get('logout', [AuthController::class, 'logout'])->name('logout');



