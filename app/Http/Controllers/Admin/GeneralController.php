<?php

namespace App\Http\Controllers\Admin;

use App\Classes\GeneralModel;
use App\Models\User;
use App\Rules\ValidString;
use App\Rules\ValidStringArabic;
use App\Traits\HasGeneral;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function index($module, Request $request)
    {
        $class_ex = class_exists('App\\Models\\'.$module);
        if (! $class_ex) {
            abort(404);
        }
        $obj = new ('App\\Models\\'.$module);
//        $usingTrait = in_array(
//            HasGeneral::class,
//            array_keys(()
//        );
        if (! $obj instanceof GeneralModel) {
            abort(404);
        }
        $out = $obj->query()->filter($request)->orderBy('id', 'DESC')->paginate(20);

       $out->appends($request->all());
        $activeLink=$module;

        return view('admin.general.index', compact('out', 'obj', 'module','activeLink'));
    }
    public function show_create($module, Request $request)
    {
        $class_ex = class_exists('App\\Models\\'.$module);
        if (! $class_ex) {
            abort(404);
        }
        $obj = new ('App\\Models\\'.$module);
//        $usingTrait = in_array(
//            HasGeneral::class,
//            array_keys(()
//        );
        if (! $obj instanceof GeneralModel) {
            abort(404);
        }


        return view('admin.general.create', compact( 'obj', 'module'));
    }
    public function show_update($module,$id, Request $request)
    {
        $class_ex = class_exists('App\\Models\\'.$module);
        if (! $class_ex) {
            abort(404);
        }
        $obj = new ('App\\Models\\'.$module);
        if (! $obj instanceof GeneralModel) {
            abort(404);
        }
        $out=$obj->where('id',$id)->firstOrFail();

        return view('admin.general.update', compact( 'out','obj', 'module'));
    }
    public function create($module, Request $request)
    {

        $class_ex = class_exists('App\\Models\\'.$module);
        if (! $class_ex) {
            abort(404);
        }
        $obj = new ('App\\Models\\'.$module);
        if (! $obj instanceof GeneralModel) {
            abort(404);
        }
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
//        flash('تم الاضافة بنجاح');
        return ['done'=>1];


    }

    public function update($module,$id, Request $request)
    {

        $class_ex = class_exists('App\\Models\\'.$module);
        if (! $class_ex) {
            abort(404);
        }
        $obj = new ('App\\Models\\'.$module);
        if (! $obj instanceof GeneralModel) {
            abort(404);
        }
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
//        flash('تم الاضافة بنجاح');
        return ['done'=>1];

    }

    public function delete($module, Request $request)
    {
        $class_ex = class_exists('App\\Models\\'.$module);
        if (! $class_ex) {
            abort(404);
        }
        $obj = new ('App\\Models\\'.$module);
        if (! $obj instanceof GeneralModel) {
            abort(404);
        }
        $ids = [];
        if (is_array($request->id)) {
            $ids = $request->id;
        } else {
            $ids[] = $request->id;
        }

        $deleted_count = $obj->whereIn('id',$ids)->delete();

        return ['done' => count($ids) == $deleted_count ? 1 : 0];
    }
    public function activate( $module,Request $request)
    {

        $class_ex = class_exists('App\\Models\\'.$module);
        if (! $class_ex) {
            abort(404);
        }
        $obj = new ('App\\Models\\'.$module);
        if (! $obj instanceof GeneralModel) {
            abort(404);
        }
        $ids = [];
        if (is_array($request->id)) {
            $ids = $request->id;
        } else {
            $ids[] = $request->id;
        }

        $obj->whereIn('id',$ids)->update(['status' => $obj->active_name]);

        return ['done' => 1];
    }
    public function deactivate($module, Request $request)
    {
        $class_ex = class_exists('App\\Models\\'.$module);
        if (! $class_ex) {
            abort(404);
        }
        $obj = new ('App\\Models\\'.$module);
        if (! $obj instanceof GeneralModel) {
            abort(404);
        }
        $ids = [];
        if (is_array($request->id)) {
            $ids = $request->id;
        } else {
            $ids[] = $request->id;
        }

        $obj->whereIn('id',$ids)->update(['status' => $obj->deactive_name]);

        return ['done' => 1];
    }
}
