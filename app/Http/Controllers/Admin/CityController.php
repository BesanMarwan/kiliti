<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CityRequest;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(Request $request){

        $out =  City::orderByDESC('id')
                    ->filter($request)
                    ->whereHas('parent',function ($q){$q->where('parent_id',0);})
                    ->with('children')
                    ->paginate(20)
                    ->appends(\request()->all());

        $activeLink ='cities';

        return view('admin.cities.index',compact('out','activeLink'));
    }


    public function create(){
        $activeLink = 'cities';
        $areas      = City::where('parent_id',0)->active()->get();
        return view('admin.cities.create',compact('activeLink','areas'));
    }

    public function store(CityRequest $request){

        City::create([
            'name'=>['ar'=>$request->name_ar,'en'=>$request->name_en],
            'parent_id'=>$request->parent_id,
            'country_id'=>1
        ]);
        return ['done'=>1];

    }

    public function showUpdateView($id){
        $city       = City::findOrFail($id);
        $areas      = City::where('parent_id',0)->get();
        $activeLink ='cities';
        return view('admin.cities.update',compact('activeLink','city','areas'));
    }
    public function update(CityRequest $request,$id){

        City::findOrFail($id)->update([
            'name'=>['ar'=>$request->name_ar,'en'=>$request->name_en],
            'parent_id'=>$request->parent_id,
            'country_id'=>1
        ]);

        return ['done'=>1];


    }

    public function districts($id){
      $city       =  City::where('parent_id','<>',0)->findOrFail($id);
      $activeLink = 'cities';
      return view('admin.cities.districts',compact('city','activeLink'));
    }
}
