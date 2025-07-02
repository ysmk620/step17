<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
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
        RateLimiter::for('login', function ($request) {
            $key = $request->input('email') . $request->ip();

            return Limit::perMinute(5)->by($key)
                ->response(function () use ($request, $key) {
                    $seconds = max(60, ceil(RateLimiter::availableIn($key)));

                    return back()
                        ->withInput($request->only('email'))
                        ->withErrors([
                            'throttle' => "試行回数が多すぎます。{$seconds}秒後に再試行してください。",
                        ]);
                });
        });
    }
}
