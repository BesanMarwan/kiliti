<?php

namespace App\Models;

use App\Classes\GeneralModel;
use App\Rules\ValidString;
use App\Rules\ValidStringArabic;
use App\Traits\HasSearchable;
use App\Traits\HasStatus;
use App\Traits\HasTranslations;
use App\Traits\ImageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Validation\Rule;

class Medication extends Model
{
    use HasTranslations,HasSearchable,HasStatus,ImageTrait;
    public $guarded =[];

    public $translatable = ['name','description','important_alert'];

    public bool $has_status = true;

    public string $permission_name = 'medication';
    public string $validation_request = 'MedicationRequest';

    public string $display_name = 'الأدوية العامة';

    public function patientMedications() : HasMany
    {
        return $this->hasMany(PatientMedication::class);
    }

    public function category(){
        return $this->belongsTo(GeneralData::class,'category_id');
    }


    public function can_del(){
        return ! (0);
    }

    public static function getSearchable()
    {
        $general_item    = GeneralData::where('uuid','drug_categories')->first();
        $drug_categories = GeneralData::where('parent_id',$general_item->id)->get();
        return [

            'name'=>[
                'type'=>'string',
                'operation'=>'like',
                'title'=>lng('dashboard.general.name'),
            ],
            'category_id'=>[
                'type'=>'select',
                'operation'=>'=',
                'title'=>lng('dashboard.category.category','القسم'),
                'options'=>$drug_categories,
            ],
            'status'=>[
                'type'=>'select',
                'operation'=>'=',
                'title'=>lng('dashboard.general.status','الحالة'),
                'options'=>Category::getStatusArray(),
            ],
        ];
    }

    public function rules():array
    {
        $id = $this->id;
        return [
            'name_ar'            => ['required','string',new ValidStringArabic(),Rule::unique('medications','name')->ignore($id)],
            'name_en'            => ['required','string',new ValidString(),Rule::unique('medications','name')->ignore($id)],
            'description_ar'     => ['required','string',new ValidStringArabic()],
            'description_en'     => ['required','string',new ValidString()],
            'important_alert_ar' => ['required','string',new ValidStringArabic()],
            'important_alert_en' => ['required','string',new ValidString()],
            'image'              => ['required']
        ];
    }
}
