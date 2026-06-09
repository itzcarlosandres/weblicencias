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
        require_once app_path('Helpers/CurrencyHelper.php');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                $mailHost = \App\Models\Setting::get('mail_host');
                if ($mailHost) {
                    config([
                        'mail.mailers.smtp.host' => $mailHost,
                        'mail.mailers.smtp.port' => \App\Models\Setting::get('mail_port', 587),
                        'mail.mailers.smtp.username' => \App\Models\Setting::get('mail_username'),
                        'mail.mailers.smtp.password' => \App\Models\Setting::get('mail_password'),
                        'mail.mailers.smtp.encryption' => \App\Models\Setting::get('mail_encryption', 'tls'),
                        'mail.from.address' => \App\Models\Setting::get('mail_from_address', env('MAIL_FROM_ADDRESS')),
                        'mail.from.name' => \App\Models\Setting::get('site_name', env('MAIL_FROM_NAME', 'TodoKeys')),
                    ]);
                }
            }
        } catch (\Exception $e) {
            // Ignorar errores durante migraciones
        }
    }
}
