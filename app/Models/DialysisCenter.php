<?php

namespace App\Models;

use App\Traits\HasSearchable;
use App\Traits\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DialysisCenter extends Model
{
    use HasFactory,HasStatus,HasSearchable;

    protected $guarded =[];

    public function doctors(): HasMany
    {
        return $this->hasMany(Doctor::class);
    }

    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function patients() : BelongsToMany
    {
        return $this->belongsToMany(Patient::class, 'patient_centers', 'center_id', 'patient_id')->withPivot(['status', 'started_at', 'ended_at',])->withTimestamps();
    }

    public function dialysisSessions() : HasMany
    {
        return $this->hasMany(DialysisSession::class, 'center_id');
    }

    public function announcements() : HasMany
    {
        return $this->hasMany(Announcement::class,'target_center_id');
    }




    public function getStatusTitleAttribute()
    {
        switch ($this->status){
            case 'disabled': return 'معطل';
            case 'enabled': return 'فعال';
            case 'temporarily_closed': return 'موقوف مؤقتا';
            default: return 'غير معروف';
        }
    }
    public function getStatusColorAttribute()
    {
        switch ($this->status){
            case 'disabled': return 'badge-danger';
            case 'enabled': return 'badge-success';
            case 'temporarily_closed': return 'badge-warning';

            default: return 'badge-light';
        }
    }


    public static function getStatusArray(){
        return ['enabled'=>'فعال','disabled'=>'معطل','temporarily_closed'=>'موقوف مؤقتا'];
    }


    public static function getSearchable()
    {
        return [

            'name'=>[
                'type'=>'string',
                'operation'=>'like',
                'title'=>lng('dashboard.centers.name','اسم المركز'),
            ],

            'phone'=>[
                'type'=>'string',
                'operation'=>'like',
                'title'=>lng('dashboard.centers.mobile','رقم الجوال'),
            ],

            'total_machines'=>[
                'type'=>'number',
                'operation'=>'=',
                'title'=>lng('dashboard.centers.total_machines','عدد الأجهزة'),
            ],
            'working_machines'=>[
                'type'=>'number',
                'operation'=>'=',
                'title'=>lng('dashboard.centers.working_machines','الأجهزة الفعالة'),
            ],
            'status'=>[
                'type'=>'select',
                'operation'=>'=',
                'title'=>lng('dashboard.general.status','الحالة'),
                'options'=>self::getStatusArray(),
            ],


        ];
    }

}
