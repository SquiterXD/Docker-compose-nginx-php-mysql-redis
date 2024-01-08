<?php

namespace App\Exports\OM;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;

class OMR0059 implements SkipsUnknownSheets, WithMultipleSheets
{
    protected $programCode;
    protected $request;
    protected $compact;
    protected $title;
    protected $arrData;

    public function __construct($programCode, $request, $compact)
    {
        $this->programCode = $programCode;
        $this->request = $request;
        $this->compact = $compact;
    }
    public function sheets(): array
    {
        return [
            'ปริมาณบุหรี่' => new OMR0059sheet1($this->programCode, $this->request, $this->compact),
            'มูลค่า' => new OMR0059sheet2($this->programCode, $this->request, $this->compact),
            'รายได้จำหน่ายยาเส้น' => new OMR0059sheet3($this->programCode, $this->request, $this->compact),
        ];
    }
    
    public function onUnknownSheet($sheetName)
    {
        // E.g. you can log that a sheet was not found.
        info("Sheet {$sheetName} was skipped");
    }
}
