<?php

namespace App\Exports\OM;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\OM\Sheets\OMR0065XFirstSheet;
use App\Exports\OM\OMR0065;
use App\Exports\OM\OMR0065_2;

class OMR0065EXCEL implements WithMultipleSheets 
{
    protected $programCode;
    protected $request;

    public function __construct($programCode, $request){
        $this->programCode = $programCode;
        $this->request = $request;
    }

    public function sheets(): array
    {

        return [
            '1' => new OMR0065($this->programCode, $this->request, 'Sheet1'),
            '2' => new OMR0065_2($this->programCode, $this->request, 'Sheet2'),
        ];
    }


}

