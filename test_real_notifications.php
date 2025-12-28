<?php

require __DIR__ . '/vendor/autoload.php';

use App\Models\Training;
use App\Models\Cadet;
use App\Models\Instructor;
use App\Models\User;
use App\Notifications\WelcomeNotification;
use Carbon\Carbon;

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "REAL TRAINING & ACCOUNT NOTIFICATION TEST\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

// Part 1: Check trainings scheduled for tomorrow and today
echo "PART 1: CHECKING REAL TRAININGS\n";
echo "═══════════════════════════════════════════════════\n\n";

$tomorrow = Carbon::tomorrow();
$today = Carbon::today();

echo "Today's date: " . $today->format('Y-m-d') . "\n";
echo "Tomorrow's date: " . $tomorrow->format('Y-m-d') . "\n\n";

// Trainings for tomorrow (1-day reminder)
$tomorrowTrainings = Training::whereDate('start_datetime', $tomorrow->toDateString())
    ->where('status', 'Active')
    ->get();

echo "Trainings scheduled for TOMORROW (1-day reminder):\n";
echo "───────────────────────────────────────────────────\n";
if ($tomorrowTrainings->isEmpty()) {
    echo "  No trainings scheduled for tomorrow.\n\n";
} else {
    echo "  Found {$tomorrowTrainings->count()} training(s):\n\n";
    foreach ($tomorrowTrainings as $training) {
        echo "  • ID: {$training->id}\n";
        echo "    Title: {$training->title}\n";
        echo "    Time: {$training->start_datetime->format('Y-m-d H:i')}\n";
        echo "    Location: {$training->location}\n";
        echo "    Involvement: {$training->involvement}\n\n";
    }
}

// Trainings for today (D-Day notification)
$todayTrainings = Training::whereDate('start_datetime', $today->toDateString())
    ->where('status', 'Active')
    ->get();

echo "Trainings scheduled for TODAY (D-Day notification):\n";
echo "───────────────────────────────────────────────────\n";
if ($todayTrainings->isEmpty()) {
    echo "  No trainings scheduled for today.\n\n";
} else {
    echo "  Found {$todayTrainings->count()} training(s):\n\n";
    foreach ($todayTrainings as $training) {
        echo "  • ID: {$training->id}\n";
        echo "    Title: {$training->title}\n";
        echo "    Time: {$training->start_datetime->format('Y-m-d H:i')}\n";
        echo "    Location: {$training->location}\n";
        echo "    Involvement: {$training->involvement}\n\n";
    }
}

// Part 2: Count affected users
echo "\nPART 2: CHECKING AFFECTED USERS\n";
echo "═══════════════════════════════════════════════════\n\n";

$totalCadets = Cadet::with('user')->get()->filter(fn($c) => $c->user !== null)->count();
$totalInstructors = Instructor::with('user')->get()->filter(fn($i) => $i->user !== null)->count();

echo "Total Cadets with user accounts: {$totalCadets}\n";
echo "Total Instructors with user accounts: {$totalInstructors}\n\n";

// Part 3: Run the actual training reminder command
echo "\nPART 3: RUNNING TRAINING REMINDER COMMAND\n";
echo "═══════════════════════════════════════════════════\n\n";

echo "Executing: php artisan notifications:training-reminders\n\n";
Artisan::call('notifications:training-reminders');
echo Artisan::output();

// Part 4: Test account creation notification
echo "\nPART 4: TESTING ACCOUNT CREATION NOTIFICATION\n";
echo "═══════════════════════════════════════════════════\n\n";

$testEmail = 'hanifnokman02@gmail.com';

echo "Creating test account for: {$testEmail}\n\n";

// Create test user
$testUser = User::updateOrCreate(
    ['email' => $testEmail],
    [
        'name' => 'Hanif Nokman Test',
        'password' => bcrypt('TestPassword123'),
        'role' => 'cadet',
        'status' => 'accepted'
    ]
);

$tempPassword = 'TestPassword123';

echo "Sending welcome notification with temporary password...\n";
try {
    $testUser->notify(new WelcomeNotification('cadet', $tempPassword));
    echo "✓ Welcome notification queued successfully!\n\n";
} catch (\Exception $e) {
    echo "✗ Error: {$e->getMessage()}\n\n";
}

// Part 5: Check queue status
echo "\nPART 5: QUEUE STATUS\n";
echo "═══════════════════════════════════════════════════\n\n";

$pendingJobs = DB::table('jobs')->count();
echo "Pending jobs in queue: {$pendingJobs}\n\n";

echo "To process all queued emails, run:\n";
echo "  php artisan queue:work --stop-when-empty\n\n";

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "TEST SUMMARY\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

echo "✓ Checked real trainings in database\n";
echo "✓ Executed training reminder command\n";
echo "✓ Tested account creation notification\n";
echo "✓ All notifications queued for processing\n\n";

echo "Next step: Process the queue to send emails\n";
echo "  php artisan queue:work --stop-when-empty\n\n";
