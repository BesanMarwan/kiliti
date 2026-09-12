<?php

namespace App\Http\Controllers\Admin;

use App\Jobs\SendUserNotification;
use App\Models\Contact;
//use App\Models\ContactReplay;
//use App\Models\Replay;
use App\Mail\ContactUsReplay;
//use App\Mail\ActivateCode;

use App\Models\ContactReplay;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $objects = Contact::query()
//              ->orderByRaw('(id - is_seen) desc')
              ->orderBy('is_seen','asc')
              ->filter($request)
              ->paginate(20)
             ->appends(\request()->all());

        return view('admin.contacts.index', compact('objects'));
    }

    public function delete(Request $request)
    {
        $ids = [];
        if (is_array($request->id)) {
            $ids = $request->id;
        } else {
            $ids[] = $request->id;
        }

        $deleted_count = 0;
        foreach ($ids as $id) {
            $contact = Contact::findOrFail($id);
            $contact->delete();
            $deleted_count++;
        }

        return ['done' => count($ids) == $deleted_count ? 1 : 0];
    }

    public function show($id)
    {
        $contact = Contact::query()->findOrFail($id);

        return view('admin.contacts.show', compact('contact'));
    }


    public function details($id)
    {
        $contact          = Contact::query()->with('replies')->findOrFail($id);
        $contact->is_seen = 1;
        $contact->save();

        return view('admin.contacts.details', compact('contact'));
    }

    public function send_replay(Request $request)
    {
        $request->validate([
            'contact_id' => 'required|exists:contacts,id',
            'message' => 'required|string'
        ]);

        $contact      = Contact::findOrFail($request->contact_id);

        $contact_reply = ContactReplay::query()->create([
            'message'    => $request->message,
            'contact_id' => $contact->id,
            'owner_id'   => 1,
            'owner_type' => 'App\Models\Admin',
        ]);

        /**
         * send msg whatsapp and notification user
         */

        if($contact->creator_type == 'App\Models\User'){
            SendUserNotification::dispatch($contact->creator_id, 'UserContactReplay', ['user_id' =>$contact->creator_id, 'message' => $contact->reply, 'action' => 'UserContactReplay'],0);
        }
        flash('تم الارسال بنجاح');
        return back();
    }

}
