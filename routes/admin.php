<?php

use App\Http\Controllers\Admin\AdminsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CenterController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DialysisSessionManagement\DialysisSessionController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\FAQController;
use App\Http\Controllers\Admin\GeneralDataController;
use App\Http\Controllers\Admin\GLobalNotificationController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\MedicationManagement\MedicationController;
use App\Http\Controllers\Admin\MedicationManagement\PatientMedicationController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SMSController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(
    [
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){
Route::get('/login',         [LoginController::class,'index'])->middleware('guest:admin')->name('admin.login');
Route::post('/login',        [LoginController::class,'login'])->middleware('guest:admin');
Route::middleware(['auth:admin'])->group(callback: function () {
    Route::get('logout',      [LoginController::class,'logout'])->name('admin.logout');
    Route::get('/',           [DashboardController::class,'index'])->name('admin.dashboard');
    Route::post('save_token', [AdminsController::class,'save_token'])->name('admin.save_token');




//=====================================================================================================
//                   Admin ROUTRS
//=====================================================================================================
        Route::prefix('admins/')->middleware('permission:admins.view,admin')->group(function () {
            Route::get('',    [AdminsController::class, 'index'])->name('system.admins.index');
            Route::get('create', [AdminsController::class, 'showCreateView'])->middleware('permission:admins.create,admin')->name('system.admins.create');
            Route::post('create', [AdminsController::class, 'store'])->middleware('permission:admins.create,admin')->name('system.admins.store');
            Route::get('update/{id}', [AdminsController::class, 'showUpdateView'])->middleware('permission:admins.edit,admin')->name('system.admins.update');
            Route::post('update/{id}', [AdminsController::class, 'update'])->middleware('permission:admins.edit,admin')->name('system.admins.updateAdmin');
            Route::get('password/{id}', [AdminsController::class, 'showPasswordView'])->middleware('permission:admins.edit,admin')->name('system.admins.password');
            Route::post('password/{id}', [AdminsController::class, 'password'])->middleware('permission:admins.edit,admin')->name('system.admins.updatePassword');
            Route::post('delete', [AdminsController::class, 'delete'])->middleware('permission:admins.delete,admin')->name('system.admins.delete');
            Route::post('update-fcm-token', [AdminsController::class, 'saveFcmToken'])->name('system.admins.update.fcm.token');
        });
        Route::prefix('profile')->group(function () {
            Route::get('', [AdminsController::class, 'showProfileView'])->name('system.admins.profile');
            Route::post('do_update', [AdminsController::class, 'profile'])->name('system.admins.do.profile');

            Route::get('showpassword', [AdminsController::class, 'showProfilePasswordView'])->name('system.admins.profile.password');
            Route::post('updatepassword', [AdminsController::class, 'profilePassword'])->name('system.admins.do.profile.password');

            Route::get('get_notifications', [AdminsController::class, 'get_notifications'])->name('system.admins.get_notifications');

        });


//=====================================================================================================
//                   ROLE ROUTRS
//=====================================================================================================
        Route::prefix('roles/')->middleware('permission:admins.edit,admin')->group(function () {
            Route::get('', [RoleController::class, 'index'])->name('system.roles.index');
            Route::get('create', [RoleController::class, 'showCreateView'])->name('system.roles.create');
            Route::post('create', [RoleController::class, 'create']);
            Route::get('update/{id}', [RoleController::class, 'showUpdateView'])->name('system.roles.update');
            Route::post('update/{id}', [RoleController::class, 'Update']);
            Route::post('delete', [RoleController::class, 'delete'])->name('system.roles.delete');
        });


//=====================================================================================================
//                   settings ROUTRS
//=====================================================================================================
        Route::prefix('settings/')->middleware('permission:settings.edit,admin')->group(function () {
            Route::get('', [SettingsController::class, 'index'])->name('system.settings.index');
            Route::post('save', [SettingsController::class, 'save'])->name('system.settings.save');
        });


//=====================================================================================================
//                   users ROUTRS
//=====================================================================================================
        Route::prefix('users/')->middleware('permission:users.view,admin')->group(function () {
            Route::get('', [UserController::class, 'index'])->name('system.users.index');
            Route::get('/details/{id}', [UserController::class, 'details'])->name('system.users.details');
            Route::post('delete', [UserController::class, 'delete'])->middleware('permission:users.delete,admin')->name('system.users.delete');
            Route::post('/notActivate', [UserController::class, 'deactivate'])->name('system.users.deactivate');
            Route::post('/activate', [UserController::class, 'activate'])->name('system.users.activate');
            Route::get('/send-msg/{id}', [UserController::class, 'sendMsgView'])->name('system.users.sendMsgView');
            Route::post('/send-msg/{id}', [UserController::class, 'sendMsg'])->name('system.users.sendMsg');
        });



//=====================================================================================================
//                   Dialysis Centers ROUTRS
//=====================================================================================================

    Route::prefix('centers/')->middleware('permission:dialysis_centers.view,admin')->group(function () {
        Route::get('',                 [CenterController::class, 'index'])->name('system.centers.index');
        Route::get('/details/{id}',    [CenterController::class, 'details'])->name('system.centers.details');
//        Route::post('delete',          [CenterController::class, 'delete'])->middleware('permission:dialysis_centers.delete,admin')->name('system.centers.delete');
        Route::post('/notActivate',    [CenterController::class, 'deactivate'])->name('system.centers.deactivate');
        Route::post('/activate',       [CenterController::class, 'activate'])->name('system.centers.activate');
        Route::post('/closed',         [CenterController::class, 'temporarilyClosed'])->name('system.centers.temporarily_closed');
        Route::get('create',           [CenterController::class, 'showCreateView'])->middleware('permission:dialysis_centers.create,admin')->name('system.centers.create');
        Route::post('create',          [CenterController::class, 'store'])->middleware('permission:dialysis_centers.create,admin')->name('system.centers.store');
        Route::get('update/{id}',      [CenterController::class, 'showUpdateView'])->middleware('permission:dialysis_centers.edit,admin')->name('system.centers.update');
        Route::post('update/{id}',     [CenterController::class, 'update'])->middleware('permission:dialysis_centers.edit,admin')->name('system.centers.updateAdmin');

    });



//=====================================================================================================
//                   Doctors ROUTRS
//=====================================================================================================
    Route::prefix('doctors/')->middleware('permission:doctors.view,admin')->group(function () {
        Route::get('',    [DoctorController::class, 'index'])->name('system.doctors.index');
        Route::get('create', [DoctorController::class, 'showCreateView'])->middleware('permission:doctors.create,admin')->name('system.doctors.create');
        Route::post('create', [DoctorController::class, 'store'])->middleware('permission:doctors.create,admin')->name('system.doctors.store');
        Route::get('update/{id}', [DoctorController::class, 'showUpdateView'])->middleware('permission:doctors.edit,admin')->name('system.doctors.update');
        Route::post('update/{id}', [DoctorController::class, 'update'])->middleware('permission:doctors.edit,admin')->name('system.doctors.updateAdmin');
        Route::get('password/{id}', [DoctorController::class, 'showPasswordView'])->middleware('permission:doctors.edit,admin')->name('system.doctors.password');
        Route::post('password/{id}', [DoctorController::class, 'password'])->middleware('permission:doctors.edit,admin')->name('system.doctors.updatePassword');
        Route::post('delete', [DoctorController::class, 'delete'])->middleware('permission:doctors.delete,admin')->name('system.doctors.delete');
        Route::post('/notActivate',    [DoctorController::class, 'deactivate'])->name('system.doctors.deactivate');
        Route::post('/activate',       [DoctorController::class, 'activate'])->name('system.doctors.activate');

    });

//=====================================================================================================
//                   Patients ROUTRS
//=====================================================================================================
    Route::prefix('patients/')->middleware('permission:patients.view,admin')->group(function () {
        Route::get('',                 [PatientController::class, 'index'])->name('system.patients.index');
        Route::get('create',           [PatientController::class, 'showCreateView'])->middleware('permission:patients.create,admin')->name('system.patients.create');
        Route::post('create',          [PatientController::class, 'store'])->middleware('permission:patients.create,admin')->name('system.patients.store');
        Route::get('update/{id}',      [PatientController::class, 'showUpdateView'])->middleware('permission:patients.edit,admin')->name('system.patients.update');
        Route::post('update/{id}',     [PatientController::class, 'update'])->middleware('permission:patients.edit,admin')->name('system.patients.updateAdmin');
        Route::get('password/{id}',    [PatientController::class, 'showPasswordView'])->middleware('permission:patients.edit,admin')->name('system.patients.password');
        Route::post('password/{id}',   [PatientController::class, 'password'])->middleware('permission:patients.edit,admin')->name('system.patients.updatePassword');
        Route::post('delete',          [PatientController::class, 'delete'])->middleware('permission:patients.delete,admin')->name('system.patients.delete');
        Route::post('/notActivate',    [PatientController::class, 'deactivate'])->name('system.patients.deactivate');
        Route::post('/activate',       [PatientController::class, 'activate'])->name('system.patients.activate');

    });


    //=====================================================================================================
    //                   General ROUTRS
    //=====================================================================================================

    Route::prefix('general_data/{item}')->group(function () {
        Route::get('',                 [GeneralDataController::class, 'index'])->name('system.general.index');
        Route::get('create',           [GeneralDataController::class, 'show_create'])->name('system.general.create');
        Route::post('create',          [GeneralDataController::class, 'create']);
        Route::get('update/{id}',      [GeneralDataController::class, 'show_update'])->name('system.general.update');
        Route::post('update/{id}',     [GeneralDataController::class, 'update']);
        Route::post('change_status',   [GeneralDataController::class, 'change_status'])->name('system.general.change_status');
        Route::post('delete',          [GeneralDataController::class, 'delete'])->name('system.general.delete');
        Route::post('activate',        [GeneralDataController::class,'activate'])->name('system.general.activate');
        Route::post('deactivate',      [GeneralDataController::class,'deactivate'])->name('system.general.deactivate');

    });

//    Route::prefix('general/{module}')->group(function () {
//        Route::get('', [GeneralController::class, 'index'])->name('system.general.index');
//        Route::get('create', [GeneralController::class, 'show_create'])->name('system.general.create');
//        Route::post('create', [GeneralController::class, 'create']);
//        Route::get('update/{id}', [GeneralController::class, 'show_update'])->name('system.general.update');
//        Route::post('update/{id}', [GeneralController::class, 'update']);
//        Route::post('change_status', [GeneralController::class, 'change_status'])->name('system.general.change_status');
//        Route::post('delete', [GeneralController::class, 'delete'])->name('system.general.delete');
//        Route::post('activate', [GeneralController::class, 'activate'])->name('system.general.activate');
//        Route::post('deactivate', [GeneralController::class, 'deactivate'])->name('system.general.deactivate');
//
//    });



    //=====================================================================================================
        //                   global_notifications ROUTRS
        //=====================================================================================================

        Route::prefix('global_notifications/')->middleware('permission:global_notifications.view,admin')->group(function () {
            Route::get('', [GLobalNotificationController::class, 'index'])->name('system.global_notifications.index');
            Route::get('add_notification', [GLobalNotificationController::class, 'showCreateView'])->middleware('permission:global_notifications.create,admin')->name('system.global_notifications.create');
            Route::post('add_notification', [GLobalNotificationController::class, 'send'])->name('system.global_notifications.store')->middleware('permission:global_notifications.create,admin');
            Route::post('delete', [GLobalNotificationController::class, 'delete'])->middleware('permission:global_notifications.delete,admin')->name('system.global_notifications.delete');
        });


    //=====================================================================================================
    //                   faqs ROUTRS
    //=====================================================================================================

    Route::prefix('faq')->middleware('permission:faqs.view,admin')->group(function () {
        Route::get('/',              [FAQController::class, 'index'])->middleware('permission:faqs.view,admin')->name('system.faq.index');
        Route::get('/create',        [FAQController::class, 'create'])->name('system.faq.create');
        Route::post('store',         [FAQController::class, 'store'])->middleware('permission:faqs.create,admin')->name('system.faq.store');
        Route::get('update/{id}',    [FAQController::class, 'showUpdateView'])->middleware('permission:faqs.edit,admin')->name('system.faq.update');
        Route::post('update/{id}',   [FAQController::class, 'update'])->middleware('permission:faqs.edit,admin');
        Route::post('delete',        [FAQController::class, 'delete'])->middleware('permission:faqs.delete,admin')->name('system.faq.delete');
    });


//=====================================================================================================
//                   Medications  ROUTRS
//=====================================================================================================

    /**************************************** Start medications Route ****************************************/
    Route::prefix('medications/')->middleware('permission:medications.view,admin')->group(function () {
        Route::get('',               [MedicationController::class, 'index'])->name('system.medications.index');
        Route::get('/create',        [MedicationController::class, 'create'])->name('system.medications.create');
        Route::post('store',         [MedicationController::class, 'store'])->middleware('permission:medications.create,admin')->name('system.medications.store');
        Route::get('update/{id}',    [MedicationController::class, 'showUpdateView'])->middleware('permission:medications.edit,admin')->name('system.medications.update');
        Route::post('update/{id}',   [MedicationController::class, 'update'])->middleware('permission:medications.edit,admin');
        Route::post('delete',        [MedicationController::class, 'delete'])->middleware('permission:medications.delete,admin')->name('system.medications.delete');
        Route::post('/notActivate',  [MedicationController::class, 'deactivate'])->name('system.medications.deactivate');
        Route::post('/activate',     [MedicationController::class, 'activate'])->name('system.medications.activate');
    });
    /**************************************** End medications Route *********************************************/



    /**************************************** Start Patients medications Route ****************************************/
    Route::prefix('patient_medications/')->middleware('permission:patient_medications.view,admin')->group(function () {
        Route::get('',               [PatientMedicationController::class, 'index'])->name('system.patient_medications.index');
        Route::get('/create',        [PatientMedicationController::class, 'create'])->name('system.patient_medications.create');
        Route::post('store',         [PatientMedicationController::class, 'store'])->middleware('permission:patient_medications.create,admin')->name('system.patient_medications.store');
        Route::get('update/{id}',    [PatientMedicationController::class, 'showUpdateView'])->middleware('permission:patient_medications.edit,admin')->name('system.patient_medications.update');
        Route::post('update/{id}',   [PatientMedicationController::class, 'update'])->middleware('permission:patient_medications.edit,admin');
        Route::post('stopped',       [PatientMedicationController::class, 'stopped'])->middleware('permission:patient_medications.delete,admin')->name('system.patient_medications.stopped');
        Route::post('activate',      [PatientMedicationController::class, 'activate'])->name('system.patient_medications.activate');
    });
    /**************************************** End Patients medications Route *********************************************/


//=====================================================================================================
//                   Dialysis Sessions  ROUTES
//=====================================================================================================
    /**************************************** Start dialysis Sessions Route ****************************************/
    Route::prefix('dialysis_sessions/')->middleware('permission:dialysis_sessions.view,admin')->group(function () {
        Route::get('',               [DialysisSessionController::class, 'index'])->name('system.dialysis_sessions.index');
        Route::get('/create',        [DialysisSessionController::class, 'create'])->name('system.dialysis_sessions.create');
        Route::post('store',         [DialysisSessionController::class, 'store'])->middleware('permission:dialysis_sessions.create,admin')->name('system.dialysis_sessions.store');
        Route::get('update/{id}',    [DialysisSessionController::class, 'showUpdateView'])->middleware('permission:dialysis_sessions.edit,admin')->name('system.dialysis_sessions.update');
        Route::post('update/{id}',   [DialysisSessionController::class, 'update'])->middleware('permission:dialysis_sessions.edit,admin');
        Route::post('delete',        [DialysisSessionController::class, 'delete'])->middleware('permission:dialysis_sessions.delete,admin')->name('system.dialysis_sessions.delete');
        Route::post('/notActivate',  [DialysisSessionController::class, 'deactivate'])->name('system.dialysis_sessions.deactivate');
        Route::post('/activate',     [DialysisSessionController::class, 'activate'])->name('system.dialysis_sessions.activate');
    });
    /**************************************** End dialysis Sessions Route *********************************************/






    /**************************************** start pages Routes ***************************************/
        Route::prefix('pages/')->middleware('permission:pages.view,admin')->group(function () {
            Route::get('', [PageController::class, 'index'])->name('system.pages.index');
            Route::get('update/{id}', [PageController::class, 'showUpdateView'])->middleware('permission:pages.edit,admin')->name('system.pages.update');
            Route::post('update/{id}', [PageController::class, 'update'])->middleware('permission:pages.edit,admin');
        });
        /**************************************** end pages Routes ***************************************/


        /**************************************** start contacts model Routes ***************************************/
    Route::prefix('contacts/')->middleware('permission:contacts.view,admin')->group(function () {
        Route::get('',             [ContactController::class,'index'])->name('system.contacts.index');
        Route::post('delete',      [ContactController::class,'delete'])->middleware('permission:contacts.delete,admin')->name('system.contacts.delete');
        Route::get('replay/{id}',  [ContactController::class,'replay'])->name('system.contacts.replay.index');
        Route::post('replay/send', [ContactController::class,'send_replay'])->name('system.contacts.replay.send');
        Route::get('details/{id}', [ContactController::class,'details'])->name('system.contacts.details');

    });
        /**************************************** end contacts model Routes ***************************************/




        /**************************************** Start Categories Route ****************************************/
        Route::prefix('categories/')->middleware('permission:categories.view,admin')->group(function () {
            Route::get('', [CategoryController::class, 'index'])->name('system.categories.index');
            Route::get('/create', [CategoryController::class, 'create'])->name('system.categories.create');
            Route::post('store', [CategoryController::class, 'store'])->middleware('permission:categories.create,admin')->name('system.categories.store');
            Route::get('update/{id}', [CategoryController::class, 'showUpdateView'])->middleware('permission:categories.edit,admin')->name('system.categories.update');
            Route::post('update/{id}', [CategoryController::class, 'update'])->middleware('permission:categories.edit,admin');
            Route::post('delete', [CategoryController::class, 'delete'])->middleware('permission:categories.delete,admin')->name('system.categories.delete');
            Route::post('/notActivate', [CategoryController::class, 'deactivate'])->name('system.categories.deactivate');
            Route::post('/activate', [CategoryController::class, 'activate'])->name('system.categories.activate');
        });
        /**************************************** End Categories Route *********************************************/



    /**************************************** Start sms Route ****************************************/
        Route::prefix('sms/')->middleware('permission:global_notifications.view,admin')->group(function () {
            Route::get('',         [SMSController::class, 'index'])->name('system.sms.index');
            Route::get('add_sms',  [SMSController::class, 'showCreateView'])->middleware('permission:sms.create,admin')->name('system.sms.create');
            Route::post('sms/add', [SMSController::class, 'send'])->middleware('permission:sms.create,admin')->name('system.sms.send');
            Route::post('delete',  [SMSController::class, 'delete'])->middleware('permission:sms.delete,admin')->name('system.sms.delete');

        });
        /**************************************** end sms Route ****************************************/


        Route::view('wizard', 'admin.template.wizard', ['activeLink' => 'dash']);


    });



});

