<?php

namespace App\Console\Commands;

use App\Models\Email;
use Illuminate\Console\Command;

class ProcessEmailQueue extends Command
{
    protected $signature = 'emails:process';
    protected $description = 'Procesar cola de emails pendientes';

    public function handle()
    {
        $pendingEmails = Email::where('status', 'pending')->get();
        
        $this->info("Encontrados {$pendingEmails->count()} emails pendientes.");

        foreach ($pendingEmails as $email) {
            $this->info("Procesando email ID: {$email->id} para: {$email->recipient}");
            
            // Disparar job para cada email pendiente
            \App\Jobs\SendEmailJob::dispatch($email);
        }

        $this->info('Todos los emails han sido encolados para procesamiento.');
    }
}