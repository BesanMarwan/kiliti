<?php

namespace App\Models;

use App\Classes\GeneralModel;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ServiceCategory
 *
 * @property int $id
 * @property string $name
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\ServiceCategoryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCategory whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $status
 * @property-read mixed $image_url
 * @property-read array $translations
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCategory active()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCategory whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralModel filter($request)
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Query\Builder|ServiceCategory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ServiceCategory withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ServiceCategory withoutTrashed()
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Service[] $services
 * @property-read int|null $services_count
 */
class ServiceCategory extends GeneralModel
{
    use HasFactory,HasTranslations;

    protected $hidden=['image','created_at','updated_at','status',];
    public $translatable = ['name'];


    public array $fields = [
//        'image' => [
//            'type' => 'image',
//            'title' => 'الصورة',
//            'searchable' => false,
//            'show_in_table' => true,
//        ],
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

    public bool $has_status = true;

    public string $permission_name = 'service_categories';

    public string $display_name = 'تصيفات الخدمات';

    public function getImageUrlAttribute()
    {
        $logo = isset($this->attributes['image']) ? $this->attributes['image'] : '';

        if (\URL::isValidUrl($logo)) {
            return $logo;
        }

        return $logo ? asset('uploads/'.$logo) : asset('uploads/blank.png');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'enabled');
    }

    public function services()
    {
        return $this->hasMany(Service::class,'service_category_id');
    }
}
