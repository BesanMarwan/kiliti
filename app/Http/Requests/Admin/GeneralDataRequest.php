<?php

namespace App\Http\Requests\Admin;

use App\Rules\ValidString;
use App\Rules\ValidStringArabic;
use Illuminate\Foundation\Http\FormRequest;

class GeneralDataRequest extends FormRequest
{
     /**
             * @OA\Schema(
             *  schema="GeneralDataRequest",
             *  title="GeneralDataRequest",
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
            'name_ar'=>['required',new ValidStringArabic(),'min:3'],
            'name_en'=>['required',new ValidString(),'min:3'],
        ];
    }
}
