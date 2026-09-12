<?php

namespace App\Jobs;

use App\Models\Country;
use App\Services\SmsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $mobile;

    public $message;

    public $country_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mobile, $message, $country_id = 0)
    {
        $this->mobile = $mobile;
        $this->message = $message;
        $this->country_id = $country_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(SmsService $sms_service)
    {
        //prepare mobile
        $mobile = $this->mobile;

        if ($this->country_id == 0) {
            $c = Country::where('is_default', 1)->first();
            $prefix = $c->prefix;
            $with_prefix = $c->accept_prefix;

            $check_start_digit = $c->check_start_digit;
        } else {
            $c = Country::where('id', $this->country_id)->first();
            $prefix = $c->prefix;
            $with_prefix = $c->accept_prefix;
            $check_start_digit = $c->check_start_digit;
        }
        // if (substr($this->mobile, 0, 1) == 0 && $check_start_digit == 0) {
        //     $mobile = substr($this->mobile, 1, strlen($this->mobile) - 1);
        // }
        if ($with_prefix) {
            $new_mobile = $mobile;
        } else {
            $new_mobile = $prefix.$mobile;
        }
        $sms_service->send_sms_oursms($new_mobile,$this->message);

    }

}
