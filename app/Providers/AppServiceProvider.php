<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Http\View\Composers\AdminSidebarComposer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind the public path to public_html in production if it exists
        // as a sibling to the base path (common in shared hosting)
        $this->app->bind('path.public', function() {
            $publicHtml = realpath(base_path() . '/../public_html');
            if ($publicHtml && is_dir($publicHtml)) {
                return $publicHtml;
            }
            return base_path('public');
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.admin', AdminSidebarComposer::class);
    }
}
