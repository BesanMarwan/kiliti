<?php
/**
 * Created by PhpStorm.
 * User: ahmed
 * Date: 1/9/2017
 * Time: 03:21 م
 */

namespace App\Http\Controllers\Admin;

use App\Actions\ImageActions;
use App\Http\Controllers\MediaController;
use App\Http\Requests\AdminRequest;
use App\Jobs\SendAdminNotification;
use App\Models\Admin;
use App\Models\AdminNotification;
use App\Models\FcmNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Spatie\Permission\Models\Role;

class AdminsController extends Controller
{


    public function index(Request $request)
    {
//        SendAdminNotification::dispatch(2,'test',['test'=>'tes'],1);
        $o =Admin::where('id','>',1)->filter($request)->orderBy('id','DESC');

        if($request->rule_id){
            $role=$request->rule_id;
            $o->whereHas('roles', function (Builder $subQuery) use ($role) {
                $subQuery->where(config('permission.table_names.roles').'.id', $role);
            });
        }
        $admins=$o->paginate(20)->appends(\request()->all());
        return view('admin.admins.index', compact('admins'));
    }
    public function showCreateView()
    {
        $roles = Role::where('id', '<>', 1)->get();
        return view('admin.admins.create', compact('roles'));

    }



    public function store(AdminRequest $request)
    {

        $n= new Admin();
        $n->name=$request->name;
        $n->email=$request->email;
        $n->mobile=$request->mobile;
        $n->image=($request->image);
        $n->password=bcrypt($request->password);
        $role = Role::where('id',$request->role_id)->get();
        $n->syncRoles($role);
        $n->save();
        if($request->is_ajax == 1){
            return ['done'=>true];
        }
        flash('تم اضافة المدير بنجاح');
        return redirect()->route('system.admins.index');

    }

    public function showUpdateView($id)
    {
        $out=Admin::findOrFail($id);
        $roles = Role::where('id', '<>', 1)->get();
        return view('admin.admins.update',compact('out','roles'));

    }

    public function update(AdminRequest $request,$id)
    {

        $n= Admin::findOrFail($id);
        $n->name=$request->name;
        $n->email=$request->email;
        $n->mobile= $request->mobile;
        if($request->image){
            $n->image=$request->image;
            ImageActions::deleteUnUsedFiles($request->image);
        }
        $n->save();
        $role = Role::where('id',$request->role_id)->get();
        $n->syncRoles($role);
        $n->save();

        flash('تم تعديل المدير بنجاح');

        return redirect()->route('system.admins.index');
    }


    public function delete(Request $request)
    {
        $ids=[];
        if(is_array($request->id)){
            $ids=$request->id;
        }else{
            $ids[]=$request->id;
        }

        foreach ($ids as $id){
            Admin::destroy($id);
        }
        return ['done'=>1];
    }
    public function showProfileView()
    {
        $out=\Auth::guard('admin')->user();
        return view('admin.admins.profile',compact('out',));

    }

    public function profile(Request $request)
    {
        $n= \Auth::guard('admin')->user();

        $this->validate($request, [
            'name' => 'required|max:255',
            'mobile' => 'required|unique:admins,mobile,'.$n->id,
            'image' => 'required',
            'email' => 'required|max:255|unique:admins,email,'.$n->id,
        ]);

        $n->name=$request->name;
        $n->email=$request->email;
        $n->mobile= $request->mobile;
        if($request->image){
            $n->image=$request->image;
            ImageActions::deleteUnUsedFiles($request->image);
        }
        $n->save();


        flash('تم تعديل بياناتك بنجاح');

        return redirect()->route('admin.dashboard');
    }

    public function showPasswordView($id)
    {
        $out=Admin::findOrFail($id);
        return view('admin.admins.password',compact('out'));

    }

    public function password(Request $request,$id)
    {
        $this->validate($request, [
            'password' => 'required|confirmed|min:8',
        ]);

        $n= Admin::findOrFail($id);
        $n->password=bcrypt($request->password);

        $n->save();

        flash('تم تغيير كلمة المرور بنجاح ');

        return redirect()->route('system.admins.index');
    }


    public function showProfilePasswordView()
    {
        return view('admin.admins.profile_password');

    }


    public function profilePassword(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        $n= \Auth::guard('admin')->user();

        if (Hash::check($request->old_password, $n->password)) {
            $n->password = bcrypt($request->password);
            $n->save();
            flash('تم تغيير كلمة المررو بنجاح ');

            return redirect()->route('system.admins.profile');
        }else{
            return redirect()->back()->withErrors(['old_password'=>'كلمة المرور القديمة خاطئة']);
        }


    }



    public function save_token(Request $request)
    {
        $user= \Auth::guard('admin')->user();
        $user->fcm_token = $request->token;
        $user->save();

        if($user)
            return response()->json([
                'message' => 'User token updated'
            ]);

        return response()->json([
            'message' => 'Error!'
        ]);
    }

    public function get_notifications(Request $request)
    {
        if($request->only_count == 1){
            return ['done'=>1,'count'=>auth('admin')->user()->new_notifications_count,'items'=>""];
        }else {
            $out = auth('admin')->user()->new_notifications()->orderBy('id', 'desc')->get();

//            dd($out);
            $items = View::make('admin.notifications', compact('out'))->render();
            auth('admin')->user()->notifies()->whereNull('read_at')->update(['read_at' => now()]);
            return ['done' => 1, 'count' => auth('admin')->user()->new_notifications_count, 'items' => $items];
        }
    }



}
