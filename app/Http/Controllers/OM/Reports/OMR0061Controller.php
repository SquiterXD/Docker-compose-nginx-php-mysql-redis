<?php
namespace App\Http\Controllers\OM\Reports;
use App\Models\ProgramInfo;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style;
use Excel;
use DB;

class ExportView implements FromView, ShouldAutoSize, WithTitle, WithStyles {
    private $view;
    private $title;
    private $data_arr;
    public function __construct(View $view, $title , $data_arr){ $this->view = $view; $this->title = $title; $this->data_arr = $data_arr; }
    public function view(): View { return $this->view; }
    //public function view(): View { return view('om.reports.omr0061.excel.index',compact('data','programCode','progTitle','progPara','remark'));}
    public function title(): string { return $this->title; }
    public function styles(Worksheet $sheet){
        $row_head = 5;
        $row_foot = 6;
        $row_count = count($this->data_arr["data"]);
        $col_count = 5;
        $col_range= range('A','Z');
        $col_name_last = $col_range[$col_count];

        $row_start = $row_head + 1;
        $row_end = $row_head+$row_count;
        $row_sum = $row_end+1;
        $row_last = $row_sum+$row_foot;
        $font = array('font'=>array('size'=>14,'name'=>'Cordia New')); // Cordia New , TH SarabunPSK
        $border = array('borders'=>[
            'bottom'=>['borderStyle'=>Style\Border::BORDER_THIN,'color'=>['argb'=>'000000']],
            'top'=>['borderStyle'=>Style\Border::BORDER_THIN,'color'=>['argb'=>'000000']],
        ]);
        $sheet->getDefaultRowDimension()->setRowHeight(20);
        $sheet->getStyle("A1:{$col_name_last}{$row_last}")->applyFromArray($font);
        $sheet->getStyle("A1:{$col_name_last}{$row_head}")->getFont()->setBold(true);
        $sheet->getStyle("A{$row_head}:{$col_name_last}{$row_head}")->applyFromArray($border);
        $sheet->getStyle("A{$row_sum}:{$col_name_last}{$row_sum}")->applyFromArray($border)->getFont()->setBold(true);
        $sheet->getStyle("B{$row_start}:{$col_name_last}{$row_sum}")->getNumberFormat()->setFormatCode('#,##0.00');

        for($i=1;$i<=$col_count;$i++){
            $col_name = $col_range[$i];
            $sum_range = "=SUM(".$col_name."{$row_start}:".$col_name."{$row_end})";
            //$sheet->getCell("{$col_name}{$row_sum}")->getCalculatedValue();
            $sheet->setCellValue("{$col_name}{$row_sum}",$sum_range);
        }
    }
}

class ReportExport implements WithMultipleSheets {
    protected $views;
    protected $titles;
    protected $datas;
    public function __construct($programCode, $request){
        $month = $request['cs_month'];
        $year = $request['cs_year'];
        $thYear = (int)$year + 543;
        $thMonth = getMonthTh(date('M', strtotime($year."-".$month."-01")));
        $remark = $request['cs_remark'];
        $mmyyyy = $month.'-'.$year;

        //$progReport = ProgramInfo::where('program_code',$programCode)->first();
        //$progTitle = $progReport->description;
        $progTitles = 'แสดงรายการยอดจำหน่ายยาสูบ/ยาเส้น';
        $progPara="ประจำเดือน $thMonth ปี $thYear";

        $rep_title[0]="เขต กทม. และ ตจว.";
        $rep_title[1]="สโมสรยาสูบขาย";
        $rep_title[2]="บุหรี่ตัวอย่าง";

        $sql_con[0]=" and d.customer_type_id not in (30,40,80)";
        $sql_con[1]=" and d.customer_type_id in (30,40)";
        $sql_con[2]=" and d.customer_type_id = '80' ";

        /* comment v1 > แก้ไขที่ดึงจากเดิม ptom_so_outstanding_v.order_quantity เป็น approve_quantity */
        for($i=0;$i<3;$i++){
            $tb_view="
                select
                    s.item_title,
                    s.screen_number,
                    sum(s.amt1) amt1,
                    sum(s.qty) qty,
                    sum(s.qty*s.unit_price) amt,
                    sum(s.qty*s.sale_price) sale_amt
                from (
                    select
                        d.item_id,
                        i.report_item_display item_title,
                        i.screen_number,
                        d.unit_price,
                        NVL(l.sale_price,0) sale_price,
                        d.uom_code unit_code,
                        case
                            when d.consignment_header_id is not null then d.consignment_uom_code
                            else d.uom_code
                        end unit_code1,
                        case
                            when d.consignment_header_id is not null then d.consignment_amount
                            else d.amount
                        end amt1,
                        case
                            when d.customer_type_id in (30,40) then d.consignment_quantity
                            else d.approve_quantity
                        end qty
                    from ptom_so_outstanding_v d
                    left join (
                            select
                                l.item_id,l.operand sale_price,l.product_uom_code sale_unit,
                                c.base_unit_code base_unit,
                                c.conversion_rate base_rate,
                                l.operand*c.conversion_rate base_price,
                                c.base_unit base_unit_title
                            from ptom_price_list_line_v l
                            left join ptom_price_list_head_v h on (h.list_header_id=l.list_header_id)
                            left join ptom_uom_conversions_v c on (l.product_uom_code=c.uom_code)
                            where h.name='ราคาขายปลีก'
                    ) l on (d.item_id=l.item_id and l.sale_unit=d.uom_code)
                    left join ptom_sequence_ecoms i on i.item_id=d.item_id
                    where NVL(CONSIGNMENT_DATE , TRUNC(PICK_RELEASE_APPROVE_DATE))BETWEEN TO_DATE('{$mmyyyy}','MM-YYYY')
                    AND TO_DATE('$mmyyyy','MM-YYYY')
                        and d.pick_release_status='Confirm'
                        and d.product_type_code='10'
                        and i.sale_type_code = 'DOMESTIC'
                        and i.screen_number<>'0'
                        {$sql_con[$i]}
                    order by i.screen_number asc
                ) s
                group by s.item_title,s.screen_number
                order by s.screen_number asc
            ";
            $data = DB::table(DB::raw("({$tb_view}) a"))->get();
            $progTitle=$progTitles." ".$rep_title[$i];
            $this->titles[$i]=$rep_title[$i];
            $this->datas[$i] = compact('data','programCode','progTitle','progPara','remark');
            $this->views[$i] = view('om.reports.omr0061.excel.index',$this->datas[$i]);
        }
    }
    public function sheets(): array{
        $sheets = [];
        for ($i = 0; $i < count($this->datas); $i++){
            $ii=$i+1;
            $sheets[] = new ExportView($this->views[$i],'OMR0061 - '.$this->titles[$i],$this->datas[$i]);
        }
        return $sheets;
    }
}

class OMR0061Controller extends Controller{
    public function export($programCode, $request){
        return Excel::download(new ReportExport($programCode,$request), "{$programCode}.xlsx");
    }
}
