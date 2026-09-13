<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Actions\ApiActions;
use App\Actions\ImageActions;
use App\Constants\ResponseCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\RegisterCenterInfoRequest;
use App\Http\Requests\Api\User\RegisterDoctorInfoRequest;
use App\Http\Requests\Api\User\RegisterFamilyInfoRequest;
use App\Http\Requests\Api\User\RegisterInitialRequest;
use App\Http\Requests\Api\User\RegisterMedicalInfoRequest;
use App\Http\Requests\Api\User\RegisterPersonalRequest;
use App\Http\Requests\Api\User\UpdateProfileRequest;
use App\Http\Requests\Api\User\UserLoginRegister;
use App\Http\Requests\Api\User\VerifyCode;
use App\Http\Resources\User\UserResource;
use App\Jobs\SendSMS;
use App\Jobs\SendUserEmail;
use App\Jobs\SendUserNotification;
use App\Mail\ActivationCode;
use App\Models\FamilyMember;
use App\Models\Patient;
use App\Models\PatientCenter;
use App\Models\PatientDoctor;
use App\Models\PatientFamilyMember;
use App\Models\User;
use App\Rules\PasswordPolicy;
use App\Rules\ValidMobile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use OpenApi\Attributes as OA;

#[OA\Info(
    description: "My College User API Documentation",
    version: "1.0.0",
    title: "Base User API swagger documentation",
    termsOfService: "http://swagger.io/terms/",
    contact: new OA\Contact(
        email: "besanmarwan2000@gmail.com"
    ),
    license: new OA\License(
        name: "Apache 2.0",
        url: "http://www.apache.org/licenses/LICENSE-2.0.html"
    )
)]
#[OA\SecurityScheme(
    securityScheme: "api_key",
    type: "http",
    in: "header",
    scheme: "bearer"
)]
#[OA\Tag(
    name: "AuthanticationApiSection",
    description: "API Package for Authantication requests"
)]
class AuthController extends Controller
{
    #[OA\Post(
        path: "/api/v1/user/verify_code",
        operationId: "apiValidateMobile",
        tags: ["AuthanticationApiSection"],
        summary: "verify login code",
        description: "Activate User account service returns user object in case of success",
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: "multipart/form-data",
                schema: new OA\Schema(ref: "#/components/schemas/VerifyCode")
            )
        ),
        parameters: [
            new OA\Parameter(ref: "#/components/parameters/language")
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Mobile Verified",
                content: new OA\JsonContent(
                    ref: "#/components/schemas/UserResource"
                )
            ),
            new OA\Response(
                response: 422,
                description: "validation error"
            )
        ]

    )]
    public function verifyMobile(VerifyCode $request)
    {
        $country_id = $request->country_id ?? 1;
        if (!User::where('mobile', $request->mobile)->where('country_id', $country_id)->exists()) {
            return ApiActions::generateResponse(null, 'no_user_please_register_first', ResponseCode::VALIDATION_ERROR);
        }

        if (User::where('mobile', $request->mobile)->where('country_id', $country_id)->where('status', '<>', 'not_verified')->first()) {
            return ApiActions::generateResponse(null, 'user_already_verified', ResponseCode::VALIDATION_ERROR);
        }

        $req = User::where('mobile', $request->mobile)->where('country_id', $country_id)->where('status', 'not_verified')->first();
        if ($req->activation_code == $request->code) {
            $req->status = 'enabled';
            $req->save();

            $user = UserResource::make($req->fresh());

            return ApiActions::generateResponse(compact('user'), 'mobile_verified');
        } else {
            return ApiActions::generateResponse(null, 'activation_code_incorrect', ResponseCode::VALIDATION_ERROR);
        }
    }


    #[OA\Post(
        path: "/api/v1/user/resend_verify_code",
        operationId: "resend verify code",
        tags: ["AuthanticationApiSection"],
        summary: "resend verify code",
        description: "User resend verify code",
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: "multipart/form-data",
                schema: new OA\Schema(
                    schema: "resend_verify_code",
                    required: ["mobile"],
                    properties: [
                        new OA\Property(
                            property: "mobile",
                            description: "mobile",
                            type: "number"
                        )
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(
                response: 451,
                description: "Not verified : User need confirm mobile",
                content: new OA\JsonContent(
                    ref: "#/components/schemas/UserResource"
                )
            ),
            new OA\Response(
                response: 422,
                description: "Validation Error"
            )
        ]
    )]
    public function resendVerifyCode(Request $request)
    {
        $country_id = $request->country_id ?? 1;
        $request->validate([
            'mobile' => ['required', new ValidMobile()],
        ]);

        if (!User::where('mobile', $request->mobile)->where('country_id', $country_id)->exists()) {
            return ApiActions::generateResponse(null, 'no_user_please_register_first', ResponseCode::VALIDATION_ERROR);
        }

        if ($user = User::where('mobile', $request->mobile)->where('country_id', $country_id)->where('status', '<>', 'not_verified')->first()) {
            if ($user->reset_code && $user->code_finished_at > Carbon::now()->toDateTimeString()) {
                $activationCode = rand(1000, 9999);
                $user->reset_code = $activationCode;
                $user->code_finished_at = Carbon::now()->addMinutes(config('custom.reset_code_expired_period', 30));
                $user->save();

                try {
                    SendSMS::dispatch($user->mobile, lang('api_texts.your_reset_code') . $user->reset_code);
                } catch (\Exception $e) {
                }

                if (config('custom.send_sms_via_notification')) {
                    SendUserNotification::dispatch($user->id, 'sms_message', ['message' => lang('api_texts.your_reset_code') . $user->reset_code]);
                }


                return ApiActions::generateResponse(compact('activationCode'), 'password_reset_code_sended');

            }


        }

        if (User::where('mobile', $request->mobile)->where('country_id', $country_id)->where('status', '<>', 'not_verified')->exists()) {
            return ApiActions::generateResponse(null, 'user_already_verified', ResponseCode::VALIDATION_ERROR);
        }

        $user = User::where('mobile', $request->mobile)->where('country_id', $country_id)->where('status', 'not_verified')->first();
        $activationCode = rand(1000, 9999);
        $user->activation_code = $activationCode;
        $user->save();

        try {
            SendSMS::dispatch($user->mobile, trans('api_texts.your_activation_code') . ' : ' . $activationCode);
        } catch (\Exception $e) {
        }

        if (config('custom.send_sms_via_notification')) {
            SendUserNotification::dispatch($user->id, 'sms_message', ['message' => trans('api_texts.your_activation_code') . ' : ' . $user->activation_code]);
        }

        $user = UserResource::make($user);

        return ApiActions::generateResponse(compact('user'), 'verify_mobile', ResponseCode::NOT_VERTIFIED);
    }

    #[OA\Post(
        path: "/api/v1/user/login",
        operationId: "login",
        tags: ["AuthanticationApiSection"],
        summary: "User login API",
        description: "User login service returns user object",
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: "multipart/form-data",
                schema: new OA\Schema(
                    ref: "#/components/schemas/UserLoginRegister"
                )
            )
        ),
        parameters: [
            new OA\Parameter(ref: "#/components/parameters/language"),
            new OA\Parameter(ref: "#/components/parameters/device_key"),
            new OA\Parameter(ref: "#/components/parameters/device_name"),
            new OA\Parameter(ref: "#/components/parameters/device_type")
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "OK",
                content: new OA\JsonContent(
                    ref: "#/components/schemas/UserResource"
                )
            ),
            new OA\Response(
                response: 422,
                description: "Validation error"
            ),
            new OA\Response(
                response: 451,
                description: "Not verified : User need confirm mobile",
                content: new OA\JsonContent(
                    ref: "#/components/schemas/UserResource"
                )
            )
        ]
    )]
    public function login(UserLoginRegister $request)
    {
        $country_id = $request->country_id ?? 1;
        $old = User::where('mobile', $request->mobile)->where('country_id', $country_id)->first();
        if ($old) {
            if (Hash::check($request->password, $old->password)) {
                $old->last_login = Carbon::now();
                if (!$old->accessToken) {
                    $old->accessToken = $old->createToken('Driver_' . $old->id . '_' . Carbon::now()->toDateTimeString())->plainTextToken;
                }
                $old->language = app()->getLocale();
                $old->save();
                $user = UserResource::make($old);
                if ($old->status != 'enabled') {
                    return ApiActions::generateResponse(compact('user'), 'verify_mobile', ResponseCode::NOT_VERTIFIED);
                }

                return ApiActions::generateResponse(compact('user'));
            } else {
                return ApiActions::generateResponse(null, 'password_wrong', ResponseCode::VALIDATION_ERROR);
            }
        }

        return ApiActions::generateResponse(compact('user'), 'verify_mobile', ResponseCode::NOT_VERTIFIED);
    }


    #[OA\Post(
        path: "/api/v1/user/register_initial",
        operationId: "register_init",
        tags: ["AuthanticationApiSection"],
        summary: "User  register initial API ",
        description: "User register service returns user object",
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: "multipart/form-data",
                schema: new OA\Schema(
                    ref: "#/components/schemas/RegisterInitial"
                )
            )
        ),
        parameters: [
            new OA\Parameter(ref: "#/components/parameters/language"),
            new OA\Parameter(ref: "#/components/parameters/device_key"),
            new OA\Parameter(ref: "#/components/parameters/device_name"),
            new OA\Parameter(ref: "#/components/parameters/device_type")
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "successful operation with status = true and user object"
            ),

            new OA\Response(
                response: 422,
                description: "status = true : User not activated || status = false : User not found or password is not correct"
            )
        ]
    )]
    public function registerInitial(RegisterInitialRequest $request)
    {
        $object          = new User();
        $object->name   = $request->name ?? null;
        $object->mobile  = $request->mobile;
        $object->email    = $request->email ?? null;
        $object->password = Hash::make($request->password);
        $object->status = 'not_verified';
        $object->role = 'patient';
        $object->country_id = 1;
        $object->activation_code = rand(1000, 9999);
        $object->last_login = Carbon::now();
        $object->language = app()->getLocale();
        $object->register_step='personal';
        $object->is_register_end=0;
        $object->save();
        $object->accessToken = $object->createToken('User_' . $object->id . '_' . Carbon::now()->toDateTimeString())->plainTextToken;
        $object->save();

        if ($request->header('device_key')) {
            ApiActions::ChangeUserDevice($request, $object->id);
        }
        if ($request->header('device_type')) {
            $object->device_type = $request->header('device_type') ?? null;
        }
        try {
            SendSMS::dispatch($object->mobile, trans('api_texts.your_activation_code') . ' : ' . $object->activation_code);

        } catch (\Exception $e) {
        }


        if (config('custom.send_sms_via_notification')) {
            SendUserNotification::dispatch($object->id, 'sms_message', ['message' => trans('api_texts.your_activation_code') . ' : ' . $object->activation_code]);
        }
        $user = UserResource::make($object);


        return ApiActions::generateResponse(compact('user'), 'verify_mobile', ResponseCode::NOT_VERTIFIED);

    }


    #[OA\Post(
        path: "/api/v1/user/register_personal",
        operationId: "register_personal",
        tags: ["AuthanticationApiSection"],
        summary: "User  register personal API ",
        description: "User register personal returns user object",
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: "multipart/form-data",
                schema: new OA\Schema(
                    ref: "#/components/schemas/RegisterPersonal"
                )
            )
        ),
        parameters: [
            new OA\Parameter(ref: "#/components/parameters/language"),
            new OA\Parameter(ref: "#/components/parameters/device_key"),
            new OA\Parameter(ref: "#/components/parameters/device_name"),
            new OA\Parameter(ref: "#/components/parameters/device_type")
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "successful operation with status = true and user object"
            ),

            new OA\Response(
                response: 422,
                description: "status = true : User not activated || status = false : User not found or password is not correct"
            )
        ]
    )]
    public function registerPersonal(RegisterPersonalRequest $request)
    {

        $user = \auth()->user();

        if($user->is_register_end ==1){
            return ApiActions::generateResponse(null, 'youre_finish_register_step', ResponseCode::VALIDATION_ERROR);
        }

        if($user->register_step != 'personal'){
            return ApiActions::generateResponse(null, 'you_must_finish_previous_steps', ResponseCode::VALIDATION_ERROR);
        }
        if($user->role != 'patient'){
            return ApiActions::generateResponse(null, 'This_registration_stepـisـintendedـforـpatients.', ResponseCode::VALIDATION_ERROR);
        }
        $patient = $user->patient;
        if(! $user->patient){
            $patient          = new Patient();
        }
        $patient->user_id        = $user->id;
        $patient->date_of_birth  = $request->birth_date;
        $patient->gender         = $request->gender;
        $patient->blood_type     = $request->blood_type;
        $patient->save();

        $user->register_step='medical_info';
        $user->is_register_end=0;
        $user->save();
        $user ->refresh();

        return ApiActions::generateResponse(compact('user'));

    }


    #[OA\Post(
        path: "/api/v1/user/register_medical_info",
        operationId: "register_medical_info",
        tags: ["AuthanticationApiSection"],
        summary: "User  register medical info API ",
        description: "User register medical info returns user object",
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: "multipart/form-data",
                schema: new OA\Schema(
                    ref: "#/components/schemas/RegisterMedicalInfo"
                )
            )
        ),
        parameters: [
            new OA\Parameter(ref: "#/components/parameters/language"),
            new OA\Parameter(ref: "#/components/parameters/device_key"),
            new OA\Parameter(ref: "#/components/parameters/device_name"),
            new OA\Parameter(ref: "#/components/parameters/device_type")
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "successful operation with status = true and user object"
            ),

            new OA\Response(
                response: 422,
                description: "status = true : User not activated || status = false : User not found or password is not correct"
            )
        ]
    )]
    public function registerMedicalInfo(RegisterMedicalInfoRequest $request)
    {

        $user = \auth()->user();

        if($user->is_register_end ==1){
            return ApiActions::generateResponse(null, 'you_are_finish_register_step', ResponseCode::VALIDATION_ERROR);
        }

        if($user->register_step != 'medical_info'){
            return ApiActions::generateResponse(null, 'you_must_finish_previous_steps', ResponseCode::VALIDATION_ERROR);
        }
        if($user->role != 'patient'){
            return ApiActions::generateResponse(null, 'This_registration_stepـisـintendedـforـpatients.', ResponseCode::VALIDATION_ERROR);
        }
        $patient = $user->patient;
        if(! $user->patient){
            $patient                 = new Patient();
            $patient->user_id        = $user->id;
        }
        $patient->dialysis_start_date     = $request->dialysis_start_date;
        $patient->dialysis_type           = $request->dialysis_type;
        $patient->sessions_per_week       = $request->sessions_per_week;
        $patient->kidney_disease_type     = $request->dialysis_type == 'hemodialysis' ? 'غسيل الكلى الدموي' :'الغسيل البريتوني';
        $patient->save();

        $user->register_step  ='dialysis_center_info';
        $user->is_register_end=0;
        $user->save();
        $user ->refresh();

        return ApiActions::generateResponse(compact('user'));

    }



    #[OA\Post(
        path: "/api/v1/user/register_center_info",
        operationId: "register_center_info",
        tags: ["AuthanticationApiSection"],
        summary: "User  register medical info API ",
        description: "User register medical info returns user object",
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: "multipart/form-data",
                schema: new OA\Schema(
                    ref: "#/components/schemas/RegisterCenterInfo"
                )
            )
        ),
        parameters: [
            new OA\Parameter(ref: "#/components/parameters/language"),
            new OA\Parameter(ref: "#/components/parameters/device_key"),
            new OA\Parameter(ref: "#/components/parameters/device_name"),
            new OA\Parameter(ref: "#/components/parameters/device_type")
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "successful operation with status = true and user object"
            ),

            new OA\Response(
                response: 422,
                description: "status = true : User not activated || status = false : User not found or password is not correct"
            )
        ]
    )]
    public function registerCenterInfo(RegisterCenterInfoRequest $request)
    {

        $user = \auth()->user();

        if($user->is_register_end ==1){
            return ApiActions::generateResponse(null, 'you_are_finish_register_step', ResponseCode::VALIDATION_ERROR);
        }

        if($user->register_step != 'dialysis_center_info'){
            return ApiActions::generateResponse(null, 'you_must_finish_previous_steps', ResponseCode::VALIDATION_ERROR);
        }
        if($user->role != 'patient'){
            return ApiActions::generateResponse(null, 'This_registration_stepـisـintendedـforـpatients.', ResponseCode::VALIDATION_ERROR);
        }
        $patient_center = PatientCenter::where('patient_id',$user->patient->id)->where('center_id',$request->center_id)->first();
        if(! $patient_center){
            $patient_center  = new PatientCenter();
            $patient_center->patient_id = $user->patient->id;
        }
        $patient_center->center_id        = $request->center_id;
        $patient_center->status           = 'enabled';
        $patient_center->started_at       = now()->toDateString();
        $patient_center->save();

        $user->register_step  ='doctor_info';
        $user->is_register_end=0;
        $user->save();

        return ApiActions::generateResponse(compact('user'));

    }



    #[OA\Post(
        path: "/api/v1/user/register_doctor_info",
        operationId: "register_doctor_info",
        tags: ["AuthanticationApiSection"],
        summary: "User  register doctor info API ",
        description: "User register doctor info returns user object",
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: "multipart/form-data",
                schema: new OA\Schema(
                    ref: "#/components/schemas/RegisterDoctorInfo"
                )
            )
        ),
        parameters: [
            new OA\Parameter(ref: "#/components/parameters/language"),
            new OA\Parameter(ref: "#/components/parameters/device_key"),
            new OA\Parameter(ref: "#/components/parameters/device_name"),
            new OA\Parameter(ref: "#/components/parameters/device_type")
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "successful operation with status = true and user object"
            ),

            new OA\Response(
                response: 422,
                description: "status = true : User not activated || status = false : User not found or password is not correct"
            )
        ]
    )]
    public function registerDoctorInfo(RegisterDoctorInfoRequest $request)
    {

        $user = \auth()->user();

        if($user->is_register_end ==1){
            return ApiActions::generateResponse(null, 'you_are_finish_register_step', ResponseCode::VALIDATION_ERROR);
        }

        if($user->register_step != 'doctor_info'){
            return ApiActions::generateResponse(null, 'you_must_finish_previous_steps', ResponseCode::VALIDATION_ERROR);
        }
        if($user->role != 'patient'){
            return ApiActions::generateResponse(null, 'This_registration_step_is_intended_for_patients.', ResponseCode::VALIDATION_ERROR);
        }
        $patient_doctor = PatientDoctor::where('patient_id',$user->patient->id)->where('doctor_id',$request->doctor_id)->first();
        if(! $patient_doctor){
            $patient_doctor  = new PatientDoctor();
            $patient_doctor->patient_id = $user->patient->id;
        }
        $patient_doctor->doctor_id        = $request->doctor_id;
        $patient_doctor->is_primary       = 1;
        $patient_doctor->started_at       = now()->toDateString();
        $patient_doctor->save();
        $user->register_step  ='family_member_info';
        $user->is_register_end=0;
        $user->save();
        $user ->refresh();

        $user = UserResource::make($user);

        return ApiActions::generateResponse(compact('user'));

    }



    #[OA\Post(
        path: "/api/v1/user/register_family_info",
        operationId: "register_family_info",
        tags: ["AuthanticationApiSection"],
        summary: "User  register family member info API ",
        description: "User register  family member info returns user object",
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: "multipart/form-data",
                schema: new OA\Schema(
                    ref: "#/components/schemas/RegisterFamilyInfo"
                )
            )
        ),
        parameters: [
            new OA\Parameter(ref: "#/components/parameters/language"),
            new OA\Parameter(ref: "#/components/parameters/device_key"),
            new OA\Parameter(ref: "#/components/parameters/device_name"),
            new OA\Parameter(ref: "#/components/parameters/device_type")
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "successful operation with status = true and user object"
            ),

            new OA\Response(
                response: 422,
                description: "status = true : User not activated || status = false : User not found or password is not correct"
            )
        ]
    )]
    public function registerFamilyInfo(RegisterFamilyInfoRequest $request)
    {

        $user = \auth()->user();

        if($user->is_register_end ==1){
            return ApiActions::generateResponse(null, 'you_are_finish_register_step', ResponseCode::VALIDATION_ERROR);
        }

        if($user->register_step != 'family_member_info'){
            return ApiActions::generateResponse(null, 'you_must_finish_previous_steps', ResponseCode::VALIDATION_ERROR);
        }
        if($user->role != 'patient'){
            return ApiActions::generateResponse(null, 'This_registration_step_is_intended_for_patients.', ResponseCode::VALIDATION_ERROR);
        }
        try{
            DB::beginTransaction();
            $userFamily = new User();
            $userFamily->name   = $request->name;
            $userFamily->mobile = $request->mobile;
            $userFamily->password = Hash::make('password');
            $userFamily->status = 'not_verified';
            $userFamily->role   = 'family';
            $userFamily->register_step  ='finish';
            $userFamily->is_register_end=1;
            $userFamily->save();
            $userFamily ->refresh();

            $member = FamilyMember::create([
               'user_id'      =>$userFamily->id,
                'relationship'=>$request->relationship
            ]);

            $patient_family_member = PatientFamilyMember::create([
                'patient_id'           =>$user->patient->id,
                'family_member_id'     =>$member->id,
                'relationship'         =>$request->relationship,
                'can_view_health_data' =>$request->can_view_health_data ?? 0,
                'can_receive_alerts'   =>$request->can_receive_alerts ?? 0,
            ]);


            DB::commit();

            $user = UserResource::make($user);

            return ApiActions::generateResponse(compact('user'));
        }catch(\Exception $e){
            return ApiActions::generateResponse(null, $e->getMessage(), ResponseCode::VALIDATION_ERROR);

        }



    }


    #[OA\Post(
        path: "/api/v1/user/update_profile",
        operationId: "update profile",
        tags: ["AuthanticationApiSection"],
        summary: "User login API",
        description: "User login service returns user object",
        security: [["api_key" => []]],
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: "multipart/form-data",
                schema: new OA\Schema(
                    ref: "#/components/schemas/UpdateProfileRequest"
                )
            )
        ),
        parameters: [
            new OA\Parameter(
                ref: "#/components/parameters/language"
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "OK",
                content: new OA\JsonContent(
                    ref: "#/components/schemas/UserResource"
                )
            ),

            new OA\Response(
                response: 422,
                description: "Validation error"
            ),

            new OA\Response(
                response: 451,
                description: "Not verified : User need confirm mobile",
                content: new OA\JsonContent(
                    ref: "#/components/schemas/UserResource"
                )
            )
        ]
    )]
    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = \auth()->user();

        $user->name  = $request->get('name', $user->name);
        $user->email = $request->get('email', $user->email);
        if ($name = ImageActions::SaveFile($request->avatar)) {
            $user->avatar = $name;
        }
        $user->language = app()->getLocale();
        if ($request->mobile) {
            if ($user->mobile != $request->mobile) {
                $activationCode = rand(1000, 9999);

                $user->activation_code = $activationCode;

                Auth::user()->tokens->each(function ($token, $key) {
                    $token->delete();
                });
                $user->country_id = 1;
                $user->mobile = $request->mobile;
                $user->status = 'not_verified';
                $user->accessToken = $user->createToken('User_' . $user->id . '_' . Carbon::now()->toDateTimeString())->plainTextToken;
                $user->save();

                if($user->role == 'patient'){
                    $patient                 = $user->patient;
                    $patient->date_of_birth  = $request->birth_date;
                    $patient->gender         = $request->gender;
                    $patient->blood_type     = $request->blood_type;
                    $patient->save();
                }

                try {
                    SendSMS::dispatch($user->mobile, trans('api_texts.your_activation_code') . ' : ' . $activationCode);
                    SendUserEmail::dispatch($user, new ActivationCode($user->activation_code));
                } catch (\Exception $e) {
                }

                if (config('custom.send_sms_via_notification')) {
                    SendUserNotification::dispatch($user->id, 'sms_message', ['message' => trans('api_texts.your_activation_code') . ' : ' . $activationCode]);
                }

                $user = UserResource::make($user);

                return ApiActions::generateResponse(compact('user'), 'verify_mobile', ResponseCode::NOT_VERTIFIED);
            }

        }

        $user->save();
        $user = UserResource::make($user);

        return ApiActions::generateResponse(compact('user'), 'profile_updated', ResponseCode::OK);
    }

    #[OA\Post(
        path: "/api/v1/user/forget_password",
        operationId: "forgetPassword",
        tags: ["AuthanticationApiSection"],
        summary: "forget password API",
        description: "forget password api ;;; this api use with three senarios 1. send the mobile only to send the code 2. send the mobile with the code to check if the code is valid (optional) 3. send the mobile with the code and the new password to change the password",
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: "multipart/form-data",
                schema: new OA\Schema(
                    schema: "forget_password",
                    required: ["mobile"],
                    properties: [
                        new OA\Property(
                            property: "mobile",
                            description: "user mobile must send in every scenario",
                            type: "string"
                        ),
                        new OA\Property(
                            property: "code",
                            description: "the forget check code must send to check if the code valid or to change the password",
                            type: "string"
                        ),

                        new OA\Property(
                            property: "password",
                            description: "the new password must send with the code and mobile to change the password",
                            type: "string"
                        )
                    ]
                )
            )
        ),
        parameters: [
            new OA\Parameter(
                ref: "#/components/parameters/language"
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "OK",
                content: new OA\JsonContent(
                    oneOf: [
                        new OA\Schema(
                            ref: "#/components/schemas/UserResource"
                        ),
                        new OA\Schema(
                            type: "boolean"
                        )
                    ]
                )
            ),

            new OA\Response(
                response: 422,
                description: "code expired , code wrong"
            ),

            new OA\Response(
                response: 404,
                description: "user not found"
            )
        ]
    )]
    public function forgetPassword(Request $request)
    {
        $request->validate([
            'mobile' => ['required', 'exists:users,mobile', new ValidMobile()],
        ], [
                'mobile.exists' => 'يجب التحقق على صحة الرقم المدخل'
            ]
        );
        if ($user = User::where('mobile', $request->mobile)->first()) {
            if ($request->code && !$request->password) {
                if ($request->code == $user->reset_code) {
                    if ($user->code_finished_at < Carbon::now()->toDateTimeString()) {
                        return ApiActions::generateResponse(null, 'code_expired', ResponseCode::VALIDATION_ERROR);
                    }

                    return ApiActions::generateResponse(null, 'code_valid', ResponseCode::OK);
                } else {
                    return ApiActions::generateResponse(null, 'code_wrong', ResponseCode::VALIDATION_ERROR);
                }
            }
            if ($request->code && $request->password) {
                if ($request->code == $user->reset_code) {
                    if ($user->code_finished_at < Carbon::now()->toDateTimeString()) {
                        return ApiActions::generateResponse(null, 'code_expired', ResponseCode::VALIDATION_ERROR);
                    }
                    $request->validate(['password' => [new PasswordPolicy()]]);
                    $user->password = Hash::make($request->password);
                    $user->last_login = Carbon::now();

                    $user->tokens->each(function ($token, $key) {
                        $token->delete();
                    });
                    $user->accessToken = $user->createToken('User_' . $user->id . '_' . Carbon::now()->toDateTimeString())->plainTextToken;
                    $user->save();

                    $user = UserResource::make($user);

                    return ApiActions::generateResponse(compact('user'), 'password_reset_done');
                } else {
                    return ApiActions::generateResponse(null, 'code_wrong', ResponseCode::VALIDATION_ERROR);
                }
            }
            $code = rand(1000, 9999);

            $user->reset_code = $code;
            $user->code_finished_at = Carbon::now()->addMinutes(config('custom.reset_code_expired_period', 30));
            $user->save();
            try {
                SendSMS::dispatch($user->mobile, lang('api_texts.your_reset_code') . $user->reset_code);
            } catch (\Exception $e) {
            }

            if (config('custom.send_sms_via_notification')) {
                SendUserNotification::dispatch($user->id, 'sms_message', ['message' => lang('api_texts.your_reset_code') . $user->reset_code]);
            }

            return ApiActions::generateResponse($code, 'password_reset_code_sended');
        } else {
            return ApiActions::generateResponse(null, 'user_not_found', ResponseCode::NOT_FOUND);
        }
    }
}
