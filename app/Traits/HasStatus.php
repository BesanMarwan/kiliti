<?php

namespace App\Traits;



trait HasStatus
{


    public function getStatusTitleAttribute()
    {
        switch ($this->status){
            case 'disabled': return 'معطل';
            case 'enabled': return 'فعال';
            default: return 'غير معروف';
        }
    }
    public function getStatusColorAttribute()
    {
        switch ($this->status){
            case 'disabled': return 'badge-danger';
            case 'enabled': return 'badge-success';
            default: return 'badge-light';
        }
    }


    public static function getStatusArray(){
        return ['enabled'=>'فعال','disabled'=>'معطل'];
    }


    /*
     * Scopes
     */
    public function scopeActive($query){
        return $query->where('status','enabled');
    }

}
