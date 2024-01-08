<?php

namespace App\Http\Controllers\OM;

use FormatDate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\OM\ARInterface;
use App\Models\OM\ClaimHeader;
use App\Models\OM\Consignment;
use App\Models\OM\ARTranTypesV;
use App\Models\OM\SequenceEcoms;
use App\Models\OM\Api\OrderHeader;
use App\Models\OM\InvoicePremiumV;
use App\Models\OM\PtomAllTaxRateV;
use Illuminate\Support\Facades\DB;
use App\Models\OM\GLInterfaceModel;
use App\Models\HrOperatingUnits;
use App\Models\OM\PtomVendorSitesV;
use App\Models\OM\TransactionTypeAllV;
use App\Http\Controllers\Controller;
use App\Models\OM\PtomInvoiceHeader;
use App\Models\OM\TranspotReportModel;
use App\Models\OM\PtomSoTempV;
use App\Repositories\OM\InterfaceRepo;
use App\Models\OM\SaleConfirmation\Terms;
use Illuminate\Support\Facades\Validator;
use App\Models\OM\Customers\Domestics\PriceList;
use App\Models\OM\CreditNote\MappingAccountModel;
use App\Models\OM\GlCodeCombinationsKFV;
use App\Models\OM\Customers\Domestics\CustomerShipSites;
use App\Models\OM\ARInterfacesReport;
use App\Models\OM\GLInterfacesReport;
use App\Models\OM\PtomArDailyAccRptDescV;
use App\Models\OM\ARInvoiceReportTemp;
use PDF;
use App\Models\OM\Customers\Domestics\CustomerAgents;
use App\Models\OM\PtomSalesInvoiceLineNumV;
use App\Models\OM\SaleConfirmation\OrderHistory;

class CloseDailySaleController extends Controller
{
    protected $orgId;
    protected $orgName;
    protected $groupId;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        return view('om.close_daily_sale.index');

