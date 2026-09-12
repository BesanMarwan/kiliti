<?php

namespace App\Actions;

 use App\Constants\ResponseCode;
 use App\Models\DeviceKey;
 use App\Models\Driver;
 use App\Models\User;
 use Barryvdh\TranslationManager\Models\Translation;
 use Illuminate\Http\Request;

 class ApiActions
 {
     public static function ChangeUserDevice(Request $request, $user = 0)
     {
         $user_id = $user ?: ($request->user() ? $request->user()->id : 0);
         $device_key = $request->header('device_key');
         $device_name = $request->header('device_name');
         $device_type = $request->header('device_type');
         $app_version = $request->header('app_version') ?? null;
         if (! $device_key) {
             $device_key = $request->token;
         }
         if (! $device_key) {
             return false;
         }
         if ($user_id) {
             if ($d_key = DeviceKey::where('fcm_token', $device_key)->first()) {
                 $d_key->owner_id = $user_id;
                 $d_key->owner_type = User::class;
                 $d_key->device_type = $device_name ?? $d_key->device_type;
                 $d_key->device_name = $device_type ?? $d_key->device_name;
                 $d_key->save();

                 $user = User::find($user_id);

                 if($user){
                     $user->update([
                        'device_type'=>$d_key->device_type,
                         'app_version'=>$app_version
                     ]);
                 }

                 if (config('custom.user_has_only_one_device_key')) {
                     DeviceKey::where('owner_id', $d_key->owner_id)->where('owner_type', User::class)->where('id', '<>', $d_key->id)->update(['owner_id' => 0]);
                 }
             } else {
                 $d_key = new DeviceKey();
                 $d_key->fcm_token = $device_key;
                 $d_key->owner_id = $user_id;
                 $d_key->owner_type = User::class;
                 $d_key->device_type = $device_name ?? '';
                 $d_key->device_name = $device_type ?? '';
                 $d_key->save();

                 $user = User::find($user_id);

                 if($user){
                     $user->update([
                         'device_type'=>$d_key->device_type,
                         'app_version'=>$app_version,
                     ]);
                 }

                 if (config('custom.user_has_only_one_device_key')) {
                     DeviceKey::where('owner_id', $d_key->owner_id)->where('owner_type', User::class)->where('id', '<>', $d_key->id)->update(['owner_id' => 0]);
                 }
             }
         } else {
             if (! DeviceKey::where('fcm_token', $device_key)->first()) {
                 $d_key = new DeviceKey();
                 $d_key->fcm_token = $device_key;
                 $d_key->owner_id = 0;
                 $d_key->owner_type = User::class;
                 $d_key->device_type = $device_name ?? '';
                 $d_key->device_name = $device_type ?? '';
                 $d_key->save();
             }
         }

         return true;
     }


     public static function generateResponse($data = null, $message_key = 'default_message', $code = ResponseCode::OK)
     {
         $text = '';
         if (is_array($message_key)) {
             $text = $message_key['text'];
             $message_key = $message_key['key'];
         }
//         dd(trans('api_texts.'.$message_key), 'api_texts.'.$message_key,trans('api_texts.'.$message_key) == 'api_texts.'.$message_key);
         if (trans('api_texts.'.$message_key) == 'api_texts.'.$message_key) {
             self::addToTrans($message_key);
         }
         $result = [
             'status' => $code == 200,
             'response_message' => trans('api_texts.'.$message_key, ['text' => $text]),
         ];
         if (is_array($data)) {
             $result = array_merge($result, $data);
         } else {
             $result['returned'] = $data;
         }

         return response()->json($result, $code, [], JSON_UNESCAPED_SLASHES);
     }

     public static function addToTrans($key)
     {
         Translation::firstOrCreate([
             'locale' => 'ar',
             'group' => 'api_texts',
             'key' => $key,
             'value' => translate(str_replace('_', ' ', $key), 'ar'),

         ]);
         Translation::firstOrCreate([
             'locale' => 'en',
             'group' => 'api_texts',
             'key' => $key,
             'value' => str_replace('_', ' ', $key),
         ]);
         Translation::firstOrCreate([
             'locale' => 'ur',
             'group' => 'api_texts',
             'key' => $key,
             'value' => translate(str_replace('_', ' ', $key), 'ur'),

         ]);
     }


 }
