<?php

namespace App\Models;

use App\Traits\HasSearchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DialysisSessionIssue extends Model
{
    use HasFactory,HasSearchable;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'reported_at' => 'datetime',
        ];
    }

    public function dialysisSession(): BelongsTo
    {
        return $this->belongsTo(DialysisSession::class, 'dialysis_session_id');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public static function getSearchable()
    {
        return [


            'reported_at'=>[
                'type'=>'range',
                'operation'=>'=',
                'title'=>'تاريخ',
            ],

            'status'=>[
                'type'=>'select',
                'operation'=>'=',
                'title'=>'الحالة',
                'options'=>self::getStatusArray()
            ],
        ];
    }

    public static function  getStatusArray(){
        return ['open', 'acknowledged', 'resolved'];
    }

}
