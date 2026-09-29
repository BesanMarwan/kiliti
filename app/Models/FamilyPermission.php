<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FamilyPermission extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function patientFamilyMember(): BelongsTo
    {
        return $this->belongsTo(PatientFamilyMember::class);
    }

    public function permissionType(): BelongsTo
    {
        return $this->belongsTo(FamilyPermissionType::class, 'permission_type_id');
    }
}
