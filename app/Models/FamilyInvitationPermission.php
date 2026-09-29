<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FamilyInvitationPermission extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(FamilyInvitation::class, 'family_invitation_id');
    }

    public function permissionType(): BelongsTo
    {
        return $this->belongsTo(FamilyPermissionType::class, 'permission_type_id');
    }
}
