<?php

namespace App\Http\Requests\Admin;

use App\Rules\ValidString;
use App\Rules\ValidStringArabic;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
     /**
             * @OA\Schema(
             *  schema="CategoryRequest",
             *  title="CategoryRequest",
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
        $id =$this->id;
        $rules =[
            'name_ar'=>['required','string',new ValidStringArabic()],
            'name_en'=>['required','string',new ValidString()],
            'status'=>['required',Rule::in(['enabled','disabled'])],
        ];

        if($id > 0){
            $rules +=[
              'image'=>'required',
            ];
        }
    }

}
