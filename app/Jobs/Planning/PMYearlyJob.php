<?php

namespace App\Jobs\Planning;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Repositories\Planning\ProductMaintenanceRepo;

class PMYearlyJob implements ShouldQueue
{
    // PRODUCT MAINTENANCE
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $resHeader;

    public function __construct($resHeader)
    {
        $this->resHeader = $resHeader;
    }

    public function handle()
    {
        \Log::info('Start Create-----');
        (new ProductMaintenanceRepo)->updatePMYearly($this->resHeader);
        \Log::info('End Create------');
        echo 'handle------';
    }

    public function failed()
    {
        echo 'failed';
    }
}
