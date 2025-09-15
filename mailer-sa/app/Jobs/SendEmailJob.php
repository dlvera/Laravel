<?php

namespace App\Jobs;

use App\Models\Email;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;

    public function __construct(Email $email)
    {
        $this->email = $email;
    }

    public function handle()
    {
        // Enviar el email
        Mail::send([], [], function ($message) {
            $message->to($this->email->recipient)
                    ->subject($this->email->subject)
                    ->setBody($this->email->body, 'text/html');
        });

        // Actualizar el estado a enviado
        $this->email->update([
            'is_sent' => true,
            'sent_at' => now(),
        ]);
    }
}
