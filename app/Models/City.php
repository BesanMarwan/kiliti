<?php

namespace App\Models;

use App\Http\Resources\User\OrderDetailsResource;
use App\Traits\HasSearchable;
use App\Traits\HasStatus;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Finder\Iterator\DepthRangeFilterIterator;

/**
 * App\Models\City
 *
 * @property int $id
 * @property array $name
 * @property int $parent_id
 * @property float|null $latitude
 * @property float|null $longitude
 * @property int $country_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|City[] $childs
 * @property-read int|null $childs_count
 * @property-read \App\Models\Country $country
 * @property-read array $translations
 * @method static \Database\Factories\CityFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City query()
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $ordered_count
 * @method static \Illuminate\Database\Eloquent\Builder|City whereOrderedCount($value)
 */
class City extends Model
{
    use HasFactory;
    use HasTranslations,HasStatus,HasSearchable;

    protected $table = 'cities';

    protected $hidden = ['created_at', 'updated_at','status'];

    protected $fillable = ['name', 'country_id', 'parent_id', 'latitude', 'longitude'];

    public $translatable = ['name'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function childs()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function cities()
    {
        return $this->hasMany(self::class, 'parent_id')->whereHas('parent',function ($q){
            $q->where('parent_id',0);
        })->with('children');
    }

    public function children(){
        return $this->hasMany(self::class,'parent_id')->whereHas('parent',function ($q){
            $q->where('parent_id','<>',0);
        });
    }

    public function parent(){
        return $this->belongsTo(self::class,'parent_id');
    }
    public function can_del(){
        return ! (0);
    }






    public static function getSearchable(){
        return [
            'name'=>[
                'type'=>'string',
                'operation'=>'like',
                'title'=>lng('dashboard.general.name'),
            ],
            'status'=>[
                'type'=>'select',
                'operation'=>'=',
                'title'=>lng('dashboard.general.status'),
                'options'=>City::getStatusArray(),
            ],
        ];
    }

    public function scopeChildOne($query){
        return $query->where('parent_id','<>',0)->whereHas('parent',function ($q){
            $q->where('parent_id',0);
        });
    }
    public function scopeChildTwo($query){
        return $query->where('parent_id','<>',0)->whereHas('parent',function ($q){
            $q->where('parent_id','<>',0);
        });
    }


    public static function getSearch(){

        return [
            'name'=>[
                'type'=>'string',
                'operation'=>'like',
                'title'=>lng('dashboard.general.name'),
            ],

            'parent_id'=>[
                'type'=>'select',
                'operation'=>'=',
                'title'=>lng('dashboard.general.area','المنطقة'),
                'options'=>City::where('parent_id',0)->get(),
            ],
            'status'=>[
                'type'=>'select',
                'operation'=>'=',
                'title'=>lng('dashboard.general.status','الحالة'),
                'options'=>City::getStatusArray(),
            ],
        ];
    }


    public static function getSearchDistrict(){

        return [
            'name'=>[
                'type'=>'string',
                'operation'=>'like',
                'title'=>lng('dashboard.general.name'),
            ],

            'area_id'=>[
                'type'=>'select',
                'operation'=>'like',
                'title'=>lng('dashboard.general.area','المنطقة'),
                'options'=>City::where('parent_id',0)->get(),
            ],

            'parent_id'=>[
                'type'=>'select',
                'operation'=>'like',
                'title'=>lng('dashboard.general.city','المدينة'),
                'options'=>City::whereHas('parent',function ($q){$q->where('parent_id',0);})->get(),

            ],


            'status'=>[
                'type'=>'select',
                'operation'=>'=',
                'title'=>lng('dashboard.general.status','الحالة'),
                'options'=>City::getStatusArray(),
            ],
        ];
    }


    public function scopeFilter($query,$request)
    {

        return $query->when($request->name ?? null, function($query_name, $name){
            $query_name->where(function ($q) use($name) {
                $q->where('name->ar','like','%'.$name.'%')
                   ->orWhere('name->en', 'like', '%' . $name . '%');
            });
             })
            ->when($request->parent_id ?? null, function($query_parent_id, $parent_id){
                $query_parent_id->where('parent_id',$parent_id);

              })
            ->when($request->area_id ?? null, function($query_area_id, $area_id){
                $query_area_id->whereHas('parent',function ($query) use($area_id){
                    $query->where('parent_id',$area_id);
                });

            })
            ->when($request->status ?? null, function($query_status, $status){
                $query_status->where('status','=',$status);

            });
    }

}
