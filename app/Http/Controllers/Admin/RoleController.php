<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{


    public function index(Request $request)
    {
        $o = Role::where('id','<>',1)->orderBy('id', 'DESC');
        if($request->name){
            $o->where('name','like','%'.$request->name.'%');
        }
        $out = $o->paginate(20)->appends(\request()->all());
        return view('admin.roles.index', compact('out'));
    }

    public function showCreateView()
    {

        $permission = Permission::where('guard_name','admin')->get();

        $permissions=[];
        foreach ($permission as $item) {
            $per=explode('.',$item->name);
            $permissions[$per[0]][$per[1]]=$item->id;
        }

        return view('admin.roles.create', compact( 'permissions'));
    }


    public function create(Request $request){
        $this->validate($request, [
            'name' => 'required|unique:roles,name|min:3',
            'permissions' => 'required',
        ]);
        $role = Role::create([
            'name' => $request->input('name'),
            'guard_name'=>'admin'
        ]);
        $permissions = Permission::whereIn('id', $request->permissions)->get();
        $role->syncPermissions([$permissions]);

        flash('تم  الاضافة بنجاح');
        return redirect(route('system.roles.index'));
    }

    public function showUpdateView($id)
    {
        $out = Role::find($id);

        $permission = Permission::where('guard_name','admin')->get();
        $permissions=[];
        foreach ($permission as $item) {
            $per=explode('.',$item->name);
            $permissions[$per[0]][$per[1]]=$item->id;
        }
        return view('admin.roles.update', compact('out', 'permissions'));
    }


    public function Update(Request $request, $id)
    {
        $role  = Role::findOrfail($id);
        $this->validate($request, [
            'name' => 'required|unique:roles,name,'.$role->id,
            'permissions' => 'required',
        ]);

        $role->update([
            'name' => $request->input('name'),
        ]);

        $permissions = Permission::whereIn('id', $request->permissions)->get();
        $role->syncPermissions([$permissions]);

        flash('تم التعديل بنجاح');

        return redirect()->route('system.roles.index');
    }


    public function delete(Request $request)
    {
        $ids=[];
        if(is_array($request->id)){
            $ids=$request->id;
        }else{
            $ids[]=$request->id;
        }
        Role::destroy($ids);
        return ['done'=>1];
    }
}
