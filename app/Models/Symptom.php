<?php

namespace App\Models;

use App\Traits\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Symptom extends Model
{
    use HasFactory,HasStatus;

    protected $guarded =[];

    protected function casts(): array
    {
        return [
            'is_critical' => 'boolean',
        ];
    }

    public function patientSymptoms() : HasMany
    {
        return $this->hasMany(PatientSymptom::class);
    }

    public function tips(): HasMany
    {
        return $this->hasMany(SymptomTip::class, 'symptom_id')->orderBy('sort_order');
    }
}
