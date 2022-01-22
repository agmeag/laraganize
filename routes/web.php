<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
Route::get("/photo-gallery", 'PhotoGalleryController@view');
Route::get("/photo-gallery/get_files", "PhotoGalleryController@getFileList");
Route::post("/photo-gallery/delete_file", "PhotoGalleryController@deleteFile");
Route::post("/photo-gallery/move-file", "PhotoGalleryController@moveFile");

Route::get("/gallery_", 'GalleryController@view');
Route::get("/gallery_/get_files", "GalleryController@getFileList");


