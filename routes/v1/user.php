<?php

use App\Http\Controllers\Api\V1\User\FamilyMemberController;
use App\Http\Controllers\Api\V1\User\NotificationController;
use App\Http\Controllers\Api\V1\User\UserController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\V1\User\AuthController;

///////  api/v1/user

Route::post('/register_initial',               [AuthController::class, 'registerInitial']);
Route::group(['middleware' => ['auth:sanctum','verified_mobile']], function () {
    Route::post('/register_personal', [AuthController::class, 'registerPersonal']);
    Route::post('/register_medical_info', [AuthController::class, 'registerMedicalInfo']);
    Route::post('/register_center_info', [AuthController::class, 'registerCenterInfo']);
    Route::post('/register_doctor_info', [AuthController::class, 'registerDoctorInfo']);
    Route::post('/register_family_info', [AuthController::class, 'registerFamilyInfo']);
});


Route::post('/login',       [AuthController::class, 'login']);

Route::post('/verify_code', [AuthController::class, 'verifyMobile']);
Route::post('/resend_verify_code', [AuthController::class, 'resendVerifyCode']);

Route::post('/forget_password', [AuthController::class, 'forgetPassword']);


Route::post('/update_fcm_token', [NotificationController::class, 'updateFcmToken']);

Route::group(['middleware' => ['auth:sanctum', 'verified_mobile']], function () {
    Route::post('/update_profile', [AuthController::class, 'updateProfile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/update_user_fcm_token', [NotificationController::class, 'updateUserFcmToken']);

    Route::post('/delete_notification', [NotificationController::class, 'DeleteUserNotification']);
    Route::get('/get_user_notifications', [NotificationController::class, 'getUserNotifications']);

    Route::get('/me'       , [UserController::class, 'me']);
    Route::post('/delete_me', [UserController::class, 'delete_me']);

    Route::post('/change_password', [UserController::class, 'changePassword']);



    Route::get('/get_family_member'       ,[UserController::class, 'getFamilyMember']);


});

