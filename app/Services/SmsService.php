<?php


namespace App\Services;


use Illuminate\Support\Facades\Http;

class SmsService
{

    public function send_sms_api_server14($mobile, $text)
    {
        $key = '';
        $sender = urlencode('housekichen');
        $messgmobile = str_replace(' ', '+', $text);
        $url = "https://api-server14.com/api/send.aspx?apikey=$key&language=2&sender=$sender&mobile=$mobile&message=$messgmobile";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);

        return curl_exec($ch);
    }

    public function send_sms_oursms($mobile, $text)
    {
        $messgmobile = urlencode($text);
        $username='';
        $password='';
        $sender='';
        $url="http://www.oursms.net/api/sendsms.php?username=$username&password=$password&message=$messgmobile&numbers=$mobile&sender=$sender&unicode=E&return=full";
        $response = Http::get($url);

        // \Log::info($response->body());
        return $response->body();
    }

    public function send_sms_unifonic($mobile, $text)
    {
        $messgmobile = urlencode($text);
        $username = '';
        $password = '';
        $AppSid = '';
        $SenderID = '';
        $response = Http::withBasicAuth($username, $password)->acceptJson()
            ->post('http://basic.unifonic.com/rest/SMS/messages', [
                'AppSid' => $AppSid,
                'SenderID' => $SenderID,
                'Body' => $messgmobile,
                'Recipient' => $mobile,
                'responseType' => 'JSON',
                'CorrelationID' => '%22%22',
                'baseEncode' => 'false',
                'statusCallback' => 'sent',
                'async' => 'false',
                'encoding' => 'UCS2',
            ]);

        return $response->body();
    }

    public function send_sms_nexmo($mobile, $text)
    {
        $key = '';
        $secret = '';
        $from = '';
        $messgmobile = urlencode($text);
        $url = "https://rest.nexmo.com/sms/json?api_key=$key&api_secret=$secret&text=".$messgmobile.'&to='.$mobile."&from=$from&type=unicode";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);

        return curl_exec($ch);
    }

    private function send_sms_nst_sms($mobile, $text)
    {
        $messgmobile = urlencode($text);
        $username = '';
        $password = '';
        $sender = '';
        $url = "http://www.nst-sms.com/api.php?send_sms&username=$username&password=$password&numbers=".$mobile."&sender=$sender&message=".$messgmobile;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);

        return curl_exec($ch);
    }

    private function send_sms_whatsApp($mobile, $text)
    {

        $curl = curl_init();
        $instance = '';
        $token = '';
        $messgmobile = urlencode($text);

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://user.4whats.net/api/sendMessage?instanceid=$instance&token=$token&phone=$mobile&body=$messgmobile",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            \Log::info($err);
        } else {
            \Log::info($response);
        }

    }



}
