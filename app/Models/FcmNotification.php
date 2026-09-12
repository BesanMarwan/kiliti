<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FcmNotification
 *
 * @property int $id
 * @property int $owner_id
 * @property string $owner_type
 * @property string $title
 * @property string $message
 * @property string $data
 * @property int|null $global_id
 * @property string $notification_key
 * @property string|null $firebase_response
 * @property string|null $link
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $message_trans
 * @property-read mixed $title_trans
 * @property-read \App\Models\GlobalNotification|null $globalNot
 * @property-read Model|\Eloquent $owner
 * @method static \Illuminate\Database\Eloquent\Builder|FcmNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FcmNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FcmNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder|FcmNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FcmNotification whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FcmNotification whereFirebaseResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FcmNotification whereGlobalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FcmNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FcmNotification whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FcmNotification whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FcmNotification whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FcmNotification whereNotificationKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FcmNotification whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FcmNotification whereOwnerType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FcmNotification whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FcmNotification whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $read_at
 * @method static \Illuminate\Database\Eloquent\Builder|FcmNotification whereReadAt($value)
 */
class FcmNotification extends Model
{
    use HasFactory;

    protected $table = 'fcm_notifications';

    protected $hidden = ['created_at', 'updated_at', 'notification_id', 'global_id', 'firebase_response', 'global_not'];

    protected $appends = ['title_trans', 'message_trans'];

    public function globalNot()
    {
        return $this->belongsTo(GlobalNotification::class, 'global_id');
    }

    public function owner()
    {
        return $this->morphTo();
    }

    public function getDataAttribute()
    {
        $d = $this->attributes['data'];

        return json_decode($d);
    }


    public function setDataAttribute($value)
    {
        $this->attributes['data'] = json_encode($value);
    }

    public function getTitleTransAttribute()
    {
        if ($this->global_id) {
            return $this->globalNot ? $this->globalNot->title : '';
        } else {
            return trans('notifications.titles.'.$this->notification_key);
        }
    }

    public function getMessageTransAttribute()
    {
        if ($this->global_id) {
            return  $this->globalNot ? $this->globalNot->message : '';
        } else {
            return trans('notifications.messages.'.$this->notification_key, (array) $this->data);
        }
    }
}
