<?php

namespace App\Models;

use App\Traits\HasSearchable;
use App\Traits\HasStatus;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GeneralData
 *
 * @property int $id
 * @property array $name
 * @property string|null $uuid
 * @property int $parent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|GeneralData[] $children
 * @property-read int|null $children_count
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralData newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralData query()
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralData whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralData whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralData whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralData whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralData whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralData whereUuid($value)
 * @mixin \Eloquent
 * @property-read array $translations
 */
class GeneralData extends Model
{
    use HasFactory,HasTranslations,HasSearchable,HasStatus;

    protected $guarded=[];
    protected $translatable=['name'];

    protected $hidden=['uuid','parent_id','created_at','updated_at',];

    public function children()
    {
        return $this->hasMany(self::class,'parent_id');

    }

    public static function getSearchable(){
        return [

            'name'=>[
                'type'=>'string',
                'operation'=>'like',
                'title'=>'الاسم'
            ],
            'status'=>[
                'type'=>'select',
                'operation'=>'=',
                'title'=>'الحالة',
                'options'=>['enabled'=>'فعال','disabled'=>'معطل']
            ],
        ];

    }

    public array $fields = [
        'name' => [
            'type' => 'translation',
            'title' => ['ar' => 'الاسم', 'en' => 'Name'],
            'searchable' => true,
            'show_in_table' => true,
            'rules'=>['required']
        ],
        'status'=>[
            'type'=>'status',
            'title'=>'الحالة',
            'options'=>['enabled'=>'فعال','disabled'=>'معطل'],
            'searchable'=>true,
            'show_in_table'=>true,
            'rules'=>['required','in:enabled,disabled']
        ],
    ];
    public function medications(){
        return $this->hasMany(Medication::class,'category_id');
    }

    public function can_del()
    {
        return !($this->medications->count());
    }

}
