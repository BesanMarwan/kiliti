<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $guarded =[];

    protected function casts(): array
    {
        return [
            'send_notification' => 'boolean',
            'published_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function targetCenter()
    {
        return $this->belongsTo(DialysisCenter::class, 'target_center_id');
    }

    public function targetUser()
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }

    public function reads()
    {
        return $this->hasMany(AnnouncementRead::class);
    }
}
