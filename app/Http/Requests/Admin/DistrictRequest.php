<?php

namespace App\Http\Requests\Admin;

use App\Rules\ValidString;
use App\Rules\ValidStringArabic;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DistrictRequest extends FormRequest
{
     /**
             * @OA\Schema(
             *  schema="DistrictRequest",
             *  title="DistrictRequest",
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
        $id = $this->id;
        return [
            'name_ar'   => ['required',new ValidStringArabic(),Rule::unique('cities','name->ar')->where('parent_id','<',0)->ignore($id)],
            'name_en'   => ['required',new ValidString(),Rule::unique('cities','name->en')->where('parent_id','<>',0)->ignore($id)],
            'area_id'   => ['required',Rule::exists('cities','id')->where('parent_id',0)],
            'city_id' => ['required',Rule::exists('cities','id')]
        ];
    }
}
