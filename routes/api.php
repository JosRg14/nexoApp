<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ServiceController;

Route::post('/servicios', function () {
    return response()->json(['ok' => true]);
});
Route::get('/servicios', [ServiceController::class, 'index']);