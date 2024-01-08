<?php

namespace App\Listeners;

use App\Events\OrderLinesSaved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderLineSaveListener
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
     * @param  \App\Events\OrderLinesSaved  $event
     * @return void
     */
    public function handle(OrderLinesSaved $event)
    {
        // app('log')->info('[Order_Line_Save_event] data', ['url'=>request()->url(),'data'=>$event->orderLine]);
    }
}
