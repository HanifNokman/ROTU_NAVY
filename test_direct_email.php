<?php

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\Mail;

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Direct Email Test (No Queue) ===\n\n";

echo "Email Configuration:\n";
echo "MAIL_HOST: " . config('mail.mailers.smtp.host') . "\n";
echo "MAIL_PORT: " . config('mail.mailers.smtp.port') . "\n";
echo "MAIL_USERNAME: " . config('mail.mailers.smtp.username') . "\n";
echo "MAIL_ENCRYPTION: " . config('mail.mailers.smtp.encryption') . "\n";
echo "MAIL_FROM: " . config('mail.from.address') . "\n\n";

echo "Testing direct SMTP connection...\n\n";

try {
    Mail::raw('This is a test email from ROTU Navy Training System.', function ($message) {
        $message->to('hanifnokman@gmail.com')
                ->subject('Test Email - Training System');
    });

    echo "✅ SUCCESS! Email sent successfully!\n";
    echo "Check hanifnokman@gmail.com inbox for the test email.\n\n";

} catch (\Exception $e) {
    echo "❌ FAILED! Error sending email:\n";
    echo "Error: " . $e->getMessage() . "\n\n";

    // Check if it's authentication error
    if (strpos($e->getMessage(), '535') !== false) {
        echo "This is a Gmail authentication error (535).\n";
        echo "The app password 'qbanibuqbkszapfc' is NOT valid for hanifnokman02@gmail.com\n\n";
        echo "Solutions:\n";
        echo "1. Double-check the app password was generated for hanifnokman02@gmail.com\n";
        echo "2. Generate a NEW app password at: https://myaccount.google.com/apppasswords\n";
        echo "3. Make sure 2-Step Verification is enabled\n";
        echo "4. Update MAIL_PASSWORD in .env file\n";
        echo "5. Run: php artisan config:clear\n";
    }
}
