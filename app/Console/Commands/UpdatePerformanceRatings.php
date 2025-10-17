<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PerformanceRating;

class UpdatePerformanceRatings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'performance:update-ratings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all performance ratings with current points';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting performance ratings update...');

        $ratings = PerformanceRating::all();
        $bar = $this->output->createProgressBar($ratings->count());

        $bar->start();

        foreach($ratings as $rating) {
            $rating->updateAllPoints();
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Performance ratings updated successfully.');
    }
}
