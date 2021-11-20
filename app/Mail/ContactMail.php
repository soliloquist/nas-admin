<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class ContactMail extends Mailable
{
    public $name;
    public $phone;
    public $email;
    public $content;


    public function __construct($name, $phone, $email, $content)
    {
        $this->name = $name;
        $this->phone = $phone;
        $this->email = $email;
        $this->content= $content;
    }

    public function build()
    {
        return $this->view('emails.contact');
    }
}
