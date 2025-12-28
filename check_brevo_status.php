<?php

/**
 * Brevo Email Status Checker
 *
 * This script helps diagnose why emails might not be received
 */

require __DIR__ . '/vendor/autoload.php';

use Brevo\Client\Api\TransactionalEmailsApi;
use Brevo\Client\Configuration;
use GuzzleHttp\Client;

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Brevo Email Status Checker\n";
echo "==========================\n\n";

$apiKey = env('BREVO_API_KEY');

if (!$apiKey) {
    echo "❌ ERROR: BREVO_API_KEY not found in .env\n";
    exit(1);
}

echo "✓ API Key found\n\n";

// Configure Brevo API
$config = Configuration::getDefaultConfiguration()->setApiKey('api-key', $apiKey);
$apiInstance = new TransactionalEmailsApi(new Client(), $config);

try {
    echo "Checking Brevo Account Status...\n";
    echo "--------------------------------\n\n";

    // Get account information
    $accountApi = new \Brevo\Client\Api\AccountApi(new Client(), $config);
    $account = $accountApi->getAccount();

    echo "Account Email: " . $account->getEmail() . "\n";
    echo "Company Name: " . ($account->getCompanyName() ?? 'Not set') . "\n";
    echo "Account Type: " . ($account->getPlan()[0]['type'] ?? 'Unknown') . "\n\n";

    // Get sender information
    echo "Checking Sender Configuration...\n";
    echo "--------------------------------\n\n";

    $sendersApi = new \Brevo\Client\Api\SendersApi(new Client(), $config);
    $senders = $sendersApi->getSenders();

    if ($senders->getSenders()) {
        echo "Verified Senders:\n";
        foreach ($senders->getSenders() as $sender) {
            $status = $sender->getActive() ? '✓ Active' : '✗ Inactive';
            echo "  - {$sender->getEmail()} ({$sender->getName()}) - {$status}\n";
        }
    } else {
        echo "⚠ WARNING: No verified senders found!\n";
        echo "  You need to verify your sender email in Brevo dashboard.\n";
        echo "  Go to: https://app.brevo.com/senders\n";
    }

    echo "\n";

    // Check recent email statistics
    echo "Recent Email Activity...\n";
    echo "------------------------\n\n";

    // Get today's stats
    $today = new DateTime();
    $statsApi = new \Brevo\Client\Api\TransactionalEmailsApi(new Client(), $config);

    try {
        // Note: Some API endpoints might not be available in free plan
        echo "Note: Detailed statistics may require a paid plan.\n";
        echo "Check full logs at: https://app.brevo.com/email/logs\n\n";
    } catch (\Exception $e) {
        echo "Unable to fetch statistics: " . $e->getMessage() . "\n\n";
    }

    echo "Configuration Summary:\n";
    echo "----------------------\n";
    echo "From Address: " . config('mail.from.address') . "\n";
    echo "From Name: " . config('mail.from.name') . "\n";
    echo "Mail Driver: " . config('mail.default') . "\n\n";

    // Check if sender is verified
    $fromAddress = config('mail.from.address');
    $isVerified = false;

    if ($senders->getSenders()) {
        foreach ($senders->getSenders() as $sender) {
            if (strtolower($sender->getEmail()) === strtolower($fromAddress)) {
                $isVerified = $sender->getActive();
                break;
            }
        }
    }

    if ($isVerified) {
        echo "✓ Your sender email ({$fromAddress}) is verified and active\n";
    } else {
        echo "❌ WARNING: Your sender email ({$fromAddress}) is NOT verified!\n";
        echo "\nTo verify your sender:\n";
        echo "1. Go to https://app.brevo.com/senders\n";
        echo "2. Click 'Add a Sender'\n";
        echo "3. Enter: {$fromAddress}\n";
        echo "4. Complete the verification process\n";
    }

    echo "\n";
    echo "Why You Might Not Receive Emails:\n";
    echo "---------------------------------\n";
    echo "1. Check your spam/junk folder\n";
    echo "2. Sender email must be verified in Brevo (see above)\n";
    echo "3. Email might take a few minutes to arrive\n";
    echo "4. Check Brevo logs: https://app.brevo.com/email/logs\n";
    echo "5. Gmail might filter emails from new senders\n\n";

    echo "✓ Diagnostic complete!\n";

} catch (\Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n\n";

    if (strpos($e->getMessage(), '401') !== false) {
        echo "Invalid API key. Please check your BREVO_API_KEY in .env\n";
    } elseif (strpos($e->getMessage(), '403') !== false) {
        echo "Account not activated. Contact Brevo support at contact@brevo.com\n";
    }
}
