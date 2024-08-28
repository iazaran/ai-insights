<?php

namespace AIInsights\Providers;

use Illuminate\Support\ServiceProvider;

class AIInsightsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        // Merge the package configuration with the application's published copy
        $this->mergeConfigFrom(__DIR__.'/../../config/ai-insights.php', 'ai-insights');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Publish the configuration file
        $this->publishes([
            __DIR__.'/../../config/ai-insights.php' => config_path('ai-insights.php'),
        ], 'ai-insights-config');
    }
}
