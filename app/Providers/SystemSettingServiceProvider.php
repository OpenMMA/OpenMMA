<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\SystemSetting;

class SystemSettingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('settings', function($app) {
            return $app['cache']->remember('site.settings', 0, function() {
                $settings = SystemSetting::all()->toArray();
                return array_combine(
                    array_map(fn($setting) => $setting['key'], $settings),
                    array_map(function($setting) {
                        switch ($setting['type']) {
                            case 'text':
                                return $setting['value'];
                            case 'json':
                            case 'form':
                                return json_decode($setting['value']);
                            case 'num':
                                return intval($setting['value']);
                            case 'image':
                                return $setting['value'];
                        }
                    }, $settings)
                );
            });
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
