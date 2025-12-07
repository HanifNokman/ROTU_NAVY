<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TrainingAttendance;
use App\Models\Training;
use App\Notifications\AbsenceJustificationRequired;

class SendAbsenceJustificationNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:absence-justification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notifications to cadets who need to provide absence justification';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for cadets with missing absence justifications...');

        // Get completed trainings with absences that lack justification
        $absences = TrainingAttendance::where('present', false)
            ->whereHas('training', function($query) {
                $query->where('status', 'Completed');
            })
            ->where(function($q) {
                $q->whereNull('absence_reason')
                  ->orWhereNull('file_url')
                  ->orWhere('absence_reason', '')
                  ->orWhere('file_url', '');
            })
            ->with(['cadet.user', 'training'])
            ->get();

        $notificationsSent = 0;

        foreach ($absences as $absence) {
            if (!$absence->cadet || !$absence->cadet->user) {
                continue;
            }

            $missingItems = [];
            if (!$absence->absence_reason || trim($absence->absence_reason) === '') {
                $missingItems[] = 'Absence Reason';
            }
            if (!$absence->file_url || trim($absence->file_url) === '') {
                $missingItems[] = 'Supporting Document';
            }

            // Check if notification already sent for this specific absence
            $existingNotification = $absence->cadet->user->notifications()
                ->where('type', 'App\Notifications\AbsenceJustificationRequired')
                ->whereJsonContains('data->training_title', $absence->training->title)
                ->whereDate('created_at', '>=', now()->subDays(7))
                ->first();

            if (!$existingNotification) {
                $absence->cadet->user->notify(new AbsenceJustificationRequired(
                    $absence->training->title,
                    $absence->training->start_datetime->format('M d, Y'),
                    $missingItems
                ));
                $notificationsSent++;
            }
        }

        $this->info("Sent {$notificationsSent} absence justification notifications.");
        return 0;
    }
}
