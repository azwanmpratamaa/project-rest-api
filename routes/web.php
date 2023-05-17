<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeminjamansController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [PeminjamansController::class, 'createToken']);

Route::get('/peminjamans', [PeminjamansController::class, 'index']);
Route::post('/peminjamans/store', [PeminjamansController::class, 'store']);
Route::get('/peminjamans/{id}', [PeminjamansController::class, 'show']);
Route::patch('/peminjamans/{id}/update', [PeminjamansController::class, 'update']);
Route::delete('/peminjamans/{id}/delete', [PeminjamansController::class, 'destroy']);
Route::get('/peminjamans/show/trash', [PeminjamansController::class, 'trash']);
Route::get('/peminjamans/show/trash/{id}', [PeminjamansController::class, 'restore']);
Route::get('/peminjamans/show/trash/permanent/{id}', [PeminjamansController::class, 'permanentDelete']);