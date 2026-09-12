<?php
namespace App\Traits;


trait HasSearchable
{
    public static function getSearchable()
    {
        return [
            'id'=>[
                'type'=>'number',
                'operation'=>'=',
                'title'=>'اي دي',
//                'relation'=>'settings'  // when search on relation

            ],
            'name'=>[
                'type'=>'string',
                'operation'=>'like',
                'title'=>'الاسم',
//                'relation'=>'settings'  // when search on relation
            ],
            'range_date'=>[
                'type'=>'range',
                'operation'=>'range',
                'title'=>'التاريخ',
//                'relation'=>'settings'  // when search on relation
            ],
            'date'=>[
                'type'=>'date',
                'operation'=>'=',
                'title'=>'التاريخ',
//                'relation'=>'settings'  // when search on relation
            ],
            'has_value'=>[
                'type'=>'checkbox',
                'operation'=>'=',
                'title'=>'يحتوي على فلاج معين',
//                'relation'=>'settings'
            ],
            'rule_id'=>[
                'type'=>'select',
//                'operation'=>'custom',  // when custom the filter will ignore this key -- you must do the search logic for it
                'operation'=>'=',
                'title'=>'الصلاحية',
 //                'relation'=>'roles',

//                'model'=>'Role' // send model name if it in the models directory or use model_class for any situation
                'options'=>['enabled'=>lng('dashboard.general.status_enabled','فعال'),'disabled'=>lng('dashboard.general.status_disabled','معطل')]

//                'model_class'=>Role::class,
//                'model_query'=>[['id' ,'<>', 1]]
            ],
            'status'=>[
                'type'=>'select',
                'title'=>lng('dashboard.general.status','الحالة'),
                'options'=>['enabled'=>lng('dashboard.general.status_enabled','فعال'),'disabled'=>lng('dashboard.general.status_disabled','معطل')]
            ],
        ];
    }
    public function scopeFilter($query,$request)
    {

        foreach ($this->getSearchable() as $key=>$searchItem){

            if($request->has($key) && $request->get($key) !== '' &&  $request->get($key) !== null ){
                $val=$request->get($key);
                $key=trim($key,'|');
                if(!isset($searchItem['operation'])){
                    $searchItem['operation']='=';
                }
                if($searchItem['operation'] == 'custom'){
                    continue;
                }
                if(isset($searchItem['relation'])){
                    if($searchItem['operation'] == 'has'){
                        $query->has($searchItem['relation']);
                    }else{
                        $query->whereHas($searchItem['relation'],function ($qqqq)use($searchItem,$val,$key){
                            if($searchItem['operation'] == 'like'){
                                $val='%'.str_replace(' ','%',$val).'%';
                            }

                            $qqqq->where($key,$searchItem['operation'],$val);
                        });
                    }

                }else{

                    if ($searchItem['operation'] == 'like') {
                        if($key != 'mobile'){
                            $val = '%' . str_replace(' ', '%', $val) . '%';

                        }
                        else{
                            $val =substr($val,3);
                            $val = '%' . str_replace(' ', '%', $val) . '%';

                        }
                    }


                    if(isset($this->translatable)&& is_array($this->translatable)&& in_array($key,$this->translatable)){
                        $query->where(function ($qqqq)use ($key,$searchItem,$val){
                            $qqqq->where($key.'->ar',$searchItem['operation'],$val)->orWhere($key.'->en',$searchItem['operation'],$val);
                        });
                    }else{
                        $query->where($key,$searchItem['operation'],$val);
                    }


                }
            }elseif($searchItem['type'] == 'range'){
                    if($key != 'created_at') {
                        if ($request->has($key . '_from') && $request->get($key . '_from')) {
                            $query->where($key, '>=', $request->get($key . '_from'));
                        }
                        if ($request->has($key . '_to') && $request->get($key . '_to')) {
                            $query->where($key, '<=', $request->get($key . '_to'));
                        }

                    }else{

                        if ($request->has($key . '_from') && $request->get($key . '_from')) {
                            $query->where($key, '>=', $request->get($key . '_from').' 00:00:00');
                        }
                        if ($request->has($key . '_to') && $request->get($key . '_to')) {
                            $query->where($key, '<=', $request->get($key . '_to').' 23:59:59');
                        }
                    }
            }
        }

        return $query;
    }
}
