<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserPasswordReset extends Mailable
{
    use Queueable, SerializesModels;

    public $code;

    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($code, $url)
    {
        $this->code = $code;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.user-password-reset')
            ->subject('Base استعادة كلمة المرور')
            ->with(['code' => $this->code, 'url' => $this->url]);
    }
}
