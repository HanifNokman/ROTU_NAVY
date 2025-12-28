<?php

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use App\Models\Training;
use App\Notifications\TrainingReminder;
use App\Notifications\TrainingDayNotification;
use Carbon\Carbon;

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Training Email Notification Test ===\n\n";

// Test email address (different from sender to avoid Gmail issues)
$testEmail = 'hanifnokman@gmail.com';
$testName = 'Hanif Nokman';

echo "Creating test user with email: {$testEmail}\n";

// Create or update test user
$user = User::updateOrCreate(
    ['email' => $testEmail],
    [
        'name' => $testName,
        'password' => bcrypt('password'),
        'role' => 'cadet',
        'status' => 'accepted'
    ]
);

echo "User created/updated: ID {$user->id}\n\n";

// Create test training for tomorrow (1-day reminder)
echo "Creating test training for TOMORROW (1-day reminder)...\n";
$tomorrowTraining = Training::create([
    'title' => 'Test Training - Tomorrow',
    'description' => 'This is a test training scheduled for tomorrow to test the 1-day reminder email notification.',
    'start_datetime' => Carbon::tomorrow()->setTime(14, 0, 0),
    'end_datetime' => Carbon::tomorrow()->setTime(16, 0, 0),
    'location' => 'Training Ground A',
    'involvement' => 'all',
    'status' => 'Active'
]);
echo "Training created: ID {$tomorrowTraining->id}\n";
echo "Scheduled for: {$tomorrowTraining->start_datetime->format('Y-m-d H:i:s')}\n\n";

// Create test training for today (D-Day notification)
echo "Creating test training for TODAY (D-Day notification)...\n";
$todayTraining = Training::create([
    'title' => 'Test Training - Today',
    'description' => 'This is a test training scheduled for today to test the D-Day email notification.',
    'start_datetime' => Carbon::today()->setTime(18, 0, 0),
    'end_datetime' => Carbon::today()->setTime(20, 0, 0),
    'location' => 'Training Ground B',
    'involvement' => 'all',
    'status' => 'Active'
]);
echo "Training created: ID {$todayTraining->id}\n";
echo "Scheduled for: {$todayTraining->start_datetime->format('Y-m-d H:i:s')}\n\n";

// Send 1-day reminder email
echo "Sending 1-day reminder email...\n";
try {
    $user->notify(new TrainingReminder($tomorrowTraining, 'cadet'));
    echo "✓ 1-day reminder email queued successfully!\n\n";
} catch (\Exception $e) {
    echo "✗ Error sending 1-day reminder: {$e->getMessage()}\n\n";
}

// Send D-Day notification email
echo "Sending D-Day notification email...\n";
try {
    $user->notify(new TrainingDayNotification($todayTraining, 'cadet'));
    echo "✓ D-Day notification email queued successfully!\n\n";
} catch (\Exception $e) {
    echo "✗ Error sending D-Day notification: {$e->getMessage()}\n\n";
}

echo "=== Email Test Summary ===\n";
echo "Recipient: {$testEmail}\n";
echo "Emails queued:\n";
echo "1. Training Reminder (1-day before) for: {$tomorrowTraining->title}\n";
echo "2. Training Day Notification (D-Day) for: {$todayTraining->title}\n\n";

echo "IMPORTANT: Process the queue to send the emails:\n";
echo "Run: php artisan queue:work\n\n";

echo "Training IDs created (for cleanup later):\n";
echo "- Tomorrow Training ID: {$tomorrowTraining->id}\n";
echo "- Today Training ID: {$todayTraining->id}\n";
echo "- Test User ID: {$user->id}\n\n";

echo "To clean up after testing, run:\n";
echo "php artisan tinker\n";
echo ">>> App\\Models\\Training::destroy([{$tomorrowTraining->id}, {$todayTraining->id}]);\n";
echo ">>> App\\Models\\User::where('email', '{$testEmail}')->delete();\n";
