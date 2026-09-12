<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations ;

/**
 * App\Models\GeneralCase
 *
 * @property-read mixed $icon_url
 * @property-read array $translations
 * @method static \Database\Factories\GeneralCaseFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralCase newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralCase newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralCase query()
 * @mixin \Eloquent
 */
class GeneralCase extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $table = 'general_cases';
    public $translatable = ['name'];
    protected $hidden = ['created_at','updated_at'];
    protected $fillable = ['name','icon'];

    public function getIconUrlAttribute(){
        $icon=isset($this->attributes['icon'])?$this->attributes['icon']:'';
        return $icon?asset('uploads/cases/'.$icon):asset('uploads/cases/default.png');
    }
}
