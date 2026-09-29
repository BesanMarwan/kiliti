<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PatientFamilyMember extends Model
{
    use HasFactory;

    protected $guarded=[];

    protected $hidden =['created_at','updated_at'];


    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function familyMember(): BelongsTo
    {
        return $this->belongsTo(FamilyMember::class);
    }

    public function permissions(): HasMany
    {
        return $this->hasMany(FamilyPermission::class);
    }

    public function hasPermission(string $permission): bool
    {
        return $this->permissions()->whereHas('permissionType', function ($query) use ($permission) {
                $query->where('name', $permission);
            })
            ->exists();
    }

}
