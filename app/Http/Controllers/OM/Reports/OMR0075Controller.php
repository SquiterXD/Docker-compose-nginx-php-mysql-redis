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
        $row_head_end = $row_head + 1;
        $row_foot = 6;
        $row_count = count($this->data_arr["data"]);
        $col_count = count($this->data_arr["items"])+1;
        $col_range= range('A','Z');
        $col_name_last = $col_range[$col_count];

        $row_start = $row_head + 2;
        $row_end = $row_start+$row_count-1;
        $row_sum = $row_end+1;
        $row_last = $row_sum+$row_foot;
        $font = array('font'=>array('size'=>14,'name'=>'Cordia New')); // Cordia New , TH SarabunPSK
        $border = array('borders'=>[
            'bottom'=>['borderStyle'=>Style\Border::BORDER_THIN,'color'=>['argb'=>'000000']],
            'top'=>['borderStyle'=>Style\Border::BORDER_THIN,'color'=>['argb'=>'000000']],
        ]);
        $allborders = array('borders'=>['allBorders'=>['borderStyle'=>Style\Border::BORDER_THIN,'color'=>['argb'=>'000000']]]);
        $sheet->getDefaultRowDimension()->setRowHeight(20);

        if($row_count>0){
            $sheet->getStyle("A1:{$col_name_last}{$row_last}")->applyFromArray($font);
            $sheet->getStyle("A1:{$col_name_last}{$row_head_end}")->getFont()->setBold(true);
            $sheet->getStyle("A{$row_head}:{$col_name_last}{$row_sum}")->applyFromArray($allborders);
            $sheet->getStyle("A{$row_sum}:{$col_name_last}{$row_sum}")->getFont()->setBold(true);
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
        $unit_cg = $request['unit_cg'];
        $unit_e = $request['unit_e'];
        $df = $request['date_f'];
        $dt = $request['date_t'];
        $remark = $request['cs_remark'];

        $date_f = date('Y-m-d',strtotime(str_replace('/','-',$df)));
        $date_t = date('Y-m-d',strtotime(str_replace('/','-',$dt)));
        $thDate_t = parseToDateTh($dt);

        $progReport = ProgramInfo::where('program_code',$programCode)->first();
        $progTitle = $progReport->description;
        $progPara="ณ วันที่ $thDate_t ";

        $unit_cg=($unit_cg=="")?"CGK":$unit_cg;
        $unit_e=($unit_e=="")?"CS1":$unit_e;
        $units = DB::table(DB::raw("(select * from ptom_uom_conversions_v where domestic='Y' order by uom_class) a"))->get();
        foreach($units as $unit){
            $unit_arr["title"][$unit->uom_code] = $unit->unit_of_measure;
            $unit_arr["rate"][$unit->uom_code] = $unit->conversion_rate;
            $unit_arr["base"][$unit->uom_code] = $unit->base_unit_code;
        }
        $progUnit[0] = $unit_arr["title"][$unit_cg]; // บุหรี่
        $progUnit[1] = $unit_arr["title"][$unit_e];  // ยาเส้น

        $tb_days = "
            SELECT
                to_char(s_date,'dd/mm/yyyy','NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE=THAI') date_th,
                to_char(s_date,'dd/mm/yyyy') date_en,
                to_char(s_date,'yyyymmdd') date_code
            FROM (
                SELECT to_date('$df','DD/MM/YYYY')+ROWNUM-1 AS s_date
                FROM ALL_OBJECTS
                WHERE ROWNUM <= 1+to_date('$dt','DD/MM/YYYY')-to_date('$df','DD/MM/YYYY')
            )
            WHERE to_char(s_date,'DY') NOT IN ('SAT','SUN')
        ";
        $items = DB::table(DB::raw("({$tb_days}) a"))->get();
        $sql_dd="";
        foreach($items as $item){
            $cc=$item->date_code;
            $sql_dd.="
                SUM(
                    CASE
                        WHEN TO_CHAR(d.pick_release_approve_date,'yyyymmdd')={$cc} THEN
                            CASE
                                WHEN d.product_type_code='10' THEN
                                    case when d.consignment_no<>'' and d.consignment_status='Confirm' then
                                        CASE
                                            WHEN d.consignment_uom_code='{$unit_cg}' THEN (d.consignment_quantity)
                                            ELSE (d.consignment_quantity)*u.conversion_rate/{$unit_arr["rate"][$unit_cg]}
                                        END
                                    else
                                        CASE
                                            WHEN d.uom_code='{$unit_cg}' THEN (d.approve_quantity)
                                            ELSE (d.approve_quantity)*u.conversion_rate/{$unit_arr["rate"][$unit_cg]}
                                        END
                                    end

                                ELSE
                                    case when d.consignment_no<>'' and d.consignment_status='Confirm' then
                                        CASE
                                            WHEN d.consignment_uom_code='{$unit_e}' THEN (d.consignment_quantity)
                                            ELSE (d.consignment_quantity)*u.conversion_rate/{$unit_arr["rate"][$unit_e]}
                                        END
                                    else
                                        CASE
                                            WHEN d.uom_code='{$unit_e}' THEN (d.approve_quantity)
                                            ELSE (d.approve_quantity)*u.conversion_rate/{$unit_arr["rate"][$unit_e]}
                                        END
                                    end
                            END
                        ELSE 0
                    END
                ) as qty_{$cc} ,
            ";
        }

        $i=0;
        $tb_view="
            select
                {$sql_dd}
                SUM(
                    CASE
                        WHEN d.product_type_code='10' THEN
                            case when d.consignment_no<>'' and d.consignment_status='Confirm' then
                                CASE
                                    WHEN d.consignment_uom_code='{$unit_cg}' THEN (d.consignment_quantity)
                                    ELSE (d.consignment_quantity)*u.conversion_rate/{$unit_arr["rate"][$unit_cg]}
                                END
                            else
                                CASE
                                    WHEN d.uom_code='{$unit_cg}' THEN (d.approve_quantity)
                                    ELSE (d.approve_quantity)*u.conversion_rate/{$unit_arr["rate"][$unit_cg]}
                                END
                            end
                        ELSE
                            case when d.consignment_no<>'' and d.consignment_status='Confirm' then
                                CASE
                                    WHEN d.consignment_uom_code='{$unit_e}' THEN (d.consignment_quantity)
                                    ELSE (d.consignment_quantity)*u.conversion_rate/{$unit_arr["rate"][$unit_e]}
                                END
                            else
                                CASE
                                    WHEN d.uom_code='{$unit_e}' THEN (d.approve_quantity)
                                    ELSE (d.approve_quantity)*u.conversion_rate/{$unit_arr["rate"][$unit_e]}
                                END
                            end
                    END
                ) as qty,
                i.report_item_display item_title,
                i.screen_number
            from ptom_so_outstanding_v d
            left join ptom_sequence_ecoms i on i.item_id=d.item_id
            left join ptom_uom_conversions_v u on (u.uom_code=d.uom_code and u.domestic='Y')
            where d.pick_release_status='Confirm'
                and i.screen_number<>'0'
                and i.sale_type_code='DOMESTIC'
                and (trunc(d.pick_release_approve_date) between to_date('{$date_f}','yyyy-mm-dd') and to_date('{$date_t}','yyyy-mm-dd'))
            group by i.report_item_display,i.screen_number
            order by i.screen_number
        ";
        $data = DB::table(DB::raw("({$tb_view}) a"))->get();
        $this->datas[$i] = compact('data','items','programCode','progUnit','progTitle','progPara','remark');

        if($data->count()>0){
            $this->views[$i] = view('om.reports.omr0075.excel.index',$this->datas[$i]);
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

class OMR0075Controller extends Controller{
    public function export($programCode, $request){
        return Excel::download(new ReportExport($programCode,$request), "{$programCode}.xlsx");
    }
}
