<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewContactUs extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $mess;

    public $name;

    public $mobile;

    public $email;

    public $title;

    public function __construct($name, $mobile, $email, $title, $mess)
    {
        $this->mess = $mess;
        $this->name = $name;
        $this->mobile = $mobile;
        $this->email = $email;
        $this->title = $title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.new_contact')->with(['name' => $this->name, 'mobile' => $this->mobile, 'email' => $this->email, 'title' => $this->title, 'mess' => $this->mess]);
    }
}
