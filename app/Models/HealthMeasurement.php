<?php

namespace App\Models;

use App\Traits\HasSearchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthMeasurement extends Model
{
    use HasFactory,HasSearchable;

    protected $guarded =[];

    protected function casts(): array
    {
        return [
            'measured_at' => 'datetime',
            'value' => 'decimal:2',
            'value_secondary' => 'decimal:2',
        ];
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public static function getSearchable()
    {
        return [


            'type'=>[
                'type'=>'select',
                'title'=>'نوع القياس',
                'options' =>['weight','blood_pressure','heart_rate','temperature','blood_sugar'],
            ],

            'measured_at'=>[
                'type'=>'range',
                'operation'=>'=',
                'title'=>'وقت القياس',
            ],

        ];
    }
}
