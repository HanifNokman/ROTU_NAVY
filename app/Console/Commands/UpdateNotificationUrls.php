<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateNotificationUrls extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:update-urls {--dry-run : Show what would be updated without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update notification URLs from localhost to 127.0.0.1:8000';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating notification URLs from localhost to 127.0.0.1:8000...');

        $dryRun = $this->option('dry-run');

        // Get all notifications that contain 'localhost' in their data
        $notifications = DB::table('notifications')
            ->where('data', 'like', '%localhost%')
            ->get();

        $this->info("Found {$notifications->count()} notification(s) with localhost URLs");

        if ($notifications->isEmpty()) {
            $this->info('No notifications need updating.');
            return;
        }

        $updatedCount = 0;

        foreach ($notifications as $notification) {
            $data = json_decode($notification->data, true);

            if (isset($data['url']) && str_contains($data['url'], 'localhost')) {
                $oldUrl = $data['url'];
                $newUrl = str_replace('localhost', '127.0.0.1:8000', $oldUrl);

                if ($dryRun) {
                    $this->line("Would update: {$oldUrl} -> {$newUrl}");
                } else {
                    $data['url'] = $newUrl;
                    DB::table('notifications')
                        ->where('id', $notification->id)
                        ->update(['data' => json_encode($data)]);
                    $updatedCount++;
                }
            }
        }

        if ($dryRun) {
            $this->info('Dry run completed. No changes made.');
        } else {
            $this->info("Successfully updated {$updatedCount} notification URL(s).");
        }

        return 0;
    }
}
