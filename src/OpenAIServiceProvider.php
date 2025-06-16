<?php

namespace Mayanksinh\OpenAI;

use Illuminate\Support\ServiceProvider;

class OpenAIServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/openai.php', 'openai');

        $this->app->singleton('openai', function () {
            return new OpenAI();
        });
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/openai.php' => config_path('openai.php'),
        ], 'openai-config');
    }
}
