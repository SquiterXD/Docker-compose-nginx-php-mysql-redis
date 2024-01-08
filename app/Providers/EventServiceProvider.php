<?php

namespace App\Providers;

use App\Events\OrderLinesDeleted;
use App\Events\OrderLinesSaved;
use App\Listeners\OrderLineDeletedListener;
use App\Listeners\OrderLineSaveListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
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
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        OrderLinesSaved::class => [
            OrderLineSaveListener::class,
        ],
        OrderLinesDeleted::class => [
            OrderLineDeletedListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
