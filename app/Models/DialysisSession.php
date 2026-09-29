<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DialysisSession extends Model
{
    use HasFactory;

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
}
