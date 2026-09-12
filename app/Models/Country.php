<?php

namespace App\Models;

use App\Classes\GeneralModel;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Country
 *
 * @property int $id
 * @property array|null $name
 * @property int|null $prefix
 * @property int|null $mobile_digits
 * @property array|null $currency
 * @property string|null $flag
 * @property int|null $is_default
 * @property int|null $check_start_digit
 * @property int|null $remove_leading_zero
 * @property int|null $start_digit
 * @property int|null $accept_prefix
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read array $translations
 * @method static \Illuminate\Database\Eloquent\Builder|Country newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Country newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Country query()
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereAcceptPrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereCheckStartDigit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereMobileDigits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country wherePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereStartDigit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $nationality
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\City[] $city
 * @property-read int|null $city_count
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereNationality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereRemoveLeadingZero($value)
 * @property string $status
 * @property-read mixed $flag_url
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralModel filter($request)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereStatus($value)
 */
class Country extends GeneralModel
{
    use HasFactory;
    use HasTranslations;

    public $translatable = ['name', 'currency','nationality'];

    public array $fields = [
        'flag' => [
            'type' => 'image',
            'title' => 'العلم',
            'searchable' => false,
            'show_in_table' => true,
            'rules'=>['required']

        ],
        'name' => [
            'type' => 'translation',
            'title' => ['ar' => 'الاسم', 'en' => 'Name'],
            'searchable' => true,
            'show_in_table' => true,
            'rules'=>['required']
        ],
        'currency' => [
            'type' => 'translation',
            'title' => ['ar' => 'العملة', 'en' => 'Currency'],
            'searchable' => false,
            'show_in_table' => true,
            'rules'=>['required']
        ],
        'nationality' => [
            'type' => 'translation',
            'title' => ['ar' => 'الجنسية', 'en' => 'Nationality'],
            'searchable' => false,
            'show_in_table' => true,
            'rules'=>['required']
        ],

        'prefix' => [
            'type' => 'string',
            'title' => 'المقدمة ',
            'searchable' => false,
            'show_in_table' => true,
            'rules'=>['required']
        ],
        'mobile_digits' => [
            'type' => 'number',
            'title' => 'عدد خانات رقم الجوال',
            'searchable' => false,
            'show_in_table' => true,
            'rules'=>['required']
        ],
//        'check_start_digit' => [
//            'type' => 'select',
//            'title' => 'التحقق من اول خانة في رقم الجوال',
//            'options'=>['1'=>'فحص الخانة','0'=>'عدم الفحص'],
//            'searchable'=>false,
//            'show_in_table'=>true,
//            'rules'=>['required','in:0,1']
//        ],
//        'remove_leading_zero' => [
//            'type' => 'select',
//            'title' => 'ازالة الصفر من بداية الرقم ان وجد',
//            'options'=>['1'=>'فعال','0'=>'معطل'],
//            'searchable'=>false,
//            'show_in_table'=>false,
//            'rules'=>['required','in:0,1']
//        ],
//
//        'start_digit' => [
//            'type' => 'number',
//            'title' => 'اول خانة في رقم الجوال',
//            'searchable' => false,
//            'show_in_table' => false,
//            'rules'=>['required']
//        ],
//
//        'accept_prefix' => [
//            'type' => 'select',
//            'title' => 'قبول المقدمة مع الرقم',
//            'options'=>['1'=>'فعال','0'=>'معطل'],
//            'searchable'=>false,
//            'show_in_table'=>true,
//            'rules'=>['required','in:0,1']
//        ],


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

    public string $permission_name = 'countries';

    public string $display_name = 'الدول';
    protected $hidden = ['created_at', 'updated_at', 'deleted_at', 'flag', 'status'];

    protected $visible = ['id', 'name', 'nationality', 'prefix', 'currency','flag_url','mobile_digits'];

    protected $appends=[ 'flag_url'];

    public function can_del()
    {
        return !($this->is_default == 1);
    }
    public function city()
    {
        return $this->hasMany(City::class, 'country_id');
    }
    public function getFlagUrlAttribute()
    {
        $logo = isset($this->attributes['flag']) ? $this->attributes['flag'] : '';

        if (\URL::isValidUrl($logo)) {
            return $logo;
        }

        return $logo ? asset('uploads/'.$logo) : asset('uploads/blank.png');
    }
}
