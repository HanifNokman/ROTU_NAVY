<?php

require __DIR__ . '/vendor/autoload.php';

use App\Models\Training;
use App\Notifications\TrainingReminder;
use App\Notifications\TrainingDayNotification;
use Carbon\Carbon;

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Training Email Preview ===\n\n";

// Create mock user
$mockUser = new class {
    public $name = 'Hanif Nokman';
    public $email = 'hanifnokman02@gmail.com';
};

// Create test training for tomorrow (1-day reminder)
$tomorrowTraining = new Training([
    'id' => 999,
    'title' => 'Test Training - Tomorrow',
    'description' => 'This is a test training scheduled for tomorrow.',
    'start_datetime' => Carbon::tomorrow()->setTime(14, 0, 0),
    'end_datetime' => Carbon::tomorrow()->setTime(16, 0, 0),
    'location' => 'Training Ground A',
    'involvement' => 'all',
    'status' => 'Active'
]);

// Create test training for today (D-Day notification)
$todayTraining = new Training([
    'id' => 1000,
    'title' => 'Test Training - Today',
    'description' => 'This is a test training scheduled for today.',
    'start_datetime' => Carbon::today()->setTime(18, 0, 0),
    'end_datetime' => Carbon::today()->setTime(20, 0, 0),
    'location' => 'Training Ground B',
    'involvement' => 'all',
    'status' => 'Active'
]);

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "1-DAY REMINDER EMAIL PREVIEW\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

$reminderNotification = new TrainingReminder($tomorrowTraining, 'cadet');
$reminderMail = $reminderNotification->toMail($mockUser);

echo "To: {$mockUser->email}\n";
echo "Subject: {$reminderMail->subject}\n";
echo "From: " . config('mail.from.address') . " (" . config('mail.from.name') . ")\n\n";
echo "Email Content:\n";
echo "───────────────────────────────────────────────────\n";
echo "Greeting: {$reminderMail->greeting}\n\n";
foreach ($reminderMail->introLines as $line) {
    echo "• $line\n";
}
echo "\n";
echo "Action Button: {$reminderMail->actionText} → {$reminderMail->actionUrl}\n\n";
foreach ($reminderMail->outroLines as $line) {
    echo "• $line\n";
}
echo "───────────────────────────────────────────────────\n\n";

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "D-DAY NOTIFICATION EMAIL PREVIEW\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

$dayNotification = new TrainingDayNotification($todayTraining, 'cadet');
$dayMail = $dayNotification->toMail($mockUser);

echo "To: {$mockUser->email}\n";
echo "Subject: {$dayMail->subject}\n";
echo "From: " . config('mail.from.address') . " (" . config('mail.from.name') . ")\n\n";
echo "Email Content:\n";
echo "───────────────────────────────────────────────────\n";
echo "Greeting: {$dayMail->greeting}\n\n";
foreach ($dayMail->introLines as $line) {
    echo "• $line\n";
}
echo "\n";
echo "Action Button: {$dayMail->actionText} → {$dayMail->actionUrl}\n\n";
foreach ($dayMail->outroLines as $line) {
    echo "• $line\n";
}
echo "───────────────────────────────────────────────────\n\n";

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "DATABASE NOTIFICATIONS PREVIEW\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

echo "1-Day Reminder (Database):\n";
$reminderArray = $reminderNotification->toArray($mockUser);
echo json_encode($reminderArray, JSON_PRETTY_PRINT) . "\n\n";

echo "D-Day Notification (Database):\n";
$dayArray = $dayNotification->toArray($mockUser);
echo json_encode($dayArray, JSON_PRETTY_PRINT) . "\n\n";

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "GMAIL AUTHENTICATION ISSUE\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

echo "Current MAIL_USERNAME: " . config('mail.mailers.smtp.username') . "\n";
echo "Current MAIL_PASSWORD: " . str_repeat('*', strlen(config('mail.mailers.smtp.password'))) . "\n\n";

echo "The emails are failing to send due to Gmail authentication.\n";
echo "This usually happens when:\n\n";
echo "1. You haven't enabled 2-Step Verification on your Gmail account\n";
echo "2. You need to generate a new App Password\n\n";
echo "To fix this:\n";
echo "─────────────────────────────────────────────────────────\n";
echo "1. Go to: https://myaccount.google.com/security\n";
echo "2. Enable 2-Step Verification if not already enabled\n";
echo "3. Go to: https://myaccount.google.com/apppasswords\n";
echo "4. Create a new App Password for 'Mail'\n";
echo "5. Update your .env file:\n";
echo "   MAIL_PASSWORD=your-new-app-password\n";
echo "6. Run: php artisan config:clear\n";
echo "7. Retry the emails: php artisan queue:retry all\n";
echo "8. Process the queue: php artisan queue:work --stop-when-empty\n";
echo "─────────────────────────────────────────────────────────\n";
