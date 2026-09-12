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
 * @property array $data_keys
 * @property string|null $last_update
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationLog whereDataKeys($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationLog whereLastUpdate($value)
 */
class NotificationLog extends Model
{
    use HasFactory;

    protected $table = 'notifications_logs';
    protected $casts=['data_keys'=>'array'];
    protected $guarded=[];

    public static function updateNotification($notification_key,$data)
    {
        $f=self::where('notification_key',$notification_key)->first();
        if($f){
            $ne_dat=$f->data_keys;

            foreach ($data as $k){
                if(!in_array($k,array_keys($f->data_keys))){
                    $ne_dat[$k]=1;
                }else{
                    $ne_dat[$k]=$ne_dat[$k]+1;
                }
            }
            $f->data_keys=$ne_dat;
            $f->last_update=now();
            $f->save();
        }else{
            $ne_dat=[];

            foreach ($data as $k){
               $ne_dat[$k]=1;

            }
            self::create([
                'notification_key'=>$notification_key,
                'data_keys'=>$ne_dat,
                'last_update'=>now()
            ]);
        }
    }

}
