<?php

namespace App\Models;

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
    use HasFactory,HasTranslations;

    protected $guarded=[];
    protected $translatable=['name'];

    protected $hidden=['uuid','parent_id','created_at','updated_at',];
    public function children()
    {
        return $this->hasMany(self::class,'parent_id');

    }
}
