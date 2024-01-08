<?php

namespace App\Listeners;

use App\Events\OrderLinesDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderLineDeletedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\OrderLinesDeleted  $event
     * @return void
     */
    public function handle(OrderLinesDeleted $event)
    {
        app('log')->info('[Order_Line_Delete_event] data', ['url'=>request()->url(),'data'=>$event->orderLine]);
    }
}
