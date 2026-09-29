<?php

use App\Http\Controllers\Website\DoctorDashboard\DashboardController;
use App\Http\Controllers\Website\DoctorDashboard\DoctorController;
use App\Http\Controllers\Website\DoctorDashboard\LoginController;
use App\Jobs\SendUserNotification;
use App\Models\MedicationLog;
use App\Models\PatientMedication;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MediaController;

//Route::get('/', function () {
//    return ['Laravel' => app()->version()];
//});

require __DIR__.'/auth.php';

Route::get('/icons', [\App\Http\Controllers\IconsController::class,'index']);
Route::view('/', 'welcome');


/**************************************** Start Doctors Dashboard Route ****************************************/
//Route::prefix('portal/doctor')->name('doctor.')->group(function () {
//
//    Route::get('/login',          [LoginController::class, 'index'])->middleware('guest:web')->name('login');
//    Route::post('/login',         [LoginController::class, 'login'])->middleware('guest:web');
//    Route::middleware(['auth:web','doctor'])->group(callback: function () {
//        Route::get('logout',         [LoginController::class, 'logout'])->name('doctors.logout');
//           Route::get('/',           [DashboardController::class, 'index'])->name('doctors.dashboard');
////        Route::post('save_token', [DoctorController::class, 'save_token'])->name('doctore.save_token');
////
////    });
////
//    });
//});
/**************************************** End Doctors Dashboard Route ****************************************/


Route::get('/test', function(){
     $now  = now()->format('H:i');
    $patient_medicines = PatientMedication::whereStatus('active')
        ->whereJsonContains('reminder_times', $now)
        ->with(['medication'])
        ->get();
        return $patient_medicines;
    });


Route::get('/times', function() {
    $now = now()->format('H:i');
    $nowBeforeMinutes = now()->subMinutes(5)->format('H:i');

    return [
        'now' => $now,
        'nowTeST' => $nowBeforeMinutes,
    ];
});


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
