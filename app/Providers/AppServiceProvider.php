<?php

namespace App\Providers;

use App\Models\DestinationCategory;
use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        view()->composer('*', function ($view) {
            $view->with([
                'navCategories' => DestinationCategory::active()->get(),
                'siteSettings'  => Setting::pluck('value', 'key')->toArray(),
            ]);
        });

        if (config('laravel-whatsapp.ui.enabled')) {
            config(['laravel-whatsapp.ui.middleware' => ['web', 'auth', 'admin']]);
        }

        $this->overrideMailConfigFromSettings();
    }

    private function overrideMailConfigFromSettings(): void
    {
        try {
            if (Setting::get('email_enabled') !== '1') {
                return;
            }

            config([
                'mail.default' => Setting::get('mail_mailer', 'smtp'),
                'mail.mailers.smtp.host' => Setting::get('mail_host', ''),
                'mail.mailers.smtp.port' => Setting::get('mail_port', '587'),
                'mail.mailers.smtp.username' => Setting::get('mail_username', ''),
                'mail.mailers.smtp.password' => Setting::get('mail_password', ''),
                'mail.mailers.smtp.encryption' => Setting::get('mail_encryption', 'tls'),
                'mail.from.address' => Setting::get('mail_from_address', ''),
                'mail.from.name' => Setting::get('mail_from_name', 'ExploreRide'),
            ]);
        } catch (\Exception $e) {
            //
        }
    }
}
