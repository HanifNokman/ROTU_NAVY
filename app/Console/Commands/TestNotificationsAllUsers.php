<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Cadet;
use App\Models\Instructor;
use App\Models\Training;
use App\Notifications\TrainingReminder;
use App\Notifications\TrainingDayNotification;
use Carbon\Carbon;

class TestNotificationsAllUsers extends Command
{
    protected $signature = 'test:notifications-all-users {--type=all : Type of notification (training-reminder, training-day, all)}';
    protected $description = 'Test training notifications for ALL users (cadets and instructors)';

    public function handle()
    {
        $type = $this->option('type');

        $this->info('╔════════════════════════════════════════════════════════════╗');
        $this->info('║   Testing Training Notifications - ALL USERS              ║');
        $this->info('╚════════════════════════════════════════════════════════════╝');
        $this->newLine();

        // Get all users
        $cadets = Cadet::with('user')->get();
        $instructors = Instructor::with('user')->get();

        $this->info("📊 System Statistics:");
        $this->line("   Cadets: {$cadets->count()}");
        $this->line("   Instructors: {$instructors->count()}");
        $this->line("   Total Users: " . ($cadets->count() + $instructors->count()));
        $this->newLine();

        if ($cadets->count() === 0 && $instructors->count() === 0) {
            $this->error('No users found in the system!');
            return 1;
        }

        $results = [
            'total_users' => 0,
            'emails_queued' => 0,
            'failed' => 0,
            'cadets_notified' => 0,
            'instructors_notified' => 0
        ];

        // Test based on type
        if ($type === 'all' || $type === 'training-reminder') {
            $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
            $this->info('Testing 1-Day Before Training Reminder');
            $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
            $this->newLine();

            $reminderResults = $this->testTrainingReminders($cadets, $instructors);
            $results['emails_queued'] += $reminderResults['queued'];
            $results['failed'] += $reminderResults['failed'];
            $results['cadets_notified'] += $reminderResults['cadets'];
            $results['instructors_notified'] += $reminderResults['instructors'];
            $this->newLine();
        }

        if ($type === 'all' || $type === 'training-day') {
            $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
            $this->info('Testing D-Day Training Notification');
            $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
            $this->newLine();

            $dayResults = $this->testTrainingDayNotifications($cadets, $instructors);
            $results['emails_queued'] += $dayResults['queued'];
            $results['failed'] += $dayResults['failed'];

            if ($type === 'training-day') {
                $results['cadets_notified'] += $dayResults['cadets'];
                $results['instructors_notified'] += $dayResults['instructors'];
            }
            $this->newLine();
        }

        $results['total_users'] = $cadets->count() + $instructors->count();

        // Summary
        $this->info('╔════════════════════════════════════════════════════════════╗');
        $this->info('║                    TEST SUMMARY                            ║');
        $this->info('╚════════════════════════════════════════════════════════════╝');
        $this->newLine();

        $this->info("Total Users in System: {$results['total_users']}");
        $this->info("✓ Cadets Notified: {$results['cadets_notified']}");
        $this->info("✓ Instructors Notified: {$results['instructors_notified']}");
        $this->info("📮 Total Emails Queued: {$results['emails_queued']}");

        if ($results['failed'] > 0) {
            $this->error("✗ Failed: {$results['failed']}");
        }
        $this->newLine();

        if ($results['emails_queued'] > 0) {
            $this->warn('⚠️  IMPORTANT: All emails are queued!');
            $this->warn('Process the queue to send emails:');
            $this->newLine();
            $this->line('   Option 1 (Process all at once):');
            $this->line('   php artisan queue:work');
            $this->newLine();
            $this->line('   Option 2 (Process one at a time):');
            $this->line('   php artisan queue:work --once');
            $this->line('   (Run this ' . $results['emails_queued'] . ' times)');
            $this->newLine();
        }

        $this->info('📊 Check Brevo Dashboard: https://app.brevo.com/email/logs');
        $this->info('📝 Check Laravel Logs: storage/logs/laravel.log');
        $this->newLine();

        return $results['failed'] > 0 ? 1 : 0;
    }

