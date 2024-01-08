<?php

namespace App\Http\Controllers\IE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\IE\CashAdvance;
use App\Models\IE\ReceiptLine;
use App\Models\IE\Reimbursement;
use App\Models\IE\APReportingEntity;
use App\Models\IE\APHeaderDFFContext;
use App\Models\IE\APLineDFFContext;

class DFFController extends Controller
{

    protected $orgId;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->orgId = getDefaultData()->bu_id;
            return $next($request);
        });
    }

    public function getFormHeader(Request $request)
    {
        $requestType = $request->requestType;
        $dffType = $header = null;
        $formType = 'HEADER';

        if( in_array($requestType, ['CASH-ADVANCE', 'CLEARING']) ){

            $header = CashAdvance::find($request->requestId);
            $requestId = $request->requestId;

        }elseif ($requestType == 'REIMBURSEMENT'){

            $header = Reimbursement::find($request->requestId);
            $requestId = $request->requestId;
            $dffType = $header->dff_type;
        }

        return view('ie.commons.dff._form_header',
                compact(
                    'header',
                    'requestId',
                    'requestType',
                    'formType',
                    'dffType'
                ));
    }

    public function getFormLine(Request $request)
    {
        $requestType = $request->requestType;
        $dffType = $line = null;
        $formType = 'LINE';

        $line = ReceiptLine::find($request->requestId);
        $requestId = $request->requestId;
        $receipt = $line->header;
        
        return view('ie.commons.dff._form_line',
                compact(
                    'line',
                    'requestId',
                    'requestType',
                    'formType',
                    'dffType'
                ));
    }

    public function getForm(Request $request)
    {

        $dff = null;
        $requestType = $request->requestType;
        $dffType = $request->dffType;
        $formType = $request->formType;
        
        $orgId = $productValue = $receiptDate = $receiptNumber = $payFor = $groupTaxCode = $poRefNumber = $paidNumber = $taxAddress = $taxId = $branchNumber = $whtFlag = $whtRefNumber = null;
        // dd( $request->all() );

        if( in_array($requestType, ['CASH-ADVANCE']) ){

            $dff = CashAdvance::find($request->requestId);
            $orgId = $dff->org_id;
            $requestId = $request->requestId;
            $payFor = $dff->dff_pay_for;
            $groupTaxCode = $dff->dff_group_tax_code;

        }elseif ( in_array($requestType, ['CLEARING']) ){

            $dff = CashAdvance::find($request->requestId);
            $orgId = $dff->org_id;
            $requestId = $request->requestId;
            $payFor = $dff->clearing_dff_pay_for;
            $groupTaxCode = $dff->clearing_dff_group_tax_code;

        }elseif ( in_array($requestType, ['REIMBURSEMENT']) ){

            $dff = Reimbursement::find($request->requestId);
            $orgId = $dff->org_id;
            $requestId = $request->requestId;

            $payFor = $dff->dff_pay_for;
            $groupTaxCode = $dff->dff_group_tax_code;
            $receiptNumber = $dff->dff_tax_invoice_number;
            $receiptDate = $dff->dff_tax_invoice_date ? dateFormatDisplay($dff->dff_tax_invoice_date) : null;
            $poRefNumber = $dff->dff_po_ref_number;
            $paidNumber = $dff->dff_paid_number;
            $taxAddress = $dff->dff_address;
            $branchNumber = $dff->dff_branch_number;
            $taxId = $dff->dff_tax_id;

        }elseif ($requestType == 'RECEIPT-LINE'){

            $dff = ReceiptLine::find($request->requestId);
            $requestId = $request->requestId;
            $receipt = $dff->header;
            $parent = $receipt->parent;
            $orgId = $parent->org_id;

            $payFor = $dff->dff_pay_for;
            $groupTaxCode = $dff->dff_group_tax_code;
    
            $receiptNumber = $dff->dff_tax_invoice_number;
            $receiptDate = $dff->dff_tax_invoice_date ? dateFormatDisplay($dff->dff_tax_invoice_date) : null ;
            $productValue = $dff->dff_product_value;

            $taxAddress = $dff->dff_address;
            $branchNumber = $dff->dff_branch_number;
            $taxId = $dff->dff_tax_id;

            $whtFlag = $dff->dff_wht_flag;
            $whtRefNumber = $dff->dff_wht_ref_number;
        }

        $groupTaxCodes = APReportingEntity::select(\DB::raw("entity_name AS full_description"),'entity_name')
                    ->whereOrgId($orgId)
                    ->orderBy('entity_name')
                    ->pluck('full_description','entity_name')
                    ->all();

        return view('ie.commons.dff._form',
                compact(
                    'dff',
                    'requestId',
                    'requestType',
                    'formType',
                    'dffType',
                    'receiptNumber',
                    'receiptDate',
                    'productValue',
                    'payFor',
                    'groupTaxCodes',
                    'poRefNumber',
                    'paidNumber',
                    'taxAddress',
                    'taxId',
                    'branchNumber',
                    'whtFlag',
                    'whtRefNumber'
                ));
    }
}