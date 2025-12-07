<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cadet;
use App\Models\Instructor;
use App\Notifications\CgpaDeclineAlert;

class CheckCgpaDecline extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:cgpa-decline {--threshold=0.3 : CGPA decline threshold}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for cadets with significant CGPA decline and notify instructors';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $threshold = (float) $this->option('threshold');
        $this->info("Checking for CGPA declines greater than {$threshold}...");

        // Get cadets with CGPA decline
        $cadetsWithDecline = Cadet::whereNotNull('current_cgpa')
            ->whereNotNull('past_cgpa')
            ->with('user')
            ->get()
            ->filter(function ($cadet) use ($threshold) {
                $decline = $cadet->current_cgpa - $cadet->past_cgpa;
                return $decline < 0 && abs($decline) >= $threshold;
            });

        if ($cadetsWithDecline->isEmpty()) {
            $this->info('No significant CGPA declines found.');
            return 0;
        }

        // Get all instructors to notify
        $instructors = Instructor::with('user')->get();

        $notificationsSent = 0;

        foreach ($cadetsWithDecline as $cadet) {
            $decline = $cadet->current_cgpa - $cadet->past_cgpa;

            foreach ($instructors as $instructor) {
                if (!$instructor->user) {
                    continue;
                }

                // Check if notification already sent for this cadet's current CGPA
                $existingNotification = $instructor->user->notifications()
                    ->where('type', 'App\Notifications\CgpaDeclineAlert')
                    ->where('data->cadet_id', $cadet->id)
                    ->where('data->current_cgpa', $cadet->current_cgpa)
                    ->first();

                if (!$existingNotification) {
                    $instructor->user->notify(new CgpaDeclineAlert(
                        $cadet->user->name,
                        $cadet->id,
                        $cadet->service_number ?? 'N/A',
                        $cadet->current_cgpa,
                        $cadet->past_cgpa,
                        $decline
                    ));
                    $notificationsSent++;
                }
            }

            $this->line("  - {$cadet->user->name}: {$cadet->past_cgpa} → {$cadet->current_cgpa} (decline: " . number_format(abs($decline), 2) . ")");
        }

        $this->info("Sent {$notificationsSent} CGPA decline notifications to instructors.");
        return 0;
    }
}
