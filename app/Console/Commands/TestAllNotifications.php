<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Training;
use App\Notifications\WelcomeNotification;
use App\Notifications\TrainingReminder;
use App\Notifications\TrainingDayNotification;
use Illuminate\Support\Facades\Password;
use Carbon\Carbon;

class TestAllNotifications extends Command
{
    protected $signature = 'test:all-notifications {email : Email address to send test notifications to}';
    protected $description = 'Test all email notifications in the system (Welcome, Training Reminders, Password Reset)';

    public function handle()
    {
        $email = $this->argument('email');

        $this->info('╔════════════════════════════════════════════════════════════╗');
        $this->info('║   ROTU NAVY - Complete Email Notification Test Suite      ║');
        $this->info('╚════════════════════════════════════════════════════════════╝');
        $this->newLine();

        $this->info("📧 Test Email: {$email}");
        $this->newLine();

        // Get or create test user
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->warn("User not found with email: {$email}");
            if ($this->confirm('Create a test user?', true)) {
                $user = $this->createTestUser($email);
            } else {
                $this->error('Cannot proceed without a user.');
                return 1;
            }
        } else {
            $this->info("✓ Using existing user: {$user->name} (ID: {$user->id}, Role: {$user->role})");
            $this->newLine();
        }

        $results = [
            'total' => 0,
            'success' => 0,
            'failed' => 0,
            'queued' => 0
        ];

        // Test 1: Welcome Email
        $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->info('[1/4] Testing Welcome Email Notification...');
        $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $result = $this->testWelcomeEmail($user);
        $this->updateResults($results, $result);
        $this->newLine();

        // Test 2: Training Reminder (1-day before)
        $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->info('[2/4] Testing Training Reminder (1-Day Before)...');
        $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $result = $this->testTrainingReminder($user);
        $this->updateResults($results, $result);
        $this->newLine();

        // Test 3: Training D-Day Notification
        $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->info('[3/4] Testing Training D-Day Notification...');
        $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $result = $this->testTrainingDayNotification($user);
        $this->updateResults($results, $result);
        $this->newLine();

        // Test 4: Password Reset
        $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->info('[4/4] Testing Password Reset Email...');
        $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $result = $this->testPasswordReset($user);
        $this->updateResults($results, $result);
        $this->newLine();

        // Summary
        $this->info('╔════════════════════════════════════════════════════════════╗');
        $this->info('║                    TEST SUMMARY                            ║');
        $this->info('╚════════════════════════════════════════════════════════════╝');
        $this->newLine();

        $this->info("Total Tests: {$results['total']}");
        $this->info("✓ Successful: {$results['success']}");
        if ($results['failed'] > 0) {
            $this->error("✗ Failed: {$results['failed']}");
        }
        $this->info("📮 Queued: {$results['queued']}");
        $this->newLine();

        if ($results['queued'] > 0) {
            $this->warn('⚠️  IMPORTANT: Emails are queued!');
            $this->warn('Run these commands to process the queue:');
            $this->newLine();
            $this->line('   php artisan queue:work --once');
            $this->line('   (Run this ' . $results['queued'] . ' times, or use: php artisan queue:work)');
            $this->newLine();
        }

        $this->info("📧 Check your inbox: {$email}");
        $this->info('📊 Brevo Dashboard: https://app.brevo.com/email/logs');
        $this->info('📝 Laravel Logs: storage/logs/laravel.log');
        $this->newLine();

