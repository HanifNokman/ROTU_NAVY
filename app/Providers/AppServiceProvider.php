<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Cadet;
use App\Models\Training;
use App\Models\LearningMaterial;
use App\Policies\CadetPolicy;
use App\Policies\TrainingPolicy;
use App\Policies\LearningMaterialPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Cadet::class => CadetPolicy::class,
        Training::class => TrainingPolicy::class,
        LearningMaterial::class => LearningMaterialPolicy::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register policies
        foreach ($this->policies as $model => $policy) {
            Gate::policy($model, $policy);
        }

        // Register mail view namespace
        $this->loadViewsFromPath(resource_path('views/vendor/mail'), 'mail');
    }

    /**
     * Load views from a given path with a namespace.
     */
    protected function loadViewsFromPath(string $path, string $namespace): void
    {
        if (is_dir($path)) {
            app('view')->addNamespace($namespace, $path);
        }
    }
}
