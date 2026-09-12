<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request){
        $out =  Category::orderByDESC('id')
            ->filter($request)
            ->paginate(20)
            ->appends(\request()->all());

        $activeLink ='categories';

        return view('admin.categories.index',compact('out','activeLink'));
    }


    public function delete(Request $request)
    {
        $ids = [];
        if (is_array($request->id)) {
            $ids = $request->id;
        } else {
            $ids[] = $request->id;
        }


        $deleted_count = Category::query()->whereIn('id',$ids)->delete();

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

        Category::query()->whereIn('id',$ids)->update(['status' =>'enabled']);

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


        Category::query()->whereIn('id',$ids)->update(['status' =>'disabled']);

        return ['done' => 1];
    }

    public function create(){
        $activeLink ='categories';
        return view('admin.categories.create',compact('activeLink'));
    }

    public function store(CategoryRequest $request){

        Category::create([
            'name'=>['ar'=>$request->name_ar,'en'=>$request->name_en],
            'image'=>$request->image,
        ]);
        return ['done'=>1];

    }

    public function showUpdateView($id){
        $category =Category::findOrFail($id);
        $activeLink ='categories';
        return view('admin.categories.update',compact('activeLink','category'));
    }
    public function update(CategoryRequest $request,$id){

        Category::findOrFail($id)->update([
            'name'=>['ar'=>$request->name_ar,'en'=>$request->name_en],
            'image'=>$request->image,
        ]);

        return ['done'=>1];


    }
}
