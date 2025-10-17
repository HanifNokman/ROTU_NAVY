<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cadet;
use App\Models\PerformanceRating;

class CreatePerformanceRatings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'performance:create-ratings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create performance ratings for all cadets that don\'t have one';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating performance ratings for all cadets...');

        $cadets = Cadet::all();
        $bar = $this->output->createProgressBar($cadets->count());

        $bar->start();

        foreach($cadets as $cadet) {
            PerformanceRating::getOrCreateForCadet($cadet->id);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Performance ratings created successfully.');
    }
}
