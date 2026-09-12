<?php


namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Pusher\Pusher;


class PusherNotificationAdmin extends Notification implements ShouldQueue
{
    use Queueable;

    public $title;

    public $message;

    public $data;


    public $link;

    /**
     * @param $title
     * @param $message
     * @param $data
     * @param $image
     */
    public function __construct(string $title, string $message, array $data, string $link = '')
    {
        $this->title = $title;
        $this->message = $message;
        $this->data = $data;
        $this->link = $link;

    }

    public function send($admin_id='')
    {
        $push=[
            'title'=>$this->title,
            'message'=>$this->message,
            'link'=>$this->link,
            'data'=>$this->data
        ];

        $pusher_auth_key=config('custom.pusher_auth_key');
        $pusher_secret=config('custom.pusher_secret');
        $pusher_app_id=config('custom.pusher_app_id');
        $options = array(
            'cluster' => 'ap2',
            'useTLS' => true
        );
        $pusher = new Pusher(
            $pusher_auth_key,
            $pusher_secret,
            $pusher_app_id,
            $options
        );


        return $pusher->trigger('admin_notifications', 'notification'.$admin_id, $push);
    }

}

