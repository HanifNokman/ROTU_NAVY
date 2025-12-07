<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// ============================================================================
// NOTIFICATION SYSTEM SCHEDULES
// ============================================================================

// Send absence justification reminders daily at 6:00 AM
Schedule::command('notifications:absence-justification')
    ->dailyAt('06:00')
    ->name('absence-justification-notifications')
    ->withoutOverlapping()
    ->onOneServer();

// Check for CGPA decline every 6 months (March 1 and October 1 at 10:00 AM)
Schedule::command('notifications:cgpa-decline')
    ->cron('0 10 1 3,10 *')  // Runs on March 1 and October 1 at 10:00 AM
    ->name('cgpa-decline-notifications')
    ->withoutOverlapping()
    ->onOneServer();

// Send training reminders daily at 5:00 AM
Schedule::command('notifications:training-reminders')
    ->dailyAt('05:00')
    ->name('training-reminders')
    ->withoutOverlapping()
    ->onOneServer();

// Clean up old notifications daily at 2:00 AM (keeps last 30 days)
Schedule::command('notifications:cleanup')
    ->dailyAt('02:00')
    ->name('cleanup-old-notifications')
    ->withoutOverlapping()
    ->onOneServer();