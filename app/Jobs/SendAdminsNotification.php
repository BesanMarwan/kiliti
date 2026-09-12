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

class SendAdminsNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;

    public $notification_key;


    public $link;

    public $is_saved;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($notification_key, $data, $is_saved = 2, $link = '')
    {
        $this->data = $data;
        $this->notification_key = $notification_key;
        $this->link = $link;
        $this->is_saved = $is_saved == 2 ? config('custom.default_save_notification') : $is_saved;

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
            NotificationLog::updateNotification($this->notification_key,array_keys($this->data));
            $title = lang('notifications.titles.'.$this->notification_key, [],'', 'ar');
            $message = lang('notifications.messages.'.$this->notification_key, $this->data,'', 'ar');
        }
        if ($this->link) {
            $this->data['link'] = $this->link;
        }
        (new PusherNotificationAdmin($title, $message, $this->data))->send();


        if ($this->is_saved) {
            foreach (Admin::all() as $admin){
                $n = new \App\Models\FcmNotification();
                $n->owner_id = $admin->id;
                $n->owner_type = $admin->getMorphClass();
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
}
