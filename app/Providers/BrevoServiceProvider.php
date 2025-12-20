<?php

namespace App\Providers;

use App\Mail\Transport\BrevoTransport;
use Illuminate\Mail\MailManager;
use Illuminate\Support\ServiceProvider;

class BrevoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->resolving(MailManager::class, function (MailManager $mailManager) {
            $mailManager->extend('brevo', function (array $config) {
                return new BrevoTransport($config['key'] ?? config('services.brevo.key'));
            });
        });
    }
}
