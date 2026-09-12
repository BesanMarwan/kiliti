<?php

namespace App\Models;

use App\Traits\HasSearchable;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\SoftDeletingScope;

/**
 * App\Models\Service
 *
 * @property int $id
 * @property string $name
 * @property string|null $image
 * @property int $service_category_id
 * @property float $price
 * @property string|null $ingredients
 * @property string|null $nutrition_facts
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Service newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service query()
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereIngredients($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereNutritionFacts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereServiceCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $status
 * @property-read mixed $image_url
 * @property-read array $translations
 * @method static \Illuminate\Database\Eloquent\Builder|Service active()
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereStatus($value)
 * @property-read \App\Models\ServiceCategory $category
 * @method static \Illuminate\Database\Eloquent\Builder|Service filter($request)
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Query\Builder|Service onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Service withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Service withoutTrashed()
 */
class Service extends Model
{
    use HasFactory,HasTranslations,HasSearchable;

    public $translatable = ['name', 'ingredients','nutrition_facts'];
    protected $fillable=['service_category_id','price','image','name','ingredients','nutrition_facts'];

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class,'service_category_id')->withoutGlobalScope(SoftDeletingScope::class);
    }

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
    public static function getSearchable()
    {
    return [

        'name'=>[
            'type'=>'string',
            'operation'=>'like',
            'title'=>lng('dashboard.general.name','الاسم'),
        ],
        'status'=>[
            'type'=>'select',
            'title'=>lng('dashboard.general.status','الحالة'),
            'options'=>['enabled'=>lng('dashboard.general.status_enabled','فعال'),'disabled'=>lng('dashboard.general.status_disabled','معطل')]
        ],
        'service_category_id|'=>[
            'type'=>'select',
            'title'=>lng('dashboard.services.category','التصنيف'),
            'model'=>"ServiceCategory"
        ],
    ];
}
}
