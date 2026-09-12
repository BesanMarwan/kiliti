<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MediaController;

//Route::get('/', function () {
//    return ['Laravel' => app()->version()];
//});

require __DIR__.'/auth.php';

Route::get('/icons', [\App\Http\Controllers\IconsController::class,'index']);
Route::view('/', 'welcome');



//======================================================================================================
//                   Others ROUTES
//======================================================================================================
Route::post('uploadFile', [MediaController::class,'saveFileJson']);
Route::post('uploadFiles', [MediaController::class,'saveMultiFileJson']);
Route::post('uploadFilesNew', [MediaController::class,'saveMultiFileJsonNew']);

//Route::prefix('commands/')->middleware(['auth:admin'])->group(function () {
//    Route::get('migrate',"ClosureController@migrate");
//    Route::get('test',"ClosureController@test");
//    Route::get('generate_models',"ClosureController@generate_models");
//    Route::get('generate_docs',"ClosureController@generate_docs");
//    Route::get('restart_queue',"ClosureController@restart_queue");
//
//    Route::get('clear',"ClosureController@clearView");
//    Route::get('changeKey',"ClosureController@changeKey");
//    Route::get('ChangeToProduction',"ClosureController@ChangeToProduction");
//    Route::get('ChangeToDevelopment',"ClosureController@ChangeToDevelopment");
//
//
//});
