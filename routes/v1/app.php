<?php

use App\Http\Controllers\Api\V1\General\GeneralController;
use App\Http\Controllers\Api\V1\General\PageController;
use App\Http\Controllers\Api\V1\General\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/get_configuration',    [GeneralController::class, 'get_configuration']);
Route::get('/get_dialysis_centers', [GeneralController::class, 'get_dialysis_centers']);

Route::get('/page/{page_id}', [PageController::class, 'get_page']);

//Route::post('/confirm_payment', [PaymentController::class, 'confirm_payment'])->middleware('auth:sanctum');
