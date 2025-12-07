<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Training;
use App\Models\Cadet;
use App\Models\Instructor;
use App\Notifications\TrainingReminder;
use Carbon\Carbon;

class SendTrainingReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:training-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send training reminder notifications and emails to cadets and instructors for trainings scheduled tomorrow';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for trainings scheduled tomorrow...');

        // Get trainings scheduled for tomorrow
        $tomorrow = Carbon::tomorrow();
        $trainings = Training::whereDate('start_datetime', $tomorrow->toDateString())
            ->where('status', 'Active')
            ->get();

        if ($trainings->isEmpty()) {
            $this->info('No trainings scheduled for tomorrow.');
            return 0;
        }

        $this->info("Found {$trainings->count()} training(s) scheduled for tomorrow.");

        $cadetNotificationsSent = 0;
        $instructorNotificationsSent = 0;

        foreach ($trainings as $training) {
            $this->line("Processing: {$training->title}");

            // Send notifications to cadets
            if ($training->involvement && $training->involvement !== 'all') {
                // Parse involvement to get intake years
                $intakes = $this->parseInvolvement($training->involvement);

                foreach ($intakes as $intakeYear) {
                    $cadets = Cadet::where('intake_year', $intakeYear)
                        ->with('user')
                        ->get();

                    foreach ($cadets as $cadet) {
                        if ($cadet->user) {
                            // Check if notification already sent
                            $existingNotification = $cadet->user->notifications()
                                ->where('type', 'App\Notifications\TrainingReminder')
                                ->where('data->training_id', $training->id)
                                ->whereDate('created_at', '>=', now()->subDays(2))
                                ->first();

                            if (!$existingNotification) {
                                $cadet->user->notify(new TrainingReminder($training, 'cadet'));
                                $cadetNotificationsSent++;
                            }
                        }
                    }
                }
            } else {
                // Send to all cadets
                $cadets = Cadet::with('user')->get();

                foreach ($cadets as $cadet) {
                    if ($cadet->user) {
                        $existingNotification = $cadet->user->notifications()
                            ->where('type', 'App\Notifications\TrainingReminder')
                            ->where('data->training_id', $training->id)
                            ->whereDate('created_at', '>=', now()->subDays(2))
                            ->first();

                        if (!$existingNotification) {
                            $cadet->user->notify(new TrainingReminder($training, 'cadet'));
                            $cadetNotificationsSent++;
                        }
                    }
                }
            }

            // Send notifications to all instructors
            $instructors = Instructor::with('user')->get();

            foreach ($instructors as $instructor) {
                if ($instructor->user) {
                    $existingNotification = $instructor->user->notifications()
                        ->where('type', 'App\Notifications\TrainingReminder')
                        ->where('data->training_id', $training->id)
                        ->whereDate('created_at', '>=', now()->subDays(2))
                        ->first();

                    if (!$existingNotification) {
                        $instructor->user->notify(new TrainingReminder($training, 'instructor'));
                        $instructorNotificationsSent++;
                    }
                }
            }
        }

        $this->info("Sent {$cadetNotificationsSent} notifications to cadets.");
        $this->info("Sent {$instructorNotificationsSent} notifications to instructors.");
        $this->info('Training reminders sent successfully!');

        return 0;
    }

    /**
     * Parse involvement string to extract intake years
     */
    private function parseInvolvement($involvement)
    {
        $intakeYears = [];

        if (empty($involvement) || $involvement === 'all') {
            return $intakeYears;
        }

        // Split by comma and parse each intake
        $intakes = explode(',', $involvement);

        foreach ($intakes as $intake) {
            $intake = trim($intake);

            // Extract year from "Intake - XX" format
            if (preg_match('/Intake\s*-\s*(\d+)/', $intake, $matches)) {
                $intakeNumber = (int) $matches[1];
                // Calculate year from intake number (Intake - 1 is 2012)
                $year = 2011 + $intakeNumber;
                $intakeYears[] = $year;
            }
        }

        return $intakeYears;
    }
}
