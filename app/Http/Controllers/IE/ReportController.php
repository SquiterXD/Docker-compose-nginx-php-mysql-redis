<?php

namespace App\Http\Controllers\IE;

use App\Models\IE\Vendor;
use App\Models\IE\APWTTypeV;
use App\Models\IE\CashAdvance;
use App\Models\IE\Reimbursement;
use App\Models\IE\APReportingEntity;
use App\Models\IE\InterfaceAPHeader;
use App\Repositories\IE\RequestRepo;
use App\Models\IE\FNDListOfValues;
use Carbon\Carbon;
use App\Models\User;
use App\Models\HREmployee;
use App\Models\IE\Employee;

use PDF;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\IE\ReceiptLine;

class ReportController extends Controller {

    public function index()
    {
        $reportLists =  [   
            'ct-invoice' => 'TOAT CT-Invoice Register', 
            'ct-wht' => 'CT-ทะเบียนคุมภาษีเงินได้หัก ณ ที่จ่าย',
            'ct-ca' => 'ทะเบียนคุมเงินทดรอง',
            'ct-budget' => 'CT-ใบขออนุมัติหลักการใช้งบ',
            'ct-vat' => 'CT-รายงานทะเบียนนำส่งใบกำกับภาษี / ใบแจ้งหนี้',
        ];

        $supplierLists = Vendor::select(\DB::raw("vendor_no || ' : ' || vendor_name AS full_description"),'vendor_id')
            ->orderBy('vendor_id')
            ->pluck('full_description','vendor_id')
            ->all();

        $groupTaxCodes = APReportingEntity::select(\DB::raw("entity_name AS full_description"),'entity_name')
            ->orderBy('entity_name')
            ->pluck('full_description','entity_name')
            ->all();

        $whtTypeLists = APWTTypeV::select('description','value')->pluck('description','value')->all();

        $departmentLists = FNDListOfValues::select(\DB::raw("flex_value || ' : ' || description AS full_description"),'flex_value')
            ->department()->orderBy('flex_value')->pluck('full_description','flex_value')->all();

        return view('ie.commons.report.index', compact(
            'supplierLists', 
            'reportLists', 
            'groupTaxCodes',
            'whtTypeLists',
            'departmentLists'
        ));
    }

    public function request(Request $request, $type, $parentId)
    {
        $pendingRequestLists = [];
        if( in_array( $type, ['CASH-ADVANCE', 'CLEARING']) ){
            $parent = CashAdvance::find($parentId);
            $pendingRequestLists = RequestRepo::getPendingOverLimitRequest($parent->requester_id);
        }elseif( in_array( $type, ['REIMBURSEMENT']) ) {
            $parent = Reimbursement::find($parentId);
        }else return abort(404);

        $requestType = $type;
        $filename = $requestType == 'CASH-ADVANCE' ? 'CA.pdf' : ($requestType == 'CLEARING' ? 'CL.pdf' : 'RE.pdf');
        $receipts = $parent->receipts()->processType($requestType)->with('lines')->get();

        $groupDatas = [];
        foreach($receipts as $index => $receipt){
            foreach($receipt->lines as $key => $line){
                $employee = $receipt->employee;
                $budgetAccount =  $employee->employee_number . ' : ' . $employee->last_name . ' ' . $employee->first_name;
                $category = optional($line->category)->name ?? 'None';
                $subCategory = optional($line->subCategory)->name ?? 'None';
                $groupDatas[$budgetAccount][] = $line;
            }
        }
        // dd($groupDatas);

        $maxLine = 12; // in_array($requestType, ['CASH-ADVANCE']) ? 12 : 16;
        $line_num = 0;
        $page = 0;
        $data = [];
        foreach($groupDatas as $budgetAccount => $lines){
            if($line_num >= $maxLine){
                $line_num = 0;
                $page++;
            }
            $line_num++;
            foreach ($lines as $key => $line) {  
                if($line_num >= $maxLine){
                    $line_num = 1;
                    $page++;
                }
                $data[$page][$budgetAccount][] = $line;
                if(mb_strlen($line->description) > 100){
                    $line_num = $line_num+2;
                }else{
                    $line_num++;
                }
            }
        }

        $activityLogs = $parent->activityLogs;
        $approvals = $parent->approvals;
        // dd($data);

        $pdf = PDF::loadView('ie.commons.report.pdf.request._template', compact(
                'parent', 
                'receipts', 
                'data', 
                'maxLine',
                'pendingRequestLists',
                'requestType',
                'activityLogs',
                'approvals',
            ))
            ->setPaper('a4')
            ->setOrientation('portrait')
            ->setOption('margin-bottom', 0);
        return $pdf->stream($filename);

    }

