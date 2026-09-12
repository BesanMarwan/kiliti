<?php

namespace App\Models;

use App\Traits\HasSearchable;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GlobalNotification
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $message
 * @property string|null $image
 * @property int|null $admin_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|GlobalNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GlobalNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GlobalNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder|GlobalNotification whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GlobalNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GlobalNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GlobalNotification whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GlobalNotification whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GlobalNotification whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read mixed $image_url
 * @method static \Illuminate\Database\Eloquent\Builder|GlobalNotification whereImage($value)
 * @property string $type
 * @method static \Illuminate\Database\Eloquent\Builder|GlobalNotification filter($request)
 * @method static \Illuminate\Database\Eloquent\Builder|GlobalNotification whereType($value)
 */
class GlobalNotification extends Model
{
    protected $table = 'global_notifications';
    use HasSearchable;

    public static function getSearchable()
    {
        return [

            'title'=>[
                'type'=>'string',
                'operation'=>'like',
                'title'=>lng('dashboard.global_notifications.title','العنوان'),
            ],

            'created_at'=>[
                'type'=>'range',
                'operation'=>'range',
                'title'=>lng('dashboard.global_notifications.date',' تاريخ الارسال'),
            ],

        ];
    }

    protected $hidden = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getImageUrlAttribute()
    {
        $logo = isset($this->attributes['image']) ? $this->attributes['image'] : '';

        return $logo ? asset('uploads/'.$logo) : asset('uploads/blank.png');
    }
}
