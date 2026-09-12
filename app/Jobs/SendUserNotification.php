<?php

namespace App\Jobs;

use App\Models\GlobalNotification;
use App\Models\NotificationLog;
use App\Models\User;
use App\Notifications\FcmLegacyNotification;
use App\Notifications\FcmNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendUserNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user_id;

    public $data;

    public $notification_key;

    public $is_saved;

    public $image;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user_id, $notification_key, $data, $is_saved = 2, $image ='')
    {
        $this->user_id = $user_id;
        $this->data = $data;
        $this->notification_key = $notification_key;
        $this->is_saved = $is_saved == 2 ? config('custom.default_save_notification') : $is_saved;
        $this->image = $image;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $user = User::find($this->user_id);

        if(!$user){
            return;
        }
        app()->setLocale($user->language);
        if ($this->notification_key === 'AdminNotification') {
            $NG = GlobalNotification::find($this->data['global_notification']);
            $title = $NG->title;
            $message = $NG->message;
        }else{
            NotificationLog::updateNotification($this->notification_key,array_keys($this->data));
            $title = lang('notifications.titles.'.$this->notification_key, [],'', $user->language);
            $message = lang('notifications.messages.'.$this->notification_key, $this->data,'', $user->language);

        }
        if (count($user->devices)) {
            try {
                foreach ($this->data as $index => $d) {
                    $this->data[$index] = (string) $d;
                }
                (new FcmLegacyNotification($title, $message, $this->data, $this->image))->send($user->routeNotificationForFcm());
//                $user->notify(new FcmNotification($title, $message, $this->data, $this->image));
            } catch (\Exception $e) {
            }
        }
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
            $n->image = $this->image;
            $n->save();
        }
    }
}
