<?php

namespace App\Exports\OM;

use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
class OMR0030  extends DefaultValueBinder implements WithMultipleSheets
{
    /**
     * @return array
     */
    public function sheets(): array
    {

        $sheets = [];

        $sheets[] = new OMR0030Sheet1();
        $sheets[] = new OMR0030Sheet2();

        return $sheets;
    }

}