        // $this->checkData($request);
    }

    public function getDateLists(Request $request)
    {
        $this->orgName = 'การยาสูบแห่งประเทศไทย';
        $hr = HrOperatingUnits::where('name', $this->orgName)->first();
        $this->orgId = $hr->organization_id;

        $documentDateLists = $this->getDocumentDateLists($this->orgId);

        return response()->json($documentDateLists);
    }

    public function validateData(Request $request)
    {
        $this->orgName = 'การยาสูบแห่งประเทศไทย';
        $hr = HrOperatingUnits::where('name', $this->orgName)->first();
        $this->orgId = $hr->organization_id;
        
        $result = [
            'status' => 'S',
            'msg' => 'Success',
        ];

        $date = Carbon::parse($request->document_date);
        $document_no = $request->document_no;

        $documentDateLists = $this->getDocumentDateLists($this->orgId);

        if(array_search($request->document_date, array_keys($documentDateLists))){
            return $result = [
                'status' => 'E',
                'msg' => 'กรุณาทำการปิดการขายประจำวันของวันก่อนหน้านี้ก่อน',
            ];
        }

        $club_cig = Consignment::whereHas('customer', function($q){
            return $q->whereIn('customer_type_id', [30, 40]);
        })
        ->whereHas('lines', function($q) {
            return $q->whereHas('orderHeader', function($p) {
                return $p->whereIn('product_type_code', [10]);
            });
        })
        ->when($document_no, function ($p, $document_no){
            return $p->where('consignment_no', $document_no);
        })
        ->whereDate('consignment_date', $date)
        ->where(function ($q) {
            return $q->where(function ($p) {
                return $p->whereNull('close_sale_flag')
                ->orWhereRaw("upper(close_sale_flag) <> 'Y'");
            })
            ->whereRaw("upper(consignment_status) = 'DRAFT'");
        })
        ->get();

        if($club_cig->count()){
            $msg = 'กรุณาทำการฝากขายใบฝากขาย';
            foreach ($club_cig as $key => $consignment) {
                $msg .= ' '.$consignment->consignment_no;
            }
            $msg .= ' ก่อน';
            return $result = [
                'status' => 'E',
                'msg' => $msg,
            ];
        }

        return response()->json($result);
    }

    public function getDocumentNoLists(Request $request)
    {
        $this->orgName = 'การยาสูบแห่งประเทศไทย';
        $hr = HrOperatingUnits::where('name', $this->orgName)->first();
        $this->orgId = $hr->organization_id;

        $date = Carbon::parse($request->document_date);
        $documentNoLists = [];

        $club_cig = Consignment::whereHas('customer', function($q){
            return $q->whereIn('customer_type_id', [30, 40]);
        })
        ->whereHas('lines', function($q) {
            return $q->whereHas('orderHeader', function($p) {
                return $p->whereIn('product_type_code', [10]);
            });
        })
        ->whereDate('consignment_date', $date)
        ->whereRaw("upper(consignment_status) = 'CONFIRM'")
        ->whereRaw("
            NOT EXISTS( 
                SELECT 1
                FROM RA_CUSTOMER_TRX_ALL    RCT
                    ,RA_BATCH_SOURCES_ALL   RBA 
                WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                AND   TRX_NUMBER = PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_NO
                AND   RCT.ORG_ID = $this->orgId
                AND   RBA.NAME   = 'ระบบขายในประเทศ'
            )
        ")
        ->get('consignment_no');

        foreach ($club_cig as $consignment) {
            $document_no = $consignment->consignment_no;
            if( !array_key_exists($document_no, $documentNoLists) ){
                $documentNoLists[$document_no] = $document_no;
            }
        }

        $club_not_cig = OrderHeader::whereHas('customer', function($q){
            return $q->whereIn('customer_type_id', [30, 40]);
        })
        ->where('product_type_code', '<>', 10)
        ->where('program_code', 'OMP0019')
        ->whereDate('pick_release_approve_date', $date)
        ->whereRaw("upper(pick_release_status) = 'CONFIRM'")
        ->whereRaw("
            NOT EXISTS( 
                SELECT 1
                FROM RA_CUSTOMER_TRX_ALL    RCT
                    ,RA_BATCH_SOURCES_ALL   RBA 
                WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                AND   TRX_NUMBER = PTOM_ORDER_HEADERS.PICK_RELEASE_NO
                AND   RCT.ORG_ID = $this->orgId
                AND   RBA.NAME   = 'ระบบขายในประเทศ'
            )
        ")
        ->get('pick_release_no');

        foreach ($club_not_cig as $item) {
            $document_no = $item->pick_release_no;
            if( !array_key_exists($document_no, $documentNoLists) ){
                $documentNoLists[$document_no] = $document_no;
            }
        }

        // order header
        $not_club = OrderHeader::whereHas('customer', function($q){
            return $q->whereNotIn('customer_type_id', [30, 40]);
        })
        ->where('program_code', 'OMP0019')
        ->whereDate('pick_release_approve_date', $date)
        ->whereRaw("upper(pick_release_status) = 'CONFIRM'")
        ->whereRaw("
            NOT EXISTS( 
                SELECT 1
                FROM RA_CUSTOMER_TRX_ALL    RCT
                    ,RA_BATCH_SOURCES_ALL   RBA 
                WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                AND   TRX_NUMBER = PTOM_ORDER_HEADERS.PICK_RELEASE_NO
                AND   RCT.ORG_ID = $this->orgId
                AND   RBA.NAME   = 'ระบบขายในประเทศ'
            )
        ")
        ->get('pick_release_no');

        foreach ($not_club as $item) {
            $document_no = $item->pick_release_no;
            if( !array_key_exists($document_no, $documentNoLists) ){
                $documentNoLists[$document_no] = $document_no;
            }
        }

        // credit_note
        $credit_note = PtomInvoiceHeader::where('program_code', 'OMP0034')
        ->whereDate('invoice_date', $date)
        ->whereRaw("upper(invoice_status) = 'CONFIRM'")
        ->whereRaw("
            NOT EXISTS( 
                SELECT 1
                FROM RA_CUSTOMER_TRX_ALL    RCT
                    ,RA_BATCH_SOURCES_ALL   RBA 
                WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                AND   TRX_NUMBER = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
                AND   RCT.ORG_ID = $this->orgId
                AND   RBA.NAME   = 'ระบบขายในประเทศ'
            )
        ")
        ->get('invoice_headers_number');

        foreach ($credit_note as $item) {
            $document_no = $item->invoice_headers_number;
            if( !array_key_exists($document_no, $documentNoLists) ){
                $documentNoLists[$document_no] = $document_no;
            }
        }

        // debit_note
        $debit_note = PtomInvoiceHeader::where('program_code', 'OMP0032')
        ->whereDate('invoice_date', $date)
        ->whereRaw("upper(invoice_status) = 'CONFIRM'")
        ->whereRaw("
            NOT EXISTS( 
                SELECT 1
                FROM RA_CUSTOMER_TRX_ALL    RCT
                    ,RA_BATCH_SOURCES_ALL   RBA 
                WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                AND   TRX_NUMBER = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
                AND   RCT.ORG_ID = $this->orgId
                AND   RBA.NAME   = 'ระบบขายในประเทศ'
            )
        ")
        ->get('invoice_headers_number');

        foreach ($debit_note as $item) {
            $document_no = $item->invoice_headers_number;
            if( !array_key_exists($document_no, $documentNoLists) ){
                $documentNoLists[$document_no] = $document_no;
            }
        }

        // credit_other
        $credit_other = PtomInvoiceHeader::whereIn('program_code', ['OMP0033', 'OMP0050', 'OMP0052'])
        ->whereDate('invoice_date', $date)
        ->whereRaw("upper(invoice_status) = 'CONFIRM'")
        ->whereRaw("
            NOT EXISTS( 
                SELECT 1
                FROM RA_CUSTOMER_TRX_ALL    RCT
                    ,RA_BATCH_SOURCES_ALL   RBA 
                WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                AND   TRX_NUMBER = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
                AND   RCT.ORG_ID = $this->orgId
                AND   RBA.NAME   = 'ระบบขายในประเทศ'
            )
        ")
        ->get('invoice_headers_number');

        foreach ($credit_other as $item) {
            $document_no = $item->invoice_headers_number;
            if( !array_key_exists($document_no, $documentNoLists) ){
                $documentNoLists[$document_no] = $document_no;
            }
        }

        $gl_exp = OrderHeader::whereHas('transactionType', function($q){
            return $q->where('op_sample_flag', 'Y');
        })
        ->where('program_code', 'OMP0020')
        ->whereDate('pick_release_approve_date', $date)
        ->whereRaw("upper(pick_release_status) = 'CONFIRM'")
        ->where(function ($p) {
            return $p->whereNull('close_sale_flag')
            ->orWhereRaw("upper(close_sale_flag) <> 'Y'");
        })
        ->get('pick_release_no');

        foreach ($gl_exp as $item) {
            $document_no = $item->pick_release_no;
            if( !array_key_exists($document_no, $documentNoLists) ){
                $documentNoLists[$document_no] = $document_no;
            }
        }

        $gl_sale_order_header = OrderHeader::where(function($q) use($date){
            return $q->where(function($p) {
                return $p->where(function($r) {
                    return $r->whereHas('customer', function($s){
                        return $s->whereNotIn('customer_type_id', [30, 40]);
                    })
                    ->whereIn('product_type_code', ['10']);
                })
                ->orWhere(function($r) {
                    return $r->whereIn('product_type_code', ['20']);
                });
            })
            ->whereDate('pick_release_approve_date', $date)
            ->whereRaw("upper(pick_release_status) = 'CONFIRM'")
            ->where(function ($r) {
                return $r->whereNull('close_sale_flag')
                ->orWhereRaw("upper(close_sale_flag) <> 'Y'");
            });
        })
        ->whereHas('transactionType', function($q) {
            return $q->where('send_stat_gl', 'Y');
        })
        ->whereHas('lines', function($q){
            return $q->where(function($p){
                return $p->where('promo_flag', '<>', 'Y')
                ->orWhereNull('promo_flag');
            });
        })
        ->get('pick_release_no');

        foreach ($gl_sale_order_header as $item) {
            $document_no = $item->pick_release_no;
            if( !array_key_exists($document_no, $documentNoLists) ){
                $documentNoLists[$document_no] = $document_no;
            }
        }

        $gl_sale_consignment = Consignment::where(function ($q) {
            return $q->where(function ($p) {
                return $p->whereNull('close_sale_flag')
                ->orWhereRaw("upper(close_sale_flag) <> 'Y'");
            })
            ->whereRaw("upper(consignment_status) = 'CONFIRM'");
        })
        ->whereDate('consignment_date', $date)
        ->whereHas('lines', function($q){
            return $q->where(function($p){
                return $p->where('attribute2', '<>', 'Y')
                ->orWhereNull('attribute2');
            });
        })
        ->get('consignment_no');

        foreach ($gl_sale_consignment as $item) {
            $document_no = $item->consignment_no;
            if( !array_key_exists($document_no, $documentNoLists) ){
                $documentNoLists[$document_no] = $document_no;
            }
        }

        ksort($documentNoLists);

        return response()->json($documentNoLists);
    }

    public function callReport(Request $request)
    {
        ini_set('max_execution_time', '7200');

        try {

            $this->orgName = 'การยาสูบแห่งประเทศไทย';
            $hr = HrOperatingUnits::where('name', $this->orgName)->first();
            $this->orgId = $hr->organization_id;

            $date = Carbon::parse($request->document_date);
            $document_no = $request->document_no;

            $club_cig = Consignment::whereHas('customer', function($q){
                return $q->whereIn('customer_type_id', [30, 40]);
            })
            ->whereHas('lines', function($q) {
                return $q->whereHas('orderHeader', function($p) {
                    return $p->whereIn('product_type_code', [10]);
                });
            })
            ->when($document_no, function ($p, $document_no){
                return $p->where('consignment_no', $document_no);
            })
            ->whereDate('consignment_date', $date)
            ->whereRaw("upper(consignment_status) = 'CONFIRM'")
            ->whereRaw("
                NOT EXISTS( 
                    SELECT 1
                    FROM RA_CUSTOMER_TRX_ALL    RCT
                        ,RA_BATCH_SOURCES_ALL   RBA 
                    WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                    AND   TRX_NUMBER = PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_NO
                    AND   RCT.ORG_ID = $this->orgId
                    AND   RBA.NAME   = 'ระบบขายในประเทศ'
                )
            ")
            ->get();

            /// club not cigarette
            $club_not_cig = OrderHeader::whereHas('customer', function($q){
                return $q->whereIn('customer_type_id', [30, 40]);
            })
            ->where('product_type_code', '<>', 10)
            ->where('program_code', 'OMP0019')
            ->whereDate('pick_release_approve_date', $date)
            ->when($document_no, function ($p, $document_no){
                return $p->where('pick_release_no', $document_no);
            })
            ->whereRaw("upper(pick_release_status) = 'CONFIRM'")
            ->whereRaw("
                NOT EXISTS( 
                    SELECT 1
                    FROM RA_CUSTOMER_TRX_ALL    RCT
                        ,RA_BATCH_SOURCES_ALL   RBA 
                    WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                    AND   TRX_NUMBER = PTOM_ORDER_HEADERS.PICK_RELEASE_NO
                    AND   RCT.ORG_ID = $this->orgId
                    AND   RBA.NAME   = 'ระบบขายในประเทศ'
                )
            ")
            ->with('customer', 'transactionType', 'lines')
            ->get();

            // not club
            $not_club = OrderHeader::whereHas('customer', function($q){
                return $q->whereNotIn('customer_type_id', [30, 40]);
            })
            ->where('program_code', 'OMP0019')
            ->whereDate('pick_release_approve_date', $date)
            ->when($document_no, function ($p, $document_no){
                return $p->where('pick_release_no', $document_no);
            })
            ->whereRaw("upper(pick_release_status) = 'CONFIRM'")
            ->whereRaw("
                NOT EXISTS( 
                    SELECT 1
                    FROM RA_CUSTOMER_TRX_ALL    RCT
                        ,RA_BATCH_SOURCES_ALL   RBA 
                    WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                    AND   TRX_NUMBER = PTOM_ORDER_HEADERS.PICK_RELEASE_NO
                    AND   RCT.ORG_ID = $this->orgId
                    AND   RBA.NAME   = 'ระบบขายในประเทศ'
                )
            ")
            ->with('customer', 'transactionType', 'lines')
            ->get();

            $rma = ClaimHeader::where('program_code', 'OMP0052')
            ->whereDate('rma_date', $date)
            ->when($document_no, function ($p, $document_no){
                return $p->where('credit_note_number', $document_no);
            })  
            ->whereRaw("upper(status_rma) = 'CONFIRM'")
            ->get();

            $credit_note = PtomInvoiceHeader::where('program_code', 'OMP0034')
            ->whereDate('invoice_date', $date)
            ->when($document_no, function ($p, $document_no){
                return $p->where('invoice_headers_number', $document_no);
            }) 
            ->whereRaw("upper(invoice_status) = 'CONFIRM'")
            ->whereRaw("
                NOT EXISTS( 
                    SELECT 1
                    FROM RA_CUSTOMER_TRX_ALL    RCT
                        ,RA_BATCH_SOURCES_ALL   RBA 
                    WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                    AND   TRX_NUMBER = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
                    AND   RCT.ORG_ID = $this->orgId
                    AND   RBA.NAME   = 'ระบบขายในประเทศ'
                )
            ")
            ->where('invoice_amount', '<>', 0)
            ->with('lines.consignment')
            ->get();

            $debit_note = PtomInvoiceHeader::where('program_code', 'OMP0032')
            ->whereDate('invoice_date', $date)
            ->when($document_no, function ($p, $document_no){
                return $p->where('invoice_headers_number', $document_no);
            }) 
            ->whereRaw("upper(invoice_status) = 'CONFIRM'")
            ->whereRaw("
                NOT EXISTS( 
                    SELECT 1
                    FROM RA_CUSTOMER_TRX_ALL    RCT
                        ,RA_BATCH_SOURCES_ALL   RBA 
                    WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                    AND   TRX_NUMBER = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
                    AND   RCT.ORG_ID = $this->orgId
                    AND   RBA.NAME   = 'ระบบขายในประเทศ'
                )
            ")
            ->where('invoice_amount', '<>', 0)
            ->get();

            $credit_other = PtomInvoiceHeader::whereIn('program_code', ['OMP0033', 'OMP0050', 'OMP0052'])
            ->whereDate('invoice_date', $date)
            ->when($document_no, function ($p, $document_no){
                return $p->where('invoice_headers_number', $document_no);
            }) 
            ->whereRaw("upper(invoice_status) = 'CONFIRM'")
            ->whereRaw("
                NOT EXISTS( 
                    SELECT 1
                    FROM RA_CUSTOMER_TRX_ALL    RCT
                        ,RA_BATCH_SOURCES_ALL   RBA 
                    WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                    AND   TRX_NUMBER = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
                    AND   RCT.ORG_ID = $this->orgId
                    AND   RBA.NAME   = 'ระบบขายในประเทศ'
                )
            ")
            ->where('invoice_amount', '<>', 0)
            ->with('lines.consignment')
            ->get();

            $gl_exp = OrderHeader::whereHas('transactionType', function($q){
                return $q->where('op_sample_flag', 'Y');
            })
            ->where('program_code', 'OMP0020')
            ->whereDate('pick_release_approve_date', $date)
            ->when($document_no, function ($p, $document_no){
                return $p->where('pick_release_no', $document_no);
            })
            ->whereRaw("upper(pick_release_status) = 'CONFIRM'")
            ->where(function ($p) {
                return $p->whereNull('close_sale_flag')
                ->orWhereRaw("upper(close_sale_flag) <> 'Y'");
            })
            ->with('customer', 'transactionType', 'lines')
            ->get();

            $gl_sale_order_header = OrderHeader::where(function($q) use($date, $document_no){
                return $q->where(function($p) {
                    return $p->where(function($r) {
                        return $r->whereHas('customer', function($s){
                            return $s->whereNotIn('customer_type_id', [30, 40]);
                        })
                        ->whereIn('product_type_code', ['10']);
                    })
                    ->orWhere(function($r) {
                        return $r->whereIn('product_type_code', ['20']);
                    });
                })
                ->whereDate('pick_release_approve_date', $date)
                ->whereRaw("upper(pick_release_status) = 'CONFIRM'")
                ->where(function ($r) {
                    return $r->whereNull('close_sale_flag')
                    ->orWhereRaw("upper(close_sale_flag) <> 'Y'");
                })
                ->when($document_no, function ($r, $document_no){
                    return $r->where('pick_release_no', $document_no);
                });
            })
            ->whereHas('transactionType', function($q) {
                return $q->where('send_stat_gl', 'Y');
            })
            ->whereHas('lines', function($q){
                return $q->where(function($p){
                    return $p->where('promo_flag', '<>', 'Y')
                    ->orWhereNull('promo_flag');
                });
            })
            ->with([
                'customer', 
                'transactionType',
                'lines' => function ($q) {
                    return $q->where(function($p){
                        return $p->where('promo_flag', '<>', 'Y')
                        ->orWhereNull('promo_flag');
                    });
                }
            ])
            ->get();

            $gl_sale_consignment = Consignment::where(function ($q) {
                return $q->where(function ($p) {
                    return $p->whereNull('close_sale_flag')
                    ->orWhereRaw("upper(close_sale_flag) <> 'Y'");
                })
                ->whereRaw("upper(consignment_status) = 'CONFIRM'");
            })
            ->whereDate('consignment_date', $date)
            ->whereHas('lines', function($q){
                return $q->where(function($p){
                    return $p->where('attribute2', '<>', 'Y')
                    ->orWhereNull('attribute2');
                });
            })
            ->when($document_no, function ($p, $document_no){
                return $p->where('consignment_no', $document_no);
            })
            ->with([
                'customer', 
                'lines' => function ($q) {
                    return $q->where(function($p){
                        return $p->where('attribute2', '<>', 'Y')
                        ->orWhereNull('attribute2');
                    });
                }
            ])
            ->get();
            
            $creation_date = Carbon::now();

            $old_groups = self::getOldGroupId($club_cig, $club_not_cig, $not_club, $rma, $credit_note, $debit_note, $credit_other);

            foreach($old_groups as $old){
                $check_ar_interface_complete = \App\Models\OM\ARInterface::where('group_id', $old)
                ->where('interface_status', ['C', 'S'])
                ->first();

                if(!$check_ar_interface_complete){
                    $delete_report_temps = ARInvoiceReportTemp::where('group_id', $old)
                    ->delete();

                    $delete_ar_report = ARInterfacesReport::where('group_id', $old)
                    ->delete();
                }

                $check_gl_interface_complete = \App\Models\OM\GLInterfaceModel::where('group_id', $old)
                ->where('interface_status', ['C', 'S'])
                ->first();

                if(!$check_gl_interface_complete){
                    $delete_gl_report = GLInterfacesReport::where('group_id', $old)
                    ->delete();
                }
            }

            $group_id = self::genGroupId(collect(), collect(), collect(), collect(), collect(), collect(), collect());
            $batchInv = $group_id.'-'.uniqid();
            $batchGl = $group_id.'-'.uniqid();

            $premium = InvoicePremiumV::where(function($q) use($date){
                return $q->where(function($p) use($date){
                    return $p->whereDate('start_date_active', '<=', $date)
                    ->orWhereNull('start_date_active');
                })->where(function($r) use($date){
                    return $r->whereDate('end_date_active', '>', $date)
                    ->orWhereNull('end_date_active');
                });
            })->first();

            foreach ($club_cig as $item) {
                $this->updateARGroupId($item, $group_id);
                $consign = Consignment::find($item->consignment_header_id);
                $order = OrderHeader::find($item->lines()->first()->order_header_id);
                $this->insertInvoiceAR('club_cig', $premium, $consign, $order, $group_id, $batchInv, $creation_date, true);
            }

            foreach ($club_not_cig as $item) {
                $this->updateARGroupId($item, $group_id);
                $order = OrderHeader::find($item->order_header_id);
                $this->insertInvoiceAR('club_not_cig', $premium, $order, $order, $group_id, $batchInv, $creation_date, true);
            }

            foreach ($not_club as $item) {
                $this->updateARGroupId($item, $group_id);
                $order = OrderHeader::find($item->order_header_id);
                $this->insertInvoiceAR('not_club', $premium, $order, $order, $group_id, $batchInv, $creation_date, true);
            }

            foreach ($rma->whereNull('ebs_order_number') as $item) {
                $this->updateARGroupId($item, $group_id);
            }

            foreach ($credit_note as $item) {
                $this->updateARGroupId($item, $group_id);
                $this->insertCreditNote($item, $group_id, $batchInv, $creation_date, true);
            }

            foreach ($debit_note as $item) {
                $this->updateARGroupId($item, $group_id);
                $this->insertDebitNote($item, $group_id, $batchInv, $creation_date, true);
            }

            foreach ($credit_other as $item) {
                $this->updateARGroupId($item, $group_id);
                $this->insertCreditOther($item, $group_id, $batchInv, $creation_date, true);
            }

            InterfaceRepo::interfaceARReport($batchInv);

            $group_gl_exp = $gl_exp->groupBy('order_type_id');
            $this->insertGLExp($group_gl_exp, $group_id, $batchGl, $creation_date, true);

            $this->insertGLSale($gl_sale_order_header, $gl_sale_consignment, $rma, $date, $group_id, $batchGl, $creation_date, true);

        }catch (\Exception $e) {

            $result = [
                'status' => 'E',
                'msg' => $e->getMessage(),
            ];
            return response()->json($result);
        }

        $result = [
            'status' => 'S',
            'msg' => 'ประมวลผลสำเร็จ Group ID '.$group_id,
            'group_id' => $group_id,
        ];

        return response()->json($result);
    }

    public function processCons(Request $request)
    {
        ini_set('max_execution_time', '7200');

        try {
            $this->orgName = 'การยาสูบแห่งประเทศไทย';
            $hr = HrOperatingUnits::where('name', $this->orgName)->first();
            $this->orgId = $hr->organization_id;

            $date = Carbon::parse($request->document_date);
            $document_no = $request->document_no;
            $creation_date = Carbon::now();
            $requestType = $request->type;

            $valid = true;

            $result = [
                'status' => 'S',
                'msg' => '',
                'group_id' => ''
            ];

            $club_cig = Consignment::whereHas('customer', function($q){
                return $q->whereIn('customer_type_id', [30, 40]);
            })
            ->whereHas('lines', function($q) {
                return $q->whereHas('orderHeader', function($p) {
                    return $p->whereIn('product_type_code', [10]);
                });
            })
            ->when($document_no, function ($p, $document_no){
                return $p->where('consignment_no', $document_no);
            })
            ->whereDate('consignment_date', $date)
            ->whereRaw("upper(consignment_status) = 'CONFIRM'")
            ->whereRaw("
                NOT EXISTS( 
                    SELECT 1
                    FROM RA_CUSTOMER_TRX_ALL    RCT
                        ,RA_BATCH_SOURCES_ALL   RBA 
                    WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                    AND   TRX_NUMBER = PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_NO
                    AND   RCT.ORG_ID = $this->orgId
                    AND   RBA.NAME   = 'ระบบขายในประเทศ'
                )
            ")
            ->get();

            /// club not cigarette
            $club_not_cig = OrderHeader::whereHas('customer', function($q){
                return $q->whereIn('customer_type_id', [30, 40]);
            })
            ->where('product_type_code', '<>', 10)
            ->where('program_code', 'OMP0019')
            ->whereDate('pick_release_approve_date', $date)
            ->when($document_no, function ($p, $document_no){
                return $p->where('pick_release_no', $document_no);
            })
            ->whereRaw("upper(pick_release_status) = 'CONFIRM'")
            ->whereRaw("
                NOT EXISTS( 
                    SELECT 1
                    FROM RA_CUSTOMER_TRX_ALL    RCT
                        ,RA_BATCH_SOURCES_ALL   RBA 
                    WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                    AND   TRX_NUMBER = PTOM_ORDER_HEADERS.PICK_RELEASE_NO
                    AND   RCT.ORG_ID = $this->orgId
                    AND   RBA.NAME   = 'ระบบขายในประเทศ'
                )
            ")
            ->with('customer', 'transactionType', 'lines')
            ->get();

            // not club
            $not_club = OrderHeader::whereHas('customer', function($q){
                return $q->whereNotIn('customer_type_id', [30, 40]);
            })
            ->where('program_code', 'OMP0019')
            ->whereDate('pick_release_approve_date', $date)
            ->when($document_no, function ($p, $document_no){
                return $p->where('pick_release_no', $document_no);
            })
            ->whereRaw("upper(pick_release_status) = 'CONFIRM'")
            ->whereRaw("
                NOT EXISTS( 
                    SELECT 1
                    FROM RA_CUSTOMER_TRX_ALL    RCT
                        ,RA_BATCH_SOURCES_ALL   RBA 
                    WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                    AND   TRX_NUMBER = PTOM_ORDER_HEADERS.PICK_RELEASE_NO
                    AND   RCT.ORG_ID = $this->orgId
                    AND   RBA.NAME   = 'ระบบขายในประเทศ'
                )
            ")
            ->with('customer', 'transactionType', 'lines')
            ->get();

            // rma
            $rma = ClaimHeader::where('program_code', 'OMP0052')
            ->whereDate('rma_date', $date)
            ->when($document_no, function ($p, $document_no){
                return $p->where('credit_note_number', $document_no);
            })
            ->whereRaw("upper(status_rma) = 'CONFIRM'")
            ->get();

            $credit_note = PtomInvoiceHeader::where('program_code', 'OMP0034')
            ->whereDate('invoice_date', $date)
            ->when($document_no, function ($p, $document_no){
                return $p->where('invoice_headers_number', $document_no);
            }) 
            ->whereRaw("upper(invoice_status) = 'CONFIRM'")
            ->whereRaw("
                NOT EXISTS( 
                    SELECT 1
                    FROM RA_CUSTOMER_TRX_ALL    RCT
                        ,RA_BATCH_SOURCES_ALL   RBA 
                    WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                    AND   TRX_NUMBER = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
                    AND   RCT.ORG_ID = $this->orgId
                    AND   RBA.NAME   = 'ระบบขายในประเทศ'
                )
            ")
            ->where('invoice_amount', '<>', 0)
            ->with('lines.consignment')
            ->get();

            $debit_note = PtomInvoiceHeader::where('program_code', 'OMP0032')
            ->whereDate('invoice_date', $date)
            ->when($document_no, function ($p, $document_no){
                return $p->where('invoice_headers_number', $document_no);
            }) 
            ->whereRaw("upper(invoice_status) = 'CONFIRM'")
            ->whereRaw("
                NOT EXISTS( 
                    SELECT 1
                    FROM RA_CUSTOMER_TRX_ALL    RCT
                        ,RA_BATCH_SOURCES_ALL   RBA 
                    WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                    AND   TRX_NUMBER = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
                    AND   RCT.ORG_ID = $this->orgId
                    AND   RBA.NAME   = 'ระบบขายในประเทศ'
                )
            ")
            ->where('invoice_amount', '<>', 0)
            ->get();

            $credit_other = PtomInvoiceHeader::whereIn('program_code', ['OMP0033', 'OMP0050', 'OMP0052'])
            ->whereDate('invoice_date', $date)
            ->when($document_no, function ($p, $document_no){
                return $p->where('invoice_headers_number', $document_no);
            }) 
            ->whereRaw("upper(invoice_status) = 'CONFIRM'")
            ->whereRaw("
                NOT EXISTS( 
                    SELECT 1
                    FROM RA_CUSTOMER_TRX_ALL    RCT
                        ,RA_BATCH_SOURCES_ALL   RBA 
                    WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                    AND   TRX_NUMBER = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
                    AND   RCT.ORG_ID = $this->orgId
                    AND   RBA.NAME   = 'ระบบขายในประเทศ'
                )
            ")
            ->where('invoice_amount', '<>', 0)
            ->with('lines.consignment')
            ->get();

            $group_id = self::genGroupId($club_cig, $club_not_cig, $not_club, $rma, $credit_note, $debit_note, $credit_other);

            $batchSO = $group_id.'-'.uniqid();

            $resultClubCig = null;

            ///////////// INTERFACE SALE ORDER /////////////

            if($club_cig->count() && $valid){

                $interfaceSO = false;
                foreach ($club_cig->whereNull('ebs_order_number') as $item) {
                    $interfaceSO = true;
                    $this->updateWebBatch($item, $batchSO);
                    $this->updateARGroupId($item, $group_id);
                }

                if($interfaceSO){
                    $resultClubCig = InterfaceRepo::interfaceSaleOrderConsignment($batchSO);
                }else {
                    $resultClubCig['status'] = null;
                    $resultClubCig['message'] = null;
                }

                $found = Consignment::where('web_batch_no', $batchSO)->whereNull('ebs_order_number')->get();

                if($found->count() || (!in_array($resultClubCig['status'], ['S', 'C']) && $interfaceSO) ){
                    $valid = false;
                    $result['status'] = 'E';
                    $result['group_id'] = $group_id;
                    $msg = (optional($club_cig->where('interface_status', 'E')->first())->interfaced_msg ?? (optional(PtomSoTempV::where('file_name', $batchSO)->where('record_status', 'E')->first())->interface_msg ?? $resultClubCig['message']));
                    foreach($found as $consign){
                        $msg = $msg == '' ? optional($consign)->consignment_no.'-ไม่พบข้อมูล EBS' : $msg.', '.optional($consign)->consignment_no.'-ไม่พบข้อมูล EBS';
                    }
                    $result['msg'] = $msg;
                }else {
                    $result['group_id'] = $group_id;
                }
            }
        
        }catch (\Exception $e) {

            $result = [
                'status' => 'E',
                'msg' => $e->getMessage(),
            ];
            return response()->json($result);
        }

        \DB::beginTransaction();

        try {
            if($valid){

                $result['status'] = 'S';
                $result['msg'] = '';
                $result['group_id'] = $group_id;

            }else {

                $result['status'] = 'E';
            }
            \DB::commit();

        }catch (\Exception $e) {
            \DB::rollBack();

            $result = [
                'status' => 'E',
                'msg' => $e->getMessage(),
            ];
        }

        return response()->json($result);
    }

    public function processSO(Request $request)
    {
        ini_set('max_execution_time', '7200');

        try {
            $this->orgName = 'การยาสูบแห่งประเทศไทย';
            $hr = HrOperatingUnits::where('name', $this->orgName)->first();
            $this->orgId = $hr->organization_id;

            $date = Carbon::parse($request->document_date);
            $document_no = $request->document_no;
            $creation_date = Carbon::now();
            $requestType = $request->type;

            $valid = true;

            $result = [
                'status' => 'S',
                'msg' => '',
                'group_id' => ''
            ];

            $club_cig = Consignment::whereHas('customer', function($q){
                return $q->whereIn('customer_type_id', [30, 40]);
            })
            ->whereHas('lines', function($q) {
                return $q->whereHas('orderHeader', function($p) {
                    return $p->whereIn('product_type_code', [10]);
                });
            })
            ->when($document_no, function ($p, $document_no){
                return $p->where('consignment_no', $document_no);
            })
            ->whereDate('consignment_date', $date)
            ->whereRaw("upper(consignment_status) = 'CONFIRM'")
            ->whereRaw("
                NOT EXISTS( 
                    SELECT 1
                    FROM RA_CUSTOMER_TRX_ALL    RCT
                        ,RA_BATCH_SOURCES_ALL   RBA 
                    WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                    AND   TRX_NUMBER = PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_NO
                    AND   RCT.ORG_ID = $this->orgId
                    AND   RBA.NAME   = 'ระบบขายในประเทศ'
                )
            ")
            ->get();

            /// club not cigarette
            $club_not_cig = OrderHeader::whereHas('customer', function($q){
                return $q->whereIn('customer_type_id', [30, 40]);
            })
            ->where('product_type_code', '<>', 10)
            ->where('program_code', 'OMP0019')
            ->whereDate('pick_release_approve_date', $date)
            ->when($document_no, function ($p, $document_no){
                return $p->where('pick_release_no', $document_no);
            })
            ->whereRaw("upper(pick_release_status) = 'CONFIRM'")
            ->whereRaw("
                NOT EXISTS( 
                    SELECT 1
                    FROM RA_CUSTOMER_TRX_ALL    RCT
                        ,RA_BATCH_SOURCES_ALL   RBA 
                    WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                    AND   TRX_NUMBER = PTOM_ORDER_HEADERS.PICK_RELEASE_NO
                    AND   RCT.ORG_ID = $this->orgId
                    AND   RBA.NAME   = 'ระบบขายในประเทศ'
                )
            ")
            ->with('customer', 'transactionType', 'lines')
            ->get();

            // not club
            $not_club = OrderHeader::whereHas('customer', function($q){
                return $q->whereNotIn('customer_type_id', [30, 40]);
            })
            ->where('program_code', 'OMP0019')
            ->whereDate('pick_release_approve_date', $date)
            ->when($document_no, function ($p, $document_no){
                return $p->where('pick_release_no', $document_no);
            })
            ->whereRaw("upper(pick_release_status) = 'CONFIRM'")
            ->whereRaw("
                NOT EXISTS( 
                    SELECT 1
                    FROM RA_CUSTOMER_TRX_ALL    RCT
                        ,RA_BATCH_SOURCES_ALL   RBA 
                    WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                    AND   TRX_NUMBER = PTOM_ORDER_HEADERS.PICK_RELEASE_NO
                    AND   RCT.ORG_ID = $this->orgId
                    AND   RBA.NAME   = 'ระบบขายในประเทศ'
                )
            ")
            ->with('customer', 'transactionType', 'lines')
            ->get();

            // rma
            $rma = ClaimHeader::where('program_code', 'OMP0052')
            ->whereDate('rma_date', $date)
            ->when($document_no, function ($p, $document_no){
                return $p->where('credit_note_number', $document_no);
            })  
            ->whereRaw("upper(status_rma) = 'CONFIRM'")
            ->get();

            $credit_note = PtomInvoiceHeader::where('program_code', 'OMP0034')
            ->whereDate('invoice_date', $date)
            ->when($document_no, function ($p, $document_no){
                return $p->where('invoice_headers_number', $document_no);
            }) 
            ->whereRaw("upper(invoice_status) = 'CONFIRM'")
            ->whereRaw("
                NOT EXISTS( 
                    SELECT 1
                    FROM RA_CUSTOMER_TRX_ALL    RCT
                        ,RA_BATCH_SOURCES_ALL   RBA 
                    WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                    AND   TRX_NUMBER = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
                    AND   RCT.ORG_ID = $this->orgId
                    AND   RBA.NAME   = 'ระบบขายในประเทศ'
                )
            ")
            ->where('invoice_amount', '<>', 0)
            ->with('lines.consignment')
            ->get();

            $debit_note = PtomInvoiceHeader::where('program_code', 'OMP0032')
            ->whereDate('invoice_date', $date)
            ->when($document_no, function ($p, $document_no){
                return $p->where('invoice_headers_number', $document_no);
            }) 
            ->whereRaw("upper(invoice_status) = 'CONFIRM'")
            ->whereRaw("
                NOT EXISTS( 
                    SELECT 1
                    FROM RA_CUSTOMER_TRX_ALL    RCT
                        ,RA_BATCH_SOURCES_ALL   RBA 
                    WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                    AND   TRX_NUMBER = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
                    AND   RCT.ORG_ID = $this->orgId
                    AND   RBA.NAME   = 'ระบบขายในประเทศ'
                )
            ")
            ->where('invoice_amount', '<>', 0)
            ->get();

            $credit_other = PtomInvoiceHeader::whereIn('program_code', ['OMP0033', 'OMP0050', 'OMP0052'])
            ->whereDate('invoice_date', $date)
            ->when($document_no, function ($p, $document_no){
                return $p->where('invoice_headers_number', $document_no);
            }) 
            ->whereRaw("upper(invoice_status) = 'CONFIRM'")
            ->whereRaw("
                NOT EXISTS( 
                    SELECT 1
                    FROM RA_CUSTOMER_TRX_ALL    RCT
                        ,RA_BATCH_SOURCES_ALL   RBA 
                    WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                    AND   TRX_NUMBER = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
                    AND   RCT.ORG_ID = $this->orgId
                    AND   RBA.NAME   = 'ระบบขายในประเทศ'
                )
            ")
            ->where('invoice_amount', '<>', 0)
            ->with('lines.consignment')
            ->get();

            $group_id = self::genGroupId($club_cig, $club_not_cig, $not_club, $rma, $credit_note, $debit_note, $credit_other);

            $batchSO = $group_id.'-'.uniqid();

            $resultClubNotCig = null;

            ///////////// INTERFACE SALE ORDER /////////////

            if($club_not_cig->count() || $not_club->count() && $valid){

                $interfaceSO = false;
                foreach ($club_not_cig->whereNull('ebs_order_number') as $item) {
                    $interfaceSO = true;
                    $this->updateWebBatch($item, $batchSO);
                    $this->updateARGroupId($item, $group_id);
                }

                foreach ($not_club->whereNull('ebs_order_number') as $item) {
                    $interfaceSO = true;
                    $this->updateWebBatch($item, $batchSO);
                    $this->updateARGroupId($item, $group_id);
                }

                if($interfaceSO){
                    $resultClubNotCig = InterfaceRepo::interfaceSaleOrder($batchSO);
                }else {
                    $resultClubNotCig['status'] = null;
                    $resultClubNotCig['message'] = null;
                }

                $found = OrderHeader::where('web_batch_no', $batchSO)->whereNull('ebs_order_number')->get();

                if($found->count() || (!in_array($resultClubNotCig['status'], ['S', 'C']) && $interfaceSO) ){
                    $valid = false;
                    $result['status'] = 'E';
                    $result['group_id'] = $group_id;
                    $msg = (optional($club_cig->where('interface_status', 'E')->first())->interfaced_msg ?? (optional(PtomSoTempV::where('file_name', $batchSO)->where('record_status', 'E')->first())->interface_msg ?? $resultClubNotCig['message']));
                    foreach($found as $order){
                        $msg = $msg == '' ? optional($order)->pick_release_no.'-ไม่พบข้อมูล EBS' : $msg.', '.optional($order)->pick_release_no.'-ไม่พบข้อมูล EBS';
                    }
                    $result['msg'] = $msg;
                }else {
                    $result['group_id'] = $group_id;
                }
            }
        
        }catch (\Exception $e) {

            $result = [
                'status' => 'E',
                'msg' => $e->getMessage(),
            ];
            return response()->json($result);
        }

        \DB::beginTransaction();

        try {
            if($valid){

                $result['status'] = 'S';
                $result['msg'] = '';
                $result['group_id'] = $group_id;

            }else {

                $result['status'] = 'E';
            }
            \DB::commit();

        }catch (\Exception $e) {
            \DB::rollBack();

            $result = [
                'status' => 'E',
                'msg' => $e->getMessage(),
            ];
        }

        return response()->json($result);
    }

    public function processRMA(Request $request)
    {
        ini_set('max_execution_time', '7200');

        try {
            $this->orgName = 'การยาสูบแห่งประเทศไทย';
            $hr = HrOperatingUnits::where('name', $this->orgName)->first();
            $this->orgId = $hr->organization_id;

            $date = Carbon::parse($request->document_date);
            $document_no = $request->document_no;
            $creation_date = Carbon::now();
            $requestType = $request->type;

            $valid = true;

            $result = [
                'status' => 'S',
                'msg' => '',
                'group_id' => ''
            ];

            $club_cig = Consignment::whereHas('customer', function($q){
                return $q->whereIn('customer_type_id', [30, 40]);
            })
            ->whereHas('lines', function($q) {
                return $q->whereHas('orderHeader', function($p) {
                    return $p->whereIn('product_type_code', [10]);
                });
            })
            ->when($document_no, function ($p, $document_no){
                return $p->where('consignment_no', $document_no);
            })
            ->whereDate('consignment_date', $date)
            ->whereRaw("upper(consignment_status) = 'CONFIRM'")
            ->whereRaw("
                NOT EXISTS( 
                    SELECT 1
                    FROM RA_CUSTOMER_TRX_ALL    RCT
                        ,RA_BATCH_SOURCES_ALL   RBA 
                    WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                    AND   TRX_NUMBER = PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_NO
                    AND   RCT.ORG_ID = $this->orgId
                    AND   RBA.NAME   = 'ระบบขายในประเทศ'
                )
            ")
            ->get();

            /// club not cigarette
            $club_not_cig = OrderHeader::whereHas('customer', function($q){
                return $q->whereIn('customer_type_id', [30, 40]);
            })
            ->where('product_type_code', '<>', 10)
            ->where('program_code', 'OMP0019')
            ->whereDate('pick_release_approve_date', $date)
            ->when($document_no, function ($p, $document_no){
                return $p->where('pick_release_no', $document_no);
            })
            ->whereRaw("upper(pick_release_status) = 'CONFIRM'")
            ->whereRaw("
                NOT EXISTS( 
                    SELECT 1
                    FROM RA_CUSTOMER_TRX_ALL    RCT
                        ,RA_BATCH_SOURCES_ALL   RBA 
                    WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                    AND   TRX_NUMBER = PTOM_ORDER_HEADERS.PICK_RELEASE_NO
                    AND   RCT.ORG_ID = $this->orgId
                    AND   RBA.NAME   = 'ระบบขายในประเทศ'
                )
            ")
            ->with('customer', 'transactionType', 'lines')
            ->get();

            // not club
            $not_club = OrderHeader::whereHas('customer', function($q){
                return $q->whereNotIn('customer_type_id', [30, 40]);
            })
            ->where('program_code', 'OMP0019')
            ->whereDate('pick_release_approve_date', $date)
            ->when($document_no, function ($p, $document_no){
                return $p->where('pick_release_no', $document_no);
            })
            ->whereRaw("upper(pick_release_status) = 'CONFIRM'")
            ->whereRaw("
                NOT EXISTS( 
                    SELECT 1
                    FROM RA_CUSTOMER_TRX_ALL    RCT
                        ,RA_BATCH_SOURCES_ALL   RBA 
                    WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                    AND   TRX_NUMBER = PTOM_ORDER_HEADERS.PICK_RELEASE_NO
                    AND   RCT.ORG_ID = $this->orgId
                    AND   RBA.NAME   = 'ระบบขายในประเทศ'
                )
            ")
            ->with('customer', 'transactionType', 'lines')
            ->get();

            // rma
            $rma = ClaimHeader::where('program_code', 'OMP0052')
            ->whereDate('rma_date', $date)
            ->when($document_no, function ($p, $document_no){
                return $p->where('credit_note_number', $document_no);
            })  
            ->whereRaw("upper(status_rma) = 'CONFIRM'")
            ->get();

            $credit_note = PtomInvoiceHeader::where('program_code', 'OMP0034')
            ->whereDate('invoice_date', $date)
            ->when($document_no, function ($p, $document_no){
                return $p->where('invoice_headers_number', $document_no);
            }) 
            ->whereRaw("upper(invoice_status) = 'CONFIRM'")
            ->whereRaw("
                NOT EXISTS( 
                    SELECT 1
                    FROM RA_CUSTOMER_TRX_ALL    RCT
                        ,RA_BATCH_SOURCES_ALL   RBA 
                    WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                    AND   TRX_NUMBER = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
                    AND   RCT.ORG_ID = $this->orgId
                    AND   RBA.NAME   = 'ระบบขายในประเทศ'
                )
            ")
            ->where('invoice_amount', '<>', 0)
            ->with('lines.consignment')
            ->get();

            $debit_note = PtomInvoiceHeader::where('program_code', 'OMP0032')
            ->whereDate('invoice_date', $date)
            ->when($document_no, function ($p, $document_no){
                return $p->where('invoice_headers_number', $document_no);
            }) 
            ->whereRaw("upper(invoice_status) = 'CONFIRM'")
            ->whereRaw("
                NOT EXISTS( 
                    SELECT 1
                    FROM RA_CUSTOMER_TRX_ALL    RCT
                        ,RA_BATCH_SOURCES_ALL   RBA 
                    WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                    AND   TRX_NUMBER = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
                    AND   RCT.ORG_ID = $this->orgId
                    AND   RBA.NAME   = 'ระบบขายในประเทศ'
                )
            ")
            ->where('invoice_amount', '<>', 0)
            ->get();

            $credit_other = PtomInvoiceHeader::whereIn('program_code', ['OMP0033', 'OMP0050', 'OMP0052'])
            ->whereDate('invoice_date', $date)
            ->when($document_no, function ($p, $document_no){
                return $p->where('invoice_headers_number', $document_no);
            }) 
            ->whereRaw("upper(invoice_status) = 'CONFIRM'")
            ->whereRaw("
                NOT EXISTS( 
                    SELECT 1
                    FROM RA_CUSTOMER_TRX_ALL    RCT
                        ,RA_BATCH_SOURCES_ALL   RBA 
                    WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                    AND   TRX_NUMBER = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
                    AND   RCT.ORG_ID = $this->orgId
                    AND   RBA.NAME   = 'ระบบขายในประเทศ'
                )
            ")
            ->where('invoice_amount', '<>', 0)
            ->with('lines.consignment')
            ->get();

            $group_id = self::genGroupId($club_cig, $club_not_cig, $not_club, $rma, $credit_note, $debit_note, $credit_other);

            $batchSO = $group_id.'-'.uniqid();

            $resultRMA = null;

            ///////////// INTERFACE SALE ORDER /////////////

            if($rma->count() && $valid){

                $interfaceSO = false;
                foreach ($rma->whereNull('ebs_order_number') as $item) {
                    $interfaceSO = true;
                    $this->updateWebBatch($item, $batchSO);
                    $this->updateARGroupId($item, $group_id);
                }

                if($interfaceSO){
                    $resultRMA = InterfaceRepo::interfaceSaleOrderRMA($batchSO);
                }else {
                    $resultRMA['status'] = null;
                    $resultRMA['message'] = null;
                }

                $found = ClaimHeader::where('web_batch_no', $batchSO)->whereNull('ebs_order_number')->get();

                if($found->count() || (!in_array($resultRMA['status'], ['S', 'C']) && $interfaceSO) ){
                    $valid = false;
                    $result['status'] = 'E';
                    $result['group_id'] = $group_id;
                    $msg = (optional($club_cig->where('interface_status', 'E')->first())->interfaced_msg ?? (optional(PtomSoTempV::where('file_name', $batchSO)->where('record_status', 'E')->first())->interface_msg ?? $resultRMA['message']));
                    foreach($found as $claim){
                        $msg = $msg == '' ? optional($claim)->claim_number.'-ไม่พบข้อมูล EBS' : $msg.', '.optional($claim)->claim_number.'-ไม่พบข้อมูล EBS';
                    }
                    $result['msg'] = $msg;
                }else {
                    $result['group_id'] = $group_id;
                }
            }
        
        }catch (\Exception $e) {

            $result = [
                'status' => 'E',
                'msg' => $e->getMessage(),
            ];
            return response()->json($result);
        }

        \DB::beginTransaction();

        try {
            if($valid){

                if($rma->count()){
                    foreach ($rma as $item) {
                        $claim = ClaimHeader::find($item->claim_header_id);
                        $this->updateCloseSaleFlagAndStatus($claim);
                    }
                }

                $result['status'] = 'S';
                $result['msg'] = '';
                $result['group_id'] = $group_id;

            }else {

                $result['status'] = 'E';
            }
            \DB::commit();

        }catch (\Exception $e) {
            \DB::rollBack();

            $result = [
                'status' => 'E',
                'msg' => $e->getMessage(),
            ];
        }

        return response()->json($result);
    }

    public function processInvoice(Request $request)
    {
        ini_set('max_execution_time', '7200');

        try {
            $this->orgName = 'การยาสูบแห่งประเทศไทย';
            $hr = HrOperatingUnits::where('name', $this->orgName)->first();
            $this->orgId = $hr->organization_id;

            $date = Carbon::parse($request->document_date);
            $document_no = $request->document_no;
            $creation_date = Carbon::now();
            $requestType = $request->type;

            $valid = true;

            $result = [
                'status' => 'S',
                'msg' => '',
                'group_id' => ''
            ];

            $club_cig = Consignment::whereHas('customer', function($q){
                return $q->whereIn('customer_type_id', [30, 40]);
            })
            ->whereHas('lines', function($q) {
                return $q->whereHas('orderHeader', function($p) {
                    return $p->whereIn('product_type_code', [10]);
                });
            })
            ->when($document_no, function ($p, $document_no){
                return $p->where('consignment_no', $document_no);
            })
            ->whereDate('consignment_date', $date)
            ->whereRaw("upper(consignment_status) = 'CONFIRM'")
            ->whereRaw("
                NOT EXISTS( 
                    SELECT 1
                    FROM RA_CUSTOMER_TRX_ALL    RCT
                        ,RA_BATCH_SOURCES_ALL   RBA 
                    WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                    AND   TRX_NUMBER = PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_NO
                    AND   RCT.ORG_ID = $this->orgId
                    AND   RBA.NAME   = 'ระบบขายในประเทศ'
                )
            ")
            ->get();

            /// club not cigarette
            $club_not_cig = OrderHeader::whereHas('customer', function($q){
                return $q->whereIn('customer_type_id', [30, 40]);
            })
            ->where('product_type_code', '<>', 10)
            ->where('program_code', 'OMP0019')
            ->whereDate('pick_release_approve_date', $date)
            ->when($document_no, function ($p, $document_no){
                return $p->where('pick_release_no', $document_no);
            })
            ->whereRaw("upper(pick_release_status) = 'CONFIRM'")
            ->whereRaw("
                NOT EXISTS( 
                    SELECT 1
                    FROM RA_CUSTOMER_TRX_ALL    RCT
                        ,RA_BATCH_SOURCES_ALL   RBA 
                    WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                    AND   TRX_NUMBER = PTOM_ORDER_HEADERS.PICK_RELEASE_NO
                    AND   RCT.ORG_ID = $this->orgId
                    AND   RBA.NAME   = 'ระบบขายในประเทศ'
                )
            ")
            ->with('customer', 'transactionType', 'lines')
            ->get();

            // not club
            $not_club = OrderHeader::whereHas('customer', function($q){
                return $q->whereNotIn('customer_type_id', [30, 40]);
            })
            ->where('program_code', 'OMP0019')
            ->whereDate('pick_release_approve_date', $date)
            ->when($document_no, function ($p, $document_no){
                return $p->where('pick_release_no', $document_no);
            })
            ->whereRaw("upper(pick_release_status) = 'CONFIRM'")
            ->whereRaw("
                NOT EXISTS( 
                    SELECT 1
                    FROM RA_CUSTOMER_TRX_ALL    RCT
                        ,RA_BATCH_SOURCES_ALL   RBA 
                    WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                    AND   TRX_NUMBER = PTOM_ORDER_HEADERS.PICK_RELEASE_NO
                    AND   RCT.ORG_ID = $this->orgId
                    AND   RBA.NAME   = 'ระบบขายในประเทศ'
                )
            ")
            ->with('customer', 'transactionType', 'lines')
            ->get();

            // rma
            $rma = ClaimHeader::where('program_code', 'OMP0052')
            ->whereDate('rma_date', $date)
            ->when($document_no, function ($p, $document_no){
                return $p->where('credit_note_number', $document_no);
            })  
            ->whereRaw("upper(status_rma) = 'CONFIRM'")
            ->get();

            $credit_note = PtomInvoiceHeader::where('program_code', 'OMP0034')
            ->whereDate('invoice_date', $date)
            ->when($document_no, function ($p, $document_no){
                return $p->where('invoice_headers_number', $document_no);
            }) 
            ->whereRaw("upper(invoice_status) = 'CONFIRM'")
            ->whereRaw("
                NOT EXISTS( 
                    SELECT 1
                    FROM RA_CUSTOMER_TRX_ALL    RCT
                        ,RA_BATCH_SOURCES_ALL   RBA 
                    WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                    AND   TRX_NUMBER = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
                    AND   RCT.ORG_ID = $this->orgId
                    AND   RBA.NAME   = 'ระบบขายในประเทศ'
                )
            ")
            ->where('invoice_amount', '<>', 0)
            ->with('lines.consignment')
            ->get();

            $debit_note = PtomInvoiceHeader::where('program_code', 'OMP0032')
            ->whereDate('invoice_date', $date)
            ->when($document_no, function ($p, $document_no){
                return $p->where('invoice_headers_number', $document_no);
            }) 
            ->whereRaw("upper(invoice_status) = 'CONFIRM'")
            ->whereRaw("
                NOT EXISTS( 
                    SELECT 1
                    FROM RA_CUSTOMER_TRX_ALL    RCT
                        ,RA_BATCH_SOURCES_ALL   RBA 
                    WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                    AND   TRX_NUMBER = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
                    AND   RCT.ORG_ID = $this->orgId
                    AND   RBA.NAME   = 'ระบบขายในประเทศ'
                )
            ")
            ->where('invoice_amount', '<>', 0)
            ->get();

            $credit_other = PtomInvoiceHeader::whereIn('program_code', ['OMP0033', 'OMP0050', 'OMP0052'])
            ->whereDate('invoice_date', $date)
            ->when($document_no, function ($p, $document_no){
                return $p->where('invoice_headers_number', $document_no);
            }) 
            ->whereRaw("upper(invoice_status) = 'CONFIRM'")
            ->whereRaw("
                NOT EXISTS( 
                    SELECT 1
                    FROM RA_CUSTOMER_TRX_ALL    RCT
                        ,RA_BATCH_SOURCES_ALL   RBA 
                    WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                    AND   TRX_NUMBER = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
                    AND   RCT.ORG_ID = $this->orgId
                    AND   RBA.NAME   = 'ระบบขายในประเทศ'
                )
            ")
            ->where('invoice_amount', '<>', 0)
            ->with('lines.consignment')
            ->get();

            $group_id = self::genGroupId($club_cig, $club_not_cig, $not_club, $rma, $credit_note, $debit_note, $credit_other);

            $batchInv = $group_id.'-'.uniqid();

            // dd($club_cig, $club_not_cig, $not_club, 'rma', $rma, 'credit', $credit_note, 'debit', $debit_note, 'credit_other', $credit_other, 'gl_exp', $gl_exp, 'gl_sale', $gl_sale_order_header);

            $resultARInvoice = null;

            ///////////// INTERFACE INVOICE /////////////

            $premium = InvoicePremiumV::where(function($q) use($date){
                return $q->where(function($p) use($date){
                    return $p->whereDate('start_date_active', '<=', $date)
                    ->orWhereNull('start_date_active');
                })->where(function($r) use($date){
                    return $r->whereDate('end_date_active', '>', $date)
                    ->orWhereNull('end_date_active');
                });
            })->first();

            if($club_cig->count() && $valid){

                foreach ($club_cig as $item) {
                    $consign = Consignment::find($item->consignment_header_id);
                    $order = OrderHeader::find($item->lines()->first()->order_header_id);
                    $this->insertInvoiceAR('club_cig', $premium, $consign, $order, $group_id, $batchInv, $creation_date);
                }
            }

            if($club_not_cig->count() || $not_club->count() && $valid){

                foreach ($club_not_cig as $item) {
                    $order = OrderHeader::find($item->order_header_id);
                    $this->insertInvoiceAR('club_not_cig', $premium, $order, $order, $group_id, $batchInv, $creation_date);
                }

                foreach ($not_club as $item) {
                    $order = OrderHeader::find($item->order_header_id);
                    $this->insertInvoiceAR('not_club', $premium, $order, $order, $group_id, $batchInv, $creation_date);
                }
            }
            
            $credit_note = PtomInvoiceHeader::where('program_code', 'OMP0034')
            ->whereDate('invoice_date', $date)
            ->when($document_no, function ($p, $document_no){
                return $p->where('invoice_headers_number', $document_no);
            }) 
            ->whereRaw("upper(invoice_status) = 'CONFIRM'")
            ->whereRaw("
                NOT EXISTS( 
                    SELECT 1
                    FROM RA_CUSTOMER_TRX_ALL    RCT
                        ,RA_BATCH_SOURCES_ALL   RBA 
                    WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                    AND   TRX_NUMBER = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
                    AND   RCT.ORG_ID = $this->orgId
                    AND   RBA.NAME   = 'ระบบขายในประเทศ'
                )
            ")
            ->where('invoice_amount', '<>', 0)
            ->with('lines.consignment')
            ->get();

            $debit_note = PtomInvoiceHeader::where('program_code', 'OMP0032')
            ->whereDate('invoice_date', $date)
            ->when($document_no, function ($p, $document_no){
                return $p->where('invoice_headers_number', $document_no);
            }) 
            ->whereRaw("upper(invoice_status) = 'CONFIRM'")
            ->whereRaw("
                NOT EXISTS( 
                    SELECT 1
                    FROM RA_CUSTOMER_TRX_ALL    RCT
                        ,RA_BATCH_SOURCES_ALL   RBA 
                    WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                    AND   TRX_NUMBER = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
                    AND   RCT.ORG_ID = $this->orgId
                    AND   RBA.NAME   = 'ระบบขายในประเทศ'
                )
            ")
            ->where('invoice_amount', '<>', 0)
            ->get();

            $credit_other = PtomInvoiceHeader::whereIn('program_code', ['OMP0033', 'OMP0050', 'OMP0052'])
            ->whereDate('invoice_date', $date)
            ->when($document_no, function ($p, $document_no){
                return $p->where('invoice_headers_number', $document_no);
            }) 
            ->whereRaw("upper(invoice_status) = 'CONFIRM'")
            ->whereRaw("
                NOT EXISTS( 
                    SELECT 1
                    FROM RA_CUSTOMER_TRX_ALL    RCT
                        ,RA_BATCH_SOURCES_ALL   RBA 
                    WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                    AND   TRX_NUMBER = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
                    AND   RCT.ORG_ID = $this->orgId
                    AND   RBA.NAME   = 'ระบบขายในประเทศ'
                )
            ")
            ->where('invoice_amount', '<>', 0)
            ->with('lines.consignment')
            ->get();

            if($credit_note->count() && $valid){

                foreach ($credit_note as $item) {
                    $this->insertCreditNote($item, $group_id, $batchInv, $creation_date);
                }
            }

            if($debit_note->count() && $valid){

                foreach ($debit_note as $item) {
                    $this->insertDebitNote($item, $group_id, $batchInv, $creation_date);
                }
            }

            if($credit_other->count() && $valid){

                foreach ($credit_other as $item) {
                    // $this->updateWebBatch($item, $batch_no);
                    $this->insertCreditOther($item, $group_id, $batchInv, $creation_date);
                }
            }

            if($valid && ($club_cig->count() || $club_not_cig->count() || $not_club->count() || $credit_note->count() || $debit_note->count() || $credit_other->count()) ){

                $checkCCID = $this->checkErrorARCCID($batchInv);

                $valid = $checkCCID['valid'];

                if($valid){

                    $resultARInvoice = InterfaceRepo::interfaceAR($batchInv);

                    // if($resultARInvoice['status'] != 'S'){
                    //     $valid = false;
                    //     $result['msg'] = 'Interface AR Invoice Error: '.($msg ?? $resultARInvoice['message']);
                    // }
                    if($msg = $this->getErrorARCCID($batchInv)){
                        $valid = false;
                        $result['msg'] = ($msg ?? $resultARInvoice['message']);
                    }
                }else {
                    $result['msg'] = $checkCCID['msg'];
                }
            }

        }catch (\Exception $e) {

            $result = [
                'status' => 'E',
                'msg' => $e->getMessage(),
            ];
            return response()->json($result);
        }

        \DB::beginTransaction();

        try {
            if($valid){

                if($club_cig->count()){
                    foreach ($club_cig as $item) {
                        $history = OrderHistory::where('order_header_id', $item->order_header_id)
                        ->where('order_status', 'Invoice')
                        ->where('pick_release_no', $item->pick_release_num)
                        ->first();

                        if($history){
                            $newHistory = $history->replicate();
                            $newHistory->order_status = 'Delivery';
                            $newHistory->close_sale_flag = 'Y';
                            $newHistory->ebs_order_number = $item->ebs_order_number;
                            $newHistory->creation_date = $creation_date;
                            $newHistory->last_update_date = $creation_date;
                            $newHistory->save();
                        }
                    }
                }

                if($club_not_cig->count()){
                    foreach ($club_not_cig as $item) {
                        $history = OrderHistory::where('order_header_id', $item->order_header_id)
                        ->where('order_status', 'Invoice')
                        ->where('pick_release_no', $item->pick_release_no)
                        ->first();

                        if($history){
                            $newHistory = $history->replicate();
                            $newHistory->order_status = 'Delivery';
                            $newHistory->close_sale_flag = 'Y';
                            $newHistory->ebs_order_number = $item->ebs_order_number;
                            $newHistory->creation_date = $creation_date;
                            $newHistory->last_update_date = $creation_date;
                            $newHistory->save();
                        }
                    }
                }

                if($not_club->count()){
                    foreach ($not_club as $item) {
                        $history = OrderHistory::where('order_header_id', $item->order_header_id)
                        ->where('order_status', 'Invoice')
                        ->where('pick_release_no', $item->pick_release_no)
                        ->first();

                        if($history){
                            $newHistory = $history->replicate();
                            $newHistory->order_status = 'Delivery';
                            $newHistory->close_sale_flag = 'Y';
                            $newHistory->ebs_order_number = $item->ebs_order_number;
                            $newHistory->creation_date = $creation_date;
                            $newHistory->last_update_date = $creation_date;
                            $newHistory->save();
                        }
                    }
                }

                $result['status'] = 'S';
                $result['msg'] = '';
                $result['group_id'] = $group_id;

            }else {

                $result['status'] = 'E';
            }
            \DB::commit();

        }catch (\Exception $e) {
            \DB::rollBack();

            $result = [
                'status' => 'E',
                'msg' => $e->getMessage(),
            ];
        }

        return response()->json($result);
    }

    public function processGL(Request $request)
    {
        ini_set('max_execution_time', '7200');

        try {
            $this->orgName = 'การยาสูบแห่งประเทศไทย';
            $hr = HrOperatingUnits::where('name', $this->orgName)->first();
            $this->orgId = $hr->organization_id;

            $date = Carbon::parse($request->document_date);
            $document_no = $request->document_no;
            $creation_date = Carbon::now();
            $requestType = $request->type;

            $valid = true;

            $result = [
                'status' => 'S',
                'msg' => '',
                'group_id' => ''
            ];

            $club_cig = Consignment::whereHas('customer', function($q){
                return $q->whereIn('customer_type_id', [30, 40]);
            })
            ->whereHas('lines', function($q) {
                return $q->whereHas('orderHeader', function($p) {
                    return $p->whereIn('product_type_code', [10]);
                });
            })
            ->when($document_no, function ($p, $document_no){
                return $p->where('consignment_no', $document_no);
            })
            ->whereDate('consignment_date', $date)
            ->whereRaw("upper(consignment_status) = 'CONFIRM'")
            ->whereRaw("
                NOT EXISTS( 
                    SELECT 1
                    FROM RA_CUSTOMER_TRX_ALL    RCT
                        ,RA_BATCH_SOURCES_ALL   RBA 
                    WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                    AND   TRX_NUMBER = PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_NO
                    AND   RCT.ORG_ID = $this->orgId
                    AND   RBA.NAME   = 'ระบบขายในประเทศ'
                )
            ")
            ->get();

            /// club not cigarette
            $club_not_cig = OrderHeader::whereHas('customer', function($q){
                return $q->whereIn('customer_type_id', [30, 40]);
            })
            ->where('product_type_code', '<>', 10)
            ->where('program_code', 'OMP0019')
            ->whereDate('pick_release_approve_date', $date)
            ->when($document_no, function ($p, $document_no){
                return $p->where('pick_release_no', $document_no);
            })
            ->whereRaw("upper(pick_release_status) = 'CONFIRM'")
            ->whereRaw("
                NOT EXISTS( 
                    SELECT 1
                    FROM RA_CUSTOMER_TRX_ALL    RCT
                        ,RA_BATCH_SOURCES_ALL   RBA 
                    WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                    AND   TRX_NUMBER = PTOM_ORDER_HEADERS.PICK_RELEASE_NO
                    AND   RCT.ORG_ID = $this->orgId
                    AND   RBA.NAME   = 'ระบบขายในประเทศ'
                )
            ")
            ->with('customer', 'transactionType', 'lines')
            ->get();

            // not club
            $not_club = OrderHeader::whereHas('customer', function($q){
                return $q->whereNotIn('customer_type_id', [30, 40]);
            })
            ->where('program_code', 'OMP0019')
            ->whereDate('pick_release_approve_date', $date)
            ->when($document_no, function ($p, $document_no){
                return $p->where('pick_release_no', $document_no);
            })
            ->whereRaw("upper(pick_release_status) = 'CONFIRM'")
            ->whereRaw("
                NOT EXISTS( 
                    SELECT 1
                    FROM RA_CUSTOMER_TRX_ALL    RCT
                        ,RA_BATCH_SOURCES_ALL   RBA 
                    WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                    AND   TRX_NUMBER = PTOM_ORDER_HEADERS.PICK_RELEASE_NO
                    AND   RCT.ORG_ID = $this->orgId
                    AND   RBA.NAME   = 'ระบบขายในประเทศ'
                )
            ")
            ->with('customer', 'transactionType', 'lines')
            ->get();

            // rma
            $rma = ClaimHeader::where('program_code', 'OMP0052')
            ->whereDate('rma_date', $date)
            ->when($document_no, function ($p, $document_no){
                return $p->where('credit_note_number', $document_no);
            })  
            ->whereRaw("upper(status_rma) = 'CONFIRM'")
            ->get();

            $credit_note = PtomInvoiceHeader::where('program_code', 'OMP0034')
            ->whereDate('invoice_date', $date)
            ->when($document_no, function ($p, $document_no){
                return $p->where('invoice_headers_number', $document_no);
            }) 
            ->whereRaw("upper(invoice_status) = 'CONFIRM'")
            ->whereRaw("
                NOT EXISTS( 
                    SELECT 1
                    FROM RA_CUSTOMER_TRX_ALL    RCT
                        ,RA_BATCH_SOURCES_ALL   RBA 
                    WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                    AND   TRX_NUMBER = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
                    AND   RCT.ORG_ID = $this->orgId
                    AND   RBA.NAME   = 'ระบบขายในประเทศ'
                )
            ")
            ->where('invoice_amount', '<>', 0)
            ->with('lines.consignment')
            ->get();

            $debit_note = PtomInvoiceHeader::where('program_code', 'OMP0032')
            ->whereDate('invoice_date', $date)
            ->when($document_no, function ($p, $document_no){
                return $p->where('invoice_headers_number', $document_no);
            }) 
            ->whereRaw("upper(invoice_status) = 'CONFIRM'")
            ->whereRaw("
                NOT EXISTS( 
                    SELECT 1
                    FROM RA_CUSTOMER_TRX_ALL    RCT
                        ,RA_BATCH_SOURCES_ALL   RBA 
                    WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                    AND   TRX_NUMBER = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
                    AND   RCT.ORG_ID = $this->orgId
                    AND   RBA.NAME   = 'ระบบขายในประเทศ'
                )
            ")
            ->where('invoice_amount', '<>', 0)
            ->get();

            $credit_other = PtomInvoiceHeader::whereIn('program_code', ['OMP0033', 'OMP0050', 'OMP0052'])
            ->whereDate('invoice_date', $date)
            ->when($document_no, function ($p, $document_no){
                return $p->where('invoice_headers_number', $document_no);
            }) 
            ->whereRaw("upper(invoice_status) = 'CONFIRM'")
            ->whereRaw("
                NOT EXISTS( 
                    SELECT 1
                    FROM RA_CUSTOMER_TRX_ALL    RCT
                        ,RA_BATCH_SOURCES_ALL   RBA 
                    WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                    AND   TRX_NUMBER = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
                    AND   RCT.ORG_ID = $this->orgId
                    AND   RBA.NAME   = 'ระบบขายในประเทศ'
                )
            ")
            ->where('invoice_amount', '<>', 0)
            ->with('lines.consignment')
            ->get();

            $group_id = self::genGroupId($club_cig, $club_not_cig, $not_club, $rma, $credit_note, $debit_note, $credit_other);

            $batchGl = $group_id.'-'.uniqid();

            $resultGLSale = null;

            ////////////  INTERFACE GL ////////////

            $gl_exp = OrderHeader::whereHas('transactionType', function($q){
                return $q->where('op_sample_flag', 'Y');
            })
            ->where('program_code', 'OMP0020')
            ->whereDate('pick_release_approve_date', $date)
            ->when($document_no, function ($p, $document_no){
                return $p->where('pick_release_no', $document_no);
            })
            ->whereRaw("upper(pick_release_status) = 'CONFIRM'")
            ->where(function ($p) {
                return $p->whereNull('close_sale_flag')
                ->orWhereRaw("upper(close_sale_flag) <> 'Y'");
            })
            ->with('customer', 'transactionType', 'lines')
            ->get();

            $gl_sale_order_header = OrderHeader::where(function($q) use($date, $document_no){
                return $q->where(function($p) {
                    return $p->where(function($r) {
                        return $r->whereHas('customer', function($s){
                            return $s->whereNotIn('customer_type_id', [30, 40]);
                        })
                        ->whereIn('product_type_code', ['10']);
                    })
                    ->orWhere(function($r) {
                        return $r->whereIn('product_type_code', ['20']);
                    });
                })
                ->whereDate('pick_release_approve_date', $date)
                ->whereRaw("upper(pick_release_status) = 'CONFIRM'")
                ->where(function ($r) {
                    return $r->whereNull('close_sale_flag')
                    ->orWhereRaw("upper(close_sale_flag) <> 'Y'");
                })
                ->when($document_no, function ($r, $document_no){
                    return $r->where('pick_release_no', $document_no);
                });
            })
            ->whereHas('transactionType', function($q) {
                return $q->where('send_stat_gl', 'Y');
            })
            ->whereHas('lines', function($q){
                return $q->where(function($p){
                    return $p->where('promo_flag', '<>', 'Y')
                    ->orWhereNull('promo_flag');
                });
            })
            ->with([
                'customer', 
                'transactionType',
                'lines' => function ($q) {
                    return $q->where(function($p){
                        return $p->where('promo_flag', '<>', 'Y')
                        ->orWhereNull('promo_flag');
                    });
                }
            ])
            ->get();

            $gl_sale_consignment = Consignment::where(function ($q) {
                return $q->where(function ($p) {
                    return $p->whereNull('close_sale_flag')
                    ->orWhereRaw("upper(close_sale_flag) <> 'Y'");
                })
                ->whereRaw("upper(consignment_status) = 'CONFIRM'");
            })
            ->whereDate('consignment_date', $date)
            ->whereHas('lines', function($q){
                return $q->where(function($p){
                    return $p->where('attribute2', '<>', 'Y')
                    ->orWhereNull('attribute2');
                });
            })
            ->when($document_no, function ($p, $document_no){
                return $p->where('consignment_no', $document_no);
            })
            ->with([
                'customer', 
                'lines' => function ($q) {
                    return $q->where(function($p){
                        return $p->where('attribute2', '<>', 'Y')
                        ->orWhereNull('attribute2');
                    });
                }
            ])
            ->get();

            if($gl_exp->count() && $valid){
                $group_gl_exp = $gl_exp->groupBy('order_type_id');
                $this->insertGLExp($group_gl_exp, $group_id, $batchGl, $creation_date);
            }

            if(($gl_sale_order_header->count() || $gl_sale_consignment->count()) && $valid){
                $this->insertGLSale($gl_sale_order_header, $gl_sale_consignment, $rma, $date, $group_id, $batchGl, $creation_date);
            }

            if($valid && ($gl_sale_order_header->count() || $gl_sale_consignment->count() || $gl_exp->count()) ){

                $checkCCID = $this->checkErrorGLCCID($batchGl);

                $valid = $checkCCID['valid'];

                if($valid){

                    $resultGLSale = InterfaceRepo::interfaceGL($batchGl);
                    if( $msg = $this->getErrorGLCCID($batchGl)){
                        $valid = false;
                        $result['msg'] = ($msg ?? $resultGLSale['message']);
                    }
                }else {
                    $result['msg'] = $checkCCID['msg'];
                }
            }
        
        }catch (\Exception $e) {

            $result = [
                'status' => 'E',
                'msg' => $e->getMessage(),
            ];
            return response()->json($result);
        }

        \DB::beginTransaction();

        try {
            if($valid){

                if($gl_exp->count()){
                    foreach ($gl_exp as $item) {
                        $order = OrderHeader::find($item->order_header_id);
                        $this->updateCloseSaleFlagAndStatus($order);
                    }
                }

                if($gl_sale_order_header->count()){
                    foreach ($gl_sale_order_header as $item) {
                        $order = OrderHeader::find($item->order_header_id);
                        $this->updateCloseSaleFlagAndStatus($order);
                    }
                }

                if($gl_sale_consignment->count()){
                    foreach ($gl_sale_consignment as $item) {
                        $consignment = Consignment::find($item->consignment_header_id);
                        $this->updateCloseSaleFlagAndStatus($consignment);
                    }
                }

                $result['status'] = 'S';
                $result['msg'] = '';
                $result['group_id'] = $group_id;

            }else {

                $result['status'] = 'E';
            }
            \DB::commit();

        }catch (\Exception $e) {
            \DB::rollBack();

            $result = [
                'status' => 'E',
                'msg' => $e->getMessage(),
            ];
        }

        return response()->json($result);
    }

    private function insertInvoiceAR($type, $premium, $item, $header, $group_id, $batch_no, $creation_date, $report = false)
    {
        if($premium->enabled_flag != 'Y'){
            $lines = $type == 'club_cig' ? $item->lines : $item->lines->where('promo_flag', '<>', 'Y');
        }else {
            $lines = $item->lines;
        }

        if($type != 'club_cig'){
            $customer = $header->customer;
            $shipTo = $header->shipTo;
        }
        // dd($item, $lines);

        if($type == 'club_cig'){

            $groupLines = $lines->groupBy('item_code');
            $line_num = 0;
            foreach ($groupLines as $item_code => $lines) {
                
                $average = $lines->sum(function($l){
                    $unit = $l->orderLine ? ($l->orderLine->promo_flag == 'Y' ? 0 : $l->orderLine->unit_price) : 0;
                    return (float)$l->actual_quantity * (float)$unit;
                });
                $line = $lines->first();

                if($type == 'club_cig'){
                    $header = $line->orderHeader;
                    $customer = $header->customer;
                    $shipTo = $header->shipTo;
                }

                $interface = $report ? new ARInterfacesReport : new ARInterface;
                $interface->group_id = $group_id;
                $interface->interface_module = 'AR';
                $interface->from_program_code = 'OMP0038';
                $interface->interface_name = 'WEB OP Sales Invoice';
                $interface->interface_type = 'Invoice';
                $interface->order_header_id = $item->consignment_header_id;
                $interface->org_id = $this->orgId;
                $interface->operating_unit = $this->orgName;
                $interface->batch_source_name = 'ระบบขายในประเทศ';
                $interface->invoice_type = $header->transactionType ? $header->transactionType->receivables_transaction_type : '';
                $interface->invoice_number = $item->consignment_no;
                $interface->invoice_date = $item->consignment_date;
                $interface->gl_date = $item->consignment_date;
    
                $interface->ebs_order_number = $item->ebs_order_number;
                $interface->product_type_code = optional($line->seqEcom)->product_type_code;
                $interface->customer_number = $customer->customer_number;
                $interface->customer_name = $customer->customer_name;
                $interface->bill_to_location = $customer->bill_to_site_name;
                $interface->ship_to_location = $shipTo->ship_to_site_name;
    
                $group_code = $customer->customer_type_id == 30 ? 0 : ($customer->customer_type_id == 40 ? 3 : 0);
                $term = Terms::where('credit_group_code', $group_code)->first();
    
                $interface->term_name = $term->name;
    
                $date = $item->consignment_date;
                $due_date = Carbon::parse($date)->addDays($term->due_days)->format('Y-M-d');
    
                $interface->due_date = $due_date;
                $interface->currency_code = 'THB';
                $interface->conversion_date = date('Y-M-d');
                $interface->conversion_type = 'User';
                $interface->conversion_rate = 1;
                $interface->comments = $line->promo_flag == 'Y' ? 'Promotion' : '';
    
                $interface->invoice_total_with_vat = $item->total_amount;
                $interface->order_line_id = $line->consignment_line_id;
                $interface->line_number = $line_num+1;
    
                $interface->item_code = $line->item_code;
                $interface->description = $line->item_description;
                $interface->uom_name = $line->uom_code ?? $line->attribute1;
                $interface->quantity = $quantity = $lines->sum('actual_quantity');
    
                $price = $line->orderLine ? ($line->orderLine->promo_flag == 'Y' ? 0 : $line->orderLine->unit_price) : 0;
    
                $interface->unit_selling_price = (float)$average / (float)$quantity;
                $interface->amount = $amount = (float)$interface->quantity * (float)$interface->unit_selling_price;
    
                $date_in_range = $item->consignment_date;
    
                $tax_amount = $lines->sum('line_tax_amount');
    
                $interface->tax_amount = $tax_amount;
                $interface->tax_rate = optional($header->transactionType)->tax_rate ?? 0;
                $interface->line_amount = $amount;
    
                $rec_account_code = 'TRX-DOM-Sales Invoice-01';
                $rec = MappingAccountModel::where('account_code', $rec_account_code)->first();
    
                $interface->rec_segment1 = optional($rec)->segment1;
                $interface->rec_segment2 = optional($rec)->segment2;
                $interface->rec_segment3 = optional($rec)->segment3;
                $interface->rec_segment4 = optional($rec)->segment4;
                $interface->rec_segment5 = optional($rec)->segment5;
                $interface->rec_segment6 = optional($rec)->segment6;
                $interface->rec_segment7 = optional($rec)->segment7;
                $interface->rec_segment8 = optional($rec)->segment8;
    
                $tran_type = ARTranTypesV::where('name', optional($header->transactionType)->receivables_transaction_type)->first();

                $interface->rec_segment9 = optional($tran_type)->receivable_account_segment9;
                $interface->rec_segment10 = optional($tran_type)->receivable_account_segment10;
                $interface->rec_segment11 = optional($rec)->segment11;
                $interface->rec_segment12 = optional($rec)->segment12;
                $interface->rec_account_combine = $interface->rec_segment1.'.'.$interface->rec_segment2.'.'.$interface->rec_segment3.'.'.$interface->rec_segment4.'.'
                                                .$interface->rec_segment5.'.'.$interface->rec_segment6.'.'.$interface->rec_segment7.'.'.$interface->rec_segment8.'.'
                                                .$interface->rec_segment9.'.'.$interface->rec_segment10.'.'.$interface->rec_segment11.'.'.$interface->rec_segment12;
    
                $interface->rec_account_id = GlCodeCombinationsKFV::checkCCID($interface->rec_account_combine);

                $rev_account_code = 'TRX-DOM-Sales Invoice-03';
                $rev = MappingAccountModel::where('account_code', $rev_account_code)->first();

                $interface->rev_segment1 = optional($rev)->segment1;
                $interface->rev_segment2 = optional($rev)->segment2;
                $interface->rev_segment3 = optional($rev)->segment3;
                $interface->rev_segment4 = optional($rev)->segment4;
    
                $date_seg5 = Carbon::parse($item->consignment_date);
                $rev_segment5 = self::getBudgetYear($date_seg5);
    
                $interface->rev_segment5 = $rev_segment5;
    
                $tran_type = ARTranTypesV::where('name', optional($header->transactionType)->receivables_transaction_type)->first();
                
                $interface->rev_segment6 = optional($tran_type)->revenue_account_segment6;
                $interface->rev_segment7 = optional($tran_type)->revenue_account_segment7;
                $interface->rev_segment8 = optional($rev)->segment8;
    
                $seq_ecoms = SequenceEcoms::where('item_id', $line->item_id)->first();
    
                $interface->rev_segment9 = optional($seq_ecoms)->main_account_code;
                $interface->rev_segment10 = optional($seq_ecoms)->sub_account_code;
                $interface->rev_segment11 = optional($rev)->segment11;
                $interface->rev_segment12 = optional($rev)->segment12;
                $interface->rev_account_combine = $interface->rev_segment1.'.'.$interface->rev_segment2.'.'.$interface->rev_segment3.'.'.$interface->rev_segment4.'.'
                                                .$interface->rev_segment5.'.'.$interface->rev_segment6.'.'.$interface->rev_segment7.'.'.$interface->rev_segment8.'.'
                                                .$interface->rev_segment9.'.'.$interface->rev_segment10.'.'.$interface->rev_segment11.'.'.$interface->rev_segment12;
    
                $interface->rev_account_id = GlCodeCombinationsKFV::checkCCID($interface->rev_account_combine);

                $taxc = CustomerAgents::where('customer_id', $customer->customer_id)->first();
    
                $interface->taxc_segment1 = optional($taxc)->segment1;
                $interface->taxc_segment2 = optional($taxc)->segment2;
                $interface->taxc_segment3 = optional($taxc)->segment3;
                $interface->taxc_segment4 = optional($taxc)->segment4;
                $interface->taxc_segment5 = optional($taxc)->segment5;
                $interface->taxc_segment6 = optional($taxc)->segment6;
                $interface->taxc_segment7 = optional($taxc)->segment7;
                $interface->taxc_segment8 = optional($taxc)->segment8;
                $interface->taxc_segment9 = optional($taxc)->segment9;
                $interface->taxc_segment10 = optional($taxc)->segment10;
                $interface->taxc_segment11 = optional($taxc)->segment11;
                $interface->taxc_segment12 = optional($taxc)->segment12;
                $interface->tax_account_combine = $interface->taxc_segment1.'.'.$interface->taxc_segment2.'.'.$interface->taxc_segment3.'.'.$interface->taxc_segment4.'.'
                                                .$interface->taxc_segment5.'.'.$interface->taxc_segment6.'.'.$interface->taxc_segment7.'.'.$interface->taxc_segment8.'.'
                                                .$interface->taxc_segment9.'.'.$interface->taxc_segment10.'.'.$interface->taxc_segment11.'.'.$interface->taxc_segment12;
                
                $interface->tax_account_id = GlCodeCombinationsKFV::checkCCID($interface->tax_account_combine);
                $interface->interface_line_attribute1 = $item->consignment_no;
                $interface->interface_line_attribute2 = null;
                $interface->interface_line_attribute3 = null;
    
                $price_list = self::getPriceList($line, $date_in_range);
                $interface->interface_line_attribute4 = $price_list;
    
                $interface->percent = 100;
                $interface->amount_dis = $amount;
    
                $interface->tax_header_amount = $item->vat_amount;
                $interface->pao_header_amount = $header->pao_amount;
                $interface->pao_line_amount = $line->orderLine ? ($line->orderLine->pao_line_amount) : 0;
    
                $interface->program_code = 'OMP0044';
                $interface->web_batch_no = $batch_no;
                $interface->created_by = getDefaultData('/users')->user_id;
                $interface->last_updated_by = getDefaultData('/users')->user_id;
                $interface->creation_date = $creation_date;
    
                if($report){
                    $desc = PtomArDailyAccRptDescV::where('meaning', $interface->from_program_code)->first();
                    $interface->report_description = $desc->description;
                }
    
                $interface->save();
                $line_num++;
            }

        }else {

            $tran_type = ARTranTypesV::where('name', optional($header->transactionType)->receivables_transaction_type)->first();
            $rec_account_code = 'TRX-DOM-Sales Invoice-01';
            $rec = MappingAccountModel::where('account_code', $rec_account_code)->first();
            $rev_account_code = 'TRX-DOM-Sales Invoice-03';
            $rev = MappingAccountModel::where('account_code', $rev_account_code)->first();
            if($type == 'not_club'){
                $taxc = MappingAccountModel::where('account_code', 'TRX-DOM-Sales Invoice-04')->first();
            }else {
                $taxc = CustomerAgents::where('customer_id', $customer->customer_id)->first();
            }
            $from_program_code = 'OMP0019';
            $desc = PtomArDailyAccRptDescV::where('meaning', $from_program_code)->first();

            foreach ($lines as $key => $line) {

                $interface = $report ? new ARInterfacesReport : new ARInterface;
                $interface->group_id = $group_id;
                $interface->interface_module = 'AR';
                $interface->from_program_code = $from_program_code;
                $interface->interface_name = 'WEB OP Sales Invoice';
                $interface->interface_type = 'Invoice';
                $interface->order_header_id = $item->order_header_id;
                $interface->org_id = $this->orgId;
                $interface->operating_unit = $this->orgName;
                $interface->batch_source_name = 'ระบบขายในประเทศ';
                $interface->invoice_type = $header->transactionType ? $header->transactionType->receivables_transaction_type : '';
                $interface->invoice_number = $item->pick_release_no;
                $interface->invoice_date = $item->pick_release_approve_date;
                $interface->gl_date = $item->pick_release_approve_date;
    
                $interface->ebs_order_number = $item->ebs_order_number;
                $interface->product_type_code = optional($line->seqEcom)->product_type_code;
                $interface->customer_number = $customer->customer_number;
                $interface->customer_name = $customer->customer_name;
                $interface->bill_to_location = $customer->bill_to_site_name;
                $interface->ship_to_location = $shipTo->ship_to_site_name;
    
                $group_code = $line->credit_group_code ? $line->credit_group_code : 0;
                $term = Terms::where('credit_group_code', $group_code)->first();
    
                $interface->term_name = $term->name;
    
                $date = $item->pick_release_approve_date;
                $due_date = Carbon::parse($date)->addDays($term->due_days)->format('Y-M-d');
    
                $interface->due_date = $due_date;
                $interface->currency_code = 'THB';
                $interface->conversion_date = date('Y-M-d');
                $interface->conversion_type = 'User';
                $interface->conversion_rate = 1;
                $interface->comments = $line->promo_flag == 'Y' ? 'Promotion' : '';
    
                $interface->invoice_total_with_vat = $header->grand_total;
                $interface->order_line_id = $line->order_line_id;
                $interface->line_number = $key+1;
    
                $interface->item_code = $line->item_code;
                $interface->description = $line->item_description;
                $interface->uom_name = $line->uom_code ?? $line->attribute1;
                $interface->quantity = $quantity = $line->approve_quantity;
    
                $price = $line->unit_price;
    
                $interface->unit_selling_price = $price;
                $interface->amount = $amount = $quantity * $price;
    
                $date_in_range = $item->pick_release_approve_date;
    
                $tax_amount = $line->tax_amount; // $this->calTax($line, $header, $date_in_range, $quantity);
    
                $interface->tax_amount = $tax_amount;
                $interface->tax_rate = optional($header->transactionType)->tax_rate ?? 0;
                $interface->line_amount = $amount;

                $interface->rec_segment1 = optional($rec)->segment1;
                $interface->rec_segment2 = optional($rec)->segment2;
                $interface->rec_segment3 = optional($rec)->segment3;
                $interface->rec_segment4 = optional($rec)->segment4;
                $interface->rec_segment5 = optional($rec)->segment5;
                $interface->rec_segment6 = optional($rec)->segment6;
                $interface->rec_segment7 = optional($rec)->segment7;
                $interface->rec_segment8 = optional($rec)->segment8;
                $interface->rec_segment9 = optional($tran_type)->receivable_account_segment9;
                $interface->rec_segment10 = optional($tran_type)->receivable_account_segment10;
                $interface->rec_segment11 = optional($rec)->segment11;
                $interface->rec_segment12 = optional($rec)->segment12;
                $interface->rec_account_combine = $interface->rec_segment1.'.'.$interface->rec_segment2.'.'.$interface->rec_segment3.'.'.$interface->rec_segment4.'.'
                                                .$interface->rec_segment5.'.'.$interface->rec_segment6.'.'.$interface->rec_segment7.'.'.$interface->rec_segment8.'.'
                                                .$interface->rec_segment9.'.'.$interface->rec_segment10.'.'.$interface->rec_segment11.'.'.$interface->rec_segment12;
    
                $interface->rec_account_id = GlCodeCombinationsKFV::checkCCID($interface->rec_account_combine);

                $interface->rev_segment1 = optional($rev)->segment1;
                $interface->rev_segment2 = optional($rev)->segment2;
                $interface->rev_segment3 = optional($rev)->segment3;
                $interface->rev_segment4 = optional($rev)->segment4;

                $date_seg5 = Carbon::parse($item->pick_release_approve_date);
                $rev_segment5 = self::getBudgetYear($date_seg5);

                $interface->rev_segment5 = $rev_segment5;
                $interface->rev_segment6 = optional($tran_type)->revenue_account_segment6;
                $interface->rev_segment7 = optional($tran_type)->revenue_account_segment7;
                $interface->rev_segment8 = optional($rev)->segment8;
    
                $seq_ecoms = SequenceEcoms::where('item_id', $line->item_id)->first();

                $interface->rev_segment9 = optional($seq_ecoms)->main_account_code;
                $interface->rev_segment10 = optional($seq_ecoms)->sub_account_code;
                $interface->rev_segment11 = optional($rev)->segment11;
                $interface->rev_segment12 = optional($rev)->segment12;
                $interface->rev_account_combine = $interface->rev_segment1.'.'.$interface->rev_segment2.'.'.$interface->rev_segment3.'.'.$interface->rev_segment4.'.'
                                                .$interface->rev_segment5.'.'.$interface->rev_segment6.'.'.$interface->rev_segment7.'.'.$interface->rev_segment8.'.'
                                                .$interface->rev_segment9.'.'.$interface->rev_segment10.'.'.$interface->rev_segment11.'.'.$interface->rev_segment12;
                $interface->rev_account_id = GlCodeCombinationsKFV::checkCCID($interface->rev_account_combine);
    
                $interface->taxc_segment1 = optional($taxc)->segment1;
                $interface->taxc_segment2 = optional($taxc)->segment2;
                $interface->taxc_segment3 = optional($taxc)->segment3;
                $interface->taxc_segment4 = optional($taxc)->segment4;
                $interface->taxc_segment5 = optional($taxc)->segment5;
                $interface->taxc_segment6 = optional($taxc)->segment6;
                $interface->taxc_segment7 = optional($taxc)->segment7;
                $interface->taxc_segment8 = optional($taxc)->segment8;
                $interface->taxc_segment9 = optional($taxc)->segment9;
                $interface->taxc_segment10 = optional($taxc)->segment10;
                $interface->taxc_segment11 = optional($taxc)->segment11;
                $interface->taxc_segment12 = optional($taxc)->segment12;
                $interface->tax_account_combine = $interface->taxc_segment1.'.'.$interface->taxc_segment2.'.'.$interface->taxc_segment3.'.'.$interface->taxc_segment4.'.'
                                                .$interface->taxc_segment5.'.'.$interface->taxc_segment6.'.'.$interface->taxc_segment7.'.'.$interface->taxc_segment8.'.'
                                                .$interface->taxc_segment9.'.'.$interface->taxc_segment10.'.'.$interface->taxc_segment11.'.'.$interface->taxc_segment12;
                
                $interface->tax_account_id = GlCodeCombinationsKFV::checkCCID($interface->tax_account_combine);
                $interface->interface_line_attribute1 = $header->prepare_order_number;
                $interface->interface_line_attribute2 = $line->line_number;
                $interface->interface_line_attribute3 = $header->order_date;
    
                $price_list = self::getPriceList($line, $date_in_range);
                $interface->interface_line_attribute4 = $price_list;
    
                $interface->percent = 100;
                $interface->amount_dis = $amount;
    
                $interface->tax_header_amount = $header->tax;
                $interface->pao_header_amount = $header->pao_amount;
                $interface->pao_line_amount = $line->pao_line_amount;
    
                $interface->program_code = 'OMP0044';
                $interface->web_batch_no = $batch_no;
                $interface->created_by = getDefaultData('/users')->user_id;
                $interface->last_updated_by = getDefaultData('/users')->user_id;
                $interface->creation_date = $creation_date;
    
                if($report){
                    $interface->report_description = $desc->description;
                }
    
                $interface->save();
            }
        }

        return;
    }

    private function insertCreditNote($item, $group_id, $batch_no, $creation_date, $report = false)
    {
        $lines = $item->lines;
        $customer = $item->customer;
        // dd($item, $lines, 'test');
        // $shipTo = $header->shipTo;
        // dd($item, $lines);

        foreach ($lines as $key => $line) {

            $interface = $report ? new ARInterfacesReport : new ARInterface;
            $interface->group_id = $group_id;
            $interface->interface_module = 'AR';
            $interface->from_program_code = 'OMP0034';
            $interface->interface_name = '';
            $interface->interface_type = 'Credit Memo';
            $interface->order_header_id = $item->invoice_headers_id;
            $interface->org_id = $this->orgId;
            $interface->operating_unit = $this->orgName;
            $interface->batch_source_name = 'ระบบขายในประเทศ';

            $transaction_type = optional(optional(optional($line->consignment)->orderHeader)->transactionType)->receivables_transaction_type;

            $tran_type = ARTranTypesV::where('name', $transaction_type)->first();

            $interface->invoice_type = $tran_type->credit_memo_type;
            $interface->invoice_number =  $item->invoice_headers_number;
            $interface->invoice_date = $item->invoice_date;
            $interface->gl_date = $item->invoice_date;

            $interface->product_type_code = optional($line->seqEcom)->product_type_code;
            $interface->customer_number = $customer->customer_number;
            $interface->customer_name = $customer->customer_name;

            $orderHeader = optional($line->consignment)->orderHeader;
            $shipTo = $orderHeader->shipTo;

            $interface->bill_to_location = $customer->bill_to_site_name;
            $interface->ship_to_location = $shipTo->ship_to_site_name;

            // $interface->term_name = 'IMMEDIATE';
            $interface->due_date = $item->invoice_date;
            $interface->currency_code = 'THB';
            $interface->conversion_date = $item->invoice_date;
            $interface->conversion_type = 'User';
            $interface->conversion_rate = 1;
            $interface->reference = $line->consignment->consignment_no;

            $interface->invoice_total_with_vat = $item->invoice_amount;
            $interface->order_line_id = $line->invoice_line_id;
            $interface->line_number = $key+1;

            $interface->description = 'บันทึกลดหนี้เงินโอนไร่';
            $interface->quantity = -1;

            $interface->unit_selling_price = $line->payment_amount;
            $interface->amount = $amount = $interface->quantity * $interface->unit_selling_price;
            $interface->line_amount = $amount;

            $rec_account_code = '13';
            $rec = MappingAccountModel::where('account_code', $rec_account_code)->first();

            $interface->rec_segment1 = $item->cr_segment1 ?? optional($rec)->segment1;
            $interface->rec_segment2 = $item->cr_segment2 ?? optional($rec)->segment2;
            $interface->rec_segment3 = $item->cr_segment3 ?? optional($rec)->segment3;
            $interface->rec_segment4 = $item->cr_segment4 ?? optional($rec)->segment4;
            $interface->rec_segment5 = $item->cr_segment5 ?? optional($rec)->segment5;
            $interface->rec_segment6 = $item->cr_segment6 ?? optional($rec)->segment6;
            $interface->rec_segment7 = $item->cr_segment7 ?? optional($rec)->segment7;
            $interface->rec_segment8 = $item->cr_segment8 ?? optional($rec)->segment8;
            $interface->rec_segment9 = $item->cr_segment9 ?? optional($rec)->segment9;
            $interface->rec_segment10 = $item->cr_segment10 ?? optional($rec)->segment10;
            $interface->rec_segment11 = $item->cr_segment11 ?? optional($rec)->segment11;
            $interface->rec_segment12 = $item->cr_segment12 ?? optional($rec)->segment12;
            $interface->rec_account_combine = $interface->rec_segment1.'.'.$interface->rec_segment2.'.'.$interface->rec_segment3.'.'.$interface->rec_segment4.'.'
                                            .$interface->rec_segment5.'.'.$interface->rec_segment6.'.'.$interface->rec_segment7.'.'.$interface->rec_segment8.'.'
                                            .$interface->rec_segment9.'.'.$interface->rec_segment10.'.'.$interface->rec_segment11.'.'.$interface->rec_segment12;

            $interface->rec_account_id = GlCodeCombinationsKFV::checkCCID($interface->rec_account_combine);
            
            $rev_account_code = '10';
            $rev = MappingAccountModel::where('account_code', $rev_account_code)->first();
            
            $interface->rev_segment1 = $item->dr_segment1 ?? optional($rev)->segment1;
            $interface->rev_segment2 = $item->dr_segment2 ?? optional($rev)->segment2;
            $interface->rev_segment3 = $item->dr_segment3 ?? optional($rev)->segment3;
            $interface->rev_segment4 = $item->dr_segment4 ?? optional($rev)->segment4;
            $interface->rev_segment5 = $item->dr_segment5 ?? optional($rev)->segment5;
            $interface->rev_segment6 = $item->dr_segment6 ?? optional($rev)->segment6;
            $interface->rev_segment7 = $item->dr_segment7 ?? optional($rev)->segment7;
            $interface->rev_segment8 = $item->dr_segment8 ?? optional($rev)->segment8;
            $interface->rev_segment9 = $item->dr_segment9 ?? optional($rev)->segment9;
            $interface->rev_segment10 = $item->dr_segment10 ?? optional($rev)->segment10;
            $interface->rev_segment11 = $item->dr_segment11 ?? optional($rev)->segment11;
            $interface->rev_segment12 = $item->dr_segment12 ?? optional($rev)->segment12;
            $interface->rev_account_combine = $interface->rev_segment1.'.'.$interface->rev_segment2.'.'.$interface->rev_segment3.'.'.$interface->rev_segment4.'.'
                                            .$interface->rev_segment5.'.'.$interface->rev_segment6.'.'.$interface->rev_segment7.'.'.$interface->rev_segment8.'.'
                                            .$interface->rev_segment9.'.'.$interface->rev_segment10.'.'.$interface->rev_segment11.'.'.$interface->rev_segment12;

            $interface->rev_account_id = GlCodeCombinationsKFV::checkCCID($interface->rev_account_combine);
            $interface->interface_line_attribute1 = $line->consignment->consignment_no;
            $interface->interface_line_attribute3 = $line->consignment->consignment_date;
            $interface->percent = 100;
            $interface->amount_dis = $amount;

            $interface->program_code = 'OMP0044';
            $interface->web_batch_no = $batch_no;
            $interface->created_by = getDefaultData('/users')->user_id;
            $interface->last_updated_by = getDefaultData('/users')->user_id;
            $interface->creation_date = $creation_date;

            if($report){
                $desc = PtomArDailyAccRptDescV::where('meaning', $interface->from_program_code)->first();
                $interface->report_description = $desc->description;
            }

            $interface->save();
        }

        return;
    }

    private function insertDebitNote($item, $group_id, $batch_no, $creation_date, $report = false)
    {
        $lines = $item->lines;
        $customer = $item->customer;
        // dd($item, $lines, 'test');
        // $shipTo = $header->shipTo;
        // dd($item, $lines);

        if(!$lines->count()){
            $interface = $report ? new ARInterfacesReport : new ARInterface;
            $interface->group_id = $group_id;
            $interface->interface_module = 'AR';
            $interface->from_program_code = 'OMP0032';
            $interface->interface_name = '';
            $interface->interface_type = 'Debit Memo';
            $interface->order_header_id = $item->invoice_headers_id;
            $interface->org_id = $this->orgId;
            $interface->operating_unit = $this->orgName;
            $interface->batch_source_name = 'ระบบขายในประเทศ';

            $interface->invoice_type = 'เพิ่มหนี้-เบ็ดเตล็ด';
            $interface->invoice_number =  $item->invoice_headers_number;
            $interface->invoice_date = $item->invoice_date;
            $interface->gl_date = $item->invoice_date;

            $interface->product_type_code = null;
            $interface->customer_number = $customer->customer_number;
            $interface->customer_name = $customer->customer_name;

            $ship_site = optional(CustomerShipSites::where('customer_id', $customer->customer_id)->where('status', 'Active')->where('attribute1', 'Y')->first())->ship_to_site_name ?? optional(CustomerShipSites::where('customer_id', $customer->customer_id)->where('status', 'Active')->orderBy('site_no')->first())->ship_to_site_name;

            $interface->bill_to_location = $customer->bill_to_site_name;
            $interface->ship_to_location = $ship_site;

            $interface->term_name = 'IMMEDIATE';

            $interface->due_date = $item->invoice_date;
            $interface->currency_code =  $item->currency ?? 'THB'; // 'THB';
            $interface->conversion_date = $item->invoice_date;
            $interface->conversion_type = 'User';
            $interface->conversion_rate = 1;

            $interface->comments = '';
            $interface->reference = $item->ref_invoice_number;

            $interface->invoice_total_with_vat = $item->invoice_amount;
            $interface->order_line_id = null;
            $interface->line_number = 1;

            $interface->item_code = null;
            $interface->description = $item->dr_segment9 == '219640' ? 'บันทึกลดยอดเจ้าหนี้ค่าบุหรี่' : 'บันทึกเพิ่มหนี้';
            $interface->uom_name = null;
            $interface->quantity = 1;

            $interface->unit_selling_price = $item->invoice_amount;
            $interface->amount = $amount = $interface->quantity * $interface->unit_selling_price;
            $interface->line_amount = $amount;

            $rec = ARInterface::where('invoice_number', $interface->reference)->first();

            $interface->rec_segment1 = $item->dr_segment1 ?? optional($rec)->rec_segment1;
            $interface->rec_segment2 = $item->dr_segment2 ?? optional($rec)->rec_segment2;
            $interface->rec_segment3 = $item->dr_segment3 ?? optional($rec)->rec_segment3;
            $interface->rec_segment4 = $item->dr_segment4 ?? optional($rec)->rec_segment4;
            $interface->rec_segment5 = $item->dr_segment5 ?? optional($rec)->rec_segment5;
            $interface->rec_segment6 = $item->dr_segment6 ?? optional($rec)->rec_segment6;
            $interface->rec_segment7 = $item->dr_segment7 ?? optional($rec)->rec_segment7;
            $interface->rec_segment8 = $item->dr_segment8 ?? optional($rec)->rec_segment8;
            $interface->rec_segment9 = $item->dr_segment9 ?? optional($rec)->rec_segment9;
            $interface->rec_segment10 = $item->dr_segment10 ?? optional($rec)->rec_segment10;
            $interface->rec_segment11 = $item->dr_segment11 ?? optional($rec)->rec_segment11;
            $interface->rec_segment12 = $item->dr_segment12 ?? optional($rec)->rec_segment12;
            $interface->rec_account_combine = $interface->rec_segment1.'.'.$interface->rec_segment2.'.'.$interface->rec_segment3.'.'.$interface->rec_segment4.'.'
                                            .$interface->rec_segment5.'.'.$interface->rec_segment6.'.'.$interface->rec_segment7.'.'.$interface->rec_segment8.'.'
                                            .$interface->rec_segment9.'.'.$interface->rec_segment10.'.'.$interface->rec_segment11.'.'.$interface->rec_segment12;

            $interface->rec_account_id = GlCodeCombinationsKFV::checkCCID($interface->rec_account_combine);
            
            $rev = ARInterface::where('invoice_number', $interface->reference)->first();

            $interface->rev_segment1 = $item->cr_segment1 ?? optional($rev)->rev_segment1;
            $interface->rev_segment2 = $item->cr_segment2 ?? optional($rev)->rev_segment2;
            $interface->rev_segment3 = $item->cr_segment3 ?? optional($rev)->rev_segment3;
            $interface->rev_segment4 = $item->cr_segment4 ?? optional($rev)->rev_segment4;
            $interface->rev_segment5 = $item->cr_segment5 ?? optional($rev)->rev_segment5;
            $interface->rev_segment6 = $item->cr_segment6 ?? optional($rev)->rev_segment6;
            $interface->rev_segment7 = $item->cr_segment7 ?? optional($rev)->rev_segment7;
            $interface->rev_segment8 = $item->cr_segment8 ?? optional($rev)->rev_segment8;
            $interface->rev_segment9 = $item->cr_segment9 ?? optional($rev)->rev_segment9;
            $interface->rev_segment10 = $item->cr_segment10 ?? optional($rev)->rev_segment10;
            $interface->rev_segment11 = $item->cr_segment11 ?? optional($rev)->rev_segment11;
            $interface->rev_segment12 = $item->cr_segment12 ?? optional($rev)->rev_segment12;
            $interface->rev_account_combine = $interface->rev_segment1.'.'.$interface->rev_segment2.'.'.$interface->rev_segment3.'.'.$interface->rev_segment4.'.'
                                            .$interface->rev_segment5.'.'.$interface->rev_segment6.'.'.$interface->rev_segment7.'.'.$interface->rev_segment8.'.'
                                            .$interface->rev_segment9.'.'.$interface->rev_segment10.'.'.$interface->rev_segment11.'.'.$interface->rev_segment12;

            $interface->rev_account_id = GlCodeCombinationsKFV::checkCCID($interface->rev_account_combine);


            $interface->interface_line_attribute1 = null;
            $interface->interface_line_attribute2 = null;
            $interface->interface_line_attribute3 = null;
            $interface->interface_line_attribute4 = null;
            $interface->percent = 100;
            $interface->amount_dis = $amount;

            $interface->program_code = 'OMP0044';
            $interface->web_batch_no = $batch_no;
            $interface->created_by = getDefaultData('/users')->user_id;
            $interface->last_updated_by = getDefaultData('/users')->user_id;
            $interface->creation_date = $creation_date;

            if($report){
                $desc = PtomArDailyAccRptDescV::where('meaning', $interface->from_program_code)->first();
                $interface->report_description = $desc->description;
            }

            $interface->save();
        }

        foreach ($lines as $key => $line) {

            $interface = $report ? new ARInterfacesReport : new ARInterface;
            $interface->group_id = $group_id;
            $interface->interface_module = 'AR';
            $interface->from_program_code = 'OMP0032';
            $interface->interface_name = '';
            $interface->interface_type = 'Debit Memo';
            $interface->order_header_id = $item->invoice_headers_id;
            $interface->org_id = $this->orgId;
            $interface->operating_unit = $this->orgName;
            $interface->batch_source_name = 'ระบบขายในประเทศ';

            $interface->invoice_type = 'เพิ่มหนี้-เบ็ดเตล็ด';
            $interface->invoice_number =  $item->invoice_headers_number;
            $interface->invoice_date = $item->invoice_date;
            $interface->gl_date = $item->invoice_date;

            $interface->product_type_code = optional($line->seqEcom)->product_type_code;
            $interface->customer_number = $customer->customer_number;
            $interface->customer_name = $customer->customer_name;

            $orderHeader = $line->orderHeader;
            $shipTo = $orderHeader->shipTo;

            $interface->bill_to_location = $customer->bill_to_site_name;
            $interface->ship_to_location = $shipTo->ship_to_site_name;

            if( !in_array($customer->customer_type_id, [30, 40])){
                $group_code = $line->credit_group_code ? $line->credit_group_code : 0;
            }else {
                $group_code = $customer->customer_type_id == '30' ? 0 : 3;
            }
            $group_code = $line->credit_group_code ? $line->credit_group_code : 0;
            $term = Terms::where('credit_group_code', $group_code)->first();
            $interface->term_name = $item->ref_invoice_number ? $term->name : 'IMMEDIATE';

            $interface->due_date = $item->invoice_date;
            $interface->currency_code =  $item->currency ?? 'THB'; // 'THB';
            $interface->conversion_date = $item->invoice_date;
            $interface->conversion_type = 'User';
            $interface->conversion_rate = $line->conversion_rate ?? 1;

            $interface->comments = $line->orderLine ? ($line->orderLine->promo_flag == 'Y' ? 'Promotion' : '') : '';
            $interface->reference = $item->ref_invoice_number;

            $interface->invoice_total_with_vat = $item->invoice_amount;
            $interface->order_line_id = $line->invoice_line_id;
            $interface->line_number = $key+1;

            $interface->item_code = $line->item_code;
            $interface->description = $line->item_code ? $line->item_description : ($item->dr_segment9 == '219640' ? 'บันทึกลดยอดเจ้าหนี้ค่าบุหรี่' : 'บันทึกเพิ่มหนี้');
            $interface->uom_name = $line->uom_code;
            $interface->quantity = 1; // $interface->reference ? $line->quantity : 1;

            $interface->unit_selling_price = $interface->reference ? $line->diff_amount : $line->payment_amount;
            $interface->amount = $amount = $interface->quantity * $interface->unit_selling_price;
            $interface->line_amount = $amount;

            $rec = ARInterface::where('invoice_number', $interface->reference)->where('item_code', $line->item_code)->first();

            $interface->rec_segment1 = $item->dr_segment1 ?? optional($rec)->rec_segment1;
            $interface->rec_segment2 = $item->dr_segment2 ?? optional($rec)->rec_segment2;
            $interface->rec_segment3 = $item->dr_segment3 ?? optional($rec)->rec_segment3;
            $interface->rec_segment4 = $item->dr_segment4 ?? optional($rec)->rec_segment4;
            $interface->rec_segment5 = $item->dr_segment5 ?? optional($rec)->rec_segment5;
            $interface->rec_segment6 = $item->dr_segment6 ?? optional($rec)->rec_segment6;
            $interface->rec_segment7 = $item->dr_segment7 ?? optional($rec)->rec_segment7;
            $interface->rec_segment8 = $item->dr_segment8 ?? optional($rec)->rec_segment8;
            $interface->rec_segment9 = $item->dr_segment9 ?? optional($rec)->rec_segment9;
            $interface->rec_segment10 = $item->dr_segment10 ?? optional($rec)->rec_segment10;
            $interface->rec_segment11 = $item->dr_segment11 ?? optional($rec)->rec_segment11;
            $interface->rec_segment12 = $item->dr_segment12 ?? optional($rec)->rec_segment12;
            $interface->rec_account_combine = $interface->rec_segment1.'.'.$interface->rec_segment2.'.'.$interface->rec_segment3.'.'.$interface->rec_segment4.'.'
                                            .$interface->rec_segment5.'.'.$interface->rec_segment6.'.'.$interface->rec_segment7.'.'.$interface->rec_segment8.'.'
                                            .$interface->rec_segment9.'.'.$interface->rec_segment10.'.'.$interface->rec_segment11.'.'.$interface->rec_segment12;

            $interface->rec_account_id = GlCodeCombinationsKFV::checkCCID($interface->rec_account_combine);
            
            $rev = ARInterface::where('invoice_number', $interface->reference)->where('item_code', $line->item_code)->first();
            
            $interface->rev_segment1 = $item->cr_segment1 ?? optional($rev)->rev_segment1;
            $interface->rev_segment2 = $item->cr_segment2 ?? optional($rev)->rev_segment2;
            $interface->rev_segment3 = $item->cr_segment3 ?? optional($rev)->rev_segment3;
            $interface->rev_segment4 = $item->cr_segment4 ?? optional($rev)->rev_segment4;
            $interface->rev_segment5 = $item->cr_segment5 ?? optional($rev)->rev_segment5;
            $interface->rev_segment6 = $item->cr_segment6 ?? optional($rev)->rev_segment6;
            $interface->rev_segment7 = $item->cr_segment7 ?? optional($rev)->rev_segment7;
            $interface->rev_segment8 = $item->cr_segment8 ?? optional($rev)->rev_segment8;
            $interface->rev_segment9 = $item->cr_segment9 ?? optional($rev)->rev_segment9;
            $interface->rev_segment10 = $item->cr_segment10 ?? optional($rev)->rev_segment10;
            $interface->rev_segment11 = $item->cr_segment11 ?? optional($rev)->rev_segment11;
            $interface->rev_segment12 = $item->cr_segment12 ?? optional($rev)->rev_segment12;
            $interface->rev_account_combine = $interface->rev_segment1.'.'.$interface->rev_segment2.'.'.$interface->rev_segment3.'.'.$interface->rev_segment4.'.'
                                            .$interface->rev_segment5.'.'.$interface->rev_segment6.'.'.$interface->rev_segment7.'.'.$interface->rev_segment8.'.'
                                            .$interface->rev_segment9.'.'.$interface->rev_segment10.'.'.$interface->rev_segment11.'.'.$interface->rev_segment12;

            $interface->rev_account_id = GlCodeCombinationsKFV::checkCCID($interface->rev_account_combine);
            $document = null;
            $document_line = null;
            if( !in_array($customer->customer_type_id, [30, 40])){
                $document = $line->orderHeader;
                $document_line = $line->orderLine;
            }

            $interface->interface_line_attribute1 = $interface->reference ? ($document ? $document->prepare_order_number : null) : null;
            $interface->interface_line_attribute2 = $interface->reference ? ($document_line ? $document_line->line_number : null) : null;
            $interface->interface_line_attribute3 = $interface->reference ? ($document ? $document->order_date : null) : null;

            $date_in_range = $document->order_date;
            $price_list = self::getPriceList($line, $date_in_range);
            $interface->interface_line_attribute4 = $price_list;
            $interface->percent = 100;
            $interface->amount_dis = $amount;

            $interface->program_code = 'OMP0044';
            $interface->web_batch_no = $batch_no;
            $interface->created_by = getDefaultData('/users')->user_id;
            $interface->last_updated_by = getDefaultData('/users')->user_id;
            $interface->creation_date = $creation_date;

            if($report){
                $desc = PtomArDailyAccRptDescV::where('meaning', $interface->from_program_code)->first();
                $interface->report_description = $desc->description;
            }

            $interface->save();
        }

        return;
    }

    private function insertCreditOther($item, $group_id, $batch_no, $creation_date, $report = false)
    {
        $lines = $item->lines;
        $customer = $item->customer;
        // dd($item, $lines, 'test');
        // $shipTo = $header->shipTo;
        // dd($item, $lines);

        if(!$lines->count()){
            $interface = $report ? new ARInterfacesReport : new ARInterface;
            $interface->group_id = $group_id;
            $interface->interface_module = 'AR';
            $interface->from_program_code = $item->program_code;
            $interface->interface_name = '';
            $interface->interface_type = 'Credit Memo';
            $interface->order_header_id = $item->invoice_headers_id;
            $interface->org_id = $this->orgId;
            $interface->operating_unit = $this->orgName;
            $interface->batch_source_name = 'ระบบขายในประเทศ';

            $interface->invoice_type = 'Credit Memo';
            $interface->invoice_number =  $item->invoice_headers_number;
            $interface->invoice_date = $item->invoice_date;
            $interface->gl_date = $item->invoice_date;

            $interface->product_type_code = null;
            $interface->customer_number = $customer->customer_number;
            $interface->customer_name = $customer->customer_name;

            $ship_site = optional(CustomerShipSites::where('customer_id', $customer->customer_id)->where('status', 'Active')->where('attribute1', 'Y')->first())->ship_to_site_name ?? optional(CustomerShipSites::where('customer_id', $customer->customer_id)->where('status', 'Active')->orderBy('site_no')->first())->ship_to_site_name;

            $interface->bill_to_location = $customer->bill_to_site_name;
            $interface->ship_to_location = $ship_site;

            $interface->term_name = null;

            $interface->due_date = $item->invoice_date;
            $interface->currency_code =  $item->currency ?? 'THB'; // 'THB';
            $interface->conversion_date = $item->invoice_date;
            $interface->conversion_type = 'User';
            $interface->conversion_rate = 1;

            $interface->comments = '';
            $interface->reference = null;

            $interface->invoice_total_with_vat = $item->invoice_amount;
            $interface->order_line_id = null;
            $interface->line_number = 1;

            $interface->item_code = null;
            $interface->description = 'บันทึกลดหนี้';
            $interface->uom_name = null;
            $interface->quantity = -1;

            $interface->unit_selling_price = $item->invoice_amount;
            $interface->amount = $amount = $interface->quantity * $interface->unit_selling_price;
            $interface->line_amount = $amount;

            $rec = MappingAccountModel::where('account_code', '07')->first();

            $interface->rec_segment1 = ($item->cr_segment1 ?? optional($rec)->segment1);
            $interface->rec_segment2 = ($item->cr_segment2 ?? optional($rec)->segment2);
            $interface->rec_segment3 = ($item->cr_segment3 ?? optional($rec)->segment3);
            $interface->rec_segment4 = ($item->cr_segment4 ?? optional($rec)->segment4);
            $interface->rec_segment5 = ($item->cr_segment5 ?? optional($rec)->segment5);
            $interface->rec_segment6 = ($item->cr_segment6 ?? optional($rec)->segment6);
            $interface->rec_segment7 = ($item->cr_segment7 ?? optional($rec)->segment7);
            $interface->rec_segment8 = ($item->cr_segment8 ?? optional($rec)->segment8);
            $interface->rec_segment9 = ($item->cr_segment9 ?? optional($rec)->segment9);
            $interface->rec_segment10 = ($item->cr_segment10 ?? optional($rec)->segment10);
            $interface->rec_segment11 = ($item->cr_segment11 ?? optional($rec)->segment11);
            $interface->rec_segment12 = ($item->cr_segment12 ?? optional($rec)->segment12);
            $interface->rec_account_combine = $interface->rec_segment1.'.'.$interface->rec_segment2.'.'.$interface->rec_segment3.'.'.$interface->rec_segment4.'.'
                                            .$interface->rec_segment5.'.'.$interface->rec_segment6.'.'.$interface->rec_segment7.'.'.$interface->rec_segment8.'.'
                                            .$interface->rec_segment9.'.'.$interface->rec_segment10.'.'.$interface->rec_segment11.'.'.$interface->rec_segment12;

            $interface->rec_account_id = GlCodeCombinationsKFV::checkCCID($interface->rec_account_combine);

            $interface->rev_segment1 = $item->dr_segment1;
            $interface->rev_segment2 = $item->dr_segment2;
            $interface->rev_segment3 = $item->dr_segment3;
            $interface->rev_segment4 = $item->dr_segment4;
            $interface->rev_segment5 = $item->dr_segment5;
            $interface->rev_segment6 = $item->dr_segment6;
            $interface->rev_segment7 = $item->dr_segment7;
            $interface->rev_segment8 = $item->dr_segment8;
            $interface->rev_segment9 = $item->dr_segment9;
            $interface->rev_segment10 = $item->dr_segment10;
            $interface->rev_segment11 = $item->dr_segment11;
            $interface->rev_segment12 = $item->dr_segment12;
            $interface->rev_account_combine = $interface->rev_segment1.'.'.$interface->rev_segment2.'.'.$interface->rev_segment3.'.'.$interface->rev_segment4.'.'
                                            .$interface->rev_segment5.'.'.$interface->rev_segment6.'.'.$interface->rev_segment7.'.'.$interface->rev_segment8.'.'
                                            .$interface->rev_segment9.'.'.$interface->rev_segment10.'.'.$interface->rev_segment11.'.'.$interface->rev_segment12;

            $interface->rev_account_id = GlCodeCombinationsKFV::checkCCID($interface->rev_account_combine);

            $interface->interface_line_attribute1 = null;
            $interface->interface_line_attribute2 = null;
            $interface->interface_line_attribute3 = null;
            $interface->interface_line_attribute4 = null;
            $interface->percent = 100;
            $interface->amount_dis = $amount;

            $interface->tax_header_amount = $item->total_vat_amount;
            $interface->pao_header_amount = $item->pao_amount;

            $interface->program_code = 'OMP0044';
            $interface->web_batch_no = $batch_no;
            $interface->created_by = getDefaultData('/users')->user_id;
            $interface->last_updated_by = getDefaultData('/users')->user_id;
            $interface->creation_date = $creation_date;

            if($report){
                $desc = PtomArDailyAccRptDescV::where('meaning', $interface->from_program_code)->first();
                $interface->report_description = $desc->description;
            }

            $interface->save();
        }

        foreach ($lines as $key => $line) {

            $ref_invoice = $line->ref_invoice_number;
            if( in_array($customer->customer_type_id, ['30', '40']) && $line->seqEcom->product_type_code == '10' ){
                $consignment = $line->consignment;
                $orderHeader = $consignment->orderHeader;
                $refConsignment = Consignment::where('consignment_no', $ref_invoice)->first();
                $refOrderHeader = $refConsignment->orderHeader;
                $transaction_type = $refOrderHeader->transactionType->receivables_transaction_type;
                $refBillTo = $refOrderHeader->billTo;
                $refShipTo = $refOrderHeader->shipTo;
                $tran_type = ARTranTypesV::where('name', $transaction_type)->first();
            }else {
                $orderHeader = $line->orderHeader;
                $refOrderHeader = OrderHeader::where('pick_release_no', $ref_invoice)->first();
                $transaction_type = $refOrderHeader->transactionType->receivables_transaction_type;
                $refBillTo = $refOrderHeader->billTo;
                $refShipTo = $refOrderHeader->shipTo;
                $tran_type = ARTranTypesV::where('name', $transaction_type)->first();
            }

            $interface = $report ? new ARInterfacesReport : new ARInterface;
            $interface->group_id = $group_id;
            $interface->interface_module = 'AR';
            $interface->from_program_code = $item->program_code;
            $interface->interface_name = '';
            $interface->interface_type = 'Credit Memo';
            $interface->order_header_id = $item->invoice_headers_id;
            $interface->org_id = $this->orgId;
            $interface->operating_unit = $this->orgName;
            $interface->batch_source_name = 'ระบบขายในประเทศ';

            $interface->invoice_type = $tran_type->credit_memo_type;
            $interface->invoice_number =  $item->invoice_headers_number;
            $interface->invoice_date = $item->invoice_date;
            $interface->gl_date = $item->invoice_date;

            $interface->ebs_order_number = optional($item->rma)->ebs_order_number;
            $interface->product_type_code = optional($line->seqEcom)->product_type_code;
            $interface->customer_number = $customer->customer_number;
            $interface->customer_name = $customer->customer_name;

            if( in_array($line->program_code, ['OMP0033', 'OMP0073', 'OMP0077', 'OMP0082', 'OMP0084']) ){
                $term = $item->term;
            }else {
                if( !in_array($customer->customer_type_id, [30, 40]) ){
                    $group_code = $line->seqEcom->product_type_code == '10' ? 3 : 0;
                }else {
                    $group_code = $line->credit_group_code ? $line->credit_group_code : 0;
                }
                $term = Terms::where('credit_group_code', $group_code)->first();
            }
            
            // $interface->term_name = $term ? $term->name : '';
            $interface->due_date = $item->invoice_date;
            $interface->currency_code = $item->currency ?? 'THB';
            $interface->conversion_date = $item->invoice_date;
            $interface->conversion_type = 'User';
            $interface->conversion_rate = 1;
            $interface->reference = $ref_invoice;

            $interface->bill_to_location = $refBillTo->bill_to_site_name;
            $interface->ship_to_location = $refShipTo->ship_to_site_name;

            $interface->invoice_total_with_vat = (-1) * $item->invoice_amount;
            $interface->order_line_id = $line->invoice_line_id;
            $interface->line_number = $key+1;

            $interface->item_code = $line->item_code;
            $interface->description = $line->item_code ? $line->item_description : 'บันทึกลดหนี้';
            $interface->uom_name = $line->uom_code;
            $interface->quantity = $quantity = in_array($line->program_code, ['OMP0033', 'OMP0077']) ? -1 : -1 * $line->quantity;

            if(in_array($line->program_code, ['OMP0033', 'OMP0077'])){
                $unit = $line->payment_amount;
            }else {
                $refLine = $refOrderHeader->lines()->where('item_code', $interface->item_code)->first();
                $unit = optional($refLine)->unit_price;
            }
            $interface->unit_selling_price = $unit;
            $interface->amount = $amount = $interface->quantity * $interface->unit_selling_price;

            if(!in_array($line->program_code, ['OMP0033'])){
                $date_in_range = $refOrderHeader->consignment_date ? $item->consignment_date : $item->pick_release_approve_date;
                $tax_amount = $line->line_tax_amount;
            
                $interface->tax_amount = $tax_amount;
                $interface->tax_rate = optional($refOrderHeader->transactionType)->tax_rate ?? 0;
            }
            $interface->line_amount = $amount;

            $rec = MappingAccountModel::where('account_code', '07')->first();

            $interface->rec_segment1 = ($item->cr_segment1 ?? optional($rec)->segment1);
            $interface->rec_segment2 = ($item->cr_segment2 ?? optional($rec)->segment2);
            $interface->rec_segment3 = ($item->cr_segment3 ?? optional($rec)->segment3);
            $interface->rec_segment4 = ($item->cr_segment4 ?? optional($rec)->segment4);
            $interface->rec_segment5 = ($item->cr_segment5 ?? optional($rec)->segment5);
            $interface->rec_segment6 = ($item->cr_segment6 ?? optional($rec)->segment6);
            $interface->rec_segment7 = ($item->cr_segment7 ?? optional($rec)->segment7);
            $interface->rec_segment8 = ($item->cr_segment8 ?? optional($rec)->segment8);
            $interface->rec_segment9 = ($item->cr_segment9 ?? optional($rec)->segment9);
            $interface->rec_segment10 = ($item->cr_segment10 ?? optional($rec)->segment10);
            $interface->rec_segment11 = ($item->cr_segment11 ?? optional($rec)->segment11);
            $interface->rec_segment12 = ($item->cr_segment12 ?? optional($rec)->segment12);
            $interface->rec_account_combine = $interface->rec_segment1.'.'.$interface->rec_segment2.'.'.$interface->rec_segment3.'.'.$interface->rec_segment4.'.'
                                            .$interface->rec_segment5.'.'.$interface->rec_segment6.'.'.$interface->rec_segment7.'.'.$interface->rec_segment8.'.'
                                            .$interface->rec_segment9.'.'.$interface->rec_segment10.'.'.$interface->rec_segment11.'.'.$interface->rec_segment12;
            
            $interface->rec_account_id = GlCodeCombinationsKFV::checkCCID($interface->rec_account_combine);
            $rev = ARInterface::where('invoice_number', $interface->reference)->where('item_code', $interface->item_code)->first();
            
            $interface->rev_segment1 = $item->dr_segment1 ?? optional($rev)->rev_segment1;
            $interface->rev_segment2 = $item->dr_segment2 ?? optional($rev)->rev_segment2;
            $interface->rev_segment3 = $item->dr_segment3 ?? optional($rev)->rev_segment3;
            $interface->rev_segment4 = $item->dr_segment4 ?? optional($rev)->rev_segment4;
            $interface->rev_segment5 = $item->dr_segment5 ?? optional($rev)->rev_segment5;
            $interface->rev_segment6 = $item->dr_segment6 ?? optional($rev)->rev_segment6;
            $interface->rev_segment7 = $item->dr_segment7 ?? optional($rev)->rev_segment7;
            $interface->rev_segment8 = $item->dr_segment8 ?? optional($rev)->rev_segment8;
            $interface->rev_segment9 = $item->dr_segment9 ?? optional($rev)->rev_segment9;
            $interface->rev_segment10 = $item->dr_segment10 ?? optional($rev)->rev_segment10;
            $interface->rev_segment11 = $item->dr_segment11 ?? optional($rev)->rev_segment11;
            $interface->rev_segment12 = $item->dr_segment12 ?? optional($rev)->rev_segment12;
            $interface->rev_account_combine = $interface->rev_segment1.'.'.$interface->rev_segment2.'.'.$interface->rev_segment3.'.'.$interface->rev_segment4.'.'
                                            .$interface->rev_segment5.'.'.$interface->rev_segment6.'.'.$interface->rev_segment7.'.'.$interface->rev_segment8.'.'
                                            .$interface->rev_segment9.'.'.$interface->rev_segment10.'.'.$interface->rev_segment11.'.'.$interface->rev_segment12;

            $interface->rev_account_id = GlCodeCombinationsKFV::checkCCID($interface->rev_account_combine);
            
            if(!in_array($line->program_code, ['OMP0033'])){

                $tax = ARInterface::where('invoice_number', $interface->reference)->where('item_code', $interface->item_code)->first();

                $interface->taxc_segment1 = optional($tax)->taxc_segment1;
                $interface->taxc_segment2 = optional($tax)->taxc_segment2;
                $interface->taxc_segment3 = optional($tax)->taxc_segment3;
                $interface->taxc_segment4 = optional($tax)->taxc_segment4;
                $interface->taxc_segment5 = optional($tax)->taxc_segment5;
                $interface->taxc_segment6 = optional($tax)->taxc_segment6;
                $interface->taxc_segment7 = optional($tax)->taxc_segment7;
                $interface->taxc_segment8 = optional($tax)->taxc_segment8;
                $interface->taxc_segment9 = optional($tax)->taxc_segment9;
                $interface->taxc_segment10 = optional($tax)->taxc_segment10;
                $interface->taxc_segment11 = optional($tax)->taxc_segment11;
                $interface->taxc_segment12 = optional($tax)->taxc_segment12;
                $interface->tax_account_combine = $interface->taxc_segment1.'.'.$interface->taxc_segment2.'.'.$interface->taxc_segment3.'.'.$interface->taxc_segment4.'.'
                                                .$interface->taxc_segment5.'.'.$interface->taxc_segment6.'.'.$interface->taxc_segment7.'.'.$interface->taxc_segment8.'.'
                                                .$interface->taxc_segment9.'.'.$interface->taxc_segment10.'.'.$interface->taxc_segment11.'.'.$interface->taxc_segment12;
                
                $interface->tax_account_id = GlCodeCombinationsKFV::checkCCID($interface->tax_account_combine);
            }
            if( in_array($line->program_code, ['OMP0033']) ){
                if( !in_array($customer->customer_type_id, [30, 40]) ){
                    $attr1 = $line->consignment->consignment_no;
                }else {
                    $attr1 = $line->orderHeader->prepare_order_number;
                }
            }elseif( in_array($line->program_code, ['OMP0050']) ){
                $attr1 = $line->orderHeader->prepare_order_number;
            }elseif( in_array($line->program_code, ['OMP0052']) ){
                $attr1 = $line->claimHeader->rma_number;
            }else {
                $attr1 = '';
            }

            $interface->interface_line_attribute1 = $attr1;

            if( in_array($line->program_code, ['OMP0033']) ){
                $attr2 = '';
            }elseif( in_array($line->program_code, ['OMP0050']) ){
                if( in_array($customer->customer_type_id, [30, 40]) && $line->seqEcom->product_type_code == '10' ){
                    $attr2 = '';
                }else {
                    $attr2 = $line->orderLine->line_number;
                }
            }elseif( in_array($line->program_code, ['OMP0052']) ){
                $attr2 = $line->claimHeader->rma_line_no;
            }else {
                $attr2 = '';
            }

            $interface->interface_line_attribute2 = $attr2;

            if( in_array($line->program_code, ['OMP0033']) ){
                
                if( in_array($customer->customer_type_id, [30, 40]) && $line->seqEcom->product_type_code == '10' ){
                    $attr3 = $line->consignment->consignment_date;
                }else {
                    $attr3 =  $line->orderHeader->order_date;
                }
            }elseif( in_array($line->program_code, ['OMP0050']) ){
                $attr3 = $line->orderHeader->order_date;
            }elseif( in_array($line->program_code, ['OMP0052']) ){
                $attr3 = $line->claimHeader->rma_date;
            }else {
                $attr3 = '';
            }

            $interface->interface_line_attribute3 = $attr3;

            if( in_array($line->program_code, ['OMP0052']) ){
                $attr4 = optional(optional($line->claimLine)->orderLine)->attribute1;
            }else {
                $attr4 = '';
            }

            $interface->interface_line_attribute4 = $attr4;
            $interface->percent = 100;
            $interface->amount_dis = $amount;

            $interface->tax_header_amount = $item->total_vat_amount;
            $interface->pao_header_amount = $item->pao_amount;
            $interface->pao_line_amount = $line->pao_line_amount;

            $interface->program_code = 'OMP0044';
            $interface->web_batch_no = $batch_no;
            $interface->created_by = getDefaultData('/users')->user_id;
            $interface->last_updated_by = getDefaultData('/users')->user_id;
            $interface->creation_date = $creation_date;

            if($report){
                $desc = PtomArDailyAccRptDescV::where('meaning', $interface->from_program_code)->first();
                $interface->report_description = $desc->description;
            }

            $interface->save();
        }

        return;
    }

    private function insertGLExp($group, $group_id, $batch_no, $creation_date, $report = false)
    {
        foreach ($group as $key => $items) {
            
            $header = $items->first();
            $date = Carbon::parse($header->pick_release_approve_date);
            $amount = $items->sum('tax');
            $tran_type = TransactionTypeAllV::where('order_type_id', $key)->first();

            $dr = $report ? new GLInterfacesReport : new GLInterfaceModel;
            $dr->group_id = $group_id;
            $dr->interface_module = 'GL';
            $dr->org_id = $this->orgId;
            $dr->ledger_name = 'การยาสูบแห่งประเทศไทย';
            $dr->accounting_date = $date;
            $dr->period_name = $date->format('M-y');
            $dr->currency_code = 'THB';
            $dr->actual_flag = 'A';
            $dr->user_je_category_name = 'WEB OP Sample';
            $dr->user_je_source_name = 'WEB ระบบขาย';
            $dr->batch_name = 'บุหรี่ตัวอย่าง';
            $dr->journal_name = 'บันทึก'.optional($tran_type)->description;
            $dr->journal_description_head = 'บันทึกตัวอย่างบุหรี่เป็น'.optional($tran_type)->description.'สำหรับวันที่ '.date('d-M-Y', strtotime($date));

            $drMap = MappingAccountModel::where('account_code', 'TRX-DOM-Sales Invoice-17')->first();
            $map = MappingAccountModel::where('account_code', 'TRX-DOM-Sales Expense-01')->first();
            $dr->je_line_num = '1';
            $dr->segment1 = optional($drMap)->segment1; // $tran_type->cogs_account_segment1;
            $dr->segment2 = optional($drMap)->segment2; // $tran_type->cogs_account_segment2;
            $dr->segment3 = optional($drMap)->segment3 ?? optional($tran_type)->cogs_account_segment3; // $tran_type->cogs_account_segment3;
            $dr->segment4 = optional($drMap)->segment4 ?? optional($tran_type)->cogs_account_segment4; // $tran_type->cogs_account_segment4;
            $dr->segment5 = optional($drMap)->segment5 ?? self::getBudgetYear($date);
            $dr->segment6 = optional($drMap)->segment6; // $tran_type->cogs_account_segment6;
            $dr->segment7 = optional($drMap)->segment7; // $tran_type->cogs_account_segment7;
            $dr->segment8 = optional($drMap)->segment8; // $tran_type->cogs_account_segment8;
            $dr->segment9 = optional($tran_type)->cogs_account_segment9;
            $dr->segment10 = $header->program_code == 'OMP0020' ? optional($tran_type)->cogs_account_segment10 : optional($map)->segment10;
            $dr->segment11 = optional($drMap)->segment11; // $tran_type->cogs_account_segment11;
            $dr->segment12 = optional($drMap)->segment12; // $tran_type->cogs_account_segment12;
            
            $dr_account_combine = $dr->segment1.'.'.$dr->segment2.'.'.$dr->segment3.'.'.$dr->segment4.'.'
                .$dr->segment5.'.'.$dr->segment6.'.'.$dr->segment7.'.'.$dr->segment8.'.'
                .$dr->segment9.'.'.$dr->segment10.'.'.$dr->segment11.'.'.$dr->segment12;

            $dr->code_combination_id = GlCodeCombinationsKFV::checkCCID($dr_account_combine);

            $dr->entered_dr = $amount;
            $dr->entered_cr = '';
            $dr->accounted_dr = $dr->entered_dr;
            $dr->accounted_cr = $dr->entered_cr;
            $dr->journal_description_line = 'Journal Import Created';

            $dr->program_code = 'OMP0044';
            $dr->web_batch_no = $batch_no;
            $dr->created_by = getDefaultData('/users')->user_id;
            $dr->last_updated_by = getDefaultData('/users')->user_id;
            $dr->creation_date = $creation_date;

            $dr->save();

            $line_attr2 = '';
            $line_attr3 = 0;
            foreach ($items as $item){
                $line_attr2 = $line_attr2 == '' ? $item->pick_release_no : $line_attr2.'|'.$item->pick_release_no;
                $cal_attr3 = 0;
                foreach($item->lines as $line){
                    $cal_attr3 += $line->attribute1 * $line->approve_quantity;
                }
                $line_attr3 += $cal_attr3 - $item->tax;
            }

            $cr = $report ? new GLInterfacesReport : new GLInterfaceModel;
            $cr->group_id = $group_id;
            $cr->interface_module = 'GL';
            $cr->org_id = $this->orgId;
            $cr->ledger_name = 'การยาสูบแห่งประเทศไทย';
            $cr->accounting_date = $date;
            $cr->period_name = $date->format('M-y');
            $cr->currency_code = 'THB';
            $cr->actual_flag = 'A';
            $cr->user_je_category_name = 'WEB OP Sample';
            $cr->user_je_source_name = 'WEB ระบบขาย';
            $cr->batch_name = 'บุหรี่ตัวอย่าง';
            $cr->journal_name = 'บันทึก'.optional($tran_type)->description;
            $cr->journal_description_head = 'บันทึกตัวอย่างบุหรี่เป็น'.optional($tran_type)->description.'สำหรับวันที่ '.date('d-M-Y', strtotime($date));

            $map = MappingAccountModel::where('account_code', 'TRX-DOM-Sales Invoice-04')->first();
            $cr->je_line_num = '2';
            $cr->segment1 = optional($map)->segment1;
            $cr->segment2 = optional($map)->segment2;
            $cr->segment3 = optional($map)->segment3;
            $cr->segment4 = optional($map)->segment4;
            $cr->segment5 = optional($map)->segment5;
            $cr->segment6 = optional($map)->segment6;
            $cr->segment7 = optional($map)->segment7;
            $cr->segment8 = optional($map)->segment8;
            $cr->segment9 = optional($map)->segment9;
            $cr->segment10 = optional($map)->segment10;
            $cr->segment11 = optional($map)->segment11;
            $cr->segment12 = optional($map)->segment12;

            $cr_account_combine = $cr->segment1.'.'.$cr->segment2.'.'.$cr->segment3.'.'.$cr->segment4.'.'
                .$cr->segment5.'.'.$cr->segment6.'.'.$cr->segment7.'.'.$cr->segment8.'.'
                .$cr->segment9.'.'.$cr->segment10.'.'.$cr->segment11.'.'.$cr->segment12;

            $cr->code_combination_id = GlCodeCombinationsKFV::checkCCID($cr_account_combine);

            $cr->entered_dr = '';
            $cr->entered_cr = $amount;
            $cr->accounted_dr = $cr->entered_dr;
            $cr->accounted_cr = $cr->entered_cr;
            $cr->journal_description_line = 'Journal Import Created';

            $cr->line_attribute1 = '07';
            $cr->line_attribute2 = $line_attr2;
            $cr->line_attribute3 = round($line_attr3, 2);
            $cr->line_attribute4 = 7;
            $cr->line_attribute5 = 'SVAT-G7';

            $cr->program_code = 'OMP0044';
            $cr->web_batch_no = $batch_no;
            $cr->created_by = getDefaultData('/users')->user_id;
            $cr->last_updated_by = getDefaultData('/users')->user_id;
            $cr->creation_date = $creation_date;

            $cr->save();
        }
        
        return;
    }

    private function insertGLSale($order_headers = [], $consignments = [], $rma = [], $request_date, $group_id, $batch_no, $creation_date, $report = false)
    {
        $base_uom = DB::table('ptom_uom_v')->where('base_uom_cbb_l', 'Y')->first();
        $datas = [];
        foreach ($order_headers as $item){
            $lines = null;
            if($item->product_type_code == '10'){
                $customer = $item->customer;
                if( !in_array($customer->customer_type_id, ['30', '40']) ){  // PTOM_CONSIGNMENT_LINES.ACTUAL_QUANTITY
                    $lines = $item->lines;
                    foreach ($lines as $line) {
                        if(!array_key_exists($line->item_id, $datas)){
                            $datas[$line->item_id]['qty'] = (float)convertUom($line->item_id, $line->approve_quantity, $line->uom_code, 'CG');
                            $datas[$line->item_id]['item_code'] = $line->item_code;
                            $datas[$line->item_id]['item_description'] = $line->item_description;
                            $datas[$line->item_id]['receivables_transaction_type'] = optional($item->transactionType)->receivables_transaction_type;
                        }else{
                            $datas[$line->item_id]['qty'] += (float)convertUom($line->item_id, $line->approve_quantity, $line->uom_code, 'CG');
                        }
                    }
                }
            }elseif($item->product_type_code == '20') { // PTOM_ORDER_LINES.APPROVE_QUANTITY หน่วยนับ PTOM_ORDER_LINES.UOM
                $lines = $item->lines;
                foreach ($lines as $line) {
                    if(!array_key_exists($line->item_id, $datas)){
                        $datas[$line->item_id]['qty'] = (float)convertUom($line->item_id, $line->approve_quantity, $line->uom_code, $base_uom->uom_code);
                        $datas[$line->item_id]['item_code'] = $line->item_code;
                        $datas[$line->item_id]['item_description'] = $line->item_description;
                        $datas[$line->item_id]['receivables_transaction_type'] = optional($item->transactionType)->receivables_transaction_type;
                    }else{
                        $datas[$line->item_id]['qty'] += (float)convertUom($line->item_id, $line->approve_quantity, $line->uom_code, $base_uom->uom_code);
                    }
                }
            }
        }

        foreach ($consignments as $consignment) {
            $lines = $consignment->lines;
            foreach ($lines as $line) {
                $item = $line->orderHeader;
                if(!array_key_exists($line->item_id, $datas)){
                    $datas[$line->item_id]['qty'] = ((float)$line->actual_quantity * 1000);
                    $datas[$line->item_id]['item_code'] = $line->item_code;
                    $datas[$line->item_id]['item_description'] = $line->item_description;
                    $datas[$line->item_id]['line'] = $line;
                    $datas[$line->item_id]['receivables_transaction_type'] = optional($item->transactionType)->receivables_transaction_type;
                }else{
                    $datas[$line->item_id]['qty'] += ((float)$line->actual_quantity * 1000);
                }
            }
        }

        foreach ($rma as $header) {
            $lines = $header->lines;
            foreach ($lines as $line) {
                $check_uom = DB::table('ptom_uom_conversions_v')->where('uom_code', $line->rma_uom_code)->first();
                if($check_uom->base_unit_code == 'CG'){
                    if(!array_key_exists($line->item_id, $datas)){
                        $datas[$line->item_id]['qty'] = (-1)*(float)convertUom($line->item_id, $line->rma_quantity, $line->rma_uom_code, 'CG');
                        $datas[$line->item_id]['item_code'] = $line->item_code;
                        $datas[$line->item_id]['item_description'] = $line->item_description;
                        $datas[$line->item_id]['receivables_transaction_type'] = optional($header->transactionType)->receivables_transaction_type;
                    }else{
                        $datas[$line->item_id]['qty'] -= (float)convertUom($line->item_id, $line->rma_quantity, $line->rma_uom_code, 'CG');
                    }
                }else {
                    if(!array_key_exists($line->item_id, $datas)){
                        $datas[$line->item_id]['qty'] = (-1)*(float)convertUom($line->item_id, $line->rma_quantity, $line->rma_uom_code, $base_uom->uom_code);
                        $datas[$line->item_id]['item_code'] = $line->item_code;
                        $datas[$line->item_id]['item_description'] = $line->item_description;
                        $datas[$line->item_id]['receivables_transaction_type'] = optional($header->transactionType)->receivables_transaction_type;
                    }else{
                        $datas[$line->item_id]['qty'] -= (float)convertUom($line->item_id, $line->rma_quantity, $line->rma_uom_code, $base_uom->uom_code);
                    }
                }
            }
        }
        // dd($datas);

        $line_num = 0;

        foreach ($datas as $item_id => $data) {

            $ar_trantype = ARTranTypesV::where('name', $data['receivables_transaction_type'])->first();
            $seq_ecoms = SequenceEcoms::where('item_id', $item_id)->first();

            $interface = $report ? new GLInterfacesReport : new GLInterfaceModel;
            $interface->group_id = $group_id;
            $interface->interface_module = 'GL';
            $interface->org_id = $this->orgId;
            $interface->ledger_name = 'การยาสูบแห่งประเทศไทย';
            $interface->accounting_date = $request_date;
            $interface->period_name = $request_date->format('M-y');
            $interface->currency_code = 'STAT';
            $interface->actual_flag = 'A';
            $interface->user_je_category_name = 'WEB OP จำนวนบุหรี่ขาย';
            $interface->user_je_source_name = 'WEB ระบบขาย';
            $interface->batch_name = 'จำนวนขายบุหรี่ในประเทศ';
            $interface->journal_name = 'บันทึกจำนวนขายบุหรี่ในประเทศ';
            $interface->journal_description_head = 'บันทึกจำนวนขายบุหรี่ในประเทศ สำหรับวันที่ '.$request_date->format('d-M').'-'.( (int)$request_date->format('Y') + 543);

            $map = MappingAccountModel::where('account_code', 'TRX-DOM-Sales Invoice-03')->first();
            $interface->je_line_num = $line_num+1;
            $interface->segment1 = optional($map)->segment1;
            $interface->segment2 = optional($map)->segment2;
            $interface->segment3 = optional($map)->segment3;
            $interface->segment4 = optional($map)->segment4;
            $interface->segment5 = self::getBudgetYear($request_date);
            $interface->segment6 = optional($ar_trantype)->revenue_account_segment6;
            $interface->segment7 = optional($ar_trantype)->revenue_account_segment7;
            $interface->segment8 = optional($map)->segment8;
            $interface->segment9 = optional($seq_ecoms)->main_account_code;
            $interface->segment10 = optional($seq_ecoms)->sub_account_code;
            $interface->segment11 = optional($map)->segment11;
            $interface->segment12 = optional($map)->segment12;

            $account_combine = $interface->segment1.'.'.$interface->segment2.'.'.$interface->segment3.'.'.$interface->segment4.'.'
                .$interface->segment5.'.'.$interface->segment6.'.'.$interface->segment7.'.'.$interface->segment8.'.'
                .$interface->segment9.'.'.$interface->segment10.'.'.$interface->segment11.'.'.$interface->segment12;
            $interface->code_combination_id = GlCodeCombinationsKFV::checkCCID($account_combine);

            $interface->entered_cr = $data['qty'];
            $interface->journal_description_line = 'Journal Import Created';

            $interface->program_code = 'OMP0044';
            $interface->web_batch_no = $batch_no;
            $interface->created_by = getDefaultData('/users')->user_id;
            $interface->last_updated_by = getDefaultData('/users')->user_id;
            $interface->creation_date = $creation_date;

            $interface->save();
            
            $line_num++;
        }
        
        return;
    }

    private function updateWebBatch($item, $batch_no)
    {
        $item->web_batch_no = $batch_no;
        $item->save();
    }

    private function updateARInvoiceWebBatch($item, $batch_no)
    {
        $item->ar_invoice_web_batch_no = $batch_no;
        $item->save();
    }

    private function updateARGroupId($item, $group_id)
    {
        $item->ar_invoice_group_id = $group_id;
        $item->save();
    }

    private function updateCloseSaleFlagAndStatus($item)
    {
        $item->close_sale_flag = 'Y';
        $item->close_sale_status = 'S';
        $item->save();
    }

    private static function getBudgetYear($date = null)
    {
        $currentYear = $date ? date('Y', strtotime($date)) : date('Y');
        $cycle = date('Y-m-d', strtotime($currentYear.'-9-30'));
        $now = $date ? date('Y-m-d', strtotime($date)) : date('Y-m-d');
        $offset = $now > $cycle ? 44 : 43;
        $year = substr( (int)$currentYear + $offset , -2);

        return $year;
    }

    private static function calTax($line, $header, $date, $quantity)
    {
        $promo = $line->orderLine ? $line->orderLine->promo_flag == 'Y' : $line->promo_flag == 'Y';
        $taxRate = $header->transactionType->tax_rate;
        $multiply = self::getPriceList($line, $date);

        return $promo ? 0 : $quantity * $multiply * $taxRate / (100+$taxRate);
        // return $promo ? 0 : $quantity * $multiply * $taxRate / 100;
    }

    private static function getPriceList($line, $date)
    {
        $price_list_header = PriceList::where('name', 'ราคาขายปลีก')->first();
        $price_list_lines = $price_list_header->listLines()
            ->where('item_id', $line->item_id)
            ->whereDate('start_date_active', '>=', Carbon::parse($date)->format('d-m-Y'))
            ->where(function($q) use ($date){
                return $q->whereDate('end_date_active', '<=', Carbon::parse($date)->format('d-m-Y'))
                    ->orWhereNull('end_date_active');
            })
            ->get();

        $price_line = $price_list_lines->first();

        if( ($line->uom_code ?? $line->attribute1) != $price_line->product_uom_code){
            $multiply = convertUom($line->item_id, $price_line->operand, ($line->uom_code ?? $line->attribute1), $price_line->product_uom_code);
        }else {
            $multiply = $price_line->operand;
        }

        return $multiply;
    }

    private static function genGroupId($club_cig, $club_not_cig, $not_club, $rma, $credit_note, $debit_note, $credit_other)
    {
        $group_id = collect();

        if($club_cig->count()){
            $groups = $club_cig->pluck("ar_invoice_group_id")->unique()->values();
            foreach ($groups as $group) {
                $group_id->push($group);
            }
        }

        if($club_not_cig->count()){
            $groups = $club_not_cig->pluck("ar_invoice_group_id")->unique()->values();
            foreach ($groups as $group) {
                $group_id->push($group);
            }
        }

        if($not_club->count()){
            $groups = $not_club->pluck("ar_invoice_group_id")->unique()->values();
            foreach ($groups as $group) {
                $group_id->push($group);
            }
        }

        if($rma->count()){
            $groups = $rma->pluck("ar_invoice_group_id")->unique()->values();
            foreach ($groups as $group) {
                $group_id->push($group);
            }
        }

        if($credit_note->count()){
            $groups = $credit_note->pluck("ar_invoice_group_id")->unique()->values();
            foreach ($groups as $group) {
                $group_id->push($group);
            }
        }

        if($debit_note->count()){
            $groups = $debit_note->pluck("ar_invoice_group_id")->unique()->values();
            foreach ($groups as $group) {
                $group_id->push($group);
            }
        }

        if($credit_other->count()){
            $groups = $credit_other->pluck("ar_invoice_group_id")->unique()->values();
            foreach ($groups as $group) {
                $group_id->push($group);
            }
        }

        return $group_id->filter()->unique()->sortDesc()->first() ?? getGroupID();
    }

    private static function getOldGroupId($club_cig, $club_not_cig, $not_club, $rma, $credit_note, $debit_note, $credit_other)
    {
        $group_id = collect();

        if($club_cig->count()){
            $groups = $club_cig->pluck("ar_invoice_group_id")->unique()->values();
            foreach ($groups as $group) {
                $group_id->push($group);
            }
        }

        if($club_not_cig->count()){
            $groups = $club_not_cig->pluck("ar_invoice_group_id")->unique()->values();
            foreach ($groups as $group) {
                $group_id->push($group);
            }
        }

        if($not_club->count()){
            $groups = $not_club->pluck("ar_invoice_group_id")->unique()->values();
            foreach ($groups as $group) {
                $group_id->push($group);
            }
        }

        if($rma->count()){
            $groups = $rma->pluck("ar_invoice_group_id")->unique()->values();
            foreach ($groups as $group) {
                $group_id->push($group);
            }
        }

        if($credit_note->count()){
            $groups = $credit_note->pluck("ar_invoice_group_id")->unique()->values();
            foreach ($groups as $group) {
                $group_id->push($group);
            }
        }

        if($debit_note->count()){
            $groups = $debit_note->pluck("ar_invoice_group_id")->unique()->values();
            foreach ($groups as $group) {
                $group_id->push($group);
            }
        }

        if($credit_other->count()){
            $groups = $credit_other->pluck("ar_invoice_group_id")->unique()->values();
            foreach ($groups as $group) {
                $group_id->push($group);
            }
        }

        return $group_id->filter()->unique()->sortDesc()->values();
    }

    private static function getDocumentDateLists($orgId)
    {
        $documentDateLists = [];

        $club_cig = Consignment::whereHas('customer', function($q){
            return $q->whereIn('customer_type_id', [30, 40]);
        })
        ->whereHas('lines', function($q) {
            return $q->whereHas('orderHeader', function($p) {
                return $p->whereIn('product_type_code', [10]);
            });
        })
        ->whereRaw("upper(consignment_status) = 'CONFIRM'")
        ->whereRaw("
            NOT EXISTS( 
                SELECT 1
                FROM RA_CUSTOMER_TRX_ALL    RCT
                    ,RA_BATCH_SOURCES_ALL   RBA 
                WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                AND   TRX_NUMBER = PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_NO
                AND   RCT.ORG_ID = $orgId
                AND   RBA.NAME   = 'ระบบขายในประเทศ'
            )
        ")
        ->get('consignment_date');

        foreach ($club_cig as $consignment) {
            $key = Carbon::parse($consignment->consignment_date)->format('Y-m-d');
            $date = Carbon::parse($consignment->consignment_date)->addYears(543)->format('d-m-Y');
            if( !array_key_exists($key, $documentDateLists) ){
                $documentDateLists[$key] = $date;
            }
        }

        $club_not_cig = OrderHeader::whereHas('customer', function($q){
            return $q->whereIn('customer_type_id', [30, 40]);
        })
        ->where('product_type_code', '<>', 10)
        ->where('program_code', 'OMP0019')
        ->whereRaw("upper(pick_release_status) = 'CONFIRM'")
        ->whereRaw("
            NOT EXISTS(
                SELECT 1
                FROM RA_CUSTOMER_TRX_ALL    RCT
                    ,RA_BATCH_SOURCES_ALL   RBA 
                WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                AND   TRX_NUMBER = PTOM_ORDER_HEADERS.PICK_RELEASE_NO
                AND   RCT.ORG_ID = $orgId
                AND   RBA.NAME   = 'ระบบขายในประเทศ'
            )
        ")
        ->get('pick_release_approve_date');

        foreach ($club_not_cig as $item) {
            $key = Carbon::parse($item->pick_release_approve_date)->format('Y-m-d');
            $date = Carbon::parse($item->pick_release_approve_date)->addYears(543)->format('d-m-Y');
            if( !array_key_exists($key, $documentDateLists) ){
                $documentDateLists[$key] = $date;
            }
        }

        // order header
        $not_club = OrderHeader::whereHas('customer', function($q){
            return $q->whereNotIn('customer_type_id', [30, 40]);
        })
        ->where('program_code', 'OMP0019')
        ->whereRaw("upper(pick_release_status) = 'CONFIRM'")
        ->whereRaw("
            NOT EXISTS(
                SELECT 1
                FROM RA_CUSTOMER_TRX_ALL    RCT
                    ,RA_BATCH_SOURCES_ALL   RBA 
                WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                AND   TRX_NUMBER = PTOM_ORDER_HEADERS.PICK_RELEASE_NO
                AND   RCT.ORG_ID = $orgId
                AND   RBA.NAME   = 'ระบบขายในประเทศ'
            )
        ")
        ->get('pick_release_approve_date');

        foreach ($not_club as $item) {
            $key = Carbon::parse($item->pick_release_approve_date)->format('Y-m-d');
            $date = Carbon::parse($item->pick_release_approve_date)->addYears(543)->format('d-m-Y');
            if( !array_key_exists($key, $documentDateLists) ){
                $documentDateLists[$key] = $date;
            }
        }

        // rma
        $rma = ClaimHeader::where('program_code', 'OMP0052')
        ->whereRaw("upper(status_rma) = 'CONFIRM'")
        ->where(function ($p) {
            return $p->whereNull('close_sale_flag')
            ->orWhereRaw("upper(close_sale_flag) <> 'Y'");
        })
        ->get('rma_date');

        foreach ($rma as $item) {
            $key = Carbon::parse($item->rma_date)->format('Y-m-d');
            $date = Carbon::parse($item->rma_date)->addYears(543)->format('d-m-Y');
            if( !array_key_exists($key, $documentDateLists) ){
                $documentDateLists[$key] = $date;
            }
        }

        // credit_note
        $credit_note = PtomInvoiceHeader::where('program_code', 'OMP0034')
        ->whereRaw("upper(invoice_status) = 'CONFIRM'")
        ->whereRaw("
            NOT EXISTS(
                SELECT 1
                FROM RA_CUSTOMER_TRX_ALL    RCT
                    ,RA_BATCH_SOURCES_ALL   RBA 
                WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                AND   TRX_NUMBER = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
                AND   RCT.ORG_ID = $orgId
                AND   RBA.NAME   = 'ระบบขายในประเทศ'
            )
        ")
        ->where('invoice_amount', '<>', 0)
        ->get('invoice_date');

        foreach ($credit_note as $item) {
            $key = Carbon::parse($item->invoice_date)->format('Y-m-d');
            $date = Carbon::parse($item->invoice_date)->addYears(543)->format('d-m-Y');
            if( !array_key_exists($key, $documentDateLists) ){
                $documentDateLists[$key] = $date;
            }
        }

        // debit_note
        $debit_note = PtomInvoiceHeader::where('program_code', 'OMP0032')
        ->whereRaw("upper(invoice_status) = 'CONFIRM'")
        ->whereRaw("
            NOT EXISTS(
                SELECT 1
                FROM RA_CUSTOMER_TRX_ALL    RCT
                    ,RA_BATCH_SOURCES_ALL   RBA 
                WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                AND   TRX_NUMBER = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
                AND   RCT.ORG_ID = $orgId
                AND   RBA.NAME   = 'ระบบขายในประเทศ'
            )
        ")
        ->where('invoice_amount', '<>', 0)
        ->get('invoice_date');

        foreach ($debit_note as $item) {
            $key = Carbon::parse($item->invoice_date)->format('Y-m-d');
            $date = Carbon::parse($item->invoice_date)->addYears(543)->format('d-m-Y');
            if( !array_key_exists($key, $documentDateLists) ){
                $documentDateLists[$key] = $date;
            }
        }

        // credit_other
        $credit_other = PtomInvoiceHeader::whereIn('program_code', ['OMP0033', 'OMP0050', 'OMP0052'])
        ->whereRaw("upper(invoice_status) = 'CONFIRM'")
        ->where('invoice_amount', '<>', 0)
        ->whereRaw("
            NOT EXISTS(
                SELECT 1
                FROM RA_CUSTOMER_TRX_ALL    RCT
                    ,RA_BATCH_SOURCES_ALL   RBA 
                WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
                AND   TRX_NUMBER = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
                AND   RCT.ORG_ID = $orgId
                AND   RBA.NAME   = 'ระบบขายในประเทศ'
            )
        ")
        ->get('invoice_date');

        foreach ($credit_other as $item) {
            $key = Carbon::parse($item->invoice_date)->format('Y-m-d');
            $date = Carbon::parse($item->invoice_date)->addYears(543)->format('d-m-Y');
            if( !array_key_exists($key, $documentDateLists) ){
                $documentDateLists[$key] = $date;
            }
        }

        $gl_exp = OrderHeader::whereHas('transactionType', function($q){
            return $q->where('op_sample_flag', 'Y');
        })
        ->where('program_code', 'OMP0020')
        ->whereRaw("upper(pick_release_status) = 'CONFIRM'")
        ->where(function ($p) {
            return $p->whereNull('close_sale_flag')
            ->orWhereRaw("upper(close_sale_flag) <> 'Y'");
        })
        ->get('pick_release_approve_date');

        foreach ($gl_exp as $item) {
            $key = Carbon::parse($item->pick_release_approve_date)->format('Y-m-d');
            $date = Carbon::parse($item->pick_release_approve_date)->addYears(543)->format('d-m-Y');
            if( !array_key_exists($key, $documentDateLists) ){
                $documentDateLists[$key] = $date;
            }
        }

        $gl_sale_order_header = OrderHeader::where(function($q) {
            return $q->where(function($p) {
                return $p->where(function($r) {
                    return $r->whereHas('customer', function($s){
                        return $s->whereNotIn('customer_type_id', [30, 40]);
                    })
                    ->whereIn('product_type_code', ['10']);
                })
                ->orWhere(function($r) {
                    return $r->whereIn('product_type_code', ['20']);
                });
            })
            ->whereRaw("upper(pick_release_status) = 'CONFIRM'")
            ->where(function ($r) {
                return $r->whereNull('close_sale_flag')
                ->orWhereRaw("upper(close_sale_flag) <> 'Y'");
            });
        })
        ->whereHas('transactionType', function($q) {
            return $q->where('send_stat_gl', 'Y');
        })
        ->whereHas('lines', function($q){
            return $q->where(function($p){
                return $p->where('promo_flag', '<>', 'Y')
                ->orWhereNull('promo_flag');
            });
        })
        ->get('pick_release_approve_date');

        foreach ($gl_sale_order_header as $item) {
            $key = Carbon::parse($item->pick_release_approve_date)->format('Y-m-d');
            $date = Carbon::parse($item->pick_release_approve_date)->addYears(543)->format('d-m-Y');
            if( !array_key_exists($key, $documentDateLists) ){
                $documentDateLists[$key] = $date;
            }
        }

        $gl_sale_consignment = Consignment::where(function ($q) {
            return $q->where(function ($p) {
                return $p->whereNull('close_sale_flag')
                ->orWhereRaw("upper(close_sale_flag) <> 'Y'");
            })
            ->whereRaw("upper(consignment_status) = 'CONFIRM'");
        })
        ->whereHas('lines', function($q){
            return $q->where(function($p){
                return $p->where('attribute2', '<>', 'Y')
                ->orWhereNull('attribute2');
            });
        })
        ->get('consignment_date');

        foreach ($gl_sale_consignment as $item) {
            $key = Carbon::parse($item->consignment_date)->format('Y-m-d');
            $date = Carbon::parse($item->consignment_date)->addYears(543)->format('d-m-Y');
            if( !array_key_exists($key, $documentDateLists) ){
                $documentDateLists[$key] = $date;
            }
        }

        // dd($club_cig, $club_not_cig, $not_club, $rma, $credit_note, $debit_note, $credit_other);

        ksort($documentDateLists);

        return $documentDateLists;
    }

    private static function checkErrorARCCID($batch)
    {
        $valid = true;
        $msg = null;

        $checkCCIDs = ARInterface::where('web_batch_no', $batch)
        ->where(function($q){
            return $q->where(function($p){
                return $p->whereNull('rec_account_id')->whereNotNull('rec_account_combine');
            })->orWhere(function($p){
                return $p->whereNull('rev_account_id')->whereNotNull('rev_account_combine');
            })->orWhere(function($p){
                return $p->whereNull('tax_account_id')->whereNotNull('tax_account_combine');
            });
        })
        ->get();

        if($checkCCIDs->count()){

            $valid = false;
            ARInterface::where('web_batch_no', $batch)->update([
                'interface_status' => 'E',
                'interfaced_msg' => 'Not Found CCID'
            ]);

            $ccid = [];

            foreach ($checkCCIDs as $item){
                if($item->rec_account_combine && !$item->rec_account_id){
                    $ccid[$item->rec_account_combine] = $item->rec_account_combine;
                }
                if($item->rev_account_combine && !$item->rev_account_id){
                    $ccid[$item->rev_account_combine] = $item->rev_account_combine;
                }
                if($item->tax_account_combine && !$item->tax_account_id){
                    $ccid[$item->tax_account_combine] = $item->tax_account_combine;
                }
            }
            $msg = 'ไม่พบข้อมูล CCID ';

            foreach ($ccid as $index => $id){
                $msg = $msg.$id.(count($ccid) == $index ? '' :', ');
            }
            $msg = $msg.' นี้ในระบบ';
        }

        return [
            'valid' => $valid,
            'msg' => $msg,
        ];
    }

    private static function checkErrorGLCCID($batch)
    {
        $valid = true;
        $msg = null;

        $checkCCIDs = GLInterfaceModel::where('web_batch_no', $batch)
            ->whereNull('code_combination_id')
            ->get();

        if($checkCCIDs->count()){

            $valid = false;
            GLInterfaceModel::where('web_batch_no', $batch)->update([
                'interface_status' => 'E',
                'interfaced_msg' => 'Not Found CCID'
            ]);

            $ccid = [];

            foreach ($checkCCIDs as $item){
                $account_combine = $item->segment1.'.'.$item->segment2.'.'.$item->segment3.'.'.$item->segment4.'.'
                .$item->segment5.'.'.$item->segment6.'.'.$item->segment7.'.'.$item->segment8.'.'
                .$item->segment9.'.'.$item->segment10.'.'.$item->segment11.'.'.$item->segment12;
    
                if($account_combine && !$item->code_combination_id){
                    $ccid[$account_combine] = $account_combine;
                }
            }
            $msg = 'ไม่พบข้อมูล CCID ';

            foreach ($ccid as $index => $id){
                $msg = $msg.$id.(count($ccid) == $index ? '' :', ');
            }
            $msg = $msg.' นี้ในระบบ';
        }

        return [
            'valid' => $valid,
            'msg' => $msg,
        ];
    }

    private static function getErrorARCCID($batch)
    {
        $msg = optional(ARInterface::where('web_batch_no', $batch)->where('interface_status', 'E')->first())->interfaced_msg;
        if(ARInterface::where('web_batch_no', $batch)->whereNull('interface_status')->count()){
            $msg = 'โปรแกรมขัดข้องกรุณาติดต่อผู้ดูแลระบบ';
        }

        return $msg;
    }

    private static function getErrorGLCCID($batch)
    {
        $msg = optional(GLInterfaceModel::where('web_batch_no', $batch)->where('interface_status', 'E')->first())->interfaced_msg;
        if(GLInterfaceModel::where('web_batch_no', $batch)->whereNull('interface_status')->count()){
            $msg = 'โปรแกรมขัดข้องกรุณาติดต่อผู้ดูแลระบบ';
        }

        return $msg;
    }

    private function checkData($request)
    {
        $this->orgName = 'การยาสูบแห่งประเทศไทย';
        $hr = HrOperatingUnits::where('name', $this->orgName)->first();
        $this->orgId = $hr->organization_id;

        $date = Carbon::parse('2022-10-31');
        $document_no = null;
        $creation_date = Carbon::now();
        $requestType = $request->type;

        // $club_cig = Consignment::whereHas('customer', function($q){
        //     return $q->whereIn('customer_type_id', [30, 40]);
        // })
        // ->whereHas('lines', function($q) {
        //     return $q->whereHas('orderHeader', function($p) {
        //         return $p->whereIn('product_type_code', [10]);
        //     });
        // })
        // ->when($document_no, function ($p, $document_no){
        //     return $p->where('consignment_no', $document_no);
        // })
        // ->whereDate('consignment_date', $date)
        // ->whereRaw("upper(consignment_status) = 'CONFIRM'")
        // ->whereRaw("
        //     NOT EXISTS( 
        //         SELECT 1
        //         FROM RA_CUSTOMER_TRX_ALL    RCT
        //             ,RA_BATCH_SOURCES_ALL   RBA 
        //         WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
        //         AND   TRX_NUMBER = PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_NO
        //         AND   RCT.ORG_ID = $this->orgId
        //         AND   RBA.NAME   = 'ระบบขายในประเทศ'
        //     )
        // ")
        // ->get();

        /// club not cigarette
        // $club_not_cig = OrderHeader::whereHas('customer', function($q){
        //     return $q->whereIn('customer_type_id', [30, 40]);
        // })
        // ->where('product_type_code', '<>', 10)
        // ->where('program_code', 'OMP0019')
        // ->whereDate('pick_release_approve_date', $date)
        // ->when($document_no, function ($p, $document_no){
        //     return $p->where('pick_release_no', $document_no);
        // })
        // ->whereRaw("upper(pick_release_status) = 'CONFIRM'")
        // ->whereRaw("
        //     NOT EXISTS( 
        //         SELECT 1
        //         FROM RA_CUSTOMER_TRX_ALL    RCT
        //             ,RA_BATCH_SOURCES_ALL   RBA 
        //         WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
        //         AND   TRX_NUMBER = PTOM_ORDER_HEADERS.PICK_RELEASE_NO
        //         AND   RCT.ORG_ID = $this->orgId
        //         AND   RBA.NAME   = 'ระบบขายในประเทศ'
        //     )
        // ")
        // ->with('customer', 'transactionType', 'lines')
        // ->get();

        // not club
        // $not_club = OrderHeader::whereHas('customer', function($q){
        //     return $q->whereNotIn('customer_type_id', [30, 40]);
        // })
        // ->where('program_code', 'OMP0019')
        // ->whereDate('pick_release_approve_date', $date)
        // ->when($document_no, function ($p, $document_no){
        //     return $p->where('pick_release_no', $document_no);
        // })
        // ->whereRaw("upper(pick_release_status) = 'CONFIRM'")
        // ->whereRaw("
        //     NOT EXISTS( 
        //         SELECT 1
        //         FROM RA_CUSTOMER_TRX_ALL    RCT
        //             ,RA_BATCH_SOURCES_ALL   RBA 
        //         WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
        //         AND   TRX_NUMBER = PTOM_ORDER_HEADERS.PICK_RELEASE_NO
        //         AND   RCT.ORG_ID = $this->orgId
        //         AND   RBA.NAME   = 'ระบบขายในประเทศ'
        //     )
        // ")
        // ->with('customer', 'transactionType', 'lines')
        // ->get();

        // $rma = ClaimHeader::where('program_code', 'OMP0052')
        // ->whereDate('rma_date', $date)
        // ->when($document_no, function ($p, $document_no){
        //     return $p->where('rma_number', $document_no);
        // })  
        // ->whereRaw("upper(status_rma) = 'CONFIRM'")
        // ->get();

        // $credit_note = PtomInvoiceHeader::where('program_code', 'OMP0034')
        // ->whereDate('invoice_date', $date)
        // ->when($document_no, function ($p, $document_no){
        //     return $p->where('invoice_headers_number', $document_no);
        // }) 
        // ->whereRaw("upper(invoice_status) = 'CONFIRM'")
        // ->whereRaw("
        //     NOT EXISTS( 
        //         SELECT 1
        //         FROM RA_CUSTOMER_TRX_ALL    RCT
        //             ,RA_BATCH_SOURCES_ALL   RBA 
        //         WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
        //         AND   TRX_NUMBER = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
        //         AND   RCT.ORG_ID = $this->orgId
        //         AND   RBA.NAME   = 'ระบบขายในประเทศ'
        //     )
        // ")
        // ->where('invoice_amount', '<>', 0)
        // ->with('lines.consignment')
        // ->get();

        // $debit_note = PtomInvoiceHeader::where('program_code', 'OMP0032')
        // ->whereDate('invoice_date', $date)
        // ->when($document_no, function ($p, $document_no){
        //     return $p->where('invoice_headers_number', $document_no);
        // }) 
        // ->whereRaw("upper(invoice_status) = 'CONFIRM'")
        // ->whereRaw("
        //     NOT EXISTS( 
        //         SELECT 1
        //         FROM RA_CUSTOMER_TRX_ALL    RCT
        //             ,RA_BATCH_SOURCES_ALL   RBA 
        //         WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
        //         AND   TRX_NUMBER = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
        //         AND   RCT.ORG_ID = $this->orgId
        //         AND   RBA.NAME   = 'ระบบขายในประเทศ'
        //     )
        // ")
        // ->where('invoice_amount', '<>', 0)
        // ->get();

        // $credit_other = PtomInvoiceHeader::whereIn('program_code', ['OMP0033', 'OMP0050', 'OMP0052'])
        // ->whereDate('invoice_date', $date)
        // ->when($document_no, function ($p, $document_no){
        //     return $p->where('invoice_headers_number', $document_no);
        // }) 
        // ->whereRaw("upper(invoice_status) = 'CONFIRM'")
        // ->whereRaw("
        //     NOT EXISTS( 
        //         SELECT 1
        //         FROM RA_CUSTOMER_TRX_ALL    RCT
        //             ,RA_BATCH_SOURCES_ALL   RBA 
        //         WHERE RCT.BATCH_SOURCE_ID = RBA.BATCH_SOURCE_ID 
        //         AND   TRX_NUMBER = PTOM_INVOICE_HEADERS.INVOICE_HEADERS_NUMBER
        //         AND   RCT.ORG_ID = $this->orgId
        //         AND   RBA.NAME   = 'ระบบขายในประเทศ'
        //     )
        // ")
        // ->where('invoice_amount', '<>', 0)
        // ->with('lines.consignment')
        // ->get();

        $gl_exp = OrderHeader::whereHas('transactionType', function($q){
            return $q->where('op_sample_flag', 'Y');
        })
        ->where('program_code', 'OMP0020')
        ->whereDate('pick_release_approve_date', $date)
        ->when($document_no, function ($p, $document_no){
            return $p->where('pick_release_no', $document_no);
        })
        ->whereRaw("upper(pick_release_status) = 'CONFIRM'")
        ->where(function ($p) {
            return $p->whereNull('close_sale_flag')
            ->orWhereRaw("upper(close_sale_flag) <> 'Y'");
        })
        ->with('customer', 'transactionType', 'lines')
        ->get();

        $gl_sale_order_header = OrderHeader::where(function($q) use($date, $document_no){
            return $q->where(function($p) {
                return $p->where(function($r) {
                    return $r->whereHas('customer', function($s){
                        return $s->whereNotIn('customer_type_id', [30, 40]);
                    })
                    ->whereIn('product_type_code', ['10']);
                })
                ->orWhere(function($r) {
                    return $r->whereIn('product_type_code', ['20']);
                });
            })
            ->whereDate('pick_release_approve_date', $date)
            ->whereRaw("upper(pick_release_status) = 'CONFIRM'")
            ->where(function ($r) {
                return $r->whereNull('close_sale_flag')
                ->orWhereRaw("upper(close_sale_flag) <> 'Y'");
            })
            ->when($document_no, function ($r, $document_no){
                return $r->where('pick_release_no', $document_no);
            });
        })
        ->whereHas('transactionType', function($q) {
            return $q->where('send_stat_gl', 'Y');
        })
        ->whereHas('lines', function($q){
            return $q->where(function($p){
                return $p->where('promo_flag', '<>', 'Y')
                ->orWhereNull('promo_flag');
            });
        })
        ->with([
            'customer', 
            'transactionType',
            'lines' => function ($q) {
                return $q->where(function($p){
                    return $p->where('promo_flag', '<>', 'Y')
                    ->orWhereNull('promo_flag');
                });
            }
        ])
        ->get();
        
        $gl_sale_consignment = Consignment::where(function ($q) {
            return $q->where(function ($p) {
                return $p->whereNull('close_sale_flag')
                ->orWhereRaw("upper(close_sale_flag) <> 'Y'");
            })
            ->whereRaw("upper(consignment_status) = 'CONFIRM'");
        })
        ->whereDate('consignment_date', $date)
        ->whereHas('lines', function($q){
            return $q->where(function($p){
                return $p->where('attribute2', '<>', 'Y')
                ->orWhereNull('attribute2');
            });
        })
        ->when($document_no, function ($p, $document_no){
            return $p->where('consignment_no', $document_no);
        })
        ->with([
            'customer', 
            'lines' => function ($q) {
                return $q->where(function($p){
                    return $p->where('attribute2', '<>', 'Y')
                    ->orWhereNull('attribute2');
                });
            }
        ])
        ->get();

        // dd($club_cig, $club_not_cig, $not_club, $rma, $gl_sale_order_header, $gl_sale_consignment);
        // $this->insertGLSale($gl_sale_order_header, $gl_sale_consignment, $rma, $date, 'test', 'test-123', $creation_date, true);
        dd($gl_exp, $gl_sale_order_header, $gl_sale_consignment);
        // dd($credit_note,$debit_note,$credit_other);

        // if($club_cig->count()){
        //     foreach ($club_cig as $item) {
        //         $history = OrderHistory::where('order_header_id', $item->order_header_id)
        //         ->where('order_status', 'Invoice')
        //         ->where('pick_release_no', $item->pick_release_num)
        //         ->first();

        //         if($history){
        //             $newHistory = $history->replicate();
        //             $newHistory->order_status = 'Delivery';
        //             $newHistory->close_sale_flag = 'Y';
        //             $newHistory->ebs_order_number = $item->ebs_order_number;
        //             $newHistory->creation_date = $creation_date;
        //             $newHistory->last_update_date = $creation_date;
        //             $newHistory->save();
        //         }
        //     }
        // }

        // if($club_not_cig->count()){
        //     foreach ($club_not_cig as $item) {
        //         $history = OrderHistory::where('order_header_id', $item->order_header_id)
        //         ->where('order_status', 'Invoice')
        //         ->where('pick_release_no', $item->pick_release_no)
        //         ->first();

        //         if($history){
        //             $newHistory = $history->replicate();
        //             $newHistory->order_status = 'Delivery';
        //             $newHistory->close_sale_flag = 'Y';
        //             $newHistory->ebs_order_number = $item->ebs_order_number;
        //             $newHistory->creation_date = $creation_date;
        //             $newHistory->last_update_date = $creation_date;
        //             $newHistory->save();
        //         }
        //     }
        // }

        // if($not_club->count()){
        //     foreach ($not_club as $item) {
        //         $history = OrderHistory::where('order_header_id', $item->order_header_id)
        //         ->where('order_status', 'Invoice')
        //         ->where('pick_release_no', $item->pick_release_no)
        //         ->first();

        //         if($history){
        //             $newHistory = $history->replicate();
        //             $newHistory->order_status = 'Delivery';
        //             $newHistory->close_sale_flag = 'Y';
        //             $newHistory->ebs_order_number = $item->ebs_order_number;
        //             $newHistory->creation_date = $creation_date;
        //             $newHistory->last_update_date = $creation_date;
        //             $newHistory->save();
        //         }
        //     }
        // }

        // if($gl_exp->count()){
        //     foreach ($gl_exp as $item) {
        //         $order = OrderHeader::find($item->order_header_id);
        //         $this->updateCloseSaleFlagAndStatus($order);
        //     }
        // }

        // if($gl_sale_order_header->count()){
        //     foreach ($gl_sale_order_header as $item) {
        //         $order = OrderHeader::find($item->order_header_id);
        //         $this->updateCloseSaleFlagAndStatus($order);
        //     }
        // }

        // if($gl_sale_consignment->count()){
        //     foreach ($gl_sale_consignment as $item) {
        //         $consignment = Consignment::find($item->consignment_header_id);
        //         $this->updateCloseSaleFlagAndStatus($consignment);
        //     }
        // }
        // dd('done');
    }
}