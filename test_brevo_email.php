<?php

/**
 * Brevo Email Integration Test Script
 *
 * This script tests the Brevo email integration.
 *
 * Usage:
 * 1. Make sure you have set BREVO_API_KEY in your .env file
 * 2. Run: php test_brevo_email.php
 */

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\Mail;

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Testing Brevo Email Integration\n";
echo "================================\n\n";

// Check if Brevo API key is set
$brevoKey = env('BREVO_API_KEY');
if (!$brevoKey || $brevoKey === 'your-brevo-api-key-here') {
    echo "❌ ERROR: BREVO_API_KEY is not set in .env file\n";
    echo "\nPlease follow these steps:\n";
    echo "1. Go to https://app.brevo.com/ and sign up or log in\n";
    echo "2. Navigate to: SMTP & API → API Keys\n";
    echo "3. Create a new API key or copy an existing one\n";
    echo "4. Update BREVO_API_KEY in your .env file\n";
    echo "5. Run this script again\n\n";
    exit(1);
}

echo "✓ Brevo API key found\n";
echo "✓ Mail mailer is set to: " . config('mail.default') . "\n\n";

// Test email configuration
echo "Email Configuration:\n";
echo "  FROM: " . config('mail.from.address') . "\n";
echo "  NAME: " . config('mail.from.name') . "\n\n";

// Prompt for test email address
echo "Enter recipient email address for test: ";
$handle = fopen("php://stdin", "r");
$recipientEmail = trim(fgets($handle));
fclose($handle);

if (!filter_var($recipientEmail, FILTER_VALIDATE_EMAIL)) {
    echo "❌ Invalid email address\n";
    exit(1);
}

echo "\nSending test email to: {$recipientEmail}\n";
echo "Please wait...\n\n";

try {
    Mail::raw('This is a test email from ROTU NAVY Training System using Brevo API.', function ($message) use ($recipientEmail) {
        $message->to($recipientEmail)
                ->subject('Brevo Integration Test - ROTU NAVY');
    });

    echo "✓ Email sent successfully!\n";
    echo "\nPlease check the inbox of {$recipientEmail}\n";
    echo "\nYou can also check the email status in your Brevo dashboard:\n";
    echo "https://app.brevo.com/email/logs\n\n";

} catch (\Exception $e) {
    echo "❌ Email sending failed!\n";
    echo "\nError: " . $e->getMessage() . "\n";
    echo "\nPossible solutions:\n";
    echo "1. Verify your BREVO_API_KEY is correct\n";
    echo "2. Check that your Brevo account is active\n";
    echo "3. Ensure MAIL_FROM_ADDRESS is verified in Brevo\n";
    echo "4. Check storage/logs/laravel.log for more details\n\n";
    exit(1);
}

echo "Test completed successfully!\n";
