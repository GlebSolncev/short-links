<?php

namespace App\Foundation\ShortLinks\DefaultShortLinks\Providers;

use App\Foundation\ShortLinks\Contracts\iShortLink;
use App\Foundation\ShortLinks\DefaultShortLinks\Models\DefaultLinks;
use App\Foundation\ShortLinks\DefaultShortLinks\Observers\ShortLinkObserver;
use App\Foundation\ShortLinks\DefaultShortLinks\Services\DefaultShortLinksService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class DefaultShortLinkProvider extends ServiceProvider
{
    /**
     *
     */
    public function boot()
    {
        DefaultLinks::observe(ShortLinkObserver::class);
    }

    /**
     *
     */
    public function register()
    {
        $this->app->singleton(iShortLink::class, function () {
            return App::make(DefaultShortLinksService::class);
        });
    }
}