<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestTrainingReminders extends Command
{
    protected $signature = 'test:training-reminders {user_id : User ID to send test notifications to}';
    protected $description = 'Test training reminder notifications (1-day before and D-Day) with Brevo';

    public function handle()
    {
        $userId = $this->argument('user_id');
        $user = \App\Models\User::find($userId);

        if (!$user) {
            $this->error("User with ID {$userId} not found.");
            return 1;
        }

        $this->info('Testing Training Reminder Notifications with Brevo');
        $this->info('===================================================');
        $this->newLine();

        $this->info("Test User: {$user->name} ({$user->email})");
        $this->info("Role: {$user->role}");
        $this->newLine();

        $tomorrowTrainings = \App\Models\Training::whereDate('start_datetime', \Carbon\Carbon::tomorrow()->toDateString())->where('status', 'Active')->get();
        $todayTrainings = \App\Models\Training::whereDate('start_datetime', \Carbon\Carbon::today()->toDateString())->where('status', 'Active')->get();

        $this->info('Training Schedule:');
        $this->info("  Tomorrow: {$tomorrowTrainings->count()} training(s)");
        $this->info("  Today: {$todayTrainings->count()} training(s)");
        $this->newLine();

        $successCount = 0;
        $failCount = 0;

        $this->info('[1/2] Testing 1-Day Before Training Reminder...');
        try {
            if ($tomorrowTrainings->isNotEmpty()) {
                $training = $tomorrowTrainings->first();
                $this->line("  Using real training: {$training->title}");
            } else {
                $this->warn('  No trainings tomorrow. Creating mock...');
                $training = $this->createMockTraining(\Carbon\Carbon::tomorrow());
            }
            $user->notify(new \App\Notifications\TrainingReminder($training, strtolower($user->role)));
            $this->info('  ✓ 1-Day Reminder sent');
            $successCount++;
        } catch (\Exception $e) {
            $this->error('  ✗ Failed: ' . $e->getMessage());
            $failCount++;
        }
        $this->newLine();

        $this->info('[2/2] Testing D-Day Notification...');
        try {
            if ($todayTrainings->isNotEmpty()) {
                $training = $todayTrainings->first();
                $this->line("  Using real training: {$training->title}");
            } else {
                $this->warn('  No trainings today. Creating mock...');
                $training = $this->createMockTraining(\Carbon\Carbon::today());
            }
            $user->notify(new \App\Notifications\TrainingDayNotification($training, strtolower($user->role)));
            $this->info('  ✓ D-Day Notification sent');
            $successCount++;
        } catch (\Exception $e) {
            $this->error('  ✗ Failed: ' . $e->getMessage());
            $failCount++;
        }
        $this->newLine();

        $this->info("✓ Successful: {$successCount}/2");
        if ($failCount > 0) $this->error("✗ Failed: {$failCount}/2");
        $this->newLine();
        $this->info("Check inbox: {$user->email}");
        $this->info('Brevo logs: https://app.brevo.com/email/logs');

        return $failCount === 0 ? 0 : 1;
    }

    private function createMockTraining($date)
    {
        $training = new \App\Models\Training();
        $training->id = 999;
        $training->title = 'Physical Training Session';
        $training->location = 'Training Ground A';
        $training->start_datetime = $date->setTime(9, 0);
        $training->end_datetime = $date->copy()->setTime(11, 0);
        $training->status = 'Active';
        return $training;
    }
}
