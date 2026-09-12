<?php

namespace App\Models;

use App\Traits\HasSearchable;
use Illuminate\Contracts\Notifications\Dispatcher;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\RoutesNotifications;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\Models\Admin
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $mobile
 * @property string $password
 * @property string|null $image
 * @property string|null $fcm_token
 * @property \Illuminate\Support\Carbon|null $login_at
 * @property int $status
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $image_url
 * @property-read int|null $new_notifications_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read int|null $notifies_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin query()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereFcmToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Admin extends Authenticatable
{
    use HasFactory,HasRoles,RoutesNotifications,HasSearchable;

    protected $guard = 'admin';

    protected $guard_name = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'login_at' => 'datetime',
    ];

    protected $withCount = ['notifications'];


    public function notifies()
    {
        return $this->morphMany(FcmNotification::class, 'owner');
    }
    public function notifications()
    {
        return $this->morphMany(FcmNotification::class, 'owner')->orderByDesc('created_at')->limit(30);
    }

    public function new_notifications()
    {
        return $this->morphMany(FcmNotification::class, 'owner')->whereNull('read_at')->orderBy('created_at','desc')->limit(40);
    }

    public function getImageUrlAttribute()
    {
        $logo = isset($this->attributes['image']) ? $this->attributes['image'] : '';

        return $logo ? asset('uploads/'.$logo) : asset('uploads/blank.png');
    }

    public function routeNotificationForFcm()
    {
        return trim($this->fcm_token);
    }


    public static function getSearchable()
    {
        return [

            'name' => [
                'type' => 'string',
                'operation' => 'like',
                'title' =>lng('dashboard.general.Name'),
            ],
            'mobile' => [
                'type' => 'string',
                'operation' => 'like',
                'title' =>lng('dashboard.general.mobile'),
            ],
            'email' => [
                'type' => 'string',
                'operation' => 'like',
                'title' => lng('dashboard.general.email'),
            ],

            'rule_id' => [
                'type' => 'select',
                'operation' => 'has',
                'title' => lng('dashboard.general.role'),
                'relation' => 'roles',
                'options' => Role::where('id', '<>', 1)->get(),
            ],


        ];
    }



    public function scopeFilter($query,$request){
        return $query
            ->when($request->name ?? null ,function ($query_name,$user_name){
                $query_name->where('name','like','%'.$user_name.'%');

            })
            ->when($request->mobile ?? null ,function ($query_name,$mobile){
                $query_name->where('mobile','like','%'.$mobile.'%');

            })
            ->when($request->email ?? null ,function ($query_email,$email){
                $query_email->where('email','like','%'.$email.'%');

            })


            ->when($request->rule_id ?? null ,function ($query_rule_id,$role){
                $query_rule_id->whereHas('roles', function (Builder $subQuery) use ($role) {
                    $subQuery->where(config('permission.table_names.roles').'.id', $role);
                });

            });
        return $query;

    }






}
