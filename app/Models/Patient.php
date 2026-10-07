<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
            'dialysis_days' => 'array',
            'dialysis_time' => 'datetime:H:i',
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

    public function patientSymptoms(): HasMany
    {
        return $this->hasMany(PatientSymptom::class, 'patient_id');
    }

    public function dialysisSessions()
    {
        return $this->hasMany(DialysisSession::class);
    }

    public function medications()
    {
        return $this->hasMany(PatientMedication::class);
    }

    public function medicationLogs()
    {
        return $this->hasManyThrough(MedicationLog::class, PatientMedication::class, 'patient_id', 'patient_medication_id', 'id', 'id');
    }



    public function fluidLogs()
    {
        return $this->hasMany(FluidLog::class);
    }

    public function fluidAlerts(): HasMany
    {
        return $this->hasMany(FluidAlert::class);
    }


    public function healthMeasurements()
    {
        return $this->hasMany(HealthMeasurement::class);
    }

    public function dietPlans()
    {
        return $this->hasMany(DietPlan::class);
    }

    public function dietLogs()
    {
        return $this->hasMany(DietLog::class);
    }

    public function symptoms()
    {
        return $this->hasMany(PatientSymptom::class);
    }

    public function aiAlerts()
    {
        return $this->hasMany(AiAlert::class);
    }

    public function aiAnalysisLogs()
    {
        return $this->hasMany(AiAnalysisLog::class);
    }

    public function adherenceRecords()
    {
        return $this->hasMany(AdherenceRecord::class);
    }

    public function conversations()
    {
        return $this->hasMany(Conversation::class);
    }

    public function medicalNotes()
    {
        return $this->hasMany(MedicalNote::class);
    }


    public function familyInvitations()
    {
        return $this->hasMany(FamilyInvitation::class);
    }

    public function patientFamilyMembers()
    {
        return $this->hasMany(PatientFamilyMember::class);
    }

    public function doctorConsultations(): HasMany
    {
        return $this->hasMany(DoctorConsultation::class);
    }

    public function familyMembers()
    {
        return $this->belongsToMany(FamilyMember::class, 'patient_family_members', 'patient_id', 'family_member_id')->withPivot(['relationship', 'status',])->withTimestamps();
    }

    public function getGenderTitleAttribute()
    {
        switch ($this->gender){
            case 'female': return 'أنثى';
            case 'male': return 'ذكر';
            default: return 'غير معروف';
        }
    }
}
