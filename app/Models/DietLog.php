<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DietLog extends Model
{
    use HasFactory;

    protected $guarded =[];

    protected function casts(): array
    {
        return [
            'recorded_at' => 'datetime',
            'calories' => 'decimal:2',
        ];
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
