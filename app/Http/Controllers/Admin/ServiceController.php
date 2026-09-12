<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{

    public function index(Request $request)
    {
        $out = Service::filter($request)->orderBy('id', 'DESC')->paginate(20);
        $out->appends($request->all());

        return view('admin.services.index', compact('out',));
    }


    public function create()
    {
        $categories=ServiceCategory::active()->get();
        return view('admin.services.create', compact('categories'));

    }

    public function store(Request $request)
    {
        $val=$request->validate([
            'name_ar'=>['required','min:3'],
            'name_en'=>['required','min:3'],
            'service_category_id'=>['required',Rule::exists('service_categories','id')],
            'price'=>['required','numeric','min:0'],
            'image'=>['required'],
            'ingredients_ar'=>['nullable'],
            'ingredients_en'=>['nullable'],
            'nutrition_facts_ar'=>['nullable'],
            'nutrition_facts_en'=>['nullable'],
        ]);
        $val['name']=['ar'=>$val['name_ar'],'en'=>$val['name_en']];
        $val['ingredients']=['ar'=>$val['ingredients_ar'],'en'=>$val['ingredients_en']];
        $val['nutrition_facts']=['ar'=>$val['nutrition_facts_ar'],'en'=>$val['nutrition_facts_en']];
        Service::create($val);
        if($request->is_ajax == 1){
            return ['done'=>true];
        }
        flash(lng('dashboard.general.created_successfully','تمت الاضافة بنجاح'));
        return redirect()->route('system.services.index');
    }



    public function edit(Service $service)
    {
        $categories=ServiceCategory::active()->get();
        return view('admin.services.update', compact('categories','service'));

    }
    public function show(Service $service)
    {
        return view('admin.services.view', compact('service'));

    }


    public function update(Request $request, Service $service)
    {
        $val=$request->validate([
            'name_ar'=>['required','min:3'],
            'name_en'=>['required','min:3'],
            'service_category_id'=>['required',Rule::exists('service_categories','id')],
            'price'=>['required','numeric','min:0'],
            'image'=>['required'],
            'ingredients_ar'=>['nullable'],
            'ingredients_en'=>['nullable'],
            'nutrition_facts_ar'=>['nullable'],
            'nutrition_facts_en'=>['nullable'],
        ]);
        $val['name']=['ar'=>$val['name_ar'],'en'=>$val['name_en']];
        $val['ingredients']=['ar'=>$val['ingredients_ar'],'en'=>$val['ingredients_en']];
        $val['nutrition_facts']=['ar'=>$val['nutrition_facts_ar'],'en'=>$val['nutrition_facts_en']];
        unset($val['name_ar'],$val['name_en'],$val['ingredients_ar'],$val['ingredients_en'],$val['nutrition_facts_ar'],$val['nutrition_facts_en']);
        $service->update($val);
        if($request->is_ajax == 1){
            return ['done'=>true];
        }
        flash(lng('dashboard.general.edited_successfully','تم التعديل بنجاح'));
        return redirect()->route('system.services.index');
    }


    public function delete(Request $request)
    {
        $ids = [];
        if (is_array($request->id)) {
            $ids = $request->id;
        } else {
            $ids[] = $request->id;
        }

        $deleted_count = Service::whereIn('id',$ids)->delete();

        return ['done' => count($ids) == $deleted_count ? 1 : 0];
    }
    public function activate(Request $request)
    {

        $ids = [];
        if (is_array($request->id)) {
            $ids = $request->id;
        } else {
            $ids[] = $request->id;
        }

        Service::whereIn('id',$ids)->update(['status' => 'enabled']);

        return ['done' => 1];
    }
    public function deactivate( Request $request)
    {

        $ids = [];
        if (is_array($request->id)) {
            $ids = $request->id;
        } else {
            $ids[] = $request->id;
        }

        Service::whereIn('id',$ids)->update(['status' => 'disabled']);

        return ['done' => 1];
    }
}
