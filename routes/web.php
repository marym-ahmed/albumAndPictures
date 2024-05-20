<?php

use Illuminate\Support\Facades\Route;

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


use App\Http\Controllers\AlbumController;
Route::get('/albums/getAlbumIdByName', [AlbumController::class, 'getAlbumIdByName']);

Route::resource('albums', AlbumController::class);
Route::post('albums/{album}/deleteOrMovePictures', [AlbumController::class, 'deleteOrMovePictures'])->name('albums.deleteOrMovePictures');

Route::get('/', [AlbumController::class, 'index']);
