<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OrderCaseLog
 *
 * @property-read array $translations
 * @method static \Database\Factories\OrderCaseLogFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderCaseLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderCaseLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderCaseLog query()
 * @mixin \Eloquent
 */
class OrderCaseLog extends Model
{
    use HasFactory;
    use HasTranslations ;
    protected $table = 'order_case_log';
    public  $translatable = ['description'];
    protected $guarded=[];

    public static function addCaseLog($order_id,$status,$description=''){
        self::create(['order_id'=>$order_id,'case_id'=>$status,'description'=>$description]);
    }
}
