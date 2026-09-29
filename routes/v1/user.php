<?php

use App\Http\Controllers\Api\V1\User\DashboardAlertController;
use App\Http\Controllers\Api\V1\User\DialysisSessionController;
use App\Http\Controllers\Api\V1\User\DialysisSessionIssueController;
use App\Http\Controllers\Api\V1\User\DoctorConsultationController;
use App\Http\Controllers\Api\V1\User\FamilyInvitationController;
use App\Http\Controllers\Api\V1\User\FamilyPermissionController;
use App\Http\Controllers\Api\V1\User\FluidLogController;
use App\Http\Controllers\Api\V1\User\HealthMeasurementController;
use App\Http\Controllers\Api\V1\User\NotificationController;
use App\Http\Controllers\Api\V1\User\PatientMedicationController;
use App\Http\Controllers\Api\V1\User\PatientSymptomController;
use App\Http\Controllers\Api\V1\User\SmartNoteController;
use App\Http\Controllers\Api\V1\User\UserController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\V1\User\AuthController;

///////  api/v1/user

Route::post('/register_initial',               [AuthController::class, 'registerInitial']);
Route::group(['middleware' => ['auth:sanctum','verified_mobile']], function () {
    Route::post('/complete_register', [AuthController::class, 'completeRegister']);
});


Route::post('/login',       [AuthController::class, 'login']);

Route::post('/verify_code', [AuthController::class, 'verifyMobile']);
Route::post('/resend_verify_code', [AuthController::class, 'resendVerifyCode']);

Route::post('/forget_password', [AuthController::class, 'forgetPassword']);


Route::post('/update_fcm_token', [NotificationController::class, 'updateFcmToken']);

Route::group(['middleware' => ['auth:sanctum', 'verified_mobile']], function () {
    Route::post('/update_profile', [AuthController::class, 'updateProfile']);
    Route::post('/logout', [AuthController::class, 'logout']);


    Route::get('/me'       , [UserController::class, 'me']);
    Route::post('/delete_me', [UserController::class, 'delete_me']);

    Route::post('/change_password', [UserController::class, 'changePassword']);



    Route::get('/get_family_member'       ,[UserController::class, 'getFamilyMember']);


    /*************************** Start notifications  routes **************************/
    Route::post('/update_user_fcm_token',     [NotificationController::class, 'updateUserFcmToken']);
    Route::post('/delete_notification',       [NotificationController::class, 'DeleteUserNotification']);
    Route::get('/get_user_notifications',     [NotificationController::class, 'getUserNotifications']);
    Route::post('/read_all_notification',     [NotificationController::class, 'ReadAllNotification']);
    /*************************** end notifications  routes **************************/


    /*************************** Start fluid Log Track **************************/
    Route::get('fluid-logs/',        [FluidLogController::class, 'getFluidLog']);
    Route::get('fluid-logs/summary',[FluidLogController::class, 'summary']);
    Route::get('fluid-logs/history', [FluidLogController::class, 'getHistoryFluidLog']);
    Route::post('fluid-logs/add',    [FluidLogController::class, 'addFluidLog']);
    /*************************** End fluid Log Track **************************/


    /*************************** Start Patient Medications **************************/
    Route::get('/my_medicine',                            [PatientMedicationController::class, 'myMedicine']);
    Route::post('/medicine_details',                      [PatientMedicationController::class, 'medicineDetails']);
    Route::get('medications/schedule',                    [PatientMedicationController::class, 'schedule']);
    Route::post('medications/log/{medicationLog}/taken',  [PatientMedicationController::class, 'markTaken']);
    Route::post('medications/log/{medicationLog}/snooze', [PatientMedicationController::class, 'snooze']);
//    Route::get('medicines/adherence',                     [PatientMedicationController::class, 'adherence']);
    /*************************** End Patient Medications **************************/



    /*************************** Start Family Member Routes **************************/
    Route::post('/family-members/invite',               [FamilyInvitationController::class, 'familyInvitation']);
    Route::get('/family/invitations',                   [FamilyInvitationController::class, 'index']);
    Route::get('/family/invitations/{invitation}',      [FamilyInvitationController::class, 'details']);
    Route::get('/family/invitation/{token}',            [FamilyInvitationController::class, 'showInvitation'])->withoutMiddleware(['auth:sanctum','verified_mobile']);
    Route::post('/family/invitations/{token}/register', [FamilyInvitationController::class, 'register'])->withoutMiddleware(['auth:sanctum','verified_mobile']);
    Route::post('/family/invitations/{token}/accept',   [FamilyInvitationController::class, 'accept']);
    /*************************** End Family Member Routes **************************/


    /*************************** Start Family Member Permissions Routes **************************/
    Route::get('/family/members/permission-types',                   [FamilyPermissionController::class, 'permissionTypes']);
     Route::put('/family/members/{patientFamilyMember}/permissions', [FamilyPermissionController::class, 'update']);
     Route::patch('/family/members/{patientFamilyMember}/revoke',    [FamilyPermissionController::class, 'revoke']);
    Route::patch('/family/members/{patientFamilyMember}/restore',    [FamilyPermissionController::class, 'restore']);
    /************************** End Family Member Permissions Routes **************************/




    /*************************** Start Dialysis Sessions Routes **************************/
    Route::get('dialysis-sessions',                           [DialysisSessionController::class, 'index']);
    Route::get('dialysis-sessions/next',                      [DialysisSessionController::class, 'next']);
    Route::get('dialysis-sessions/{dialysisSession}',         [DialysisSessionController::class, 'show']);
    Route::post('dialysis-sessions/{dialysisSession}/confirm',[DialysisSessionController::class, 'confirm']);
    Route::post('dialysis-sessions/{dialysisSession}/issues', [DialysisSessionIssueController::class, 'index']);
    Route::get('dialysis-session-issues/history',             [DialysisSessionIssueController::class, 'history']);
    Route::get('dialysis-session-issues/{issue}',             [DialysisSessionIssueController::class, 'show']);
    /************************** End Dialysis Sessions Routes **************************/


    /*************************** Start Health Measurement Routes **************************/
    Route::get('health-measurements',                [HealthMeasurementController::class, 'index']);
    Route::post('health-measurements',               [HealthMeasurementController::class, 'store']);
    Route::get('health-measurements/summary',        [HealthMeasurementController::class, 'summary']);
    /************************** End Health Measurement Routes **************************/



    /*************************** Start symptoms Routes **************************/
    Route::prefix('symptoms')->group(function () {
        Route::get('/',                 [PatientSymptomController::class, 'index']);
        Route::post('/',                [PatientSymptomController::class, 'store']);
        Route::get('/history',          [PatientSymptomController::class, 'history']);
        Route::get('/{patientSymptom}', [PatientSymptomController::class, 'show']);
    });
   /************************** End symptoms Routes **************************/




    /************************** Start Doctor Consultations Routes **************************/

        Route::prefix('doctor-consultations')->group(function () {
            Route::post('/',              [DoctorConsultationController::class, 'store']);
            Route::get('/',               [DoctorConsultationController::class, 'index']);
//            Route::get('/{consultation}', [DoctorConsultationController::class, 'show']);
        });

   /************************** End Doctor Consultations Routes **************************/

    Route::get('dashboard/smart-note', [SmartNoteController::class, 'show']);
    Route::get('dashboard/alerts',     [DashboardAlertController::class, 'index']);

});

