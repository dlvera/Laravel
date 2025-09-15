<?php

namespace App\Console\Commands;

use App\Models\Email;
use Illuminate\Console\Command;
use App\Jobs\SendEmailJob;

class ProcessEmailQueue extends Command
{
    protected $signature = 'email:process';
    protected $description = 'Procesa la cola de emails pendientes';

    public function handle()
    {
        $pendingEmails = Email::where('is_sent', false)->get();
        
        foreach ($pendingEmails as $email) {
            SendEmailJob::dispatch($email);
            $this->info("Email {$email->id} añadido a la cola de envío");
        }
        
        $this->info("Procesamiento de emails completado. Total: {$pendingEmails->count()}");
    }
}