<?php

namespace App\Models;

use App\Enums\FamilyInvitationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class FamilyInvitation extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'accepted_at' => 'datetime',
            'status' => FamilyInvitationStatus::class,
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function acceptedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'accepted_by_user_id');
    }

    public function permissions(): HasMany
    {
        return $this->hasMany(FamilyInvitationPermission::class);
    }

    public function isPending(): bool
    {
        return $this->status === FamilyInvitationStatus::PENDING;
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function patientFamilyMember(): HasOne
    {
        return $this->hasOne(PatientFamilyMember::class, 'patient_id', 'patient_id'
                     )->whereHas('familyMember', function ($query) {
                         $query->whereHas('user', function ($query) {
                             $query->whereColumn(
                                 'users.id',
                                 'family_members.user_id'
                             );
                         });
                     });
    }

}

