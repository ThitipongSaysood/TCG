<?php

namespace App\Server;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use SocialiteProviders\Manager\SocialiteWasCalled;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // siamcard schema (auth, wallet, address) — separate migration path
        $this->loadMigrationsFrom(database_path('migrations/siamcard'));

        Event::listen(SocialiteWasCalled::class, [
            \SocialiteProviders\Line\LineExtendSocialite::class, 'handle',
        ]);
    }
}
