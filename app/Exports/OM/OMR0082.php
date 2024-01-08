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
// use App\Models\OM\Rma\Export\PtomProformaInvoiceHeadres;
// use App\Models\OM\Rma\Export\PtomProformaInvoiceLines;
// use App\Models\OM\Api\Customer;
// use App\Models\OM\SequenceEcoms;
// use App\Models\OM\PrepareSaleOrder\UomConversionModel;
// use App\Models\OM\Settings\ProductTypeExport;
use Illuminate\Support\Facades\DB;

class OMR0082  extends DefaultValueBinder implements WithCustomValueBinder, FromView, WithColumnWidths, WithColumnFormatting
{
    protected $view, $data, $type, $title, $type_name;

    public function __construct($view, $data, $type, $title, $type_name)
    {
        $this->view = $view;
        $this->data = $data;
        $this->type = $type;
        $this->title = $title;
        $this->type_name = $type_name;
    }

    public function view(): View
    {
        $this->data['titleReport'] = $this->title;
        $this->data['typeName'] = $this->type_name;
        $this->data['product_type_code'] = $this->type;
        $product_type_code = $this->type;

        if(in_array($product_type_code, ['10']))
            $request_uom = request()->uom_code;
        elseif(in_array($product_type_code, ['20'])){
            $request_uom = request()->uom_nomal;
        }else {
            $request_uom = request()->uom_weight;
        }

        $all_uom_request = DB::table('ptom_uom_conversions_v')
        ->whereIn('uom_code', [request()->uom_code, request()->uom_nomal, request()->uom_weight])
        ->get();

        $this->data['uom'] = DB::table('ptom_uom_conversions_v')->where('uom_code', $request_uom)->first();
        $this->data['items'] = [];
        foreach($this->data['data'] as $item) {
            foreach($item->lines as $line) {
                $line_uom = optional(DB::table('ptom_uom_conversions_v')->where('uom_code', $line->uom_code)->first());
                $find = $all_uom_request->where('base_unit_code', $line_uom->base_unit_code)->first();
                $line->approve_quantity = $this->convertUom($line->item_id, $line->uom_code, $find->uom_code, $line->approve_quantity);
                $line->header_obj = $item;
                if($item->currency == 'THB') {
                    $line->total_amount = $line->total_amount;
                } else {
                    $line->total_amount = $item->pick_exchange_rate * $line->total_amount;
                }

                if($item->currency == 'THB') {
                    $line->tax_amount = $line->tax_amount;
                } else {
                    $line->tax_amount = $item->pick_exchange_rate * $line->tax_amount;
                }

                if($item->currency == 'THB') {
                    $line->amount = $line->amount;
                } else {
                    $line->amount = $item->pick_exchange_rate * $line->amount;
                }
                $this->data['items'][] = $line;
            }
        }
        $this->data['items'] = collect($this->data['items']);
        return view($this->view, $this->data);
    }

    public function convertUom($item_id, $from , $to, $amout) {
        $sql = "select  (apps.inv_convert.inv_um_convert (
                            item_id           => '{$item_id}',
                            organization_id   => 164,
                            PRECISION         => NULL,
                            from_quantity     => '{$amout}',
                            from_unit         => '{$from}',
                            to_unit           => '{$to}',
                            from_name         => NULL,
                            to_name           => NULL)
                    )                                                               result
                from dual";
            try {
                return \DB::select($sql)[0]->result;
            } catch (\Throwable $th) {
                return false;
            }
    }
    public function columnWidths(): array
    {
        return [
            'A' => 40,
            'B' => 20,
            'C' => 20,
            'D' => 20,
            'E' => 20,
            'F' => 20,
            // 'G' => 20,
            // 'H' => 20,
            // 'I' => 20,
            // 'J' => 20,
            // 'K' => 20,
            // 'L' => 20,
            // 'M' => 20,
            // 'N' => 20,
            // 'O' => 20,
            // 'P' => 20,
            // 'Q' => 20,
            // 'R' => 20,
            // 'S' => 20,
            // 'T' => 20,
            // 'U' => 20,
            // 'V' => 20,
            // 'W' => 20,
            // 'X' => 20,
            // 'Y' => 20,
        ];
    }

    public function columnFormats(): array
    {
        return [
            // 'B' => '#,##0.00',
            // 'C' => '#,##0.00',
            // 'D' => '#,##0.00',
            // 'E' => '#,##0.00',
            // 'F' => '#,##0.00',
            // 'G' => '#,##0.00',
            // 'H' => '#,##0.00',
            // 'I' => '#,##0.00',
            // 'J' => '#,##0.00',
            // 'K' => '#,##0.00',
            // 'L' => '#,##0.00',
            // 'M' => '#,##0.00',
            // 'N' => '#,##0.00',
            // 'O' => '#,##0.00',
            // 'P' => '#,##0.00',
            // 'Q' => '#,##0.00',
            // 'R' => '#,##0.00',
            // 'S' => '#,##0.00',
            // 'T' => '#,##0.00',
            // 'U' => '#,##0.00',
            // 'V' => '#,##0.00',
            // 'W' => '#,##0.00',
            // 'X' => '#,##0.00',
            // 'Y' => '#,##0.00',
        ];
    }

}

