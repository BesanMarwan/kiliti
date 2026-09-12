<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AreaRequest;
use App\Http\Requests\Admin\CityRequest;
use App\Models\City;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index(Request $request){

        $out =  City::orderByDESC('id')
            ->filter($request)
            ->where('parent_id',0)
            ->paginate(20)
            ->appends(\request()->all());

        $activeLink ='areas';

        return view('admin.areas.index',compact('out','activeLink'));
    }


    public function delete(Request $request)
    {
        $ids = [];
        if (is_array($request->id)) {
            $ids = $request->id;
        } else {
            $ids[] = $request->id;
        }



        City::query()->whereHas('parent',function($q)use($ids){
            $q->where('parent_id',$ids);
        })->delete();
         City::query()->whereIn('parent_id',$ids)->delete();

         City::query()->whereIn('id',$ids)->delete();

        return ['done' => 1];
    }

    public function activate(Request $request)
    {

        $ids = [];
        if (is_array($request->id)) {
            $ids = $request->id;
        } else {
            $ids[] = $request->id;
        }
        City::query()->whereIn('parent_id',$ids)->update(['status'=>'enabled']);


        City::query()->whereHas('parent',function($q)use($ids){
            $q->where('parent_id',$ids);
        })->update(['status' =>'enabled']);
        City::query()->whereIn('id',$ids)->update(['status' =>'enabled']);

        return ['done' => 1];
    }
    public function deactivate (Request $request)
    {
        $ids = [];
        if (is_array($request->id)) {
            $ids = $request->id;
        } else {
            $ids[] = $request->id;
        }


        City::query()->whereIn('parent_id',$ids)->update(['status' =>'disabled']);
        City::query()->whereHas('parent',function($q)use ($ids){
            $q->where('parent_id',$ids);
        })->update(['status' =>'disabled']);
        City::query()->whereIn('id',$ids)->update(['status' =>'disabled']);

        return ['done' => 1];
    }

    public function show_cities($id){
        $cities = City::where('parent_id',$id)->select('id','name')->get();
        return response()->json(['data' =>$cities]);
    }

    public function cities($id){
        $area       = City::findOrFail($id);
        $activeLink = 'areas';
        return view('admin.areas.cities',compact('area','activeLink'));
    }

    public function create(){
        $activeLink ='categories';
        return view('admin.areas.create',compact('activeLink'));
    }

    public function store(AreaRequest $request){

        City::create([
            'name'     =>['ar'=>$request->name_ar,'en'=>$request->name_en],
            'parent_id'=>0,
            'country_id'=>1,
        ]);
        return ['done'=>1];

    }

    public function showUpdateView($id){
        $area =City::findOrFail($id);
        $activeLink ='areas';
        return view('admin.areas.update',compact('activeLink','area'));
    }
    public function update(AreaRequest $request,$id){

        City::findOrFail($id)->update([
            'name'=>['ar'=>$request->name_ar,'en'=>$request->name_en],

        ]);

        return ['done'=>1];


    }
}
