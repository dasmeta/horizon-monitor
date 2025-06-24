<?php

namespace App\Providers;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\ServiceProvider;
use Laravel\Horizon\Horizon;

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
        Event::listen(function (\SocialiteProviders\Manager\SocialiteWasCalled $event) {
            $event->extendSocialite('authentik', \SocialiteProviders\Authentik\Provider::class);
        });

        Horizon::auth(function () {
             // No OAuth provider → allow public access
            if (empty(env('OAUTH_PROVIDER'))) {
                return true;
            }

            // Redirect to login if not authenticated
            if (!Auth::check()) {

                // Save intended destination (optional)
                session(['url.intended' => url()->current()]);

                throw new HttpResponseException(
                    Redirect::route('redirect')
                );
            }

            return true;
        });
    }
}
