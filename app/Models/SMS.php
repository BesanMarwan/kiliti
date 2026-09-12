<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasSearchable;


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
 */
class SMS extends Model
{
    use HasSearchable;
    protected $table='sms';
    protected $hidden=['created_at','updated_at'];


    public static function getSearchable()
    {
        return [
//
//            'type'=>[
//                'type'=>'select',
//                'operation'=>'=',
//                'title'=>lng('dashboard.general.type','الفئة المستهدفة'),
//                'options'=>self::getTypeArray(),
//            ],


            'created_at'=>[
                'type'=>'range',
                'operation'=>'range',
                'title'=>lng('dashboard.global_notifications.date',' تاريخ الارسال'),
            ],

        ];
    }

    public static function getTypeArray()
    {
        return ['users'=>lng('dashboard.sms.all_users','جميع العملاء')];
    }


    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }


    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }


    public function getTypeTextAttribute(){
        switch ($this->type){
            case 'users'       : return 'جميع العملاء';
            case 'supervisors' : return 'جميع المشرفين';
            default            : return 'غير محدد';
        }
    }

}
