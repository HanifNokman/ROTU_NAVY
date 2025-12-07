<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Training;
use App\Models\Cadet;
use App\Models\Instructor;
use App\Notifications\TrainingReminder;
use App\Notifications\TrainingDayNotification;
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
        $this->info('Checking for trainings scheduled tomorrow and today...');

        // Get trainings scheduled for tomorrow (1-day reminder)
        $tomorrow = Carbon::tomorrow();
        $tomorrowTrainings = Training::whereDate('start_datetime', $tomorrow->toDateString())
            ->where('status', 'Active')
            ->get();

        // Get trainings scheduled for today (D-Day notification)
        $today = Carbon::today();
        $todayTrainings = Training::whereDate('start_datetime', $today->toDateString())
            ->where('status', 'Active')
            ->get();

        $cadetNotificationsSent = 0;
        $instructorNotificationsSent = 0;

        // Process tomorrow's trainings (1-day reminder)
        if (!$tomorrowTrainings->isEmpty()) {
            $this->info("Found {$tomorrowTrainings->count()} training(s) scheduled for tomorrow.");
            $stats = $this->sendReminders($tomorrowTrainings, TrainingReminder::class, '1-day reminder');
            $cadetNotificationsSent += $stats['cadets'];
            $instructorNotificationsSent += $stats['instructors'];
        } else {
            $this->info('No trainings scheduled for tomorrow.');
        }

        // Process today's trainings (D-Day notification)
        if (!$todayTrainings->isEmpty()) {
            $this->info("Found {$todayTrainings->count()} training(s) scheduled for today.");
            $stats = $this->sendReminders($todayTrainings, TrainingDayNotification::class, 'D-Day notification');
            $cadetNotificationsSent += $stats['cadets'];
            $instructorNotificationsSent += $stats['instructors'];
        } else {
            $this->info('No trainings scheduled for today.');
        }

        $this->info("Total sent: {$cadetNotificationsSent} notifications to cadets.");
        $this->info("Total sent: {$instructorNotificationsSent} notifications to instructors.");
        $this->info('Training notifications sent successfully!');

        return 0;
    }

    /**
     * Send reminders for given trainings
     */
    private function sendReminders($trainings, $notificationClass, $type)
    {
        $cadetNotificationsSent = 0;
        $instructorNotificationsSent = 0;

        foreach ($trainings as $training) {
            $this->line("Processing {$type}: {$training->title}");

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
                                ->where('type', $notificationClass)
                                ->where('data->training_id', $training->id)
                                ->whereDate('created_at', '>=', now()->subDays(2))
                                ->first();

                            if (!$existingNotification) {
                                $cadet->user->notify(new $notificationClass($training, 'cadet'));
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
                            ->where('type', $notificationClass)
                            ->where('data->training_id', $training->id)
                            ->whereDate('created_at', '>=', now()->subDays(2))
                            ->first();

                        if (!$existingNotification) {
                            $cadet->user->notify(new $notificationClass($training, 'cadet'));
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
                        ->where('type', $notificationClass)
                        ->where('data->training_id', $training->id)
                        ->whereDate('created_at', '>=', now()->subDays(2))
                        ->first();

                    if (!$existingNotification) {
                        $instructor->user->notify(new $notificationClass($training, 'instructor'));
                        $instructorNotificationsSent++;
                    }
                }
            }
        }

        return [
            'cadets' => $cadetNotificationsSent,
            'instructors' => $instructorNotificationsSent
        ];
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
