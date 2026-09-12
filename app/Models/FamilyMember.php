<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    use HasFactory;

    protected $guarded=[];
    protected $hidden =['created_at','updated_at'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function patients()
    {
        return $this->belongsToMany(Patient::class, 'patient_family_members', 'family_member_id', 'patient_id')->withPivot(['relationship', 'can_view_health_data', 'can_receive_alerts',])->withTimestamps();
    }
}
