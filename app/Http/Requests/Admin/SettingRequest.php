<?php

namespace App\Http\Requests\Admin;

use App\Rules\ValidInstagram;
use App\Rules\ValidTwitter;
use App\Rules\ValidFaceBook;
use App\Rules\ValidMobile;
use App\Rules\ValidString;
use App\Rules\ValidGooglePlay;
use App\Rules\ValidAppleStore;
use App\Rules\ValidStringArabic;
use App\Rules\ValidUrl;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
     /**
             * @OA\Schema(
             *  schema="SettingRequest",
             *  title="SettingRequest",
             *  required={"sample1","sample2"},
             *  @OA\Property(
             *      property="sample1",
             *      description="sample1 desc",
             *      type="number",
             *  ),
             *  @OA\Property(
             *      property="sample2",
             *      description="sample2 desc",
             *      type="string",
             *  ),
             * )
             */
        public function authorize()
        {
            return true;
        }


    public function rules()
    {
        return [
            'update_android'         =>['nullable','numeric'],
            'update_ios'             =>['nullable','numeric'],
            'ios_version'            =>['required','numeric'],
            'android_version'        =>['required','numeric'],
            'whatsapp'               =>['required'],
            'mobile'                 =>['required',new ValidMobile()],
            'instagram'               =>['required',new ValidInstagram()],
            'twitter'                =>['required',new ValidTwitter()],
            'facebook'              =>['required',new ValidFaceBook()],
            'currency_ar'            =>['required',new ValidStringArabic()],
            'name_ar'                =>['required',new ValidStringArabic()],
            'name_en'                =>['required',new ValidString()],
            'currency_en'            =>['required',new ValidString()],
            'ios'                    =>['required',new ValidAppleStore()],
            'android'                =>['required',new ValidGooglePlay()],
            'email'                  =>['required','email'],
            'address'                =>['required',new ValidStringArabic()],
            'address_en'             =>['required',new ValidString()],
            'linked_in'              =>['required',new ValidUrl()],

        ];
    }
}
