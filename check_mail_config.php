<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "========================================\n";
echo "  Checking Mail Configuration\n";
echo "========================================\n\n";

echo "ENV Values (from .env file):\n";
echo "MAIL_USERNAME: " . env('MAIL_USERNAME') . "\n";
echo "MAIL_PASSWORD: " . env('MAIL_PASSWORD') . "\n";
echo "MAIL_FROM_ADDRESS: " . env('MAIL_FROM_ADDRESS') . "\n";
echo "MAIL_FROM_NAME: " . env('MAIL_FROM_NAME') . "\n\n";

echo "CONFIG Values (what Laravel is using):\n";
echo "MAIL_USERNAME: " . config('mail.mailers.smtp.username') . "\n";
echo "MAIL_PASSWORD: " . config('mail.mailers.smtp.password') . "\n";
echo "MAIL_FROM_ADDRESS: " . config('mail.from.address') . "\n";
echo "MAIL_FROM_NAME: " . config('mail.from.name') . "\n\n";

echo "========================================\n";

// Check .env file directly
echo "Reading .env file directly:\n";
$envFile = file_get_contents(__DIR__ . '/.env');
$envLines = explode("\n", $envFile);
foreach ($envLines as $line) {
    if (strpos($line, 'MAIL_USERNAME') !== false ||
        strpos($line, 'MAIL_PASSWORD') !== false ||
        strpos($line, 'MAIL_FROM') !== false) {
        echo $line . "\n";
    }
}
