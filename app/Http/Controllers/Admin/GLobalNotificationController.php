<?php

namespace App\Http\Controllers\Admin;

use App\Jobs\SendDriverNotification;
use App\Jobs\SendDriversNotification;
use App\Jobs\SendUserNotification;
use App\Jobs\SendUsersNotification;
use App\Models\Driver;
use App\Models\GlobalNotification;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GLobalNotificationController extends Controller
{
    public function index(Request $request)
    {
        $out = GlobalNotification::filter($request);
        $out=$out->paginate(20)->appends(\request()->all());

        return view('admin.global_notifications.index', compact('out'));
    }

    public function showCreateView()
    {
        return view('admin.global_notifications.create');
    }

    public function send(Request $request)
    {
        $request->validate([
            'title'  =>['required','string'],
            'message'=>['required','string'],
        ]);
        $notification = new GlobalNotification();
        $notification->title = $request->title;
        $notification->message = $request->message;
        $notification->admin_id = Auth::guard('admin')->user()->id;
        $notification->save();
        SendUsersNotification::dispatch( 'AdminNotification',  ['global_notification'=>$notification->id],1);

        return ['done'=>1];
    }

    public function delete(Request $request)
    {
        $ids = [];
        if (is_array($request->id)) {
            $ids = $request->id;
        } else {
            $ids[] = $request->id;
        }

         GlobalNotification::destroy($ids);

        return ['done' => 1];
    }
}