    public function ctInvoice(Request $request)
    {
        // dd($request->all());
        $document_type = strtoupper($request->document_type);
        $department = $request->department;
        $requester = strtoupper($request->requester);
        $date_from = $request->request_date_from;
        $date_to = $request->request_date_to;
        $invoice_from = strtoupper($request->invoice_no_from);
        $invoice_to = strtoupper($request->invoice_no_to);
        $document_from =  strtoupper($request->document_no_from);
        $document_to =  strtoupper($request->document_no_to);

        if( $document_type == 'REIMBURSEMENT' ){
            $query = Reimbursement::with('interfaces.statusPaid', 'interfaces.supplier', 'interfaces.lines.wht');
        }else {
            $query = CashAdvance::with('interfaces.statusPaid', 'interfaces.supplier', 'interfaces.lines.wht')->whereNull('apply_to');
        }

        $data = $query->when($department, function($q, $department){
            return $q->whereHas('requester', function($p) use($department){
                return $p->whereHas('PersonalDeptLocation', function($t) use($department){
                    return $t->where('dept_cd_f02', $department);
                });
            });
        })
        ->when($requester, function($q, $requester){
            return $q->where('requester_id', $requester);
        })
        ->when($date_from || $date_to, function($q) use($date_from, $date_to){
            if($date_from && $date_to){
                $oneDate = $date_from == $date_to;
                if($oneDate){
                    return $q->whereDate('creation_date', Carbon::createFromFormat('d/m/Y', $date_from));
                }else {
                    return $q->whereBetween('creation_date', [Carbon::createFromFormat('d/m/Y', $date_from)->startOfDay(), Carbon::createFromFormat('d/m/Y', $date_to)->endOfDay()]);
                }
            }elseif($date_from){
                $q->whereDate('creation_date', '>=', Carbon::createFromFormat('d/m/Y', $date_from));
            }elseif($date_to){
                $q->whereDate('creation_date', '<=', Carbon::createFromFormat('d/m/Y', $date_to));
            }else return $q;
        })
        ->when($invoice_from || $invoice_to, function($q) use($invoice_from, $invoice_to, $document_type){
            if($invoice_from && $invoice_to){
                if( in_array( $document_type, ['REIMBURSEMENT']) ){
                    return $q->whereRaw("UPPER(invoice_no) >= '".$invoice_from."'")
                        ->whereRaw("UPPER(invoice_no) <= '".$invoice_to."'");
                } else if( in_array( $document_type, ['CASH-ADVANCE']) ) {
                    return $q->whereRaw("UPPER(invoice_no) >= '".$invoice_from."'")
                        ->whereRaw("UPPER(invoice_no) <= '".$invoice_to."'");
                } else if( in_array( $document_type, ['CLEARING']) ) {
                    return $q->whereRaw("UPPER(clearing_invoice_no) >= '".$invoice_from."'")
                        ->whereRaw("UPPER(clearing_invoice_no) <= '".$invoice_to."'");
                } else {
                    return $q;
                }
            }else if($invoice_from){
                if( in_array( $document_type, ['REIMBURSEMENT']) ){
                    return $q->whereRaw("UPPER(invoice_no) >= '".$invoice_from."'");
                } else if( in_array( $document_type, ['CASH-ADVANCE']) ) {
                    return $q->whereRaw("UPPER(invoice_no) >= '".$invoice_from."'");
                } else if( in_array( $document_type, ['CLEARING']) ) {
                    return $q->whereRaw("UPPER(clearing_invoice_no) >= '".$invoice_from."'");
                } else {
                    return $q;
                }
            }else if($invoice_to){
                if( in_array( $document_type, ['REIMBURSEMENT']) ){
                    return $q->whereRaw("UPPER(invoice_no) <= '".$invoice_to."'");
                } else if( in_array( $document_type, ['CASH-ADVANCE']) ) {
                    return $q->whereRaw("UPPER(invoice_no) <= '".$invoice_to."'");
                } else if( in_array( $document_type, ['CLEARING']) ) {
                    return $q->whereRaw("UPPER(clearing_invoice_no) <= '".$invoice_to."'");
                } else {
                    return $q;
                }
            }else return $q;
        })
        ->when($document_from || $document_to, function($q) use($document_from, $document_to, $document_type){
            if($document_from && $document_to){
                if( in_array( $document_type, ['REIMBURSEMENT']) ){
                    return $q->whereRaw("UPPER(document_no) >= '".$document_from."'")
                        ->whereRaw("UPPER(document_no) <= '".$document_to."'");
                } else if( in_array( $document_type, ['CASH-ADVANCE']) ) {
                    return $q->whereRaw("UPPER(document_no) >= '".$document_from."'")
                        ->whereRaw("UPPER(document_no) <= '".$document_to."'");
                } else if( in_array( $document_type, ['CLEARING']) ) {
                    return $q->whereRaw("UPPER(clearing_document_no) >= '".$document_from."'")
                        ->whereRaw("UPPER(clearing_document_no) <= '".$document_to."'");
                } else {
                    return $q;
                }
            }elseif($document_from){
                if( in_array( $document_type, ['REIMBURSEMENT']) ){
                    return $q->whereRaw("UPPER(document_no) >= '".$document_from."'");
                } else if( in_array( $document_type, ['CASH-ADVANCE']) ) {
                    return $q->whereRaw("UPPER(document_no) >= '".$document_from."'");
                } else if( in_array( $document_type, ['CLEARING']) ) {
                    return $q->whereRaw("UPPER(clearing_document_no) >= '".$document_from."'");
                } else {
                    return $q;
                }
            }elseif($document_to){
                if( in_array( $document_type, ['REIMBURSEMENT']) ){
                    return $q->whereRaw("UPPER(document_no) <= '".$document_to."'");
                } else if( in_array( $document_type, ['CASH-ADVANCE']) ) {
                    return $q->whereRaw("UPPER(document_no) <= '".$document_to."'");
                } else if( in_array( $document_type, ['CLEARING']) ) {
                    return $q->whereRaw("UPPER(clearing_document_no) <= '".$document_to."'");
                } else {
                    return $q;
                }
            }else return $q;
        })
        ->orderBy('document_no')
        ->get();

        // dd($data);

        $pdf = PDF::loadView('ie.commons.report.pdf.ct-invoice-register._template', compact(
                'data',
                'document_type'
            ))
            ->setPaper('a4')
            ->setOrientation('landscape')
            ->setOption('margin-bottom', 0);
        return $pdf->stream('invoice.pdf');
    }

