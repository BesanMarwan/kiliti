<?php

use App\Http\Controllers\Api\V1\General\GeneralController;
use App\Http\Controllers\Api\V1\General\PageController;
use App\Http\Controllers\Api\V1\General\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/get_configuration',         [GeneralController::class, 'get_configuration']);
Route::get('/get_dialysis_centers',      [GeneralController::class, 'get_dialysis_centers']);
Route::post('/rate',                     [GeneralController::class, 'rateApplication'])->middleware('auth:sanctum');
Route::get('/family-relationships',      [GeneralController::class, 'familyRelationships']);
Route::get('/get_gen_items/{item_type}', [GeneralController::class, 'get_gen_items']);

Route::get('/page/{page_id}',            [PageController::class, 'get_page']);
Route::get('/faqs',                      [PageController::class, 'get_faqs']);

//Route::post('/confirm_payment', [PaymentController::class, 'confirm_payment'])->middleware('auth:sanctum');
