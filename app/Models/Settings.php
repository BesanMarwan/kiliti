<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Settings
 *
 * @property int $id
 * @property string $name
 * @property string|null $value
 * @property int $show_edit
 * @property string|null $tab_name
 * @method static \Illuminate\Database\Eloquent\Builder|Settings newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Settings newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Settings query()
 * @method static \Illuminate\Database\Eloquent\Builder|Settings whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settings whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settings whereShowEdit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settings whereTabName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settings whereValue($value)
 * @mixin \Eloquent
 * @property int $show_api
 * @method static \Illuminate\Database\Eloquent\Builder|Settings active()
 * @method static \Illuminate\Database\Eloquent\Builder|Settings whereShowApi($value)
 */
class Settings extends Model{
    protected $table = 'settings';
    protected $fillable=['name','value','tab_name','show_edit'];
    public $timestamps=false;
    public static function get_data( $key)
    {

        if(app()->environment('local')){
            //where('page_key',$page_key)->where('section_key',$section_key)->
            $data=self::firstOrCreate(['name'=>$key]);
        }else{

            $data = \Cache::remember('settings.'.$key, 500000, function ()use( $key) {
                return self::firstOrCreate(['name'=>$key]);
            });
        }

        return $data->value;
    }

    public static function set($name, $value,$tab='default',$is_edit=1)
    {
        if(!app()->environment('local')){
            \Cache::forget('settings.'.$name);
        }
        return self::query()->updateOrCreate([
            'name' => $name,
        ], [
            'value' => $value,
            'tab_name' => $tab,
            'show_edit' => $is_edit,
        ]);
    }

    public function scopeActive($query)
    {
        return $query->where('show_api', 1);
    }
}
