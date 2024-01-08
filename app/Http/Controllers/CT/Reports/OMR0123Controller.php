<?php

namespace App\Http\Controllers\CT\Reports;

use App\Exports\CT\CTR0012;
use App\Exports\CT\CTR0032;
use App\Exports\CT\PDR0003;
use App\Exports\OM\OMR0082;
use App\Exports\OM\OMR0082MultiSheet;
use App\Http\Controllers\Controller;
use App\Http\Controllers\OM\Reports\OMR0060Controller;
use App\Models\OM\Api\OrderHeader;
use App\Models\OM\ConsignmentHeader;
use App\Models\OM\CreditNote\CreditGroupModel;
use App\Models\OM\DebtDomV;
use App\Models\OM\PaymentDomV;
use App\Models\OM\PaymentHeader;
use App\Models\OM\ProformaInvoiceHeader;
use App\Models\OM\ProformaInvoiceLines;
use App\Models\PD\PtpdDetailsWrappersBlendV;
use App\Models\PD\PtpdSummaryFMLCigaretteV;
use App\Models\ProgramInfo;
use Carbon\Carbon;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDO;

class OMR0123Controller extends Controller
{
    protected $titleReport;
    protected $view = 'om.reports.omr0123.pdf.index';
    protected $programe;
    protected $dateFormat = 'd/m/Y';

