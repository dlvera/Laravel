<?php

namespace App\Jobs;

use App\Models\Email;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserEmail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $email;

    public function __construct(Email $email)
    {
        $this->email = $email;
    }

    public function handle()
    {
        try {
            // Marcar como enviando
            $this->email->update(['status' => 'sending']);
            
            // Enviar email
            Mail::to($this->email->recipient)->send(new UserEmail($this->email));
            
            // Marcar como enviado
            $this->email->markAsSent();
            
        } catch (\Exception $e) {
            $this->email->markAsFailed();
            \Log::error("Error sending email {$this->email->id}: " . $e->getMessage());
        }
    }

    public function failed(\Exception $exception)
    {
        $this->email->markAsFailed();
        \Log::error("Job failed for email {$this->email->id}: " . $exception->getMessage());
    }
}