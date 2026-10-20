<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
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
        \App\Models\Payment::observe(\App\Observers\PaymentObserver::class);

        // Tema brand Fintegrita: pink/purple sesuai fintegrita.com (inline, tanpa build step)
        \Illuminate\Support\Facades\FilamentView::registerRenderHook(
            \Filament\View\PanelsRenderHook::STYLES_BEFORE,
            fn () => '<style>'.file_get_contents(resource_path('css/fintegrita-theme.css')).'</style>'
        );

        if ($this->app->environment('production')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}
