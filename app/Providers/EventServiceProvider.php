<?php

namespace App\Providers;

use App\Events\ActivityLogged;
use App\Listeners\LogActivity;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // Register your event and listener here
        ActivityLogged::class => [
            LogActivity::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        // You can register any custom events here if needed
    }
}
