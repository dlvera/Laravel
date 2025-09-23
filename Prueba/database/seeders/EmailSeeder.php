<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Email;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class EmailSeeder extends Seeder
{
    public function run()
    {
        // Usar delete() en lugar de truncate() para evitar problemas con claves foráneas
        DB::table('email_attachments')->delete();
        DB::table('emails')->delete();
        
        // Resetear auto-incrementos
        DB::statement('ALTER TABLE emails AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE email_attachments AUTO_INCREMENT = 1');
        
        $users = User::all();
        $allowedStatuses = ['pending', 'sending', 'sent', 'failed'];
        
        if ($users->count() === 0) {
            $this->command->info('No users found. Skipping email seeding.');
            return;
        }
        
        // Crear emails para cada usuario
        foreach ($users as $user) {
            Email::create([
                'subject' => 'Welcome Email for ' . $user->name,
                'recipient' => $user->email,
                'body' => 'Thank you for registering with our service.',
                'status' => 'sent',
                'user_id' => $user->id,
                'sent_at' => now()->subDays(rand(1, 30)),
            ]);
        }
        
        // Crear emails adicionales
        for ($i = 0; $i < 50; $i++) {
            $status = $allowedStatuses[array_rand($allowedStatuses)];
            
            Email::create([
                'subject' => 'Email ' . ($i + 1) . ' - ' . $status,
                'recipient' => 'test' . $i . '@example.com',
                'body' => 'This is a ' . $status . ' email content.',
                'status' => $status,
                'user_id' => $users->random()->id,
                'sent_at' => $status === 'sent' ? now()->subDays(rand(1, 60)) : null,
            ]);
        }
        
        $this->command->info('Emails seeded successfully!');
    }
}