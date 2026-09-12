<?php

namespace App\Jobs;

use App\Models\DeviceKey;
use App\Models\GlobalNotification;
use App\Models\NotificationLog;
use App\Models\User;
use App\Models\UserNotification;
use App\Notifications\FcmLegacyNotification;
use App\Notifications\FcmNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendUsersNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;

    public $notification_key;

    public $is_saved;

    public $image;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($notification_key, $data, $is_saved = 2, $image = '')
    {
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
        if ($this->notification_key === 'AdminNotification') {
            $NG = GlobalNotification::find($this->data['global_notification']);
        } else {
            NotificationLog::updateNotification($this->notification_key, array_keys($this->data));
            $title = lang('notifications.titles.' . $this->notification_key, []);
            $message = lang('notifications.messages.' . $this->notification_key, $this->data);

        }

        // replace variables

        $keys = DeviceKey::where('owner_type', User::class)->get();

        $user = new User();
        $user->alt_tokens = $keys->pluck('fcm_token')->toArray();

        try {

            if ($this->notification_key === 'AdminNotification') {
                $title = $NG->title;
                $message = $NG->message;
            }
            foreach ($this->data as $index => $d) {
                $this->data[$index] = (string)$d;
            }
            (new FcmLegacyNotification($title, $message, $this->data, $this->image))->send($user->routeNotificationForFcm());

        } catch (\Exception $e) {
        }

        if ($this->is_saved) {
            foreach ($keys as $key) {
                if ($key->user) {
                    $user = $key->user;
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
    }
}
