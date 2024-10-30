<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;

class LoginServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Event::listen(function (Login $event) {
            $event->user->update([
                'last_login_at' => now(),
            ]);
        });
    }
}
