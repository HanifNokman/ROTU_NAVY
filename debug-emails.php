<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Training;
use App\Models\Cadet;
use App\Models\Instructor;
use Carbon\Carbon;

echo "=== EMAIL DEBUG REPORT ===\n\n";

// Check 1: Training tomorrow
echo "1. Checking trainings tomorrow:\n";
$tomorrow = Carbon::tomorrow();
$trainings = Training::whereDate('start_datetime', $tomorrow->toDateString())
    ->where('status', 'Active')
    ->get();

echo "   Tomorrow's date: " . $tomorrow->toDateString() . "\n";
echo "   Trainings found: " . $trainings->count() . "\n";

foreach($trainings as $training) {
    echo "   - " . $training->title . " (ID: {$training->id})\n";
    echo "     Status: {$training->status}\n";
    echo "     Involvement: {$training->involvement}\n";
    echo "     Date: " . $training->start_datetime->format('Y-m-d H:i') . "\n";
}

echo "\n2. Checking cadets:\n";
$cadets = Cadet::with('user')->get();
echo "   Total cadets: " . $cadets->count() . "\n";
echo "   Cadets with user account: " . $cadets->filter(fn($c) => $c->user !== null)->count() . "\n";

echo "\n3. Checking instructors:\n";
$instructors = Instructor::with('user')->get();
echo "   Total instructors: " . $instructors->count() . "\n";
echo "   Instructors with user account: " . $instructors->filter(fn($i) => $i->user !== null)->count() . "\n";

echo "\n4. Checking queue:\n";
$queuedJobs = DB::table('jobs')->count();
echo "   Jobs in queue: {$queuedJobs}\n";

echo "\n5. Checking if queue worker is running:\n";
echo "   Run this command: tasklist | findstr php\n";
echo "   If you see php.exe processes, queue worker is running\n";

echo "\n6. Mail configuration:\n";
echo "   MAIL_MAILER: " . config('mail.default') . "\n";
echo "   MAIL_HOST: " . config('mail.mailers.smtp.host') . "\n";
echo "   MAIL_FROM: " . config('mail.from.address') . "\n";

echo "\n=== END REPORT ===\n";
