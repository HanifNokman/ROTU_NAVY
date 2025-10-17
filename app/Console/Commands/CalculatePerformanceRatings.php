<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\PerformanceCalculationService;

class CalculatePerformanceRatings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'performance:calculate {--intake= : Calculate for specific intake year} {--cadet= : Calculate for specific cadet ID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate and update performance ratings for cadets';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $service = new PerformanceCalculationService();

        if ($this->option('cadet')) {
            $cadetId = $this->option('cadet');
            $this->info("Calculating performance for cadet ID: {$cadetId}");
            $service->calculateCadetPerformance($cadetId);
            $this->info('Performance calculation completed for cadet.');
        } elseif ($this->option('intake')) {
            $intakeYear = $this->option('intake');
            $this->info("Calculating performance for intake year: {$intakeYear}");
            $service->calculateIntakePerformance($intakeYear);
            $this->info('Performance calculation completed for intake.');
        } else {
            $this->info('Calculating performance for all cadets...');
            $service->calculateAllCadetsPerformance();
            $this->info('Performance calculation completed for all cadets.');
        }

        return Command::SUCCESS;
    }
}
