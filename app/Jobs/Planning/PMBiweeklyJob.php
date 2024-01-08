<?php

namespace App\Jobs\Planning;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Repositories\Planning\ProductMaintenanceRepo;

class PMBiweeklyJob implements ShouldQueue
{
    // PRODUCT MAINTENANCE
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $pluckHead;

    public function __construct($pluckHead)
    {
        $this->pluckHead = $pluckHead;
    }

    public function handle()
    {
        \Log::info('Start Create-----');
        (new ProductMaintenanceRepo)->updatePMBiweekly($this->pluckHead);
        \Log::info('End Create------');
        echo 'handle------';
    }

    public function failed()
    {
        echo 'failed';
    }
}
