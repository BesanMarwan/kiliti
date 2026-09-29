<?php

namespace App\Models;

use App\Traits\AddMobilePrefix;
use App\Traits\HasSearchable;
use App\Traits\HasStatus;
use App\Traits\ImageTrait;
use Illuminate\Contracts\Notifications\Dispatcher;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $mobile
 * @property string|null $activation_code
 * @property string|null $reset_code
 * @property string $password
 * @property string|null $avatar
 * @property int $status
 * @property string|null $email_verified_at
 * @property \Illuminate\Support\Carbon|null $last_login
 * @property string|null $code_finished_at
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DeviceKey[] $devices
 * @property-read int|null $devices_count
 * @property-read mixed $image_url
 * @property-read mixed $status_color
 * @property-read mixed $status_title
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereActivationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCodeFinishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereResetCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $country_id
 * @property string|null $language
 * @property string $accessToken
 * @property int $mobile_changed
 * @property int $enable_notification
 * @property string $schedule_notification_before
 * @property-read \App\Models\Country|null $country
 * @method static \Illuminate\Database\Eloquent\Builder|User filter($request)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAccessToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEnableNotification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMobileChanged($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereScheduleNotificationBefore($value)
 */
class User extends Authenticatable
{
    use HasApiTokens,HasFactory, Notifiable,HasSearchable,AddMobilePrefix,ImageTrait,HasStatus;

    protected $guarded=[];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'last_login' => 'datetime',
    ];

    public static function getSearchable()
    {
        return [
            'name'=>[
                'type'=>'string',
                'operation'=>'like',
                'title'=>lng('dashboard.general.name'),
            ],
            'mobile'=>[
                'type'=>'string',
                'operation'=>'like',
                'title'=>lng('dashboard.general.mobile'),
            ],
            'email'=>[
                'type'=>'string',
                'operation'=>'like',
                'title'=>lng('dashboard.general.email'),
            ],
            'status'=>[
                'type'=>'select',
                'title'=>lng('dashboard.general.status','الحالة'),
                'options'=>['not_verified'=>'غير مؤكد','enabled'=>'فعال','disabled'=>'معطل']
            ],
        ];
    }



    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function devices()
    {
        return $this->morphMany(DeviceKey::class, 'owner');
    }

    public function notifications()
    {
        return $this->morphMany(FcmNotification::class, 'owner');
    }

    public function fcm_tokens()
    {
        return $this->devices()->pluck('fcm_token')->toArray();
    }

    public function patient()
    {
        return $this->hasOne(Patient::class,'user_id');
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    public function rate()
    {
        return $this->hasOne(ApplicationRate::class);
    }

    public function familyMember()
    {
        return $this->hasOne(FamilyMember::class);
    }


    public function announcementsCreated()
    {
        return $this->hasMany(Announcement::class, 'created_by');
    }

    public function targetedAnnouncements()
    {
        return $this->hasMany(Announcement::class, 'target_user_id');
    }

    public function reviewedAiAlerts()
    {
        return $this->hasMany(AiAlert::class, 'reviewed_by');
    }

    public function new_notifications()
    {
        return $this->morphMany(FcmNotification::class,'owner')->whereNull('read_at');
    }



    /**
     * Specifies the user's FCM token
     *
     * @return string|array
     */
    public function routeNotificationForFcm()
    {
        return isset($this->alt_tokens)&&is_array($this->alt_tokens)?$this->alt_tokens:$this->fcm_tokens();
    }

}
