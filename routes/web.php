<?php

use App\Http\Controllers\Website\DoctorDashboard\DashboardController;
use App\Http\Controllers\Website\DoctorDashboard\DoctorController;
use App\Http\Controllers\Website\DoctorDashboard\LoginController;
use App\Jobs\SendUserNotification;
use App\Models\MedicationLog;
use App\Models\PatientMedication;
use App\Models\Symptom;
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

    $symptoms = [
        [
            'name' => ['ar'=>'ألم في الصدر','en'=> 'pain'],
            'description' => ['ar'=>'شعور بألم أو ضغط في منطقة الصدر، ويُعد من الأعراض الحرجة التي تتطلب انتباهًا طبيًا فوريًا.','en'=>''],
            'is_critical' => 1,
            'status' => 'enabled',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => ['ar'=>'دوخة أو دوار','en'=>'dizziness'],
            'description' => ['ar'=>'إحساس عدم الاتزان أو الدوار الخفيف أو الشديد.','en'=>''],
            'is_critical' => 0,
            'status' => 'enabled',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => ['ar'=>'غثيان','en'=>'nausea'],
            'description' => ['ar'=>'رغبة في القيء أو شعور بالاضطراب في المعدة.','en'=>''],
            'is_critical' => 0,
            'status' => 'enabled',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => ['ar'=>'ضيق في التنفس','en'=>'shortness of breath'],
            'description' => ['ar'=>'صعوبة أو ضيق في التنفس، ويُعد من المؤشرات الحيوية الحرجة للمريض.','en'=>''],
            'is_critical' => 1,
            'status' => 'enabled',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => ['ar'=>'ارتفاع في الحرارة','en'=>''],
            'description' => ['ar'=>'ارتفاع درجات حرارة الجسم عن المعدل الطبيعي (حمى).','en'=>''],
            'is_critical' => 0,
            'status' => 'enabled',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => ['ar'=>'ألم في الرأس','en'=>'headache'],
            'description' =>['ar'=>'صداع أو ألم مستمر في منطقة الرأس.','en'=>''],
            'is_critical' => 0,
            'status' => 'enabled',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => ['ar'=>'إرهاق شديد','en'=>'severe fatigue'],
            'description' => ['ar'=>'شعور بالتعب العام والإرهاق وقلة الطاقة الجسدية.','en'=>''],
            'is_critical' => 0,
            'status' => 'enabled',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => ['ar'=>'أخرى','en'=>'Other'],
            'description' => ['ar'=>'أعراض أخرى غير مدرجة في القائمة.','en'=>''],
            'is_critical' => 0,
            'status' => 'enabled',
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ];
    for($i=0 ; $i< count($symptoms);$i++){
        Symptom::findOrFail($i+1)->update($symptoms[$i]);
    }
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
