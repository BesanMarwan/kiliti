<?php

namespace App\Models;

use App\Enums\MedicationFrequency;
use App\Traits\HasSearchable;
use App\Traits\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PatientMedication extends Model
{
    use HasFactory,HasSearchable;
    public $guarded =[];
    protected $appends = [
        'next_dose_time',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'reminder_times' => 'array',
            'reminder_enabled' => 'boolean',
            'frequency' => MedicationFrequency::class,

        ];

    }


   public function patient()
    {
        return $this->belongsTo(Patient::class);
    }


    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function medication()
    {
        return $this->belongsTo(Medication::class);
    }
    public function alerts(): HasMany
    {
        return $this->hasMany(MedicationAlert::class);
    }

    public function routeObj()
    {
        return $this->belongsTo(GeneralData::class,'route');
    }


    public function logs()
    {
        return $this->hasMany(MedicationLog::class);
    }


    public function getNextDoseTimeAttribute()
    {

        if (!$this->reminder_enabled || empty($this->reminder_times)) {
            return null;
        }

        $now = now('Asia/Gaza');

        if ($this->status !== 'active' || !$this->reminder_enabled || empty($this->reminder_times)) {
            return null;
        }

        foreach ($this->reminder_times as $time) {
            $doseTime = $now->copy()->setTimeFromTimeString($time);

            if ($doseTime->isAfter($now)) {
                return $doseTime;
            }
        }

        return $now->copy()->addDay()->setTimeFromTimeString($this->reminder_times[0]);
    }


    public static function getSearchable()
    {

        return [


            'patient_id'=>[
                'type'=>'select',
                'operation'=>'has',
                'relation'=>'patients',
                'title'=>lng('dashboard.general.patients','المريض'),
                'options'=>Patient::all(),
            ],

            'doctor_id'=>[
                'type'=>'select',
                'operation'=>'has',
                'relation'=>'doctors',
                'title'=>lng('dashboard.general.doctor','الدكتور'),
                'options'=> Doctor::all(),
            ],

            'medication_id'=>[
                'type'=>'select',
                'operation'=>'has',
                'relation'=>'medications',
                'title'=>lng('dashboard.general.medication','اسم الدواء'),
                'options'=>Patient::all(),
            ],

            'start_date'=>[
                'type'=>'date',
                'operation'=>'range',
                'title'=>lng('dashboard.patient_medication.start_date','بداية العلاج'),
            ],


            'end_date'=>[
                'type'=>'date',
                'operation'=>'range',
                'title'=>lng('dashboard.patient_medication.end_date','نهاية العلاج'),
            ],

            'status'=>[
                'type'=>'select',
                'operation'=>'=',
                'title'=>lng('dashboard.general.status','الحالة'),
                'options'=>self::getStatusArray(),
            ],
        ];
    }

    public static function getStatusArray(){
        return [
            'active'=>'نشط',
            'completed'=>'مكتمل',
            'stopped'=>'موقوف',
        ];
    }

    public function getStatusTitleAttribute()
    {
        switch ($this->status){
            case 'active': return 'نشط';
            case 'completed': return 'مكتمل';
            case 'stopped': return 'موقوف';
            default: return 'غير معروف';
        }
    }
    public function getStatusColorAttribute()
    {
        switch ($this->status){

            case 'active': return 'badge-success';
            case 'completed': return 'badge-info';
            case 'stopped': return 'badge-danger';
            default: return 'badge-light';
        }
    }


}
