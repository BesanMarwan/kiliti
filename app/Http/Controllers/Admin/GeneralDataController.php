<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GeneralDataRequest;
use App\Models\GeneralData;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class GeneralDataController extends Controller
{

    public function index($item, Request $request)
    {

        $obj          =new GeneralData;
        $general_item =GeneralData::where('uuid',$item)->first();
        if(!$general_item){
            abort(404);
        }

        $out          = GeneralData::query()
                        ->where('parent_id',$general_item->id)
                        ->filter($request)
                        ->orderByDesc('id')
                        ->paginate(20)->appends(\request()->all());

        $module=$item;
        $activeLink=$item;
        $item_text =$this->getSingle($item);
        return view('admin.general.index', compact('out','item_text','general_item','module','obj', 'item','activeLink'));
    }


    public function show_create($item, Request $request)
    {
        $item_object = GeneralData::where('uuid',$item)->first();
        if (! $item_object) {
            abort(404);
        }
        $obj    = new GeneralData;
        $module =$item;
        $activeLink=$item;

        return view('admin.general.create', compact( 'obj','item_object', 'module','activeLink'));
    }

    public function show_update($item,$id, Request $request)
    {

        $item_object = GeneralData::where('uuid',$item)->first();
        if (! $item_object) {
            abort(404);
        }
        $obj    = new GeneralData;
        $module =$item;
        $out=$obj->where('id',$id)->firstOrFail();
        $activeLink=$item;


        return view('admin.general.update', compact( 'out','obj','item_object','activeLink', 'module'));
    }
    public function create($item, GeneralDataRequest $request)
    {


        $item_object = GeneralData::where('uuid',$item)->first();
        if (! $item_object) {
            abort(404);
        }
        $obj    = new GeneralData;
        $module =$item;
        $rules=[];
        foreach ($obj->fields as $f_id=>$field){
            if(isset($field['rules'])){
                if($field['type']=='translation'){
                    $rules[$f_id.'_ar']=$field['rules'];
                    $rules[$f_id.'_en']=$field['rules'];
                }else{
                    $rules[$f_id]=$field['rules'];
                }

            }
        }
        $request->validate($rules);
        foreach ($obj->fields as $f_id=>$field){
            if($field['type']=='translation'){
                $obj->{$f_id}=['ar'=>$request->get($f_id.'_ar'),'en'=>$request->get($f_id.'_en')];
            }else{
                $obj->{$f_id}=$request->get($f_id);
            }
        }
        $obj->parent_id =$request->parent_id ?? $item_object->id;
        $obj->save();
        flash('تم الاضافة بنجاح')->success();
        return ['done'=>1];


    }

    public function update($item,$id, GeneralDataRequest $request)
    {


        $item_object = GeneralData::where('uuid',$item)->first();
        if (! $item_object) {
            abort(404);
        }
        $obj    = new GeneralData;
        $module =$item;

        $obj=$obj->where('id',$id)->firstOrFail();
        $rules=[];
        foreach ($obj->fields as $f_id=>$field){
            if(isset($field['rules'])){
                if($field['type']=='translation'){
                    $rules[$f_id.'_ar']=$field['rules'];
                    $rules[$f_id.'_en']=$field['rules'];
                }else{
                    $rules[$f_id]=$field['rules'];
                }

            }
        }
        $request->validate($rules);
        foreach ($obj->fields as $f_id=>$field){
            if($field['type']=='translation'){
                $obj->{$f_id}=['ar'=>$request->get($f_id.'_ar'),'en'=>$request->get($f_id.'_en')];
            }else{
                $obj->{$f_id}=$request->get($f_id);
            }
        }
        $obj->save();
        flash('تم التعديل بنجاح');
        return ['done'=>1];

    }

    public function delete($item, Request $request)
    {

        $item_object = GeneralData::where('uuid',$item)->first();
        if (! $item_object) {
            abort(404);
        }
        $obj    = new GeneralData;
        $module =$item;
        $ids = [];
        if (is_array($request->id)) {
            $ids = $request->id;
        } else {
            $ids[] = $request->id;
        }

        $deleted_count = $obj->whereIn('id',$ids)->delete();

        return ['done' => 1];
    }
    public function activate( $item,Request $request)
    {


        $item_object = GeneralData::where('uuid',$item)->first();
        if (! $item_object) {
            abort(404);
        }
        $obj    = new GeneralData;
        $module =$item;

        $ids = [];
        if (is_array($request->id)) {
            $ids = $request->id;
        } else {
            $ids[] = $request->id;
        }

        $obj->whereIn('id',$ids)->update(['status' => 'enabled']);

        return ['done' => 1];
    }
    public function deactivate($item, Request $request)
    {

        $item_object = GeneralData::where('uuid',$item)->first();
        if (! $item_object) {
            abort(404);
        }
        $obj    = new GeneralData;
        $module =$item;
        $ids = [];
        if (is_array($request->id)) {
            $ids = $request->id;
        } else {
            $ids[] = $request->id;
        }

        $obj->whereIn('id',$ids)->update(['status' =>'disabled']);

        return ['done' => 1];
    }


    public function getSingle($uuid){
        switch($uuid){
            case 'drug_categories': return 'قسم دواء';
            case 'routes': return 'طريقة';
            default: return 'عنصر';
        }

    }


}
