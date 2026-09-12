<?php

namespace App\Http\Controllers\Admin;

use App\Actions\ImageActions;
use App\Http\Requests\FeatureRequest;
use App\Http\Requests\HomeRequest;
use App\Models\Feature;
use App\Models\Home;
use App\Models\Page;
use App\Rules\ValidString;
use App\Rules\ValidStringArabic;
use App\Rules\ValidStringUrdu;
use Illuminate\Http\Request;
use DB;
use Illuminate\Validation\Rule;


class PageController extends Controller
{
    public function index(Request $request)
    {
        $objects = Page::orderBy('id', 'DESC');
        if($request->name){
            $objects->where('title->ar','like','%'.$request->name.'%')->orWhere('title->en','like','%'.$request->name.'%')->orWhere('title->ur','like','%'.$request->name.'%');;
        }
        $objects = $objects->paginate(15);
        return view('admin.pages.index', compact('objects'));
    }


    public function showUpdateView($id)
    {
        $object = Page::find($id);
        return view('admin.pages.update', compact('object'));
    }


    public function Update(Request $request, $id)
    {
        $rules = [
            'detail_ar'=>['required','string'],
            'detail_en'=>['required','string'],
        ];
        if($id > 0){
            $rules +=[
                'name_ar'=>['required',new ValidStringArabic(),Rule::unique('pages','title->ar')->ignore($id)],
                'name_en'=>['required',new ValidString(),Rule::unique('pages','title->en')->ignore($id)],
            ];
        }else{
            $rules +=[
                'name_ar'=>['required',new ValidStringArabic(),Rule::unique('pages','title->ar')],
                'name_en'=>['required',new ValidString(),Rule::unique('pages','title->en')],
            ];
        }
        $request->validate($rules);
        $object  = Page::FindOrFail($id);

        $object->update([
            'title' => ['ar'=>$request->name_ar,'en'=>$request->name_en],
            'text' => ['ar'=>$request->detail_ar,'en'=>$request->detail_en],
        ]);
        flash('تم التعديل بنجاح');
        return redirect()->route('system.pages.index');
    }


}
