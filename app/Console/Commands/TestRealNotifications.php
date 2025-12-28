<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Training;
use App\Notifications\WelcomeNotification;
use App\Notifications\TrainingReminder;
use App\Mail\UserAcceptedMail;

class TestRealNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:notifications {email : Email address to send test notifications to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test real system notifications with Brevo email integration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $testEmail = $this->argument('email');

        if (!filter_var($testEmail, FILTER_VALIDATE_EMAIL)) {
            $this->error('Invalid email address provided.');
            return 1;
        }

        $this->info('Testing ROTU NAVY Real Notifications with Brevo');
        $this->info('===============================================');
        $this->newLine();

        // Check configuration
        $this->info('Configuration:');
        $this->info('  Mail Driver: ' . config('mail.default'));
        $this->info('  From Address: ' . config('mail.from.address'));
        $this->info('  Test Email: ' . $testEmail);
        $this->newLine();

        // Find a test user or create a temporary one
        $testUser = User::where('email', $testEmail)->first();

        if (!$testUser) {
            $this->warn('No user found with email: ' . $testEmail);
            $this->info('Creating a temporary test user...');

            $testUser = new User();
            $testUser->name = 'Test User';
            $testUser->email = $testEmail;
            $testUser->role = 'cadet';
            $testUser->password = bcrypt('test123');
            // Don't save to database, just use for notification testing
        }

        $this->newLine();
        $this->info('Running notification tests...');
        $this->newLine();

        $successCount = 0;
        $failCount = 0;

        // Test 1: Welcome Notification
        $this->info('[1/3] Testing Welcome Notification...');
        try {
            $testUser->notify(new WelcomeNotification('cadet', 'TempPass123'));
            $this->info('  ✓ Welcome notification sent successfully');
            $successCount++;
        } catch (\Exception $e) {
            $this->error('  ✗ Failed: ' . $e->getMessage());
            $failCount++;
        }
        $this->newLine();

        // Test 2: Training Reminder
        $this->info('[2/3] Testing Training Reminder Notification...');
        try {
            $training = Training::first();

            if ($training) {
                $testUser->notify(new TrainingReminder($training, 'cadet'));
                $this->info('  ✓ Training reminder sent successfully');
                $this->info('  Training: ' . $training->title);
                $successCount++;
            } else {
                $this->warn('  ⚠ No training found in database. Creating mock training for test...');

                // Create a mock training object for testing
                $mockTraining = new Training();
                $mockTraining->title = 'Physical Training Session';
                $mockTraining->location = 'Training Ground A';
                $mockTraining->start_datetime = now()->addDay();
                $mockTraining->end_datetime = now()->addDay()->addHours(2);
                $mockTraining->id = 999;

                $testUser->notify(new TrainingReminder($mockTraining, 'cadet'));
                $this->info('  ✓ Training reminder sent successfully (with mock data)');
                $successCount++;
            }
        } catch (\Exception $e) {
            $this->error('  ✗ Failed: ' . $e->getMessage());
            $failCount++;
        }
        $this->newLine();

        // Test 3: User Accepted Mail (Mailable)
        $this->info('[3/3] Testing User Accepted Mail...');
        try {
            Mail::to($testEmail)->send(new UserAcceptedMail($testUser));
            $this->info('  ✓ User accepted email sent successfully');
            $successCount++;
        } catch (\Exception $e) {
            $this->error('  ✗ Failed: ' . $e->getMessage());
            $failCount++;
        }
        $this->newLine();

        // Summary
        $this->info('Test Summary:');
        $this->info('=============');
        $this->info("✓ Successful: {$successCount}");

        if ($failCount > 0) {
            $this->error("✗ Failed: {$failCount}");
        } else {
            $this->info("✗ Failed: {$failCount}");
        }

        $this->newLine();

        if ($successCount > 0) {
            $this->info('Check your email inbox at: ' . $testEmail);
            $this->info('Also check spam/junk folder if emails are not in inbox');
            $this->info('View delivery status: https://app.brevo.com/email/logs');
        }

        $this->newLine();

        return $failCount === 0 ? 0 : 1;
    }
}
