<?php

namespace App\Mail;

use App\Models\Email;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;

    public function __construct(Email $email)
    {
        $this->email = $email;
    }

    public function build()
    {
        return $this->subject($this->email->subject)
                    ->view('emails.template')
                    ->with([
                        'content' => $this->email->body,
                        'sender' => $this->email->user->name
                    ]);
    }
}