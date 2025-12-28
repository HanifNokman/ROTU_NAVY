<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestBrevoEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:test-brevo {email : The email address to send the test to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Brevo email integration by sending a test email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Invalid email address provided.');
            return 1;
        }

        $this->info('Testing Brevo Email Integration');
        $this->info('================================');
        $this->newLine();

        // Check configuration
        $this->info('Mail Driver: ' . config('mail.default'));
        $this->info('From Address: ' . config('mail.from.address'));
        $this->info('From Name: ' . config('mail.from.name'));
        $this->info('Brevo API Key: ' . (config('services.brevo.key') ? 'Set' : 'Not Set'));
        $this->newLine();

        if (!config('services.brevo.key')) {
            $this->error('Brevo API key is not set in your .env file!');
            return 1;
        }

        $this->info("Sending test email to: {$email}");
        $this->newLine();

        try {
            Mail::raw('This is a test email from ROTU NAVY Training System using Brevo API.', function ($message) use ($email) {
                $message->to($email)
                        ->subject('Brevo Integration Test - ROTU NAVY');
            });

            $this->info('✓ Email sent successfully!');
            $this->newLine();
            $this->info("Please check the inbox of {$email}");
            $this->info('You can also check the email status in your Brevo dashboard:');
            $this->info('https://app.brevo.com/email/logs');
            $this->newLine();

            return 0;

        } catch (\Exception $e) {
            $this->error('✗ Email sending failed!');
            $this->newLine();
            $this->error('Error: ' . $e->getMessage());
            $this->newLine();
            $this->warn('Possible solutions:');
            $this->warn('1. Verify your BREVO_API_KEY is correct');
            $this->warn('2. Check that your Brevo account is active');
            $this->warn('3. Ensure MAIL_FROM_ADDRESS is verified in Brevo');
            $this->warn('4. Check storage/logs/laravel.log for more details');
            $this->newLine();

            return 1;
        }
    }
}
