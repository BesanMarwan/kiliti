<?php

namespace App\Models;

use App\Traits\HasSearchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoctorConsultation extends Model
{
    use HasFactory,HasSearchable;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'sent_at' => 'datetime',
            'answered_at' => 'datetime',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function consultation_type_object(): BelongsTo
    {
        return $this->belongsTo(GeneralData::class,'consultation_type');
    }



    public static function getSearchable(){
        return [

            'status'=>[
                'type'=>'select',
                'operation'=>'=',
                'title'=>lng('dashboard.general.status'),
                'options'=>self::getStatusArray(),
            ],
        ];
    }

    public static function getStatusArray(){
        return ['pending'=>'قيد المراجعة','answered'=>'تم الرد','closed'=>'مغلق'];
    }

    public function getStatusTitleAttribute()
    {
        switch ($this->status){
            case 'pending' : return 'قيد المراجعة';
            case 'answered': return 'تم الرد';
            case 'closed'  : return 'مغلق';
            default        : return 'غير معروف';
        }
    }

}
