<?php

use App\Http\Controllers\Admin\AdminsController;
use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\DistrictController;
use App\Http\Controllers\Admin\GeneralController;
use App\Http\Controllers\Admin\GLobalNotificationController;
use \App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PaymentController;
use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\Admin\SMSController;

use \App\Http\Controllers\Admin\LoginController;
use \App\Http\Controllers\Admin\DashboardController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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




        /**************************************** Start admins Route ****************************************/

        Route::prefix('admins/')->middleware('permission:admins.view,admin')->group(function () {
            Route::get('', [AdminsController::class, 'index'])->name('system.admins.index');
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
        /**************************************** End Admin Route ****************************************/


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
        //                   General ROUTRS
        //=====================================================================================================

        Route::prefix('general/{module}')->group(function () {
            Route::get('', [GeneralController::class, 'index'])->name('system.general.index');
            Route::get('create', [GeneralController::class, 'show_create'])->name('system.general.create');
            Route::post('create', [GeneralController::class, 'create']);
            Route::get('update/{id}', [GeneralController::class, 'show_update'])->name('system.general.update');
            Route::post('update/{id}', [GeneralController::class, 'update']);
            Route::post('change_status', [GeneralController::class, 'change_status'])->name('system.general.change_status');
            Route::post('delete', [GeneralController::class, 'delete'])->name('system.general.delete');
            Route::post('activate', [GeneralController::class, 'activate'])->name('system.general.activate');
            Route::post('deactivate', [GeneralController::class, 'deactivate'])->name('system.general.deactivate');

        });

        //=====================================================================================================
        //                   global_notifications ROUTRS
        //=====================================================================================================

        Route::prefix('global_notifications/')->middleware('permission:global_notifications.view,admin')->group(function () {
            Route::get('', [GLobalNotificationController::class, 'index'])->name('system.global_notifications.index');
            Route::get('add_notification', [GLobalNotificationController::class, 'showCreateView'])->middleware('permission:global_notifications.create,admin')->name('system.global_notifications.create');
            Route::post('add_notification', [GLobalNotificationController::class, 'send'])->name('system.global_notifications.store')->middleware('permission:global_notifications.create,admin');
            Route::post('delete', [GLobalNotificationController::class, 'delete'])->middleware('permission:global_notifications.delete,admin')->name('system.global_notifications.delete');
        });



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


        /**************************************** start services Routes ***************************************/
        Route::prefix('services/')->middleware('permission:services.view,admin')->group(function () {
            Route::get('', [ServiceController::class, 'index'])->name('system.services.index');
            Route::get('create', [ServiceController::class, 'create'])->name('system.services.create');
            Route::post('create', [ServiceController::class, 'store']);
            Route::get('update/{service}', [ServiceController::class, 'edit'])->name('system.services.update');
            Route::get('show/{service}', [ServiceController::class, 'show'])->name('system.services.show');
            Route::post('update/{service}', [ServiceController::class, 'update']);
            Route::post('delete', [ServiceController::class, 'delete'])->middleware('permission:services.delete,admin')->name('system.services.delete');
            Route::post('activate', [ServiceController::class, 'activate'])->name('system.services.activate');
            Route::post('deactivate', [ServiceController::class, 'deactivate'])->name('system.services.deactivate');


        });
        /**************************************** end services Routes ***************************************/


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

    /**************************************** Start areas Route ****************************************/
    Route::prefix('areas/')->middleware('permission:cities.view,admin')->group(function () {
        Route::get('',               [AreaController::class, 'index'])->name('system.areas.index');
        Route::get('/create',        [AreaController::class, 'create'])->name('system.areas.create');
        Route::get('/show-cities/{id}',[AreaController::class, 'show_cities'])->name('system.areas.show_cities');
        Route::get('/cities/{id}',   [AreaController::class, 'cities'])->name('system.areas.cities');
        Route::post('store',         [AreaController::class, 'store'])->middleware('permission:cities.create,admin')->name('system.areas.store');
        Route::get('update/{id}',    [AreaController::class, 'showUpdateView'])->middleware('permission:cities.edit,admin')->name('system.areas.update');
        Route::post('update/{id}',   [AreaController::class, 'update'])->middleware('permission:cities.edit,admin');
        Route::post('delete',        [AreaController::class, 'delete'])->middleware('permission:cities.delete,admin')->name('system.areas.delete');
        Route::post('/notActivate',  [AreaController::class, 'deactivate'])->name('system.areas.deactivate');
        Route::post('/activate',     [AreaController::class, 'activate'])->name('system.areas.activate');
    });
    /**************************************** End areas Route *********************************************/


    /**************************************** Start areas Route ****************************************/
    Route::prefix('cities/')->middleware('permission:cities.view,admin')->group(function () {
        Route::get('',               [CityController::class, 'index'])->name('system.cities.index');
        Route::get('/create',        [CityController::class, 'create'])->name('system.cities.create');
        Route::post('store',         [CityController::class, 'store'])->middleware('permission:cities.create,admin')->name('system.cities.store');
        Route::get('update/{id}',    [CityController::class, 'showUpdateView'])->middleware('permission:cities.edit,admin')->name('system.cities.update');
        Route::post('update/{id}',   [CityController::class, 'update'])->middleware('permission:cities.edit,admin');
        Route::get('/districts/{id}',[CityController::class, 'districts'])->name('system.cities.districts');

    });
    /**************************************** End areas Route *********************************************/

    /**************************************** Start areas Route ****************************************/
    Route::prefix('districts/')->middleware('permission:cities.view,admin')->group(function () {
        Route::get('',               [DistrictController::class, 'index'])->name('system.districts.index');
        Route::get('/create',        [DistrictController::class, 'create'])->name('system.districts.create');
        Route::post('store',         [DistrictController::class, 'store'])->middleware('permission:cities.create,admin')->name('system.districts.store');
        Route::get('update/{id}',    [DistrictController::class, 'showUpdateView'])->middleware('permission:cities.edit,admin')->name('system.districts.update');
        Route::post('update/{id}',   [DistrictController::class, 'update'])->middleware('permission:cities.edit,admin');
    });
    /**************************************** End areas Route *********************************************/

    /**************************************** Start payments Route ****************************************/
    Route::prefix('payments/')->middleware('permission:payment_types.view,admin')->group(function () {
        Route::get('',               [PaymentController::class, 'index'])->name('system.payments.index');
        Route::get('update/{id}',    [PaymentController::class, 'showUpdateView'])->middleware('permission:payment_types.edit,admin')->name('system.payments.update');
        Route::post('update/{id}',   [PaymentController::class, 'update'])->middleware('permission:payment_types.edit,admin');
        Route::post('/notActivate',  [PaymentController::class, 'deactivate'])->name('system.payments.deactivate');
        Route::post('/activate',     [PaymentController::class, 'activate'])->name('system.payments.activate');

    });
    /**************************************** End areas Route *********************************************/



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

