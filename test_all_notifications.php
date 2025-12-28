<?php

require __DIR__ . '/vendor/autoload.php';

use App\Models\User;
use App\Models\Training;
use App\Notifications\TrainingReminder;
use App\Notifications\TrainingDayNotification;
use App\Notifications\WelcomeNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "========================================\n";
echo "  ROTU NAVY - Email Notification Test  \n";
echo "========================================\n\n";

// Test email address
$testEmail = 'hanifnokman02@gmail.com';
$testName = 'Lt M Hanif Nokman';

echo "Step 1: Creating test user...\n";
echo "Email: {$testEmail}\n";

// Create or update test user
$user = User::updateOrCreate(
    ['email' => $testEmail],
    [
        'name' => $testName,
        'password' => bcrypt('password123'),
        'role' => 'cadet',
        'status' => 'accepted'
    ]
);

echo "✓ User created/updated: ID {$user->id}\n\n";

// ==========================================
// TEST 1: Account Creation Email
// ==========================================
echo "========================================\n";
echo "TEST 1: Account Creation Email\n";
echo "========================================\n";
$temporaryPassword = 'TempPass123!';

try {
    // Send notification directly
    $user->notify(new WelcomeNotification('cadet', $temporaryPassword));

    echo "✅ SUCCESS! Account creation email sent!\n";
    echo "Recipient: {$testEmail}\n";
    echo "Temporary Password: {$temporaryPassword}\n\n";
} catch (\Exception $e) {
    echo "❌ FAILED! Error: {$e->getMessage()}\n\n";
}

// ==========================================
// TEST 2: 1-Day Before Training Reminder
// ==========================================
echo "========================================\n";
echo "TEST 2: 1-Day Before Training Reminder\n";
echo "========================================\n";

echo "Creating training for TOMORROW...\n";
$tomorrowTraining = Training::create([
    'title' => 'Physical Training Session',
    'description' => 'Weekly physical training and fitness assessment. All cadets must attend in proper PT uniform.',
    'start_datetime' => Carbon::tomorrow()->setTime(14, 0, 0),
    'end_datetime' => Carbon::tomorrow()->setTime(16, 0, 0),
    'location' => 'UMS Sports Complex',
    'involvement' => 'all',
    'status' => 'Active'
]);

echo "Training created: ID {$tomorrowTraining->id}\n";
echo "Scheduled: {$tomorrowTraining->start_datetime->format('Y-m-d H:i:s')}\n";

try {
    // Send notification directly
    $user->notify(new TrainingReminder($tomorrowTraining, 'cadet'));

    echo "✅ SUCCESS! 1-day reminder email sent!\n";
    echo "Training: {$tomorrowTraining->title}\n";
    echo "When: {$tomorrowTraining->start_datetime->format('d M Y, h:i A')}\n\n";
} catch (\Exception $e) {
    echo "❌ FAILED! Error: {$e->getMessage()}\n\n";
}

// ==========================================
// TEST 3: D-Day Training Notification
// ==========================================
echo "========================================\n";
echo "TEST 3: D-Day Training Notification\n";
echo "========================================\n";

echo "Creating training for TODAY...\n";
$todayTraining = Training::create([
    'title' => 'Navigation & Seamanship Training',
    'description' => 'Hands-on training in naval navigation and seamanship techniques. Bring your training manual and compass.',
    'start_datetime' => Carbon::today()->setTime(18, 0, 0),
    'end_datetime' => Carbon::today()->setTime(20, 0, 0),
    'location' => 'Naval Training Center',
    'involvement' => 'all',
    'status' => 'Active'
]);

echo "Training created: ID {$todayTraining->id}\n";
echo "Scheduled: {$todayTraining->start_datetime->format('Y-m-d H:i:s')}\n";

try {
    // Send notification directly
    $user->notify(new TrainingDayNotification($todayTraining, 'cadet'));

    echo "✅ SUCCESS! D-Day notification email sent!\n";
    echo "Training: {$todayTraining->title}\n";
    echo "When: {$todayTraining->start_datetime->format('d M Y, h:i A')}\n\n";
} catch (\Exception $e) {
    echo "❌ FAILED! Error: {$e->getMessage()}\n\n";
}

// ==========================================
// SUMMARY
// ==========================================
echo "========================================\n";
echo "           TEST SUMMARY                 \n";
echo "========================================\n";
echo "Recipient Email: {$testEmail}\n\n";

echo "Emails Sent:\n";
echo "1. ✉️  Account Creation (Welcome Email)\n";
echo "   - Subject: Welcome to ROTU NAVY UMS\n";
echo "   - Contains: Temporary Password\n\n";

echo "2. ✉️  Training Reminder (1-Day Before)\n";
echo "   - Training: {$tomorrowTraining->title}\n";
echo "   - Date: {$tomorrowTraining->start_datetime->format('d M Y')}\n";
echo "   - Time: {$tomorrowTraining->start_datetime->format('h:i A')}\n\n";

echo "3. ✉️  Training Day Notification (D-Day)\n";
echo "   - Training: {$todayTraining->title}\n";
echo "   - Date: {$todayTraining->start_datetime->format('d M Y')}\n";
echo "   - Time: {$todayTraining->start_datetime->format('h:i A')}\n\n";

echo "========================================\n";
echo "📧 Check {$testEmail} inbox!\n";
echo "========================================\n\n";

echo "Test Data Created:\n";
echo "- User ID: {$user->id} ({$user->email})\n";
echo "- Tomorrow Training ID: {$tomorrowTraining->id}\n";
echo "- Today Training ID: {$todayTraining->id}\n\n";

echo "To clean up test data, run:\n";
echo "php artisan tinker\n";
echo ">>> App\\Models\\Training::destroy([{$tomorrowTraining->id}, {$todayTraining->id}]);\n";
echo ">>> App\\Models\\User::where('email', '{$testEmail}')->delete();\n\n";
