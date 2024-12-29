<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MultipleFileUploadController;

Route::get('multiple-file-upload', [ MultipleFileUploadController::class, 'getFileUploadForm' ])->name('get.multipleFileupload');
Route::post('multiple-file-upload', [ MultipleFileUploadController::class, 'store' ])->name('store.multiple-files');
Route::post('/multiple-file-upload/store-cache',   [MultipleFileUploadController::class, 'storeCache'])->name('store.multiple-files.catche');;
