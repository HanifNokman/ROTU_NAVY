<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class StandardizeUserNames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:standardize-names {--dry-run : Preview changes without applying them}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Standardize all user names with proper capitalization (e.g., "hanif bin nokman" → "Hanif bin Nokman")';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');

        if ($dryRun) {
            $this->info('🔍 DRY RUN MODE - No changes will be made to the database');
            $this->newLine();
        }

        $users = User::all();
        $totalUsers = $users->count();

        if ($totalUsers === 0) {
            $this->info('No users found in the database.');
            return Command::SUCCESS;
        }

        $this->info("Found {$totalUsers} users. Starting name standardization...");
        $this->newLine();

        $updated = 0;
        $skipped = 0;
        $changes = [];

        $progressBar = $this->output->createProgressBar($totalUsers);
        $progressBar->start();

        foreach ($users as $user) {
            $originalName = $user->name;
            $standardizedName = $this->standardizeName($originalName);

            if ($originalName !== $standardizedName) {
                $changes[] = [
                    'id' => $user->id,
                    'email' => $user->email,
                    'original' => $originalName,
                    'standardized' => $standardizedName,
                ];

                if (!$dryRun) {
                    $user->name = $standardizedName;
                    $user->save();
                }

                $updated++;
            } else {
                $skipped++;
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        // Display summary
        $this->info('📊 Summary:');
        $this->table(
            ['Metric', 'Count'],
            [
                ['Total Users', $totalUsers],
                ['Names Updated', $updated],
                ['Names Already Correct', $skipped],
            ]
        );

        // Display changes if there are any
        if ($updated > 0) {
            $this->newLine();

            if ($dryRun) {
                $this->warn('🔍 Preview of changes (use without --dry-run to apply):');
            } else {
                $this->info('✅ Applied changes:');
            }

            $this->newLine();

            // Show first 20 changes, or all if less than 20
            $displayChanges = array_slice($changes, 0, 20);

            $this->table(
                ['ID', 'Email', 'Original Name', 'Standardized Name'],
                array_map(function($change) {
                    return [
                        $change['id'],
                        $change['email'],
                        $change['original'],
                        $change['standardized'],
                    ];
                }, $displayChanges)
            );

            if (count($changes) > 20) {
                $remaining = count($changes) - 20;
                $this->info("... and {$remaining} more changes");
            }

            if ($dryRun) {
                $this->newLine();
                $this->info('💡 To apply these changes, run: php artisan users:standardize-names');
            }
        } else {
            $this->newLine();
            $this->info('✨ All user names are already properly formatted!');
        }

        return Command::SUCCESS;
    }

    /**
     * Standardize name by capitalizing the first letter of each word.
     * Handles common Malay name particles (bin, binti) as lowercase.
     */
    private function standardizeName(string $name): string
    {
        // Trim and remove extra spaces
        $name = trim(preg_replace('/\s+/', ' ', $name));

        // Split into words
        $words = explode(' ', $name);

        // Common Malay name particles that should be lowercase
        $lowercaseParticles = ['bin', 'binti', 'a/l', 'a/p', 'al'];

        $standardized = [];
        foreach ($words as $word) {
            $lowerWord = strtolower($word);

            // Check if it's a common particle
            if (in_array($lowerWord, $lowercaseParticles)) {
                $standardized[] = $lowerWord;
            } else {
                // Capitalize first letter, rest lowercase
                $standardized[] = ucfirst($lowerWord);
            }
        }

        return implode(' ', $standardized);
    }
}
