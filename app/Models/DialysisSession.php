<?php

namespace App\Models;

use App\Traits\HasSearchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DialysisSession extends Model
{
    use HasFactory,HasSearchable;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'scheduled_at' => 'datetime',
            'started_at' => 'datetime',
            'ended_at' => 'datetime',
        ];
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function center()
    {
        return $this->belongsTo(DialysisCenter::class, 'center_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function record()
    {
        return $this->hasOne(DialysisSessionRecord::class, 'session_id');
    }

    public function medicalNotes()
    {
        return $this->hasMany(MedicalNote::class, 'session_id');
    }


    public function issues(): HasMany
    {
        return $this->hasMany(DialysisSessionIssue::class, 'dialysis_session_id');
    }

    public  function getSessionTypeTitleAttribute(){
        switch($this->session_type){
            case 'hemodialysis' : return 'غسيل دموي';
            case 'peritoneal' : return 'غسيل بريتوني';
            default : return 'غير معروف';
        }
    }


    public static function getStatusArray()
    {
        return [
             'scheduled'=>'مجدول',
             'confirmed'=>'مؤكد',
             'checked_in'=>'تم الحضور',
             'in_progress'=>'قيد المتابعة',
             'completed'=>'مكتمل',
             'missed'=>'فائتة',
             'cancelled'=>'ملغي',
            ];

    }

    public function getStatusTitleAttribute()
    {
        switch ($this->status){
            case 'scheduled': return 'مجدول';
            case 'confirmed': return 'مؤكد';
            case 'checked_in': return 'تم الحضور';
            case 'in_progress': return 'قيد المتابعة';
            case 'completed': return 'مكتمل';
            case 'missed': return 'فائتة';
            case 'cancelled': return 'ملغي';
            default: return 'غير معروف';
        }
    }
    public function getStatusColorAttribute()
    {
        switch ($this->status){
            case 'scheduled': return 'badge-primary';
            case 'confirmed': return 'badge-info';
            case 'checked_in': return 'badge-light-warning';
            case 'in_progress': return 'badge-light-success';
            case 'completed': return 'badge-success';
            case 'missed': return 'badge-light-danger';
            case 'cancelled': return 'badge-danger';
            default: return 'badge-light';
        }
    }


    public static function getSearchable(){
        return [
            'center_id'=>[
                'type'=>'select',
                'operation'=>'=',
                'relation'=>'center',
                'title'=>lng('dashboard.sessions.center','اسم المركز'),
                'options' => DialysisCenter::all(),
            ],

            'session_type'=>[
                'type'=>'select',
                'operation'=>'=',
                'title'=>lng('dashboard.session.session_type','نوع الجلسة'),
                'options' => ['hemodialysis'=>'غسيل دموي','peritoneal'=>'غسيل بريتوني'],
            ],

            'scheduled_at'=>[
                'type'=>'range',
                'operation'=>'range',
                'title'=>lng('dashboard.session.scheduled_at','موعد الجلسة'),
            ],


            'status'=>[
                'type'=>'select',
                'operation'=>'=',
                'title'=>lng('dashboard.general.status'),
                'options'=>self::getStatusArray(),
            ],
        ];
    }
}
