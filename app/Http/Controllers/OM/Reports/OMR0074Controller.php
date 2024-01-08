<?php
namespace App\Http\Controllers\OM\Reports;
//use App\Models\ProgramInfo;
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
        $col_count = count($this->data_arr["items"]);
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
        if($row_count>0){
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
}

class ReportExport implements WithMultipleSheets {
    protected $views;
    protected $datas;
    public function __construct($programCode, $request){
        $listby = $request['cs_listby'];
        $cs_times = $request['cs_times'];
        $year_f = $request['year_f'];
        $year_t = $request['year_t'];

        $thYear_f = (int)$year_f + 543;
        $thYear_t = (int)$year_t + 543;
        $remark = $request['cs_remark'];

        $cs_title = [
            'qty' => "รายงานประมาณการจำหน่ายบุหรี่โรงงานยาสูบ รายปี",
            'amt' => "รายงานมูลค่าประมาณการจำหน่ายบุหรี่โรงงานยาสูบ รายปี"
        ];
        $cs_unit = [
            'qty' => "พันมวน(บุหรี่)/หีบ(ยาเส้น)",
            'amt' => "บาท"
        ];
        //$progReport = ProgramInfo::where('program_code',$programCode)->first();
        //$progTitle = $progReport->description;
        $progTitle = $cs_title[$listby];
        $progUnit = $cs_unit[$listby];
        $progPara="ปีงบประมาณ $thYear_f - $thYear_t ครั้งที่ $cs_times";

        $sql_year="";
        for($iyear=$year_f;$iyear<=$year_t;$iyear++){
            $items[] = $iyear;
            $sql_year.=" SUM(CASE WHEN d.budget_year={$iyear} THEN d.quantity ELSE 0 END) as qty_{$iyear} ,";
            $sql_year.=" SUM(CASE WHEN d.budget_year={$iyear} THEN d.amount ELSE 0 END) as amt_{$iyear} ,";
        }

        $i=0;
        $tb_view="
            select
                TO_CHAR(d.approve_date, 'dd/mm/yyyy','NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE=THAI') approve_date,
                {$sql_year}
                i.report_item_display item_title,
                i.screen_number
            from ptom_yearly_sales_forecast d
            left join ptom_sequence_ecoms i on i.item_id=d.item_id
            where d.sales_class_type = 'DOMESTIC'
                and i.screen_number<>'0'
                and d.approve_flag = 'Y'
                and d.version = '{$cs_times}'
                and d.budget_year between {$year_f} and {$year_t}
            group by i.report_item_display,i.screen_number,d.approve_date
            order by i.screen_number
        ";
        $data = DB::table(DB::raw("({$tb_view}) a"))->get();
        $this->datas[$i] = compact('data','items','listby','programCode','progUnit','progTitle','progPara','remark');
        if($data->count()>0){
            $this->views[$i] = view('om.reports.omr0074.excel.index',$this->datas[$i]);
        }else{
            $this->views[$i] = view('om.reports.nodata',$this->datas[$i]);
        }

    }
    public function sheets(): array{
        $sheets = [];
        for ($i = 0; $i < count($this->datas); $i++){
            $ii=$i+1;
            $sheets[] = new ExportView($this->views[$i],$this->datas[$i]["programCode"].' - Sheet '.$ii,$this->datas[$i]);
        }
        return $sheets;
    }
}

class OMR0074Controller extends Controller{
    public function export($programCode, $request){
        return Excel::download(new ReportExport($programCode,$request), "{$programCode}.xlsx");
    }
}
