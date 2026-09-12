<?php

namespace App\Classes;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Classes\GeneralModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralModel filter($request)
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GeneralModel query()
 * @mixin \Eloquent
 */
class GeneralModel extends Model
{
    public array $fields=[
        'name'=>[
            'type'=>'translation',
            'title'=>['ar'=>'الاسم','en'=>'Name'],
            'searchable'=>true,
            'show_in_table'=>true,
            'rules'=>['required']
        ],
        'image'=>[
            'type'=>'image',
            'title'=>'الصورة',
            'searchable'=>false,
            'show_in_table'=>true
        ],
        'status'=>[
            'type'=>'status',
            'title'=>'الحالة',
            'options'=>['enabled'=>'فعال','disabled'=>'معطل'],
            'searchable'=>true,
            'show_in_table'=>true,
            'rules'=>['required']
        ],
    ];
    public bool $has_status;
    public string $permission_name;
    public string $display_name;
    public string $active_name='enabled';
    public string $deactive_name='disabled';
    public function scopeFilter($query,$request)
    {
        foreach ($this->fields as $field_name => $field) {
            if (isset($field['searchable']) && $field['searchable']) {
                if ($request->has($field_name) && $request->get($field_name)) {


                    if ($field['type'] == 'translation' || $field['type'] == 'string') {
                        $val='%'.$request->get($field_name).'%';
                        if(isset($this->translatable)&& is_array($this->translatable)&& in_array($field_name,$this->translatable)){
                            $query->where(function ($qqqq)use ($field_name,$val){
                                $qqqq->where($field_name.'->ar','like',$val)->orWhere($field_name.'->en','like',$val);
                            });
                        }else{
                            $query->where($field_name, 'like', $val);
                        }
                    } else {
                        $query->where($field_name, $request->get($field_name));
                    }
                }
            }
        }

        return $query;
    }


    public function getSearch()
    {
        $searchable=[];
        foreach ($this->fields as $field_name => $field) {
            if (isset($field['searchable']) && $field['searchable']) {
                if($field['type'] == 'translation'){
                    $searchable[$field_name]=[
                        'type'=>'string',
                        'operation'=>'like',
                        'title'=>$field['title']['ar'],
                    ];
                }elseif($field['type'] == 'status'){
                    $searchable[$field_name]=[
                        'type'=>'select',
                        'operation'=>'=',
                        'title'=>$field['title'],
                        'options'=>$field['options'],
                    ];
                }else{
                    $searchable[$field_name]=[
                        'type'=>$field['type'],
                        'operation'=>$field['type'] == 'string'?'like':'=',
                        'title'=>$field['title'],
                    ];
                }

            }
        }
        return $searchable;
    }
    public static function getSearchable()
    {
        $f = new static();
        return $f->searchable;
    }

    public function can_del()
    {
        return true;
    }
}
