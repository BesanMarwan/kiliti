<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'birth_date',
        'gender',
        'blood_type',
        'kidney_disease_type',
        'dialysis_type',
        'dialysis_start_date',
        'emergency_contact_name',
        'emergency_contact_phone',
        'medical_notes',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];


    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'dialysis_start_date' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'patient_doctors')->withPivot(['is_primary', 'started_at', 'ended_at',]);
    }

    public function centers()
    {
        return $this->belongsToMany(DialysisCenter::class, 'patient_centers', 'patient_id', 'center_id');
//        return $this->belongsToMany(DialysisCenter::class, 'patient_centers', 'patient_id', 'center_id');
//            ->withPivot(['status', 'started_at', 'ended_at',])->withTimestamps();
    }

    public function familyMembers()
    {
        return $this->belongsToMany(FamilyMember::class, 'patient_family_members', 'patient_id', 'family_member_id')->with('user')->withPivot(['relationship','can_view_health_data', 'can_receive_alerts']);
    }

}
