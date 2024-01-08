<?php

namespace App\Exports\OM;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
/////// Models \\\\\\
use App\Models\OM\Rma\Export\PtomProformaInvoiceHeadres;
use App\Models\OM\Rma\Export\PtomProformaInvoiceLines;
use App\Models\OM\Api\Customer;
use App\Models\OM\SequenceEcoms;
use App\Models\OM\PrepareSaleOrder\UomConversionModel;
use App\Models\OM\Settings\ProductTypeExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class OMR0082MultiSheet  implements WithMultipleSheets
{
    protected $view, $data;

    public function __construct($view, $data)
    {
        $this->view = $view;
        $this->data = $data;
    }
    public function sheets(): array
    {
        $sheets = [];
        // $product_type_code = [1, 2, 3];\

        $group = $this->data['data']->groupBy([function($item){
            return in_array($item->product_type_code, ['10', '20']) ? $item->product_type_code : '0';
        },function($item){
            return optional($item->tran_type)->description;
        }]);

        foreach ($group as $product_type_code => $groupName) {

            if(in_array($product_type_code, ['10']))
                $title = 'รายงานยอดจำหน่ายบุหรี่ต่างประเทศ';
            elseif(in_array($product_type_code, ['20'])){
                $title = 'รายงานยอดจำหน่ายยาเส้นต่างประเทศ';
            }else {
                $title = 'รายงานยอดจำหน่ายสินค้ากึ่งสำเร็จรูปต่างประเทศ';
            }

            foreach ($groupName as $type_name => $items) {
                $sheets[] = new OMR0082(
                    $this->view, [
                        'data' => $items,
                        'master_uom' => $this->data['master_uom'],
                        'program' => $this->data['program'],
                        'titleReport' => $this->data['titleReport'],
                        'date' => $this->data['date']
                    ], 
                    $product_type_code, 
                    $title,
                    $type_name
                );
            }
        }

        return $sheets;
    }
    


}

