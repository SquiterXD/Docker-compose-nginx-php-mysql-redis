<?php

namespace App\Jobs\Planning;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Repositories\Planning\MachineYearlyRepo;

class MachineYearlyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $search;
    public $user;

    public function __construct($search, $user)
    {
        $this->search = $search;
        $this->user = $user;
    }

    public function handle()
    {
        \Log::info('Start Create-----');
        (new MachineYearlyRepo)->create($this->search, $this->user);
        \Log::info('End Create------');
        echo 'handle------';
    }

    public function failed()
    {
        echo 'failed';
    }
}