    public function getMonthTh($month) {
        $toInt = (int)($month);
        $months_th = ['' ,"มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
        return $months_th[$toInt];
    }
    public function __construct()
    {
        
        $this->program = ProgramInfo::where('program_code', request()->program_code)->first();
        $this->titleReport = $this->program->description;
    }

    public function OMR0123($programcode, Request $request)
    {
        
        $program     = $this->program;
        $titleReport = $this->titleReport;
        $view        = $this->view;
        $arrData       = [];
        $arrData       = [];
        $arrData['program']     = $program;
        $arrData['programCode']     = $program;
        $arrData['progTitle'] = $titleReport;
        $arrData['remark'] = request()->text;
        $arrData['date_from'] = Carbon::createFromFormat('d/m/Y', $request->date_from)->addYears(543);
        $arrData['product_type_code'] = $request->product_type_code;
        $arrData['date_to'] = Carbon::createFromFormat('d/m/Y', $request->date_to)->addYears(543);

        if(request()->batch_name == 'ระบบขายในประเทศ') {
            if(!($request->has('product_type_code') || $request->has('order_type_code'))) {
                echo "<script>";
                echo "window.open('". $request->fullUrl() ."&order_type_code=1014&product_type_code=10');";
                echo "window.open('". $request->fullUrl() ."&order_type_code=1015&product_type_code=20');";
                
                echo "window.close();";
                echo "</script>";
                exit;
            }
        } else {
                
            if(!($request->has('product_type_code') || $request->has('order_type_code'))) {
                $getExportOrderType = collect(DB::select("select order_type_id
                                            from ptom_transaction_types_all_v
                                            where sales_type = 'EXPORT'
                                            and transaction_type_id = '33'"))->pluck('order_type_id');
                echo "<script>";
                foreach($getExportOrderType as $orderTypeId) {
                    echo "window.open('". $request->fullUrl() ."&order_type_code=". $orderTypeId ."');";
                }
                // echo "window.open('". $request->fullUrl() ."&order_type_code=1021');";
                // echo "window.open('". $request->fullUrl() ."&order_type_code=1019');";
                // echo "window.open('". $request->fullUrl() ."&order_type_code=1078');";
                // echo "window.open('". $request->fullUrl() ."&order_type_code=1056');";
                
                echo "window.close();";
                echo "</script>";
                exit;
            }
        }
        $arrData = array_merge($this->queryData($program, $request), $arrData);
        if(count($arrData['items']) == 0) {
            echo "<script>console.log('test');</script>";
            echo "<script>window.close();</script>";
            exit;
        }
        // return view($view,$arrData);
        $pdf = PDF::loadView($view,$arrData)
                ->setPaper('a4','landscape')
                ->setOption('header-right',"\n\n\n\n[page]/[topage] ")
                ->setOption('header-font-name',"THSarabunNew")
                ->setOption('header-font-size',9)
                ->setOption('header-spacing',3)
                ->setOption('margin-bottom', 10);
        return $pdf->stream($programcode .'.pdf');
    }

    public function mappingDate($items) {
        return $items->map(function($item){
            $item->day = Carbon::createFromFormat('Y-m-d H:i:s', $item->payment_date)->format('d');
            return $item;
        });
    } 

    public function getRma($date, $product_type_code, $case_export) {
        $query = DB::table('ptom_ar_interfaces pai')->where('pai.interface_status','C')
        ->where('pai.batch_source_name', 'ระบบขายในประเทศ')
        ->where('pai.interface_type', 'Credit Memo')
        ->whereNotNull('pai.item_code')
        ->when(request()->has('product_type_code'), function($q) use($product_type_code, $case_export) {
            $q->whereIn('pai.product_type_code', [$product_type_code, $case_export]);  // 10.OMR0123 20.OMR0123_L 
        })
        ->select(
        //'pai.*',
        'pai.order_header_id',
        'pai.group_id',
        'pai.oaom_tax_adjust',
        'pai.pao_line_amount',
        'pai.invoice_date',
        
        // 'ppi.order_type_id', 
        'pai.amount', 
        'pai.gl_date',
        'pai.invoice_number',
        'pai.tax_header_amount',
        'pao_header_amount',
        'pai.payment_type_code',
        'pai.product_type_code',
        'ptom_customers.customer_type_id',
        'ptom_customers.province_code',
        'pai.reference',
        'pai.invoice_total_with_vat',
        DB::raw("'rma' by_case"),
        )
        // ->whereRaw("pai.group_id not in (SELECT GROUP_ID FROM ptom_ar_interfaces WHERE INTERFACE_STATUS = 'E' GROUP BY GROUP_ID)")
        ->leftJoin('ptom_customers', 'ptom_customers.customer_number', '=', 'pai.customer_number')
        ->whereRaw("trunc(pai.invoice_date) BETWEEN to_date('{$date['start']}') AND to_date('{$date['end']}')");
        if(request()->batch_name == 'ระบบขายในประเทศ') {
           
        } else {
           
        }
        $data = $query
        ->get();

        // ลูกค้าที่ไม่ใช่ลูกค้าสโมสร
        $case_1 = $data->filter(function($q) {
            return $q->customer_type_id != 30 ||  $q->customer_type_id != 40;
        });

        // ลูกค้าสโมสรกรุงเทพ บุหรี
        $case_2 = $data->filter(function($q) {
            return $q->customer_type_id == 30 && $q->product_type_code == 10;
        });

        // ลูกค้าสโมสรกรุงเทพ ยาเส้น
        $case_3 = $data->filter(function($q) {
            return $q->customer_type_id == 30 && $q->product_type_code != 10;
        });

        // ลูกค้าสโมสรภูมิภาค ยาเส้น
        $case_4 = $data->filter(function($q) {
            return $q->customer_type_id == 40 && $q->product_type_code != 10;
        });
        // ลูกค้าสโมสรภูมิภาค บุหรี่
        $case_5 = $data->filter(function($q) {
            return $q->customer_type_id == 40 && $q->product_type_code == 10;
        });

        // ลูกค้าที่ไม่ใช่ลูกค้าสโมสร และ ลูกค้าสโมสรกรุงเทพ ยาเส้น ดึงจากที่เดียว
        $case_1 = $case_1->merge($case_3);
        $case_1 = $case_1->merge($case_4);
        $case_2 = $case_2->merge($case_5);

        $get_order_header = OrderHeader::select(['pick_release_no', 'payment_type_code', 'pick_release_approve_date'])->whereIn('pick_release_no', $case_1->pluck('reference')->toArray())->get();
        $get_consignment_header = ConsignmentHeader::select(['consignment_date', 'consignment_no'])->whereIn('consignment_no', $case_2->pluck('reference')->toArray())->get();
        
      
        $data = $data->map(function($i) use($get_order_header, $get_consignment_header, $product_type_code) {
            if($i->customer_type_id != 30 ||  $i->customer_type_id != 40) {
                $order = $get_order_header->where('pick_release_no', $i->reference)->first();
                $pick_release_approve_date = Carbon::createFromFormat('Y-m-d H:i:s', $order->pick_release_approve_date)->format('Y-m-d');
                $invoice_date = Carbon::createFromFormat('Y-m-d H:i:s', $i->invoice_date)->format('Y-m-d');
                if($order->payment_type_code != 10 || $pick_release_approve_date != $invoice_date) {
                    $i->col1  = 0;
                    $i->process = 'กรณีลูกค้าที่ไม่ใช่ลูกค้าสโมสร (ptom_customers.customer_type_id ไม่ใช่ 30 และ 40)\n ไม่เขาเคสวันที่ หรือ payment_type';
    
                } else {
                    $i->col1 = $i->amount;
                }
                if($order->payment_type_code != 20 || $pick_release_approve_date != $invoice_date) {
                    $i->col2  = 0;
                    $i->process = 'กรณีลูกค้าที่ไม่ใช่ลูกค้าสโมสร (ptom_customers.customer_type_id ไม่ใช่ 30 และ 40)\n ไม่เขาเคสวันที่ หรือ payment_type';
    
                } else {
                    $i->col2 = $i->amount;
                }
                
            }

            /*
                กรณีลูกค้าสโมสรกรุงเทพ (ptom_customers.customer_type_id = 30)
                เคสบุหรี่ (ptom_ar_interfaces.product_type_code = 10) 
                เจ้าหนี้ หาจาก sum(ptom_ar_interfaces.amount) โดยเงื่อนไขคือ ptom_ar_interfaces.invoice_date (วันที่ของใบลดหนี้ใบนี้) 
                ต้องเป็นวันที่เดียวกันกับ ptom_consignment_headers.consignment_date (วันที่ของใบฝากขาย ที่ reference) 
                โดย where ptom_consignment_headers.consignment_no = ptom_ar_interfaces.reference ถ้าเป็นคนละวันกัน 
                จะไม่นับค่าของใบลดหนี้ใบนั้นมาแสดงในช่องนี้
            */
            if($i->customer_type_id == 30) {
                if($product_type_code == 10) {
                     $consignment = $get_consignment_header->where('consignment_no', $i->consignment_no)->first();
                     $consignmen_date = Carbon::createFromFormat('Y-m-d H:i:s', $consignment->consignment_date)->format('Y-m-d');
                     $invoice_date = Carbon::createFromFormat('Y-m-d H:i:s', $i->invoice_date)->format('Y-m-d');
                     if($consignmen_date != $invoice_date) {
                        $i->col1  = 0;
                        $i->process = 'ข้อมูล Consignment date ไม่ตรงกับ Invoice Date';
                     } else {
                        $i->col1 = $i->amount;

                     }
                } 
                /*
                    เคสที่ไม่ใช่บุหรี่ (ptom_ar_interfaces.product_type_code <> 10) เจ้าหนี้ 
                    หาจาก sum(ptom_ar_interfaces.amount) โดยเงื่อนไขคือ ptom_ar_interfaces.invoice_date 
                    (วันที่ของใบลดหนี้ใบนี้) ต้องเป็นวันที่เดียวกันกับ ptom_order_headers.pick_release_approve_date 
                    (วันที่ของ invoice ที่ reference) โดย where ptom_order_headers.pick_release_no = ptom_ar_interfaces.reference 
                    ถ้าเป็นคนละวันกัน จะไม่นับค่าของใบลดหนี้ใบนั้นมาแสดงในช่องนี้
                */
                else {
                    $order = $get_order_header->where('pick_release_no', $i->reference)->first();
                    $pick_release_approve_date = Carbon::createFromFormat('Y-m-d H:i:s', $order->pick_release_approve_date)->format('Y-m-d');
                    $invoice_date = Carbon::createFromFormat('Y-m-d H:i:s', $i->invoice_date)->format('Y-m-d');
                    if($pick_release_approve_date != $invoice_date) {
                        $i->col1  = 0;
                        $i->process = 'กรณีลูกค้าที่ลูกค้าสโมสร เคสวันที่ หรือ payment_type';
                    } else {
                        $i->col1 = $i->amount;
                    }
                }

                $i->col2 = 0;
            }

            /*
            กรณีลูกค้าสโมสรภูมิภาค (ptom_customers.customer_type_id = 40)
            เคสบุหรี่ (ptom_ar_interfaces.product_type_code = 10) จะไม่แสดงข้อมูลในช่องนี้
            เคสที่ไม่ใช่บุหรี่ (ptom_ar_interfaces.product_type_code <> 10) เจ้าหนี้ หาจาก sum(ptom_ar_interfaces.amount) 
            โดยเงื่อนไขคือ ptom_ar_interfaces.invoice_date (วันที่ของใบลดหนี้ใบนี้) ต้องเป็นวันที่เดียวกันกับ ptom_order_headers.pick_release_approve_date 
            (วันที่ของ invoice ที่ reference) โดย where ptom_order_headers.pick_release_no = ptom_ar_interfaces.reference 
            ถ้าเป็นคนละวันกัน จะไม่นับค่าของใบลดหนี้ใบนั้นมาแสดงในช่องนี้
            */
            if($i->customer_type_id == 40) {
                if($product_type_code == 10) { 
                    $consignment = $get_consignment_header->where('consignment_no', $i->consignment_no)->first();
                    $consignmen_date = Carbon::createFromFormat('Y-m-d H:i:s', $consignment->consignment_date)->format('Y-m-d');
                    $invoice_date = Carbon::createFromFormat('Y-m-d H:i:s', $i->invoice_date)->format('Y-m-d');

                    $i->col1  = 0;
                    $i->process = 'ข้อมูล (ptom_customers.customer_type_id == 40 และ ptom_ar_interfaces.product_type_code = 10';
                    if($consignmen_date != $invoice_date) {
                        $i->col2  = 0;
                     } else {
                        $i->col2 = $i->amount;
                     }

                } else {
                    $order = $get_order_header->where('pick_release_no', $i->reference)->first();
                    $pick_release_approve_date = Carbon::createFromFormat('Y-m-d H:i:s', $order->pick_release_approve_date)->format('Y-m-d');
                    $invoice_date = Carbon::createFromFormat('Y-m-d H:i:s', $i->invoice_date)->format('Y-m-d');
                    $i->col2  = 0;
                    if($pick_release_approve_date != $invoice_date) {
                        $i->col1  = 0;
                        $i->process = 'กรณีลูกค้าที่ลูกค้าสโมสร เคสวันที่ หรือ payment_type';
                    } else {
                        $i->col1 = $i->amount;

                    }
                }
            }
            // if($i->col1 ==0 && $i->col2 == 0) {
            //     $i->col3 = 0;
            // } else {
                $i->col3 = $i->amount;
            // }
            $i->tax_centra = $i->customer_type_id != 40 ? $i->oaom_tax_adjust * (-1) : 0;
            $i->tax_around = $i->customer_type_id == 40 ? $i->oaom_tax_adjust * (-1) : 0;
            $i->tax_p1 = $i->customer_type_id != 20 && $i->province_code != 10 ? $i->pao_line_amount * (-1) : 0;
            $i->total = $i->amount - $i->tax_centra - $i->tax_around - $i->tax_p1;
            return $i;
        });

        return $data;
    }

    public function queryData($programCode, $request){
        $arrData = []; 
        $dateFrom = Carbon::createFromFormat('d/m/Y', $request->date_from)->format('Y-m-d');
        $dateTo = Carbon::createFromFormat('d/m/Y', $request->date_to)->format('Y-m-d');
        $product_type_code = $request->product_type_code;
        $case_export = $product_type_code == '20' ? '55' : null;
        $batch_name = $request->batch_name;
        $arrData['getRMA'] = (new OMR0060Controller)->getRMA(['start'=> $dateFrom, 'end' => $dateTo]);
        $query = DB::table('ptom_ar_interfaces pai')->where('pai.interface_status','C')
        ->where('pai.batch_source_name', $batch_name)
        ->where('pai.interface_type', 'Invoice')
        ->when($request->has('product_type_code'), function($q) use($product_type_code, $case_export) {
            $q->whereIn('pai.product_type_code', [$product_type_code, $case_export]);  // 10.OMR0123 20.OMR0123_L 
        })
        ->select(
        //'pai.*',
        'pai.group_id',
        'ppi.order_type_id', 
        'pai.gl_date',
        'pai.invoice_number',
        'pai.tax_header_amount',
        'pao_header_amount',
        'pai.payment_type_code',
        'pai.product_type_code',
        'ptom_customers.customer_type_id',
        'pai.invoice_total_with_vat',
        DB::raw("'normal' by_case"),
        )
        ->whereRaw("pai.group_id not in (SELECT GROUP_ID FROM ptom_ar_interfaces WHERE INTERFACE_STATUS = 'E' GROUP BY GROUP_ID)")
        ->leftJoin('ptom_customers', 'ptom_customers.customer_number', '=', 'pai.customer_number')
        ->whereRaw("trunc(pai.gl_date) BETWEEN to_date('{$dateFrom}') AND to_date('{$dateTo}')");
        if(request()->batch_name == 'ระบบขายในประเทศ') {
            $query = $query->leftjoin('ptom_order_headers ppi',function($q) {
                    $q->on('ppi.order_header_id', 'pai.order_header_id')->where('pai.from_program_code','<>', 'OMP0038');
                })
                ->addSelect(DB::raw('nvl(rep.description, rep2.description) label_meaning'))
                ->leftjoin('ptom_consignment_lines cl',function($q) {
                    $q->on('pai.order_header_id', 'cl.consignment_header_id')->where('pai.from_program_code', 'OMP0038');
                })
                ->leftjoin('ptom_order_headers ppi2', function($q) {
                    $q->on('ppi2.order_header_id', 'cl.order_header_id')->where('pai.from_program_code', 'OMP0038');
                })
                ->when($request->has('order_type_code'), function($q) {
                    $q->where(function($q) {
                        $q->where('ppi.order_type_id',request()->order_type_code);
                        $q->orwhere('ppi2.order_type_id',request()->order_type_code);
                    });
                })
            ->leftjoin('ptom_omr0123_report_name_v rep2', 'rep2.lookup_code', 'ppi2.order_type_id')
            ;
        } else {
            $query = $query
            ->addSelect(DB::raw('rep.description label_meaning'))
            ->leftjoin('ptom_proforma_invoice_headers ppi', 'ppi.pi_header_id', 'pai.order_header_id')
                    ->when($request->has('order_type_code'), function($q) {
                        $q->where('ppi.order_type_id',request()->order_type_code);
                    });
        }
        $query = $query
        ->leftjoin('ptom_omr0123_report_name_v rep', 'rep.lookup_code', 'ppi.order_type_id')
        ->get();

        $rma = $this->getRma(['start' => $dateFrom, 'end' => $dateTo], $product_type_code, $case_export);
        $query= $query->merge($rma);
        $label_meaning = optional($query->first())->label_meaning;
        $invoince_number = collect($query->pluck('invoice_number'))->unique();
        $ptom_order_headers = DB::table('ptom_order_headers')->whereIn('pick_release_no', $invoince_number)->get();
        $proforma = DB::table('ptom_proforma_invoice_headers')->whereIn('pick_release_no', $invoince_number)->get();
        // invoice_date
        $query = $query->sortBy('gl_date')->groupBy(function($i) {
            if($i->by_case == 'normal') {
                return Carbon::createFromFormat('Y-m-d H:i:s', $i->gl_date)->format('Y-m-d');
            } else {
                return Carbon::createFromFormat('Y-m-d H:i:s', $i->invoice_date)->format('Y-m-d');
            }
        });
        $query = $query->map(function($items) use($ptom_order_headers, $proforma, $product_type_code) {
           
            $items = $items->groupBy('group_id');
            $items = $items->map(function($items) use($ptom_order_headers, $proforma, $product_type_code) {
                $item = collect();
                $item_a = $items->where('by_case', 'rma')->groupBy('invoice_number')
                ->map(function($items) use($ptom_order_headers, $proforma, $product_type_code) {
                    $arrData = array();
                    $arrData['case_customer_type_id'] = $items->first()->customer_type_id;
                    $arrData['columns_1'] = $items->sum('col1'); //เจ้าหนี้
                    $arrData['columns_2'] = $items->sum('col2');
                    $arrData['columns_3'] = $items->sum('col3');
                    $arrData['columns_5'] = $items->sum('tax_centra');
                    $arrData['columns_6'] = $items->sum('tax_around');
                    $arrData['columns_7'] =  $items->sum('tax_p1');
                    $arrData['columns_4'] = $items->sum('total'); // รายได้

                    return $arrData;
                });
                $item_b = $items->where('by_case', 'normal')->groupBy('invoice_number')
                ->map(function($items) use($ptom_order_headers, $proforma, $product_type_code) {
                    $arrData = array();
                    // ลูกค้าสโมสรกรุงเทพ
                    if($proforma->count()){
                        if($items->first()->payment_type_code == '20'){
                            $arrData['case_customer_type_id'] = $items->first()->customer_type_id;
                            $arrData['columns_1'] = 0; //เจ้าหนี้
                            $arrData['columns_2'] = $items->first()->invoice_total_with_vat; // ลูกหนี้
                            $arrData['columns_3'] = $arrData['columns_1'] + $arrData['columns_2']; // $items->first()->invoice_total_with_vat; // ยอดจำหน่าย
                            $arrData['columns_5'] = $items->first()->tax_header_amount; // ภาษีขายส่วนกลาง
                            $arrData['columns_6'] = 0; // ภาษีขายภูมิภาค
                            $arrData['columns_7'] = 0; // ภาษี อบจ. 100%
                            $arrData['columns_4'] = $arrData['columns_3'] - $arrData['columns_5'] - $arrData['columns_6'] - $arrData['columns_7']; // รายได้
                        }else {
                            $arrData['case_customer_type_id'] = $items->first()->customer_type_id;
                            $arrData['columns_1'] = $items->first()->invoice_total_with_vat; //เจ้าหนี้
                            $arrData['columns_2'] = 0; // ลูกหนี้
                            $arrData['columns_3'] = $arrData['columns_1'] + $arrData['columns_2']; // $items->first()->invoice_total_with_vat; // ยอดจำหน่าย
                            $arrData['columns_5'] = $items->first()->tax_header_amount; // ภาษีขายส่วนกลาง
                            $arrData['columns_6'] = 0; // ภาษีขายภูมิภาค
                            $arrData['columns_7'] = 0; // ภาษี อบจ. 100%
                            $arrData['columns_4'] = $arrData['columns_3'] - $arrData['columns_5'] - $arrData['columns_6'] - $arrData['columns_7']; // รายได้
                        }
                    }else {
                        if($items->first()->product_type_code == 10) {
                            $ptom_order_headers = $ptom_order_headers->where('pick_release_no', $items->first()->invoice_number);
                            if($items->first()->customer_type_id == '30') {
                                $arrData['case_customer_type_id'] = $items->first()->customer_type_id;
                                $arrData['columns_1'] = $items->first()->invoice_total_with_vat; //เจ้าหนี้
                                $arrData['columns_2'] = 0; // ลูกหนี้
                                $arrData['columns_3'] = $arrData['columns_1'] + $arrData['columns_2'];// $items->first()->invoice_total_with_vat; // ยอดจำหน่าย
                                $arrData['columns_5'] = $items->first()->tax_header_amount; // ภาษีขายส่วนกลาง
                                $arrData['columns_6'] = 0; // ภาษีขายภูมิภาค
                                $arrData['columns_7'] = 0; // ภาษี อบจ. 100%
                                $arrData['columns_4'] = $arrData['columns_3'] - $arrData['columns_5'] - $arrData['columns_6'] - $arrData['columns_7']; // รายได้
                            }
                            
                            // ลูกค้าสโมสรภูมิภาค
                            elseif( $items->first()->customer_type_id == '40') {
                                $arrData['case_customer_type_id'] = $items->first()->customer_type_id;
                                $arrData['columns_1'] = 0;  //เจ้าหนี้
                                $arrData['columns_2'] = $items->first()->invoice_total_with_vat; // ลูกหนี้
                                $arrData['columns_3'] = $arrData['columns_1'] + $arrData['columns_2']; // $items->first()->invoice_total_with_vat; // ยอดจำหน่าย
                                $arrData['columns_5'] = 0; // ภาษีขายส่วนกลาง
                                $arrData['columns_6'] = $items->first()->tax_header_amount; // ภาษีขายภูมิภาค
                                $arrData['columns_7'] = $items->first()->pao_header_amount; // ภาษี อบจ. 100%
                                $arrData['columns_4'] = $arrData['columns_3'] - $arrData['columns_5'] - $arrData['columns_6'] - $arrData['columns_7']; // รายได้
                            } 
                            // ลูกค้าที่ไม่ใช่สโมสรกรุงเทพและสโมสรภูมิภาค
                            else {
                                $arrData['case_customer_type_id'] = $items->first()->customer_type_id;
                                $arrData['columns_1'] = $ptom_order_headers->sum('cash_amount');    //เจ้าหนี้
                                $arrData['columns_2'] = $ptom_order_headers->sum('credit_amount'); // ลูกหนี้
                                $arrData['columns_3'] = $arrData['columns_1'] + $arrData['columns_2']; // $items->first()->invoice_total_with_vat; // ยอดจำหน่าย
                                $arrData['columns_5'] = $items->first()->tax_header_amount; // ภาษีขายส่วนกลาง
                                $arrData['columns_6'] = 0; // ภาษีขายภูมิภาค
                                $arrData['columns_7'] = $items->first()->pao_header_amount; // ภาษี อบจ. 100%
                                $arrData['columns_4'] = $arrData['columns_3'] - $arrData['columns_5'] - $arrData['columns_6'] - $arrData['columns_7']; // รายได้
                            }
                        } else {
                                $arrData['case_customer_type_id'] = $items->first()->customer_type_id;
                                $arrData['columns_1'] = $items->first()->invoice_total_with_vat; //เจ้าหนี้
                                $arrData['columns_2'] = 0; // ลูกหนี้
                                $arrData['columns_3'] = $arrData['columns_1'] + $arrData['columns_2']; // $items->first()->invoice_total_with_vat; // ยอดจำหน่าย
                                $arrData['columns_5'] = $items->first()->tax_header_amount; // ภาษีขายส่วนกลาง
                                $arrData['columns_6'] = 0; // ภาษีขายภูมิภาค
                                $arrData['columns_7'] = 0; // ภาษี อบจ. 100%
                                $arrData['columns_4'] = $arrData['columns_3'] - $arrData['columns_5'] - $arrData['columns_6'] - $arrData['columns_7']; // รายได้
                        }
                    }

                    return $arrData;
                });
                $item = $item_a->merge($item_b);
                return $item;
            });
            return $items;
        });
        $arrData['label_meaning'] = $label_meaning;
        $arrData['items'] = $query;
        return $arrData;
    }
}
