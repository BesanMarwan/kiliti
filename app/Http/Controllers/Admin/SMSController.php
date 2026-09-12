<?php

namespace App\Http\Controllers\Admin;

use App\Jobs\SendSMS2;
use App\Jobs\SendSupervisorsSMS;
use App\Jobs\SendUsersSMS;
use App\Models\Advisor;
use App\Models\User;
use App\Models\SMS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SMSController extends Controller
{
    public function index(Request $request)
    {
        $out=SMS::latest()
             ->filter($request)
             ->paginate(20)
             ->appends(\request()->all());

        return view('admin.sms.index',compact('out'));
    }

    public function showCreateView()
    {
        return view('admin.sms.create');

    }
    public function send(Request $request)
    {
        $request->validate([
            'message'     => ['required','string'],
            //'notify_type' => ['required',Rule::in(['users','supervisors'])],
        ]);
        $sms           = new SMS();
        $sms->message  = $request->message;
        //$sms->type     = $request->notify_type;
        $sms->admin_id = Auth::guard('admin')->user()->id;
        $sms->save();

        $message= $request->message ;
         SendUsersSMS::dispatch($message);

        return ['done'=>1];

    }

    public function delete(Request $request)
    {
        $ids=[];
        if(is_array($request->id)){
            $ids=$request->id;
        }else{
            $ids[]=$request->id;
        }

        SMS::destroy($ids);

        return ['done'=>1];
    }
}
