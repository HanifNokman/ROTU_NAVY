<?php

require __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Recent Notifications in Database ===\n\n";

$notifications = DB::table('notifications')
    ->where('notifiable_id', 1) // User ID 1 (test user)
    ->latest()
    ->take(10)
    ->get();

if ($notifications->isEmpty()) {
    echo "No notifications found in database.\n";
} else {
    echo "Found {$notifications->count()} notification(s):\n\n";

    foreach ($notifications as $notification) {
        $data = json_decode($notification->data, true);

        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "Notification ID: " . substr($notification->id, 0, 8) . "...\n";
        echo "Type: " . $notification->type . "\n";
        echo "Created: " . $notification->created_at . "\n";
        echo "Read: " . ($notification->read_at ? 'Yes' : 'No') . "\n\n";
        echo "Title: " . ($data['title'] ?? 'N/A') . "\n";
        echo "Message: " . ($data['message'] ?? 'N/A') . "\n";
        echo "Training: " . ($data['training_title'] ?? 'N/A') . "\n";
        echo "Date: " . ($data['training_date'] ?? 'N/A') . "\n";
        echo "Time: " . ($data['training_time'] ?? 'N/A') . "\n";
        echo "Location: " . ($data['training_location'] ?? 'N/A') . "\n";
        echo "URL: " . ($data['url'] ?? 'N/A') . "\n";
        echo "\n";
    }
}
