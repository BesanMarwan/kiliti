<?php

namespace App\Models;

use App\Traits\HasSearchable;
use App\Traits\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DialysisCenter extends Model
{
    use HasFactory,HasStatus,HasSearchable;

    protected $fillable = [
        'name',
        'phone',
        'governorate',
        'city',
        'address',
        'total_machines',
        'working_machines',
        'status',
    ];

    public function doctors(): HasMany
    {
        return $this->hasMany(Doctor::class);
    }

}
