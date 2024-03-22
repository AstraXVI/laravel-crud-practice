<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CrudController;

Route::get('/', function () {
    return view('contact_manager');
});


Route::post('/insert', [CrudController::class,'insert'])->name('insert');
Route::get('/getContact', [CrudController::class,'getContact'])->name('getData');
Route::post('/update', [CrudController::class,'update'])->name('update');
Route::post('/delete', [CrudController::class,'delete'])->name('delete');