        return $results['failed'] === 0 ? 0 : 1;
    }

    private function testWelcomeEmail($user)
    {
        try {
            $this->line('  Subject: Welcome to ROTU NAVY UMS - Training System');
            $this->line('  Type: Account Creation / Welcome Email');
            $this->line('  Includes: Login credentials, dashboard link');

            $temporaryPassword = 'TempPass123!';
            $user->notify(new WelcomeNotification(strtolower($user->role), $temporaryPassword));

            $this->info('  ✓ Welcome email queued successfully');
            $this->line("  📝 Temporary password shown: {$temporaryPassword}");

            return ['success' => true, 'queued' => true];
        } catch (\Exception $e) {
            $this->error('  ✗ Failed: ' . $e->getMessage());
            $this->line('  Stack trace: ' . $e->getTraceAsString());
            return ['success' => false, 'queued' => false];
        }
    }

    private function testTrainingReminder($user)
    {
        try {
            // Get or create training scheduled tomorrow
            $tomorrow = Carbon::tomorrow();
            $training = Training::whereDate('start_datetime', $tomorrow->toDateString())
                ->where('status', 'Active')
                ->first();

            if (!$training) {
                $this->warn('  No training scheduled for tomorrow. Creating mock training...');
                $training = $this->createMockTraining($tomorrow);
                $this->line('  📅 Mock training created for testing purposes');
            } else {
                $this->line("  📅 Using real training: {$training->title}");
            }

            $this->line('  Subject: Training Reminder: ' . $training->title);
            $this->line('  Type: 1-Day Before Training Reminder');
            $this->line('  Training: ' . $training->title);
            $this->line('  Date: ' . $training->start_datetime->format('M d, Y'));
            $this->line('  Time: ' . $training->start_datetime->format('h:i A'));
            $this->line('  Location: ' . $training->location);

            $user->notify(new TrainingReminder($training, strtolower($user->role)));

            $this->info('  ✓ Training reminder queued successfully');

            return ['success' => true, 'queued' => true];
        } catch (\Exception $e) {
            $this->error('  ✗ Failed: ' . $e->getMessage());
            return ['success' => false, 'queued' => false];
        }
    }

    private function testTrainingDayNotification($user)
    {
        try {
            // Get or create training scheduled today
            $today = Carbon::today();
            $training = Training::whereDate('start_datetime', $today->toDateString())
                ->where('status', 'Active')
                ->first();

            if (!$training) {
                $this->warn('  No training scheduled for today. Creating mock training...');
                $training = $this->createMockTraining($today);
                $this->line('  📅 Mock training created for testing purposes');
            } else {
                $this->line("  📅 Using real training: {$training->title}");
            }

            $this->line('  Subject: Training Today: ' . $training->title);
            $this->line('  Type: D-Day Training Notification');
            $this->line('  Training: ' . $training->title);
            $this->line('  Time: ' . $training->start_datetime->format('h:i A'));
            $this->line('  Location: ' . $training->location);

            $user->notify(new TrainingDayNotification($training, strtolower($user->role)));

            $this->info('  ✓ D-Day notification queued successfully');

            return ['success' => true, 'queued' => true];
        } catch (\Exception $e) {
            $this->error('  ✗ Failed: ' . $e->getMessage());
            return ['success' => false, 'queued' => false];
        }
    }

    private function testPasswordReset($user)
    {
        try {
            $this->line('  Subject: Reset Password Notification');
            $this->line('  Type: Password Reset Request');
            $this->line('  Includes: Reset password link (valid for 60 minutes)');

            // Send password reset notification
            $token = Password::createToken($user);
            $user->sendPasswordResetNotification($token);

            $this->info('  ✓ Password reset email sent successfully');
            $this->line('  🔗 Reset link will be valid for 60 minutes');

            return ['success' => true, 'queued' => false];
        } catch (\Exception $e) {
            $this->error('  ✗ Failed: ' . $e->getMessage());
            return ['success' => false, 'queued' => false];
        }
    }

    private function createTestUser($email)
    {
        $this->info('Creating test user...');

        $role = $this->choice(
            'Select user role for testing:',
            ['admin', 'instructor', 'cadet'],
            0
        );

        $user = User::create([
            'name' => 'Test User',
            'email' => $email,
            'password' => bcrypt('password'),
            'role' => $role,
            'email_verified_at' => now(),
        ]);

        $this->info("✓ Test user created: {$user->name} (ID: {$user->id}, Role: {$role})");

        return $user;
    }

    private function createMockTraining($date)
    {
        $training = new Training();
        $training->id = 999;
        $training->title = 'Physical Training Session - TEST';
        $training->description = 'Mock training session created for email testing purposes';
        $training->location = 'Training Ground A';
        $training->start_datetime = $date->copy()->setTime(9, 0);
        $training->end_datetime = $date->copy()->setTime(11, 0);
        $training->status = 'Active';
        $training->involvement = 'all';

        return $training;
    }

    private function updateResults(&$results, $result)
    {
        $results['total']++;
        if ($result['success']) {
            $results['success']++;
        } else {
            $results['failed']++;
        }
        if ($result['queued']) {
            $results['queued']++;
        }
    }
}
