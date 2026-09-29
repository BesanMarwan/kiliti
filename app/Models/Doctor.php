<?php

namespace App\Models;

use App\Traits\HasSearchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    use HasFactory, HasSearchable;
    protected $guarded =[];

    public function dialysisCenter(): BelongsTo
    {
        return $this->belongsTo(DialysisCenter::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function patients()
    {
        return $this->belongsToMany(Patient::class,'patient_doctors')->withPivot(['is_primary', 'started_at', 'ended_at'])->withTimestamps();
    }

    public function dialysisSessions()
    {
        return $this->hasMany(DialysisSession::class);
    }

    public function dietPlans()
    {
        return $this->hasMany(DietPlan::class);
    }

    public function medicalNotes()
    {
        return $this->hasMany(MedicalNote::class);
    }

    public function consultations(): HasMany
    {
        return $this->hasMany(DoctorConsultation::class);
    }
}
