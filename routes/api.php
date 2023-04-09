<?php

use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\Api\VariacionController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::apiResource('producto', ProductoController::class);

//Route::get('variacion/{producto}', [VariacionController::class, 'index']);
Route::apiResource('variacion', VariacionController::class);



// Route::get('producto', [ProductoController::class, 'index']);
// Route::post('producto', [ProductoController::class, 'store']);
// Route::get('producto/{producto}', [ProductoController::class, 'show']);
// Route::put('producto/{producto}', [ProductoController::class, 'update']);


