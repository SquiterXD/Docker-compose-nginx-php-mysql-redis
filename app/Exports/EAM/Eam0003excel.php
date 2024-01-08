<?php

namespace App\Exports\EAM;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class Eam0003excel implements FromView
{
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        // return  view('eam.report.emp0003.index', compact('m', 'data', 'hol', 'programCode', 'progTitle', 'tyear', 'y'));
        $m = $this->data['m'];
        $data = $this->data['data'];
        $hol = $this->data['hol'];
        $programCode = $this->data['programCode'];
        $progTitle = $this->data['progTitle'];
        $tyear = $this->data['tyear'];
        $y = $this->data['y'];
        return  view('eam.report.emp0003.index', compact('m', 'data', 'hol', 'programCode', 'progTitle', 'tyear', 'y'));
    }
}
