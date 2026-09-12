<?php

namespace App\Models;

use App\Classes\GeneralModel;
use App\Rules\ValidString;
use App\Rules\ValidStringArabic;
use App\Traits\HasStatus;
use App\Traits\HasTranslations;
use App\Traits\HasSearchable;
use App\Traits\ImageTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


/**
 * App\Models\Category
 *
 * @property int $id
 * @property array $name
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $image_url
 * @property-read array $translations
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Category extends GeneralModel
{
    use HasFactory;
    use HasTranslations,HasSearchable,HasStatus,ImageTrait;
    public $translatable = ['name'];
    protected $guarded=[];





    public array $fields = [
        'image' => [
            'type' => 'image',
            'title' => 'الصورة',
            'searchable' => false,
            'show_in_table' => true,

        ],
        'name' => [
            'type' => 'translation',
            'title' => ['ar' => 'الاسم', 'en' => 'Name'],
            'searchable' => true,
            'show_in_table' => true,
            'rules'=>['required','string']

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

    public string $permission_name = 'categories';
    public string $validation_request = 'CategoryRequest';

    public string $display_name = 'الأقسام المتاحة';






    public static function getSearchable()
    {
        return [

            'name'=>[
                'type'=>'string',
                'operation'=>'like',
                'title'=>lng('dashboard.general.name'),
            ],
            'status'=>[
                'type'=>'select',
                'operation'=>'=',
                'title'=>lng('dashboard.general.status','الحالة'),
                'options'=>Category::getStatusArray(),
            ],


        ];
    }

    public function can_del(){
        return ! (0);
    }



    public function rules():array
    {
        $rules =[
            'name_ar'=>['required','string',new ValidStringArabic()],
            'name_en'=>['required','string',new ValidString()],
            'status'=>['required',Rule::in(['enabled','disabled'])],
        ];

        return $rules;
    }



}
