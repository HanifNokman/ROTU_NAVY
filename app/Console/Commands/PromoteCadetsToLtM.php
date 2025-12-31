<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cadet;
use App\Helpers\BadgeHelper;
use Carbon\Carbon;

class PromoteCadetsToLtM extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cadets:promote-to-ltm {--force : Force promotion without date check}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically promote cadets to Lt M and set status to Completed when they reach their Tauliah date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting automatic cadet promotion process...');

        $force = $this->option('force');
        $today = now();

        // Get all cadets who are not yet Lt M and not Completed
        $cadets = Cadet::where('rank', '!=', 'Lt M')
            ->where('cadet_status', '!=', 'Completed')
            ->whereNotNull('intake_year')
            ->get();

        if ($cadets->isEmpty()) {
            $this->info('No cadets eligible for promotion.');
            return 0;
        }

        $promotedCount = 0;
        $skippedCount = 0;

        foreach ($cadets as $cadet) {
            $intakeYear = $cadet->intake_year;
            $tauliahDate = Carbon::createFromDate($intakeYear + 3, 9, 15);

            // Check if cadet has reached Tauliah date
            if ($force || $today->greaterThanOrEqualTo($tauliahDate)) {
                $oldRank = $cadet->rank;
                $oldStatus = $cadet->cadet_status;

                // Promote to Lt M and set status to Completed
                $cadet->rank = 'Lt M';
                $cadet->cadet_status = 'Completed';
                $cadet->save();

                // Award relevant badges
                $this->awardCompletionBadges($cadet);

                $this->line(sprintf(
                    '✓ Promoted: %s (Matric: %s) - %s → Lt M, %s → Completed [Tauliah: %s]',
                    $cadet->name ?? 'N/A',
                    $cadet->matric_no ?? 'N/A',
                    $oldRank ?? 'N/A',
                    $oldStatus ?? 'N/A',
                    $tauliahDate->format('Y-m-d')
                ));

                $promotedCount++;
            } else {
                $skippedCount++;
            }
        }

        $this->newLine();
        $this->info("Promotion Summary:");
        $this->info("- Promoted: {$promotedCount} cadet(s)");
        $this->info("- Skipped (Tauliah date not reached): {$skippedCount} cadet(s)");
        $this->newLine();

        if ($promotedCount > 0) {
            $this->info('✓ Promotion process completed successfully!');
        } else {
            $this->comment('No promotions were made.');
        }

        return 0;
    }

    /**
     * Award badges to newly promoted Lt M cadets
     */
    private function awardCompletionBadges(Cadet $cadet)
    {
        try {
            // Award Commissioned Officer badge for reaching Lt M
            BadgeHelper::awardBadge($cadet->id, 'Commissioned Officer');

            // Award Best Cadet badge if applicable
            if ($cadet->is_best_cadet) {
                BadgeHelper::awardBadge($cadet->id, 'Best Cadet');
            }

            // Award Best Academic badge if applicable
            if ($cadet->is_best_academic) {
                BadgeHelper::awardBadge($cadet->id, 'Best Academic');
            }
        } catch (\Exception $e) {
            $this->warn("Warning: Could not award badges for {$cadet->name}: {$e->getMessage()}");
        }
    }
}
