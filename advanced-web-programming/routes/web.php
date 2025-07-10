<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EncryptedFileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/profiles', [ProfileController::class, 'index']);
Route::get('/encrypted/upload', [EncryptedFileController::class, 'showUploadForm']);
Route::post('/encrypted/upload', [EncryptedFileController::class, 'upload']);
Route::get('/encrypted/list', [EncryptedFileController::class, 'list']);
Route::get('/encrypted/download/{filename}', [EncryptedFileController::class, 'download']);
