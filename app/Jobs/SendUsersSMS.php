<?php

namespace App\Jobs;

use App\Models\Country;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\SmsService;
use App\Models\User;


class SendUsersSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $message;

    public function __construct($message)
    {
        $this->message      = $message ;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(SmsService $sms_service)
    {


       $users =  User::where('status','enabled')->select(['mobile','country_id'])->get();

       foreach ($users as $user) {
           //prepare mobile
           $sms_service->send_sms_oursms($user->mobile_prefix,$this->message);

       }




    }
}
