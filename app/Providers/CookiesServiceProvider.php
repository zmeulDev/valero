<?php

namespace App\Providers;

use Whitecube\LaravelCookieConsent\Consent;
use Whitecube\LaravelCookieConsent\Facades\Cookies;
use Whitecube\LaravelCookieConsent\CookiesServiceProvider as ServiceProvider;

class CookiesServiceProvider extends ServiceProvider
{
    protected function registerCookies(): void
    {
        // Essential cookies (cannot be declined)
        Cookies::essentials()
            ->session()
            ->csrf();

        // Analytics cookies
        Cookies::analytics()
            ->google(
                id: env('GOOGLE_ANALYTICS_ID'),
                anonymizeIp: true
            );

        // Partner Ads cookies
        Cookies::optional()
            ->name('app_partner_ads')
            ->description('This cookie helps us remember your partner ads preferences.')
            ->duration(60 * 24 * 30) // 30 days
            ->accepted(function(Consent $consent) {
                $consent->cookie(value: 'true');
            });
    }
} 