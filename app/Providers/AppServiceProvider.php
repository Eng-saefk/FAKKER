<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // هذا السطر يخبر لارفيل أن كل الروابط والتحويلات يجب أن تكون آمنة
        if (config('app.env') !== 'local') {
            URL::forceScheme('https');
        }
    }
}