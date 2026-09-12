<?php


namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;


class FcmLegacyNotification extends Notification implements ShouldQueue
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
    public function __construct(string $title, string $message, array $data, string $image = '', string $link = '')
    {
        $this->title = $title;
        $this->message = $message;
        $this->data = $data;
        $this->image = $image;
        $this->link = $link;

    }

    public function send($fcm_token)
    {
        $push=[
            'title'=>$this->title,
            'body'=>$this->message,
//            'badge'=>$this->data['badge'] ?? 1,

        ];
        if(is_array($fcm_token)){
            if(count($fcm_token) == 1){
                return self::send_notification($push,$this->data,$fcm_token[0]);
            }
            return self::send_notification_multible($push,$this->data,$fcm_token);

        }
        return self::send_notification([
            'title'=>$this->title,
            'body'=>$this->message
        ],$this->data,$fcm_token);
    }

    private static function send_notification($push, $data, $key)
    {
        $api_key = config('custom.legacy_fcm_api_key');
        $api_url = 'https://fcm.googleapis.com/fcm/send';

        $pdata = $data;
        //   dd($push);
        $push['sound']='default';
        $fields = array(
            'notification' => $push,
            'data' => $pdata,
            'to' => $key,
            'priority'=>'high',
            'content_available'=>true,
            'apns'=>[
                'headers'=>['apns-priority'=>'10'],
                'payload'=>[
                    'aps'=>['sound'=>'default']
                ]
            ],
            'android'=>[
                'priority'=>'high',
                'notification'=>[
                    'sound'=>'default'
                ]
            ],
        );
        //  $fields = array('notification' => $push, 'data' => $pdata, 'to' => $key);
        $headers = array('Authorization:key=' . $api_key, 'Content-Type: application/json');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        if ($result === false)
            die('Curl failed ' . curl_error($ch));
        curl_close($ch);
        \Log::debug('sended_fcm_for_user',['push'=>$push,'response'=>$result]);

        return $result;
    }
    private static function send_notification_multible($push, $data, $keys)
    {
        $api_key = config('custom.legacy_fcm_api_key');
//        $api_key ='AAAAqA0P9rs:APA91bE79knZUrxZXyAoNZ_yFTKjB7RD1ogvN_gFE-qhUlAPv0cKckiNAYQys1ESS9UXWFtYsPlIoFi18oaf2CFAEehGf9bUP_3Jx5rr2_Msb0G26bxham9MAN9dKYwDgUU1kvCDPBI3';
        $api_url = 'https://fcm.googleapis.com/fcm/send';

        $pdata = $data;
        $push['sound']='default';
//        $fields = array('notification' => $push, 'data' => $pdata, 'registration_ids' => $keys ,
//            "priority" => "high");
        $fields = array(
            'notification' => $push,
            'data' => $pdata,
            'registration_ids' => $keys ,
            'priority'=>'high',
            'content_available'=>true,
            'apns'=>[
                'headers'=>['apns-priority'=>'10'],
                'payload'=>[
                    'aps'=>['sound'=>'default']
                ]
            ],
            'android'=>[
                'priority'=>'high',
                'notification'=>[
                    'sound'=>'default'
                ]
            ],
        );

        //  $fields = array('notification' => $push, 'data' => $pdata, 'to' => $key);
        $headers = array('Authorization:key=' . $api_key, 'Content-Type: application/json');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        if ($result === false)
            die('Curl failed ' . curl_error($ch));
        curl_close($ch);
        \Log::debug('sended_fcm_for_user',['push'=>$push,'response'=>$result]);

        return $result;
    }
}