    public function ctWHT(Request $request)
    {
        $groupTaxCode = $request->group_tax_type;
        $whtType = $request->wht_type;
        $preparer = $request->preparer;
        $startDate = $request->start_date ? \DateTime::createFromFormat(trans('date.format'), $request->start_date)->format('d-M-y') : null;
        $startSearchDate = Carbon::createFromFormat('d-M-y', $startDate)->startOfDay();
        $endDate = $request->end_date ? \DateTime::createFromFormat(trans('date.format'), $request->end_date)->format('d-M-y') : null;
        $endSearchDate = Carbon::createFromFormat('d-M-y', $endDate)->endOfDay();
        $document_type = strtoupper($request->document_type);
        $document_from =  strtoupper($request->document_no_from);
        $document_to =  strtoupper($request->document_no_to);

        $oneDoc = $document_from == $document_to ? $document_from : null;

        $query = ReceiptLine::where(function($q){
            return $q->where(function($p) {
                return $p->where('dff_wht_flag', 'Y')
                    ->whereNotNull('dff_wht_ref_number');
            })->orWhere(function($p){
                return $p->where('distribution_type', 'ภาษีเงินได้หัก ณ ที่จ่าย')
                    ->whereNotNull('distribution_wht_date')
                    ->whereNotNull('distribution_cert_number')
                    ->whereNotNull('distribution_income_type')
                    ->whereNotNull('distribution_income_name');
            });
        })
        ->whereRaw("exists (
            select * from ptw_receipts 
            where ptw_receipt_lines.receipt_id = ptw_receipts.receipt_id 
            and (
                (
                    ptw_receipts.receiptable_type = 'App\Models\IE\CashAdvance' 
                    and exists (
                        select * from ptw_cash_advances 
                        where ptw_receipts.receiptable_id = ptw_cash_advances.cash_advance_id 
                        and apply_to is null
                    )
                ) 
                or (
                    ptw_receipts.receiptable_type = 'App\Models\IE\Reimbursement'
                    and exists (
                        select * from ptw_reimbursements 
                        where ptw_receipts.receiptable_id = ptw_reimbursements.reimbursement_id
                    )
                )
            ) 
            and ptw_receipts.deleted_at is null
        )")
        ->whereHas('header', function($q) use ($document_type) {
            return $q->where('process_type', $document_type);
        })
        ->where(function($q){
            return $q->where('total_amount_inc_vat', '<', 0);
        })
        ->when($document_from || $document_to, function($q) use($document_from, $document_to){
            return $q->whereHas('header', function($p) use($document_from, $document_to) {
                return $p->whereHas('receiptable', function($t) use($document_from, $document_to) {
                    return $t->whereRaw("
                        exists (
                            select * from ptw_receipts 
                            where ptw_receipt_lines.receipt_id = ptw_receipts.receipt_id 
                            and (
                                (
                                    ptw_receipts.receiptable_type = 'App\Models\IE\CashAdvance' 
                                    and exists (
                                        select * from ptw_cash_advances 
                                        where ptw_receipts.receiptable_id = ptw_cash_advances.cash_advance_id"
                                        .(
                                            $document_from ? " and UPPER(clearing_document_no) >= '".$document_from."'" : ""
                                        ).( 
                                            $document_to ? " and UPPER(clearing_document_no) <= '".$document_to."'" : ""
                                        )."
                                    )
                                )
                                or (
                                    ptw_receipts.receiptable_type = 'App\Models\IE\CashAdvance' 
                                    and exists (
                                        select * from ptw_cash_advances 
                                        where ptw_receipts.receiptable_id = ptw_cash_advances.cash_advance_id"
                                        .(
                                            $document_from ? " and UPPER(document_no) >= '".$document_from."'" : ""
                                        ).( 
                                            $document_to ? " and UPPER(document_no) <= '".$document_to."'" : ""
                                        )."
                                    )
                                )
                                or (
                                    ptw_receipts.receiptable_type = 'App\Models\IE\Reimbursement' 
                                    and exists (
                                        select * from ptw_reimbursements 
                                        where ptw_receipts.receiptable_id = ptw_reimbursements.reimbursement_id"
                                        .(
                                            $document_from ? " and UPPER(document_no) >= '".$document_from."'" : ""
                                        ).( 
                                            $document_to ? " and UPPER(document_no) <= '".$document_to."'" : ""
                                        )."
                                    )
                                )
                            ) 
                            and ptw_receipts.deleted_at is null
                        )
                    ");
                });
            });
        })
        ->when($preparer, function($q) use($preparer) {
            return $q->whereHas('header', function($p) use ($preparer) {
                return $p->whereHas('receiptable', function($t) use ($preparer){
                    return $t->whereHas('preparer', function($u) use ($preparer) {
                        return $u->where('name', 'like', '%'.$preparer.'%')
                            ->orWhere('username', 'like', '%'.$preparer.'%');
                    });
                });
            });
        })
        ->when($groupTaxCode, function($q, $groupTaxCode) {
            return $q->where('dff_group_tax_code', $groupTaxCode);
        })
        ->when($whtType, function($q) use($whtType) {
            return $q->where('distribution_income_type', $whtType);
        })
        ->when($startSearchDate || $endSearchDate, function($q) use($startSearchDate, $endSearchDate){
            return $q->whereBetween('distribution_wht_date', [$startSearchDate, $endSearchDate]);
        })
        ->get()
        ->groupBy([function($item) use ($document_type){
            $document = optional($item->header)->parent;
            return in_array( $document_type, ['CLEARING']) ? $document->clearing_document_no : $document->document_no;
        }]);

        $maxLine = 10;
        $line_num = 0;
        $page = 0;
        $data = [];
        foreach($query as $document_no => $lines) {
            foreach ($lines as $line) {
                $data[$page][$document_no]['end_flag'] = false;

                $refs = ReceiptLine::whereHas('header', function($p) use ($line) {
                    return $p->where('receiptable_id', $line->header->receiptable_id)
                    ->where('receiptable_type', $line->header->receiptable_type);
                })
                ->whereHas('header', function($p) use ($document_type) {
                    return $p->where('process_type', $document_type);
                })
                ->whereRaw("exists (
                    select * from ptw_receipts 
                    where ptw_receipt_lines.receipt_id = ptw_receipts.receipt_id 
                    and (
                        (   
                            ptw_receipts.receiptable_type = 'App\Models\IE\CashAdvance' 
                            and exists (
                                select * from ptw_cash_advances 
                                where ptw_receipts.receiptable_id = ptw_cash_advances.cash_advance_id 
                                and apply_to is null
                            )
                        ) 
                        or (
                            ptw_receipts.receiptable_type = 'App\Models\IE\Reimbursement'
                            and exists (
                                select * from ptw_reimbursements 
                                where ptw_receipts.receiptable_id = ptw_reimbursements.reimbursement_id
                            )
                        )
                    ) 
                    and ptw_receipts.deleted_at is null
                )")
                ->where('dff_wht_flag', 'Y')
                ->where('dff_wht_ref_number', $line->distribution_cert_number)
                ->when($document_from || $document_to, function($q) use($document_from, $document_to){
                    return $q->whereHas('header', function($p) use($document_from, $document_to) {
                        return $p->whereHas('receiptable', function($t) use($document_from, $document_to) {
                            return $t->whereRaw("
                                exists (
                                    select * from ptw_receipts 
                                    where ptw_receipt_lines.receipt_id = ptw_receipts.receipt_id 
                                    and (
                                        (
                                            ptw_receipts.receiptable_type = 'App\Models\IE\CashAdvance' 
                                            and exists (
                                                select * from ptw_cash_advances 
                                                where ptw_receipts.receiptable_id = ptw_cash_advances.cash_advance_id"
                                                .(
                                                    $document_from ? " and UPPER(clearing_document_no) >= '".$document_from."'" : ""
                                                ).( 
                                                    $document_to ? " and UPPER(clearing_document_no) <= '".$document_to."'" : ""
                                                )."
                                            )
                                        )
                                        or (
                                            ptw_receipts.receiptable_type = 'App\Models\IE\CashAdvance' 
                                            and exists (
                                                select * from ptw_cash_advances 
                                                where ptw_receipts.receiptable_id = ptw_cash_advances.cash_advance_id"
                                                .(
                                                    $document_from ? " and UPPER(document_no) >= '".$document_from."'" : ""
                                                ).( 
                                                    $document_to ? " and UPPER(document_no) <= '".$document_to."'" : ""
                                                )."
                                            )
                                        )
                                        or (
                                            ptw_receipts.receiptable_type = 'App\Models\IE\Reimbursement' 
                                            and exists (
                                                select * from ptw_reimbursements 
                                                where ptw_receipts.receiptable_id = ptw_reimbursements.reimbursement_id"
                                                .(
                                                    $document_from ? " and UPPER(document_no) >= '".$document_from."'" : ""
                                                ).( 
                                                    $document_to ? " and UPPER(document_no) <= '".$document_to."'" : ""
                                                )."
                                            )
                                        )
                                    ) 
                                    and ptw_receipts.deleted_at is null
                                )
                            ");
                        });
                    });
                })
                ->get();

                if(!array_key_exists('lines', $data[$page][$document_no])){
                    $data[$page][$document_no]['lines'] = [];
                }

                foreach($refs as $ref){

                    if($line_num >= $maxLine){
                        $line_num = 0;
                        $page++;
                        $data[$page][$document_no]['end_flag'] = false;
                    }

                    $ref->ref = $line;

                    $data[$page][$document_no]['lines'][] = $ref;
                    $line_num++;
                }
            }
            $data[$page][$document_no]['end_flag'] = true;
            $page++;
        }
        // dd($data);

        $pdf = PDF::loadView('ie.commons.report.pdf.ct-wht-register._template', 
            compact(
                'data',
                'whtType',
                'startDate',
                'endDate',
                'document_type',
                'oneDoc'
            ))
            ->setPaper('a4')
            ->setOrientation('landscape')
            ->setOption('margin-bottom', 0);
        return $pdf->stream('ทะเบียนคุมภาษีเงินได้หัก ณ ที่จ่าย.pdf');
    }

    public function ctCa(Request $request)
    {
        $department_from = $request->department_from;
        $department_to = $request->department_to;
        $requester = $request->requester;
        $date_from = $request->start_date;
        $date_to = $request->end_date;
        $advance_type = $request->advance_type;

        $startMonth = Carbon::createFromFormat('d/m/Y', $date_from)->format('n');
        $startSearchDate = Carbon::createFromFormat('d/m/Y', $date_from)->startOfDay();
        $end = Carbon::createFromFormat('d/m/Y', $date_to)->endOfDay();
        $end3month = Carbon::createFromFormat('d/m/Y', $date_from)->addMonths(2)->endOfMonth()->endOfDay();
        $endSearchDate = $end->gte($end3month) ? $end3month : $end;

        $user_ids = [];
        if($requester){
            $user_ids = User::whereRaw("UPPER(name) like '%".$requester."%'")
                ->pluck('user_id');
        }

        $search = CashAdvance::with('interfaces', 'activityLogs')
            ->whereNull('apply_to')
            ->orderBy('creation_date')
            ->whereBetween('creation_date', [$startSearchDate, $endSearchDate])
            // ->whereHas('interfaces', function ($q) use($startSearchDate, $endSearchDate){
            //     return $q->whereBetween('creation_date', [$startSearchDate, $endSearchDate]);
            // })
            ->when($department_from || $department_to, function($q) use($department_from, $department_to) {
                if($department_from && $department_to){
                    $oneDepart = $department_from == $department_to;
                    if($oneDepart){
                        $q->where('department_code', $department_from);
                    }else {
                        $q->where('department_code', '>=', $department_from)
                            ->where('department_code', '<=', $department_to);
                    }
                }elseif($department_from){
                    $q->where('department_code', '>=', $department_from);
                }elseif($department_to){
                    $q->where('department_code', '<=', $department_to);
                }
            })
            ->when($advance_type, function($q) use($advance_type){
                $q->where('advance_type', $advance_type);
            })
            ->when($requester, function($q) use($user_ids){
                $q->whereIn('user_id', $user_ids);
            })
            ->get();

        $groupDatas = $search->groupBy(function ($item, $key) {
            // $ca_interface = $item->interfaces->where('request_from', 'CASH-ADVANCE')->first();
            // return $ca_interface->creation_date->format('n-Y');
            return $item->creation_date->format('n-Y');
        });

        $countInMonth = $groupDatas->map(function ($item, $key) {
            return $item->count();
        })->toArray();

        $maxLine = 15;
        $line_num = 0;
        $page = 0;
        $data = [];
        foreach($groupDatas as $groupMonth => $lines){
            if($line_num >= $maxLine){
                $line_num = 0;
                $page++;
            }
            $line_num++;
            foreach($lines as $line){
                if($line_num >= $maxLine){
                    $line_num = 1;
                    $page++;
                }
                $data[$page][$groupMonth][] = $line;
                $line_num++;
            }
        }
        // dd($data);
        $txtMonth = [
            '1' => 'มกราคม',
            '2' => 'กุมภาพันธ์',
            '3' => 'มีนาคม',
            '4' => 'เมษายน',
            '5' => 'พฤษภาคม',
            '6' => 'มิถุนายน',
            '7' => 'กรกฎาคม',
            '8' => 'สิงหาคม',
            '9' => 'กันยายน',
            '10' => 'ตุลาคม',
            '11' => 'พฤศจิกายน',
            '12' => 'ธันวาคม'
        ];

        $shortTxtMonth = [
            '1' => 'ม.ค.',
            '2' => 'ก.พ.',
            '3' => 'มี.ค.',
            '4' => 'เม.ย.',
            '5' => 'พ.ค.',
            '6' => 'มิ.ย.',
            '7' => 'ก.ค.',
            '8' => 'ส.ค.',
            '9' => 'ก.ย.',
            '10' => 'ต.ค.',
            '11' => 'พ.ย.',
            '12' => 'ธ.ค.'
        ];

        $pdf = PDF::loadView('ie.commons.report.pdf.ct-ca-register._template', 
            compact(
                'data',
                'txtMonth',
                'shortTxtMonth',
                'startMonth',
                'startSearchDate',
                'endSearchDate',
                'countInMonth'
            ))
            ->setPaper('a4')
            ->setOrientation('landscape')
            ->setOption('margin-bottom', 0);
        return $pdf->stream('ทะเบียนคุมเงินทดรอง.pdf');
    }

    public function ctBudget(Request $request)
    {
        $department = $request->department;
        $docType = $request->document_type;
        // $docNo = $request->document_no;
        $docNoFrom = strtoupper($request->document_no_from);
        $docNoTo =  strtoupper($request->document_no_to);
        $purpose = $request->purpose;

        if( in_array( $docType, ['REIMBURSEMENT']) ){
            $query = Reimbursement::has('receipts.lines');
        }else {
            $query = CashAdvance::has('receipts.lines')->whereNull('apply_to');
        }

        $needByDate = $request->need_by_date ? Carbon::createFromFormat('d/m/Y', $request->need_by_date) : null;
        $query = $query->when($department, function($q) use ($department){
            return $q->whereHas('requester', function($p) use($department){
                return $p->whereHas('PersonalDeptLocation', function($t) use($department){
                    return $t->where('dept_cd_f02', $department);
                });
            });
        })
        ->when($docNoFrom || $docNoTo, function($q) use($docNoFrom, $docNoTo, $docType){
            if($docNoFrom && $docNoTo){
                if( in_array( $docType, ['REIMBURSEMENT']) ){
                    return $q->whereRaw("UPPER(document_no) >= '".$docNoFrom."'")
                        ->whereRaw("UPPER(document_no) <= '".$docNoTo."'");
                } else if( in_array( $docType, ['CASH-ADVANCE']) ) {
                    return $q->whereRaw("UPPER(document_no) >= '".$docNoFrom."'")
                        ->whereRaw("UPPER(document_no) <= '".$docNoTo."'");
                } else if( in_array( $docType, ['CLEARING']) ) {
                    return $q->whereRaw("UPPER(clearing_document_no) >= '".$docNoFrom."'")
                        ->whereRaw("UPPER(clearing_document_no) <= '".$docNoTo."'");
                } else {
                    return $q;
                }
            }elseif($docNoFrom){
                if( in_array( $docType, ['REIMBURSEMENT']) ){
                    return $q->whereRaw("UPPER(document_no) >= '".$docNoFrom."'");
                } else if( in_array( $docType, ['CASH-ADVANCE']) ) {
                    return $q->whereRaw("UPPER(document_no) >= '".$docNoFrom."'");
                } else if( in_array( $docType, ['CLEARING']) ) {
                    return $q->whereRaw("UPPER(clearing_document_no) >= '".$docNoFrom."'");
                } else {
                    return $q;
                }
            }elseif($docNoTo){
                if( in_array( $docType, ['REIMBURSEMENT']) ){
                    return $q->whereRaw("UPPER(document_no) <= '".$docNoTo."'");
                } else if( in_array( $docType, ['CASH-ADVANCE']) ) {
                    return $q->whereRaw("UPPER(document_no) <= '".$docNoTo."'");
                } else if( in_array( $docType, ['CLEARING']) ) {
                    return $q->whereRaw("UPPER(clearing_document_no) <= '".$docNoTo."'");
                } else {
                    return $q;
                }
            }else return $q;
        })
        ->when($needByDate, function($q, $needByDate){
            return $q->whereDate('need_by_date', $needByDate);
        })
        ->orderBy('document_no')
        ->get();

        $budgetDetailInfo = FNDListOfValues::budgetDetail()->first();
        $accountInfo = FNDListOfValues::subAccount()->first();

        $maxLine = 15;
        $line_num = 0;
        $page = 0;
        $data = [];
        foreach($query as $index => $document){

            $receipts = $document->receipts()->processType($docType)->get();
            if(!$receipts->count()){
                continue;
            }

            $data[$page]['lines'] = [];
            $data[$page]['accounts'] = [];
            $data[$page]['document'] = $document;
            $arrAccount = [];

            foreach($receipts as $receipt){
                $lines = $receipt->lines()->whereHas('subCategory', function($p){
                    return $p->where('wht_flag', 0);
                })->get();

                foreach($lines as $line){
                    if($line_num >= $maxLine){
                        $line_num = 0;
                        $page++;
                        $data[$page]['accounts'] = [];
                    }
                    $data[$page]['document'] = $document;
                    $data[$page]['lines'][] = $line;

                    $segments = explode('.', $line->concatenated_segments);

                    if(!array_key_exists($line->code_combination_id, $arrAccount)){
                        $arrAccount[$line->code_combination_id]['code_combination_id'] = $line->code_combination_id;
                        $arrAccount[$line->code_combination_id]['concatenated_segments'] = $line->concatenated_segments;
                        $arrAccount[$line->code_combination_id]['budget_year'] = $segments[4];
                        $arrAccount[$line->code_combination_id]['budget_code'] = $segments[2].'.'.$segments[5].'.'.$segments[6].'.'.$segments[7].'.'.$segments[8].'.'.$segments[9];

                        $des_seg3 = optional(FNDListOfValues::department()->where('flex_value', $segments[2])->first())->description;
                        $des_seg6 = optional(FNDListOfValues::budgetType()->where('flex_value', $segments[5])->first())->description;
                        $des_seg7 = optional(FNDListOfValues::budgetDetail()->byParentValue(optional($budgetDetailInfo)->parent_flex_value_set_name, $segments[5])->where('flex_value', $segments[6])->first())->description;
                        $des_seg8 = optional(FNDListOfValues::budgetReason()->where('flex_value', $segments[7])->first())->description;
                        $des_seg9 = optional(FNDListOfValues::account()->where('flex_value', $segments[8])->first())->description;
                        $des_seg10 = optional(FNDListOfValues::subAccount()->byParentValue(optional($accountInfo)->parent_flex_value_set_name, $segments[8])->where('flex_value', $segments[9])->first())->description;

                        $arrAccount[$line->code_combination_id]['budget_description'] = $des_seg3.'.'.$des_seg6.'.'.$des_seg7.'.'.$des_seg8.'.'.$des_seg9.'.'.$des_seg10;
                        $arrAccount[$line->code_combination_id]['budget_amount'] = (float)$line->budget_amount;
                        $arrAccount[$line->code_combination_id]['encumbrance_amount'] = (float)$line->encumbrance_amount;
                        $arrAccount[$line->code_combination_id]['actual_amount'] = (float)$line->actual_amount;
                        $arrAccount[$line->code_combination_id]['fund_available'] = (float)$line->fund_available;
                    }

                    $line_num++;
                }
            }
            
            if(($line_num >= 5) || (count($arrAccount) >= 3)){
                $line_num = 0;
                $page++;
                $data[$page]['lines'] = [];
            }

            foreach($arrAccount as $codeCombinationId => $account){

                if($line_num >= $maxLine){
                    $line_num = 0;
                    $page++;
                    $data[$page]['lines'] = [];
                }
                $data[$page]['document'] = $document;
                $data[$page]['accounts'] = $arrAccount;
                $line_num++;
            }
            $line_num = 0;
            $page++;
        }
        // dd($data);

        $pdf = PDF::loadView('ie.commons.report.pdf.ct-budget._template', 
            compact(
                'data',
                'docType'
            ))
            ->setPaper('a4')
            ->setOrientation('landscape')
            ->setOption('margin-bottom', 0);
        return $pdf->stream('ใบขออนุมัติหลักการใช้งบ.pdf');
    }

    public function ctVat(Request $request)
    {
        // dd($request->all());
        $document_type = strtoupper($request->document_type);
        $department = $request->department;
        $requester = strtoupper($request->requester);
        $date_from = $request->request_date_from;
        $date_to = $request->request_date_to;
        $invoice_from = strtoupper($request->invoice_no_from);
        $invoice_to = strtoupper($request->invoice_no_to);
        $document_from =  strtoupper($request->document_no_from);
        $document_to =  strtoupper($request->document_no_to);

        if( $document_type == 'REIMBURSEMENT' ){
            $query = Reimbursement::whereHas('receipts', function($q){
                return $q->whereHas('lines', function($p){
                    return $p->whereNotNull('vat_id');
                });
            })
            ->with('interfaces', 'interfaces.lines');
        }else {
            $query = CashAdvance::whereHas('receipts', function($q){
                return $q->whereHas('lines', function($p){
                    return $p->whereNotNull('vat_id');
                });
            })
            ->with('interfaces', 'interfaces.lines')->whereNull('apply_to');
        }

        $data = $query->when($department, function($q, $department){
            return $q->whereHas('requester', function($p) use($department){
                return $p->whereHas('PersonalDeptLocation', function($t) use($department){
                    return $t->where('dept_cd_f02', $department);
                });
            });
        })
        ->when($requester, function($q, $requester){
            return $q->where('requester_id', $requester);
        })
        ->when($date_from || $date_to, function($q) use($date_from, $date_to){
            if($date_from && $date_to){
                $oneDate = $date_from == $date_to;
                if($oneDate){
                    return $q->whereDate('creation_date', Carbon::createFromFormat('d/m/Y', $date_from));
                }else {
                    return $q->whereBetween('creation_date', [Carbon::createFromFormat('d/m/Y', $date_from)->startOfDay(), Carbon::createFromFormat('d/m/Y', $date_to)->endOfDay()]);
                }
            }elseif($date_from){
                $q->whereDate('creation_date', '>=', Carbon::createFromFormat('d/m/Y', $date_from));
            }elseif($date_to){
                $q->whereDate('creation_date', '<=', Carbon::createFromFormat('d/m/Y', $date_to));
            }else return $q;
        })
        ->when($invoice_from || $invoice_to, function($q) use($invoice_from, $invoice_to, $document_type){
            if($invoice_from && $invoice_to){
                if( in_array( $document_type, ['REIMBURSEMENT']) ){
                    return $q->whereRaw("UPPER(invoice_no) >= '".$invoice_from."'")
                        ->whereRaw("UPPER(invoice_no) <= '".$invoice_to."'");
                } else if( in_array( $document_type, ['CASH-ADVANCE']) ) {
                    return $q->whereRaw("UPPER(invoice_no) >= '".$invoice_from."'")
                        ->whereRaw("UPPER(invoice_no) <= '".$invoice_to."'");
                } else if( in_array( $document_type, ['CLEARING']) ) {
                    return $q->whereRaw("UPPER(clearing_invoice_no) >= '".$invoice_from."'")
                        ->whereRaw("UPPER(clearing_invoice_no) <= '".$invoice_to."'");
                } else {
                    return $q;
                }
            }else if($invoice_from){
                if( in_array( $document_type, ['REIMBURSEMENT']) ){
                    return $q->whereRaw("UPPER(invoice_no) >= '".$invoice_from."'");
                } else if( in_array( $document_type, ['CASH-ADVANCE']) ) {
                    return $q->whereRaw("UPPER(invoice_no) >= '".$invoice_from."'");
                } else if( in_array( $document_type, ['CLEARING']) ) {
                    return $q->whereRaw("UPPER(clearing_invoice_no) >= '".$invoice_from."'");
                } else {
                    return $q;
                }
            }else if($invoice_to){
                if( in_array( $document_type, ['REIMBURSEMENT']) ){
                    return $q->whereRaw("UPPER(invoice_no) <= '".$invoice_to."'");
                } else if( in_array( $document_type, ['CASH-ADVANCE']) ) {
                    return $q->whereRaw("UPPER(invoice_no) <= '".$invoice_to."'");
                } else if( in_array( $document_type, ['CLEARING']) ) {
                    return $q->whereRaw("UPPER(clearing_invoice_no) <= '".$invoice_to."'");
                } else {
                    return $q;
                }
            }else return $q;
        })
        ->when($document_from || $document_to, function($q) use($document_from, $document_to, $document_type){
            if($document_from && $document_to){
                if( in_array( $document_type, ['REIMBURSEMENT']) ){
                    return $q->whereRaw("UPPER(document_no) >= '".$document_from."'")
                        ->whereRaw("UPPER(document_no) <= '".$document_to."'");
                } else if( in_array( $document_type, ['CASH-ADVANCE']) ) {
                    return $q->whereRaw("UPPER(document_no) >= '".$document_from."'")
                        ->whereRaw("UPPER(document_no) <= '".$document_to."'");
                } else if( in_array( $document_type, ['CLEARING']) ) {
                    return $q->whereRaw("UPPER(clearing_document_no) >= '".$document_from."'")
                        ->whereRaw("UPPER(clearing_document_no) <= '".$document_to."'");
                } else {
                    return $q;
                }
            }elseif($document_from){
                if( in_array( $document_type, ['REIMBURSEMENT']) ){
                    return $q->whereRaw("UPPER(document_no) >= '".$document_from."'");
                } else if( in_array( $document_type, ['CASH-ADVANCE']) ) {
                    return $q->whereRaw("UPPER(document_no) >= '".$document_from."'");
                } else if( in_array( $document_type, ['CLEARING']) ) {
                    return $q->whereRaw("UPPER(clearing_document_no) >= '".$document_from."'");
                } else {
                    return $q;
                }
            }elseif($document_to){
                if( in_array( $document_type, ['REIMBURSEMENT']) ){
                    return $q->whereRaw("UPPER(document_no) <= '".$document_to."'");
                } else if( in_array( $document_type, ['CASH-ADVANCE']) ) {
                    return $q->whereRaw("UPPER(document_no) <= '".$document_to."'");
                } else if( in_array( $document_type, ['CLEARING']) ) {
                    return $q->whereRaw("UPPER(clearing_document_no) <= '".$document_to."'");
                } else {
                    return $q;
                }
            }else return $q;
        })
        ->orderBy('document_no')
        ->get();

        // dd($data);

        $pdf = PDF::loadView('ie.commons.report.pdf.ct-vat-register._template', compact(
                'data',
                'document_type'
            ))
            ->setPaper('a4')
            ->setOrientation('landscape')
            ->setOption('margin-bottom', 0);
        return $pdf->stream('vat.pdf');
    }

    public function getCtInvoiceRequester(Request $request)
    {
        $department = $request->department;

        $employeeLists = HREmployee::whereHas('PersonalDeptLocation', function( $q ) use( $department ){
            return $q->where('dept_cd_f02', $department);
        })
        ->select(\DB::raw("first_name || ' ' || last_name AS description"), 'username')
        ->orderBy('username')
        ->pluck('description','username')
        ->all();

        return response()->json($employeeLists);
    }

    public function getCtInvoiceDocument(Request $request)
    {
        $docType = $request->doc_type;
        $department = $request->department;
        $requester = $request->requester;

        if( in_array( $docType, ['REIMBURSEMENT']) ){
            $query = Reimbursement::has('receipts.lines')
            ->select('reimbursement_id as document_id', 'document_no', 'invoice_no');
        }else if( in_array( $docType, ['CASH-ADVANCE']) ) {
            $query = CashAdvance::has('receipts.lines')->whereNull('apply_to')
            ->select('cash_advance_id as document_id', 'document_no', 'invoice_no');
        }elseif( in_array( $docType, ['CLEARING']) ) {
            $query = CashAdvance::has('receipts.lines')->whereNull('apply_to')
            ->select('cash_advance_id as document_id', 'clearing_document_no as document_no', 'clearing_invoice_no as invoice_no');
        }else {
            return response()->json([]);
        }

        $documentLists = $query->when($department, function($q) use ($department, $requester){
            if($requester){
                return $q->where('requester_id', $requester);
            }
            return $q->whereHas('requester', function($p) use($department){
                return $p->whereHas('PersonalDeptLocation', function($t) use($department){
                    return $t->where('dept_cd_f02', $department);
                });
            });
        })
        ->orderBy('document_no')
        ->get();

        return response()->json($documentLists);
    }

    public function getCtWhtDocument(Request $request)
    {
        $docType = $request->doc_type;
        $groupTaxCode = $request->group_tax_code;
        $whtType = $request->wht_type;

        if( in_array( $docType, ['REIMBURSEMENT']) ){
            $query = Reimbursement::has('receipts.lines')
            ->select('reimbursement_id as document_id', 'document_no');
        }else if( in_array( $docType, ['CASH-ADVANCE']) ) {
            $query = CashAdvance::has('receipts.lines')->whereNull('apply_to')
            ->select('cash_advance_id as document_id', 'document_no');
        }elseif( in_array( $docType, ['CLEARING']) ) {
            $query = CashAdvance::has('receipts.lines')->whereNull('apply_to')
            ->select('cash_advance_id as document_id', 'clearing_document_no as document_no');
        }else {
            return response()->json([]);
        }

        $documentLists = $query
        ->whereHas('receipts', function($q) use ($docType, $groupTaxCode, $whtType) {
            return $q->whereHas('lines', function($p) use ($docType, $groupTaxCode, $whtType) {
                return $p->where(function($u){
                    return $u->where(function($t) {
                        return $t->where('dff_wht_flag', 'Y')
                            ->whereNotNull('dff_wht_ref_number');
                    })->orWhere(function($t){
                        return $t->where('distribution_type', 'ภาษีเงินได้หัก ณ ที่จ่าย')
                            ->whereNotNull('distribution_wht_date')
                            ->whereNotNull('distribution_cert_number')
                            ->whereNotNull('distribution_income_type')
                            ->whereNotNull('distribution_income_name');
                    });
                })
                ->whereRaw("exists (
                    select * from ptw_receipts 
                    where ptw_receipt_lines.receipt_id = ptw_receipts.receipt_id 
                    and (
                        (
                            ptw_receipts.receiptable_type = 'App\Models\IE\CashAdvance' 
                            and exists (
                                select * from ptw_cash_advances 
                                where ptw_receipts.receiptable_id = ptw_cash_advances.cash_advance_id 
                                and apply_to is null
                            )
                        ) 
                        or (
                            ptw_receipts.receiptable_type = 'App\Models\IE\Reimbursement'
                            and exists (
                                select * from ptw_reimbursements 
                                where ptw_receipts.receiptable_id = ptw_reimbursements.reimbursement_id
                            )
                        )
                    ) 
                    and ptw_receipts.deleted_at is null
                )")
                ->whereHas('header', function($u) use ($docType) {
                    return $u->where('process_type', $docType);
                })
                ->when($groupTaxCode, function($q, $groupTaxCode) {
                    return $q->where('dff_group_tax_code', $groupTaxCode);
                })
                ->when($whtType, function($q) use($whtType) {
                    return $q->where('distribution_income_type', $whtType);
                })
                ->where(function($u){
                    return $u->where('total_amount_inc_vat', '<', 0);
                });
            });
        })
        ->orderBy('document_no')
        ->get();

        return response()->json($documentLists);
    }

    public function getCtBudgetDocument(Request $request)
    {
        $docType = $request->doc_type;
        $department = $request->department;

        if( in_array( $docType, ['REIMBURSEMENT']) ){
            $query = Reimbursement::has('receipts.lines')
            ->select('reimbursement_id as document_id', 'document_no');
        }else if( in_array( $docType, ['CASH-ADVANCE']) ) {
            $query = CashAdvance::has('receipts.lines')->whereNull('apply_to')
            ->select('cash_advance_id as document_id', 'document_no');
        }elseif( in_array( $docType, ['CLEARING']) ) {
            $query = CashAdvance::has('receipts.lines')->whereNull('apply_to')
            ->select('cash_advance_id as document_id', 'clearing_document_no as document_no');
        }else {
            return response()->json([]);
        }

        $documentLists = $query->when($department, function($q) use ($department){
            return $q->whereHas('requester', function($p) use($department){
                return $p->whereHas('PersonalDeptLocation', function($t) use($department){
                    return $t->where('dept_cd_f02', $department);
                });
            });
        })
        ->orderBy('document_no')
        ->get();

        return response()->json($documentLists);
    }

    public function getCtVatRequester(Request $request)
    {
        $department = $request->department;

        $employeeLists = HREmployee::whereHas('PersonalDeptLocation', function( $q ) use( $department ){
            return $q->where('dept_cd_f02', $department);
        })
        ->select(\DB::raw("first_name || ' ' || last_name AS description"), 'username')
        ->orderBy('username')
        ->pluck('description','username')
        ->all();

        return response()->json($employeeLists);
    }

    public function getCtVatDocument(Request $request)
    {
        $docType = $request->doc_type;
        $department = $request->department;
        $requester = $request->requester;

        if( in_array( $docType, ['REIMBURSEMENT']) ){
            $query = Reimbursement::whereHas('receipts', function($q){
                return $q->whereHas('lines', function($p){
                    return $p->whereNotNull('vat_id');
                });
            })
            ->select('reimbursement_id as document_id', 'document_no', 'invoice_no');
        }else if( in_array( $docType, ['CASH-ADVANCE']) ) {
            $query = CashAdvance::whereHas('receipts', function($q){
                return $q->whereHas('lines', function($p){
                    return $p->whereNotNull('vat_id');
                });
            })
            ->whereNull('apply_to')
            ->select('cash_advance_id as document_id', 'document_no', 'invoice_no');
        }elseif( in_array( $docType, ['CLEARING']) ) {
            $query = CashAdvance::whereHas('receipts', function($q){
                return $q->whereHas('lines', function($p){
                    return $p->whereNotNull('vat_id');
                });
            })
            ->whereNull('apply_to')
            ->select('cash_advance_id as document_id', 'clearing_document_no as document_no', 'clearing_invoice_no as invoice_no');
        }else {
            return response()->json([]);
        }

        $documentLists = $query->when($department, function($q) use ($department, $requester){
            if($requester){
                return $q->where('requester_id', $requester);
            }
            return $q->whereHas('requester', function($p) use($department){
                return $p->whereHas('PersonalDeptLocation', function($t) use($department){
                    return $t->where('dept_cd_f02', $department);
                });
            });
        })
        ->orderBy('document_no')
        ->get();

        return response()->json($documentLists);
    }

}
