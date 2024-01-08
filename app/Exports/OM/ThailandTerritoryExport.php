<?php

namespace App\Exports\OM;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ThailandTerritoryExport implements FromView
{
    public function __construct($thailandTerritories)
    {
        $this->thailandTerritories = $thailandTerritories;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('om.settings.thailand-territory.exports._template', [
            'thailandTerritories' => $this->thailandTerritories,
        ]);
    }
}
