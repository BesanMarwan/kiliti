<?php

namespace App\Models;

use App\Traits\HasSearchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * App\Models\Contact
 *
 * @property int $id
 * @property string $name
 * @property string $mobile
 * @property string|null $email
 * @property int|null $country_id
 * @property string|null $title
 * @property string $message
 * @property int $is_seen
 * @property int|null $creator_id
 * @property string|null $creator_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Country|null $country
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Replay> $replies
 * @property-read int|null $replies_count
 * @method static \Illuminate\Database\Eloquent\Builder|Contact filter($request)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact query()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereCreatorType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereIsSeen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Contact extends Model
{
    use HasFactory,HasSearchable;
    protected $guarded=[];

    protected $hidden = ['updated_at'];


    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function replies(){
        return $this->hasMany(ContactReplay::class,'contact_id');
    }
    public function creator()
    {
        return $this->morphTo();
    }

    public static function getSearchable()
    {
        return [

            'name'=>[
                'type'=>'string',
                'operation'=>'like',
                'title'=>'الاسم',
            ],
            'email'=>[
                'type'=>'string',
                'operation'=>'like',
                'title'=>'الايميل',
            ],

            'mobile'=>[
                'type'=>'string',
                'operation'=>'like',
                'title'=>'رقم الجوال',
            ],

            'created_at'=>[
                'type'=>'range',
                'operation'=>'=',
                'title'=>'تاريخ الارسال',
            ],

            'is_seen'=>[
                'type'=>'checkbox',
                'operation'=>'!=',
                'title'=>'جديد',
            ],


        ];
    }


    public static function boot() {
        parent::boot();

        static::deleting(function($contact) { // before delete() method call this
            $contact->replies()->delete();
        });
    }


}
