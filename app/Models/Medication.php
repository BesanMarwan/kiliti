<?php

namespace App\Models;

use App\Traits\HasSearchable;
use App\Traits\HasStatus;
use App\Traits\HasTranslations;
use App\Traits\ImageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medication extends Model
{
    use HasTranslations,HasSearchable,HasStatus,ImageTrait;
    public $guarded =[];

    public $translatable = ['name','description','important_alert'];
    public function patientMedications() : HasMany
    {
        return $this->hasMany(PatientMedication::class);
    }

    public function category(){
        return $this->belongsTo(GeneralData::class,'category_id');
    }
}
