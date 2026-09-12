<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Jobs\SendSMS;
use App\Models\SMS;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{


    public function index(Request $request)
    {
        $out = User::filter($request)
             ->latest('id')
             ->paginate(20)
             ->appends(\request()->all());

        return view('admin.users.index', compact('out'));
    }

    public function details($id){

      $user =  User::findOrFail($id);
      return view('admin.users.details',compact('user'));
    }

    public function delete(Request $request)
    {
        $ids=[];
        if(is_array($request->id)){
            $ids=$request->id;
        }else{
            $ids[]=$request->id;
        }
        
        SMS::whereIn('user_id',$ids)->delete();

        User::destroy($ids);

        return ['done'=>1];
    }



    public function activate(Request $request)
    {

        $ids = [];
        if (is_array($request->id)) {
            $ids = $request->id;
        } else {
            $ids[] = $request->id;
        }

        User::query()->whereIn('id',$ids)->update(['status' =>'enabled']);

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

        User::query()->whereIn('id',$ids)->update(['status' =>'disabled']);

        return ['done' => 1];
    }
    
    
    public function sendMsgView($id){
        
        $user =User::findOrFail($id);
        return view('admin.users.send_msg',compact('user'));
        
    }
    
    public function sendMsg(Request $request,$id){
        
    
            
        $user =User::findOrFail($id);
        
        $sms = new SMS();
        $sms->message = $request->message;
        $sms->admin_id = Auth::guard('admin')->user()->id;
        $sms->type     = 'user';
        $sms->user_id  = $user->id;
        $sms->save();
        
        SendSMS::dispatch($user->mobile,$request->message,1);
        

        

        return ['done'=>true];

            
    }

}
