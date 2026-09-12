<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidNotification;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;
use NotificationChannels\Fcm\Resources\WebpushConfig;
use NotificationChannels\Fcm\Resources\WebpushFcmOptions;

class FcmNotification extends Notification
{
    use Queueable;

    public $title;
    public $message;
    public $data;
    public $image;
    public $link;

    /**
     * @param $title
     * @param $message
     * @param $data
     * @param $image
     */
    public function __construct(string $title,string $message, array $data, string $image='', string $link='')
    {
        $this->title = $title;
        $this->message = $message;
        $this->data = $data;
        $this->image = $image;
        $this->link = $link;
    }


    public function via($notifiable)
    {
        return [FcmChannel::class];
    }

    public function toFcm($notifiable)
    {
        $message=\NotificationChannels\Fcm\Resources\Notification::create()
            ->setTitle((string)$this->title)
            ->setBody((string)$this->message);
        if($this->image){
            $message->setImage($this->image);
        }

        $data=[];
        foreach ($this->data as $id=>$d){
            $data[$id]=(string) $d;
        }
        if(!$this->image){
            $this->image='';
        }
        $fcm= FcmMessage::create()
            ->setData($this->data)
            ->setNotification($message)
            ->setAndroid(
                AndroidConfig::create()
                    ->setFcmOptions(AndroidFcmOptions::create()->setAnalyticsLabel('analytics'))
//                    ->setNotification(AndroidNotification::create()->setColor('#0A0A0A'))
            )
            ->setWebpush(
                WebpushConfig::create()
                    ->setData($this->data)
                    ->setNotification([
                        'icon'=>$this->image,
                        'link'=>$this->link,
                    ])->setFcmOptions(WebpushFcmOptions::create()->setAnalyticsLabel('analytics_js'))
//                    ->setNotification(AndroidNotification::create()->setColor('#0A0A0A'))
            )->setApns(
                ApnsConfig::create()
                    ->setFcmOptions(ApnsFcmOptions::create()->setAnalyticsLabel('analytics_ios')));
        return $fcm;

    }

    // optional method when using kreait/laravel-firebase:^3.0, this method can be omitted, defaults to the default project
    public function fcmProject($notifiable, $message)
    {

        // $message is what is returned by `toFcm`
        return 'app'; // name of the firebase project to use
    }
}
