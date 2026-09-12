<?php

namespace App\Jobs;

use App\Models\Admin;
use App\Models\GlobalNotification;
use App\Models\NotificationLog;
use App\Notifications\PusherNotificationAdmin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendAdminNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $admin_id;

    public $data;

    public $notification_key;

    public $is_saved;

    public $link;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($admin_id, $notification_key, $data,  $link = '', $is_saved = 1)
    {
        $this->admin_id = $admin_id;
        $this->data = $data;
        $this->notification_key = $notification_key;
        $this->is_saved = $is_saved;
        $this->link = $link;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {


        if ($this->notification_key === 'AdminNotification') {
            $NG = GlobalNotification::find($this->data['global_notification']);
            $title = $NG->title;
            $message = $NG->message;
        } else {
            //create the fields if not found
            /// see cms/admin/translations for translate the keys
            ///
            NotificationLog::updateNotification($this->notification_key,array_keys($this->data));
            $title = lang('notifications.titles.'.$this->notification_key, [],'', 'ar');
            $message = lang('notifications.messages.'.$this->notification_key, $this->data,'', 'ar');
        }

        $user = Admin::find($this->admin_id);


        if ($this->link) {
            $this->data['link'] = $this->link;
        }
        (new PusherNotificationAdmin($title, $message, $this->data))->send($user->id);

        if ($this->is_saved) {
            $n = new \App\Models\FcmNotification();
            $n->owner_id = $user->id;
            $n->owner_type = $user->getMorphClass();
            $n->notification_key = $this->notification_key;
            $n->title = $title;
            $n->message = $message;
            $n->data = $this->data;
            if ($this->notification_key == 'AdminNotification') {
                $n->global_id = $NG->id;
            } else {
                $n->global_id = null;
            }
            $n->save();
        }
    }
}
