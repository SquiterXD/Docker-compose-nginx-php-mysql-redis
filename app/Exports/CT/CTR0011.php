<?php

namespace App\Exports\CT;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithProperties;

use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithColumnWidths;
use App\Models\CT\PtctCostTransactionsV;


use PhpOffice\PhpSpreadsheet\Cell\DataType;


use App\Models\CT\PeriodYear;


use FormatDate;
use Carbon\Carbon;

class CTR0011 implements FromView ,WithStyles, WithColumnFormatting, ShouldAutoSize, WithColumnWidths

{

    // public function __construct($data = [])
    // {
    //     $this->data = $data;
    // }

    public function columnFormats(): array
    {
        return [
            'G' => '#,##0.000',
            'H' => '#,##0.000000',
            'I' => '#,##0.00',
            'J' => '#,##0.00',
            'K' => '#,##0.00',
            'L' => '#,##0.00',
            'M' => '#,##0.00',
            'N' => '#,##0.000000000',
            // 'O' => '#,##0.00',
            // 'P' => '#,##0.00',
            // 'F' => '#,##0.00',
        ];
    }


    public function view(): View
    {
        $data = self::getData();
        if ($data->type_report == 'batch_no') {
            return view('ct.Reports.ctr0011.excel.index-by-batch', compact('data'));
        } else if ($data->type_report == 'product') {
            return view('ct.Reports.ctr0011.excel.index-by-product', compact('data'));
        }
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->setShowGridlines(false);
        $sheet->getStyle(0)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle(0)->getFont()->setName('TH SarabunPSK');
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 20,
            'C' => 50,
            'D' => 20,
            'E' => 20,
            'F' => 30,
            'G' => 30,
            'H' => 30,
        ];
    }


    public function getData()
    {
        $periodYear = request()->period_year ? request()->period_year : '';
        $periodName = request()->period_name ? request()->period_name : '';
        $org = request()->org ? request()->org : '';
        $costCode = request()->cost_code ? request()->cost_code : '';
        $typeReport = request()->type_report ? request()->type_report : '';

        $paramPeriodYear = $periodYear ? "and period_year = $periodYear" : '';
        $paramPeriodName = $periodName ? "and period_name = '$periodName'" : '';
        $paramOrg = $org ? "and organization_code = '$org'" : '';
        $paramCostCode = $costCode ? "and cost_code = '$costCode'" : '';

        $costCodeData = collect(\DB::select("
            select DISTINCT cost_code, description
            from PTCT_COST_CENTER_V
            where 1=1
            $paramCostCode
        "));
        $costCodeData = $costCodeData->first();

        $period = collect(\DB::select("
            SELECT
                to_char(start_date, 'DD-MON-YYYY') start_date_format, to_char(end_date, 'DD-MON-YYYY') end_date_format,
                trim (to_char(start_date, 'DD') || '-' ||
                to_char(end_date, 'DD') || ' ' ||
                to_char(end_date, 'MONTH', 'nls_calendar=''Thai Buddha'' nls_date_language = Thai')) || ' ' ||
                (to_char(end_date, 'YYYY') + 543) thai_date
            from GL_PERIODS_V where 1=1 $paramPeriodYear $paramPeriodName
        "));

        $startDate = optional($period)->first()->start_date_format;
        $endDate = optional($period)->first()->end_date_format;
        $db     =   \DB::connection('oracle')->getPdo();
        $sql    =   "
            declare
                xx number;
            begin
                ptct_report_pkg.CTR0011 (P_YEAR  => '$periodYear'
                                ,P_COST_CODE => '$costCode'
                                ,P_DATE_FROM => '$startDate'
                                ,P_DATE_TO   => '$endDate'
                                ,X_RPT_ID    => :xx );
                DBMS_OUTPUT.PUT_LINE(xx);
            end;
        ";
        \Log::info($sql);
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':xx', $result['RPT_ID'], \PDO::PARAM_STR, 4000);
        $stmt->execute();
        \Log::info($result);

        $rptId  = $result['RPT_ID'];
        // $rptId  = 17596;
        $sql = "
            SELECT cost_code, description, product_item_number, product_item_desc, batch_no, oprn_code, oprn_desc, organization_code, organization_name,
                sum(sum_qty) sum_qty,
                sum(transaction_quantity) qty,
                sum(transaction_amount) cost,
                sum(wage_amount) wage_cost,
                sum(vary_amount) vary_cost,
                sum(fixed_amount) fixed_cost
            from oact.PTCT_CTR0011 CT
            where 1=1
                $paramPeriodYear
                $paramPeriodName
                $paramOrg
                $paramCostCode
                and rpt_id = $rptId
            group by cost_code, description, product_item_number,product_item_desc,batch_no,oprn_code,oprn_desc,organization_code,organization_name
        ";
        \Log::info("report CTR0011 ". $sql);
        $data = collect(\DB::select($sql));
        $lines = collect([]);
        $summaryProduct = collect([]);

        $reportHeader = (object) [
            'report_name' => 'รายงานสรุปงานระหว่างผลิตปลายงวด',
            'program_code' => strtoupper(request()->program_code ?? '')
        ];

        if ($typeReport == 'batch_no') {
            $sql2 = "
                SELECT  product_item_number, batch_no, sum(sum_qty) sum_qty, oprn_code
                    , sum(transaction_quantity) qty
                    , sum(transaction_amount) cost
                    , sum(wage_amount) wage_cost
                    , sum(vary_amount) vary_cost
                    , sum(fixed_amount) fixed_cost
                from oact.PTCT_CTR0011 CT
                where 1=1
                    $paramPeriodYear
                    $paramPeriodName
                    $paramOrg
                    $paramCostCode
                    and rpt_id = $rptId
                    and product_item_number = item_number
                group by product_item_number, batch_no, oprn_code
            ";
            $productData = collect(\DB::select($sql2));

            $reportHeader->report_name = $reportHeader->report_name. ' ตามคำสั่งผลิต';
            $data = $data->groupBy(['product_item_number', 'batch_no', 'oprn_code']);
            foreach ($data as $key => $items) {
                foreach ($items as $key => $batchs) {
                    foreach ($batchs as $key => $oprn) {
                        $firstLine = $oprn->first();
                        $line  = (object)[];

                        $line->product_item_number = $firstLine->product_item_number;
                        $line->product_item_desc = $firstLine->product_item_desc;
                        $line->batch_no = $firstLine->batch_no;
                        $line->oprn_code = $firstLine->oprn_code;
                        $line->oprn_desc = $firstLine->oprn_desc;
                        $line->cost_code = $firstLine->cost_code;
                        $line->description = $firstLine->description;

                        // $line->sum_tran_qty = $firstLine->sum_qty;
                        // $line->sum_tran_qty = $oprn->sum('sum_qty');
                        $line->sum_tran_qty = 0;
                        $findProd = optional($productData->where('product_item_number', $line->product_item_number));
                        $findProd = optional($productData->where('batch_no', $line->batch_no)->where('oprn_code', $key))->first();
                        // $findProd = optional($findProd)->sum_qty ?? 0;
                        if ($findProd) {
                            // Add var for by line 20230718
                            $line->sum_tran_qty = optional($findProd)->sum_qty ?? 0;
                            $line->qty = optional($findProd)->qty ?? 0;
                            $line->cost = optional($findProd)->cost ?? 0;
                        }

                        $line->sum_qty = $oprn->sum('qty');
                        $line->sum_cost = $oprn->sum('cost');
                        // $line->wage_cost = $firstLine->wage_cost; # ค่าแรง
                        // $line->vary_cost = $firstLine->vary_cost; # ค่าใช้จ่ายผันแปร
                        // $line->fixed_cost = $firstLine->fixed_cost; # ค่าใช้จ่ายคงที่
                        $line->wage_cost = $oprn->sum('wage_cost'); # ค่าแรง
                        $line->vary_cost = $oprn->sum('vary_cost'); # ค่าใช้จ่ายผันแปร
                        $line->fixed_cost = $oprn->sum('fixed_cost'); # ค่าใช้จ่ายคงที่
                        $line->sum_all = $line->sum_cost + $line->wage_cost + $line->vary_cost + $line->fixed_cost;# รวม
                        if ($line->sum_all == 0 || $line->sum_tran_qty == 0) {
                            $line->avg_per_unit = 0;
                        } else {
                            $line->avg_per_unit = $line->sum_all / $line->sum_tran_qty; # เฉลี่ยต่อหน่วย
                        }

                        $organizations = collect([]);
                        foreach ($oprn->where('qty', '>', 0)->sortBy('organization_code') as $key => $org) {
                            $orgData = (object)[];
                            $orgData->organization_format = "$org->organization_code $org->organization_name";
                            $orgData->qty = $org->qty;
                            $orgData->cost = $org->cost;
                            $organizations->push($orgData);
                        }
                        $line->organizations = $organizations;
                        $lines->push($line);
                    }
                }
            }
        } else if ($typeReport == 'product') {

            $sql2 = "
                SELECT  product_item_number, sum(sum_qty) sum_qty
                from oact.PTCT_CTR0011 CT
                where 1=1
                    $paramPeriodYear
                    $paramPeriodName
                    $paramOrg
                    $paramCostCode
                    and rpt_id = $rptId
                    and product_item_number = item_number
                group by product_item_number
            ";
            $productData = collect(\DB::select($sql2));

            $reportHeader->report_name = $reportHeader->report_name. ' ตามผลิตภัณฑ์';
            $data = $data->groupBy(['product_item_number']);
            foreach ($data as $key => $items) {
                $firstLine = $items->first();
                $line  = (object)[];
                $line->product_item_number = $firstLine->product_item_number;
                $line->product_item_desc = $firstLine->product_item_desc;
                $line->batch_no = $firstLine->batch_no;
                $line->oprn_code = $firstLine->oprn_code;
                $line->oprn_desc = $firstLine->oprn_desc;
                $line->cost_code = $firstLine->cost_code;
                $line->description = $firstLine->description;

                $line->sum_tran_qty = 0;
                $findProd = optional($productData->where('product_item_number', $line->product_item_number))->first();
                $findProd = optional($findProd)->sum_qty ?? 0;
                if ($findProd) {
                    $line->sum_tran_qty = $findProd;
                }
                $line->sum_qty = $items->sum('qty');
                $line->sum_cost = $items->sum('cost');
                // $line->wage_cost = $firstLine->wage_cost; # ค่าแรง
                // $line->vary_cost = $firstLine->vary_cost; # ค่าใช้จ่ายผันแปร
                // $line->fixed_cost = $firstLine->fixed_cost; # ค่าใช้จ่ายคงที่
                $line->wage_cost =$items->sum('wage_cost'); # ค่าแรง
                $line->vary_cost =$items->sum('vary_cost'); # ค่าใช้จ่ายผันแปร
                $line->fixed_cost =$items->sum('fixed_cost'); # ค่าใช้จ่ายคงที่
                $line->sum_all = $line->sum_cost + $line->wage_cost + $line->vary_cost + $line->fixed_cost;# รวม
                if ($line->sum_all == 0 || $line->sum_tran_qty == 0) {
                    $line->avg_per_unit = 0;
                } else {
                    $line->avg_per_unit = $line->sum_all / $line->sum_tran_qty; # เฉลี่ยต่อหน่วย
                }

                $organizations = collect([]);
                foreach ($items->where('qty', '>', 0)->sortBy('organization_code') as $key => $org) {
                    $orgData = (object)[];
                    $orgData->organization_format = "$org->organization_code $org->organization_name";
                    $orgData->qty = $org->qty;
                    $orgData->cost = $org->cost;
                    $organizations->push($orgData);
                }
                $line->organizations = $organizations;
                $lines->push($line);
            }
        }

        $summaryProduct = $lines->groupBy('product_item_number')->map(function ($item, $group) {
            $data = (object)[];
            $data->sum_tran_qty = $item->sum('sum_tran_qty');
            $data->sum_qty = $item->sum('sum_qty');
            $data->sum_cost = $item->sum('sum_cost');
            $data->wage_cost = $item->sum('wage_cost');
            $data->vary_cost = $item->sum('vary_cost');
            $data->fixed_cost = $item->sum('fixed_cost');
            $data->sum_all = $item->sum('sum_all');
            if ($data->sum_all == 0 || $data->sum_tran_qty == 0) {
                $data->avg_per_unit = 0;
            } else {
                $data->avg_per_unit = $data->sum_all / $data->sum_tran_qty; # เฉลี่ยต่อหน่วย
            }
            return $data;
        });

        $summaryCostCode = $lines->groupBy('cost_code')->map(function ($item, $group) {
            $firstLine = $item->first();
            $data = (object)[];
            $data->description = $firstLine->description;
            $data->sum_tran_qty = $item->sum('sum_tran_qty');
            $data->sum_qty = $item->sum('sum_qty');
            $data->sum_cost = $item->sum('sum_cost');
            $data->wage_cost = $item->sum('wage_cost');
            $data->vary_cost = $item->sum('vary_cost');
            $data->fixed_cost = $item->sum('fixed_cost');
            $data->sum_all = $item->sum('sum_all');
            if ($data->sum_all == 0 || $data->sum_tran_qty == 0) {
                $data->avg_per_unit = 0;
            } else {
                $data->avg_per_unit = $data->sum_all / $data->sum_tran_qty; # เฉลี่ยต่อหน่วย
            }
            return $data;
        });
        $data = (object) [
            'lines' => $lines,
            'cost_code_data' => $costCodeData,
            'type_report' => $typeReport,
            'period' => optional($period)->first(),
            'report_header' => $reportHeader,
            'summary' => (object) [
                'product' => $summaryProduct,
                'cost_code' => $summaryCostCode
            ],
        ];

        return $data;
    }

}