    private function testTrainingReminders($cadets, $instructors)
    {
        // Get or create training for tomorrow
        $tomorrow = Carbon::tomorrow();
        $training = Training::whereDate('start_datetime', $tomorrow->toDateString())
            ->where('status', 'Active')
            ->first();

        if (!$training) {
            $this->warn('No training scheduled for tomorrow. Creating mock training...');
            $training = $this->createMockTraining($tomorrow, 'Physical Training Session');
            $this->line('📅 Mock training created for testing');
        } else {
            $this->line("📅 Using real training: {$training->title}");
        }

        $this->line("   Date: {$training->start_datetime->format('M d, Y')}");
        $this->line("   Time: {$training->start_datetime->format('h:i A')}");
        $this->line("   Location: {$training->location}");
        $this->newLine();

        $queued = 0;
        $failed = 0;
        $cadetCount = 0;
        $instructorCount = 0;

        // Send to all cadets
        $this->info('Sending to Cadets...');
        $bar = $this->output->createProgressBar($cadets->count());
        $bar->start();

        foreach ($cadets as $cadet) {
            if ($cadet->user) {
                try {
                    $cadet->user->notify(new TrainingReminder($training, 'cadet'));
                    $queued++;
                    $cadetCount++;
                    $bar->advance();
                } catch (\Exception $e) {
                    $failed++;
                    $this->newLine();
                    $this->error("Failed for cadet {$cadet->user->name}: {$e->getMessage()}");
                }
            }
        }
        $bar->finish();
        $this->newLine();
        $this->info("✓ Queued for {$cadetCount} cadets");
        $this->newLine();

        // Send to all instructors
        $this->info('Sending to Instructors...');
        $bar = $this->output->createProgressBar($instructors->count());
        $bar->start();

        foreach ($instructors as $instructor) {
            if ($instructor->user) {
                try {
                    $instructor->user->notify(new TrainingReminder($training, 'instructor'));
                    $queued++;
                    $instructorCount++;
                    $bar->advance();
                } catch (\Exception $e) {
                    $failed++;
                    $this->newLine();
                    $this->error("Failed for instructor {$instructor->user->name}: {$e->getMessage()}");
                }
            }
        }
        $bar->finish();
        $this->newLine();
        $this->info("✓ Queued for {$instructorCount} instructors");

        return [
            'queued' => $queued,
            'failed' => $failed,
            'cadets' => $cadetCount,
            'instructors' => $instructorCount
        ];
    }

    private function testTrainingDayNotifications($cadets, $instructors)
    {
        // Get or create training for today
        $today = Carbon::today();
        $training = Training::whereDate('start_datetime', $today->toDateString())
            ->where('status', 'Active')
            ->first();

        if (!$training) {
            $this->warn('No training scheduled for today. Creating mock training...');
            $training = $this->createMockTraining($today, 'Team Building Exercises');
            $this->line('📅 Mock training created for testing');
        } else {
            $this->line("📅 Using real training: {$training->title}");
        }

        $this->line("   Time: {$training->start_datetime->format('h:i A')}");
        $this->line("   Location: {$training->location}");
        $this->newLine();

        $queued = 0;
        $failed = 0;
        $cadetCount = 0;
        $instructorCount = 0;

        // Send to all cadets
        $this->info('Sending to Cadets...');
        $bar = $this->output->createProgressBar($cadets->count());
        $bar->start();

        foreach ($cadets as $cadet) {
            if ($cadet->user) {
                try {
                    $cadet->user->notify(new TrainingDayNotification($training, 'cadet'));
                    $queued++;
                    $cadetCount++;
                    $bar->advance();
                } catch (\Exception $e) {
                    $failed++;
                    $this->newLine();
                    $this->error("Failed for cadet {$cadet->user->name}: {$e->getMessage()}");
                }
            }
        }
        $bar->finish();
        $this->newLine();
        $this->info("✓ Queued for {$cadetCount} cadets");
        $this->newLine();

        // Send to all instructors
        $this->info('Sending to Instructors...');
        $bar = $this->output->createProgressBar($instructors->count());
        $bar->start();

        foreach ($instructors as $instructor) {
            if ($instructor->user) {
                try {
                    $instructor->user->notify(new TrainingDayNotification($training, 'instructor'));
                    $queued++;
                    $instructorCount++;
                    $bar->advance();
                } catch (\Exception $e) {
                    $failed++;
                    $this->newLine();
                    $this->error("Failed for instructor {$instructor->user->name}: {$e->getMessage()}");
                }
            }
        }
        $bar->finish();
        $this->newLine();
        $this->info("✓ Queued for {$instructorCount} instructors");

        return [
            'queued' => $queued,
            'failed' => $failed,
            'cadets' => $cadetCount,
            'instructors' => $instructorCount
        ];
    }

    private function createMockTraining($date, $title)
    {
        $training = new Training();
        $training->id = 999 + rand(1, 100);
        $training->title = $title . ' - TEST';
        $training->description = 'Mock training session created for email testing purposes';
        $training->location = 'Training Ground A';
        $training->start_datetime = $date->copy()->setTime(9, 0);
        $training->end_datetime = $date->copy()->setTime(11, 0);
        $training->status = 'Active';
        $training->involvement = 'all';

        return $training;
    }
}
