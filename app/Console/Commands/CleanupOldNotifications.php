<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CleanupOldNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:cleanup {--days=30 : Number of days to keep notifications}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete notifications older than specified days (default: 30 days)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = (int) $this->option('days');
        $cutoffDate = Carbon::now()->subDays($days);

        $this->info("Cleaning up notifications older than {$days} days...");
        $this->line("Cutoff date: {$cutoffDate->format('Y-m-d H:i:s')}");

        // Count notifications to be deleted
        $count = DB::table('notifications')
            ->where('created_at', '<', $cutoffDate)
            ->count();

        if ($count === 0) {
            $this->info('No old notifications to clean up.');
            return 0;
        }

        // Show what will be deleted
        $this->line("Found {$count} notification(s) to delete.");

        // Delete old notifications
        $deleted = DB::table('notifications')
            ->where('created_at', '<', $cutoffDate)
            ->delete();

        $this->info("✓ Deleted {$deleted} old notification(s).");

        // Show statistics
        $remaining = DB::table('notifications')->count();
        $unread = DB::table('notifications')->whereNull('read_at')->count();

        $this->newLine();
        $this->line("Statistics:");
        $this->line("  • Remaining notifications: {$remaining}");
        $this->line("  • Unread notifications: {$unread}");

        return 0;
    }
}
