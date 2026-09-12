<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CityRequest;
use App\Http\Requests\Admin\DistrictRequest;
use App\Models\City;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function index(Request $request){
        $out =  City::orderByDESC('id')
                      ->filter($request)
                      ->whereHas('parent',function ($q){$q->where('parent_id','<>',0);})
                      ->doesntHave('children')
                      ->paginate(20)
                      ->appends(\request()->all());

        $activeLink ='districts';

        return view('admin.districts.index',compact('out','activeLink'));
    }

    public function create(){
        $activeLink = 'cities';
        $areas      = City::where('parent_id',0)->active()->get();
        $cities     = City::where('parent_id','<>',0)->whereHas('children')->active()->get();
        return view('admin.districts.create',compact('activeLink','areas','cities'));
    }

    public function store(DistrictRequest $request){

        City::create([
            'name'=>['ar'=>$request->name_ar,'en'=>$request->name_en],
            'parent_id'=>$request->city_id,
            'country_id'=>1
        ]);
        return ['done'=>1];

    }

    public function showUpdateView($id){
        $city       = City::findOrFail($id);

        $areas      = City::where('parent_id',0)->get();
        $cities     = City::where('parent_id','=',$city->parent->parent_id)->get();

        $activeLink ='cities';
        return view('admin.districts.update',compact('activeLink','city','areas','cities'));
    }

    public function update(DistrictRequest $request,$id){

        City::findOrFail($id)->update([
            'name'=>['ar'=>$request->name_ar,'en'=>$request->name_en],
            'parent_id'=>$request->city_id,
            'country_id'=>1
        ]);

        return ['done'=>1];
    }

}
