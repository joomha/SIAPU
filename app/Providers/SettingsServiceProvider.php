<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
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
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                $settings = \App\Models\Setting::all();
                
                foreach ($settings as $setting) {
                    \Illuminate\Support\Facades\Config::set('settings.'.$setting->key, $setting->value);
                    
                    // Override Mail
                    if ($setting->key == 'smtp_host' && $setting->value) {
                        \Illuminate\Support\Facades\Config::set('mail.mailers.smtp.host', $setting->value);
                    }
                    if ($setting->key == 'smtp_port' && $setting->value) {
                        \Illuminate\Support\Facades\Config::set('mail.mailers.smtp.port', $setting->value);
                    }
                    if ($setting->key == 'smtp_username' && $setting->value) {
                        \Illuminate\Support\Facades\Config::set('mail.mailers.smtp.username', $setting->value);
                    }
                    if ($setting->key == 'smtp_password' && $setting->value) {
                        \Illuminate\Support\Facades\Config::set('mail.mailers.smtp.password', $setting->value);
                    }
                    if ($setting->key == 'mail_from_address' && $setting->value) {
                        \Illuminate\Support\Facades\Config::set('mail.from.address', $setting->value);
                    }
                    if ($setting->key == 'mail_from_name' && $setting->value) {
                        \Illuminate\Support\Facades\Config::set('mail.from.name', $setting->value);
                    }
                }
            }
        } catch (\Exception $e) {
            // Log error or ignore if DB is not ready
        }
    }
}
