<?php

require __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Email Configuration Check ===\n\n";

echo "MAIL_MAILER: " . config('mail.default') . "\n";
echo "MAIL_HOST: " . config('mail.mailers.smtp.host') . "\n";
echo "MAIL_PORT: " . config('mail.mailers.smtp.port') . "\n";
echo "MAIL_USERNAME: " . config('mail.mailers.smtp.username') . "\n";
echo "MAIL_PASSWORD: " . str_repeat('*', strlen(config('mail.mailers.smtp.password'))) . " (length: " . strlen(config('mail.mailers.smtp.password')) . ")\n";
echo "MAIL_ENCRYPTION: " . config('mail.mailers.smtp.encryption') . "\n";
echo "MAIL_FROM_ADDRESS: " . config('mail.from.address') . "\n";
echo "MAIL_FROM_NAME: " . config('mail.from.name') . "\n\n";

echo "Password Details:\n";
echo "Raw password (first 4 chars): " . substr(config('mail.mailers.smtp.password'), 0, 4) . "...\n";
echo "Contains spaces: " . (strpos(config('mail.mailers.smtp.password'), ' ') !== false ? 'YES (THIS IS A PROBLEM!)' : 'No') . "\n";
echo "Contains quotes: " . (strpos(config('mail.mailers.smtp.password'), '"') !== false || strpos(config('mail.mailers.smtp.password'), "'") !== false ? 'YES (THIS IS A PROBLEM!)' : 'No') . "\n\n";

echo "Note: Google App Passwords should be 16 characters, all lowercase, no spaces.\n";
