<?php

namespace App\Http\Controllers\OM;

use Carbon\Carbon;
use App\Models\OM\OnHandV;
use App\Models\MtlParameter;
use App\Models\OM\SaleTypeV;
use Illuminate\Http\Request;
use App\Models\OM\ClaimHeader;
use App\Models\OM\IssueStockLots;
use App\Models\OM\Api\OrderHeader;
use App\Models\OM\IssueStockLines;
use Illuminate\Support\Facades\DB;
use App\Models\OM\TransactionTypeAllV;
use App\Http\Controllers\Controller;
use App\Models\OM\IssueStockHeaders;
use App\Models\OM\MtlTransactionsInterface;
use App\Models\OM\MtlTransactionLotsInterface;
use App\Models\OM\CreditNote\Ptgl\CoaEvmVModel;
use App\Models\OM\CreditNote\Ptgl\CoaCompanyVModel;
use App\Models\OM\CreditNote\Ptgl\CoaDeptCodeVModel;
use App\Models\OM\CreditNote\Ptgl\CoaReserved1VModel;
use App\Models\OM\CreditNote\Ptgl\CoaReserved2VModel;
use App\Models\OM\CreditNote\Ptgl\CoaBudgetTypeVModel;
use App\Models\OM\CreditNote\Ptgl\CoaBudgetYearVModel;
use App\Models\OM\CreditNote\Ptgl\CoaCostCenterVModel;
use App\Models\OM\CreditNote\Ptgl\CoaSubAccountVModel;
use App\Models\OM\CreditNote\Ptgl\CoaMainAccountVModel;
use App\Models\OM\CreditNote\Ptgl\CoaBudgetDetailVModel;
use App\Models\OM\CreditNote\Ptgl\CoaBudgetReasonVModel;
use App\Models\OM\SaleConfirmation\ProformaInvoiceHeaders;
use App\Models\OM\MtlTransactionType;
use App\Repositories\OM\InterfaceRepo;

class CutStockInventoryController extends Controller
{
    public function index()
    {
        $segment = [
            'company'        => CoaCompanyVModel::select('meaning', 'description')->where('company_code','01')->get(),
            'evm'            => CoaEvmVModel::select('meaning', 'description')->get(),
            'dept'           => CoaDeptCodeVModel::select('meaning', 'description')->get(),
            // 'costCenter'     => CoaCostCenterVModel::select('meaning', 'description', 'department_code')->get(),
            'costCenter'     => [],
            'budgetYear'     => CoaBudgetYearVModel::select('meaning', 'description')->get(),
            'budgetType'     => CoaBudgetTypeVModel::select('meaning', 'description')->get(),
            // 'budgetDetail'   => CoaBudgetDetailVModel::select('meaning', 'description', 'budget_type')->get(),
            'budgetDetail'   => [],
            'budgetReason'   => CoaBudgetReasonVModel::select('meaning', 'description')->get(),
            'mainAccount'    => CoaMainAccountVModel::select('meaning', 'description')->get(),
            // 'subAccount'     => CoaSubAccountVModel::select('meaning', 'description', 'main_account')->get(),
            'subAccount'     => [],
            'reserved1'      => CoaReserved1VModel::select('meaning', 'description')->get(),
            'reserved2'      => CoaReserved2VModel::select('meaning', 'description')->get()
        ];
        
        $transactionTypes = MtlTransactionType::select('transaction_type_id', 'transaction_type_name')->get();

        return view('om.cut_stock_inventory.index', compact(
            'segment',
            'transactionTypes',
        ));
    }

    public function store(Request $request)
    {
        $invoice_data = collect($request->invoice_data);
        $line_data = collect($request->line_data);
        $invoice_id = $invoice_data['invoice_id'];
        $invoice_type = strtoupper($invoice_data['invoice_type']);
        $class_sale_type = strtoupper($invoice_data['class_sale_type']);

        if($invoice_type === 'ORDER'){
            $invoice = OrderHeader::find($invoice_id);
        }else if($invoice_type === 'PROFORMA'){
            $invoice = ProformaInvoiceHeaders::find($invoice_id);
        }else if( in_array($invoice_type, ['RMA']) ){
            $invoice = ClaimHeader::find($invoice_id);
        }else {
            return response()->json([
                'status' => 'E',
                'msg' => 'ไม่พบข้อมูล Invoice Type'
            ]);
        }

        \DB::beginTransaction();
        try {

            $mtl_interface_ids = [];

            $now = Carbon::now();
            $user_id = getDefaultData('/users')->user_id;

            $issueHeader                            = new IssueStockHeaders;
            $issueHeader->pick_release_no           = $invoice->ref_invoice_number ?? $invoice->pick_release_no;
            $issueHeader->pick_release_approve_date = $invoice->invoice_date ?? $invoice->pick_release_approve_date;
            $issueHeader->order_header_id           = ($invoice->invoice_id ?? $invoice->pi_header_id) ?? $invoice->order_header_id;
            $issueHeader->claim_header_id           = $invoice->claim_header_id;
            $issueHeader->claim_number              = $invoice->claim_number;
            $issueHeader->claim_date                = $invoice->claim_date;
            $issueHeader->rma_number                = $invoice->rma_number;
            $issueHeader->rma_date                  = $invoice->rma_date;
            $issueHeader->sales_order_number        = $invoice_data['sale_number'];
            $issueHeader->delivery_date             = Carbon::createFromFormat('d/m/Y', $invoice_data['ship_date'])->subYears(543)->format('Y-m-d');
            $issueHeader->customer_id               = $invoice->customer_id;
            $issueHeader->customer_number           = optional($invoice->customer)->customer_number;
            $issueHeader->sales_type                = optional($invoice->customer)->sales_classification_code;
            $issueHeader->order_type_id             = $invoice->rma_order_type_id ?? optional($invoice->ref)->order_type_id ?? $invoice->order_type_id;
            $issueHeader->transaction_type_id       = $invoice_data['transaction_type'] ?? optional($invoice->transactionType)->transaction_type_id;// $transaction_type_id ?? (optional($invoice->transactionType)->transaction_type_id ?? $invoice_data['transaction_type']);
            $issueHeader->transaction_date          = Carbon::parse(date("Y-m-d", strtotime($invoice_data['transaction_date'])));
            $issueHeader->ebs_order_number          = $invoice_data['ebs_number'];
            $issueHeader->remark                    = isset($invoice_data['remark']) ? $invoice_data['remark'] : null;
            $issueHeader->program_code              = 'OMP0100';
            $issueHeader->created_by                = $user_id;
            $issueHeader->creation_date             = $now;
            $issueHeader->last_updated_by           = $user_id;
            $issueHeader->last_update_date          = $now;
            $issueHeader->created_at                = $now;
            $issueHeader->created_by_id             = $user_id;
            $issueHeader->updated_by_id             = $user_id;
            $issueHeader->web_batch_no              = '';
            $issueHeader->status                    = 'Confirm';
            $issueHeader->issueable_id              = $invoice_id;
            $issueHeader->issueable_type            = in_array($invoice_type, ['RMA']) ? 'App\Models\OM\ClaimHeader' 
                                                    : ($invoice_type === 'PROFORMA' ? 'App\Models\OM\SaleConfirmation\ProformaInvoiceHeaders' 
                                                    : ($invoice_type === 'ORDER' ? 'App\Models\OM\Api\OrderHeader' : ''));
            $issueHeader->save();

            $transaction_source_name = (in_array($invoice_type, ['RMA']) ? $invoice->credit_note_number : $issueHeader->pick_release_no) .'-'. Carbon::parse(date("Y-m-d", strtotime($invoice_data['transaction_date'])))->format('Ymd');

            foreach($line_data as $line) {
                $line = (object)$line;
                $issueLine = new IssueStockLines;
                $issueLine->issue_header_id     = $issueHeader->issue_header_id;
                $issueLine->order_header_id     = ($invoice->invoice_id ?? $invoice->pi_header_id) ?? $invoice->order_header_id;
                $issueLine->order_line_id       = isset($line->pi_line_id) ? $line->pi_line_id : (isset($line->order_line_id) ? $line->order_line_id : null);
                $issueLine->claim_header_id     = isset($line->claim_header_id) ? $line->claim_header_id : null;
                $issueLine->claim_line_id       = isset($line->claim_line_id) ? $line->claim_line_id : null;
                $issueLine->item_id             = isset($line->item_id) ? $line->item_id : null;
                $issueLine->item_code           = isset($line->item_code) ? $line->item_code : null;
                $issueLine->item_description    = isset($line->item_description) ? $line->item_description : null;
                $issueLine->order_quantity      = isset($line->rma_quantity) ? $line->rma_quantity : (isset($line->approve_quantity) ? $line->approve_quantity : null);
                $issueLine->uom_code            = isset($line->rma_uom_code) ? $line->rma_uom_code : (isset($line->uom_code) ? $line->uom_code : null);
                $issueLine->uom                 = isset($line->uom) ? $line->uom : null;
                $issueLine->cogs_segment1       = isset($line->segment1) ? $line->segment1 : null;
                $issueLine->cogs_segment2       = isset($line->segment2) ? $line->segment2 : null;
                $issueLine->cogs_segment3       = isset($line->segment3) ? $line->segment3 : null;
                $issueLine->cogs_segment4       = isset($line->segment4) ? $line->segment4 : null;
                $issueLine->cogs_segment5       = isset($line->segment5) ? $line->segment5 : null;
                $issueLine->cogs_segment6       = isset($line->segment6) ? $line->segment6 : null;
                $issueLine->cogs_segment7       = isset($line->segment7) ? $line->segment7 : null;
                $issueLine->cogs_segment8       = isset($line->segment8) ? $line->segment8 : null;
                $issueLine->cogs_segment9       = isset($line->segment9) ? $line->segment9 : null;
                $issueLine->cogs_segment10      = isset($line->segment10) ? $line->segment10 : null;
                $issueLine->cogs_segment11      = isset($line->segment11) ? $line->segment11 : null;
                $issueLine->cogs_segment12      = isset($line->segment12) ? $line->segment12 : null;
                $issueLine->program_code        = 'OMP0100';
                $issueLine->created_by          = $user_id;
                $issueLine->creation_date       = $now;
                $issueLine->last_updated_by     = $user_id;
                $issueLine->last_update_date    = $now;
                $issueLine->created_at          = $now;
                $issueLine->updated_at          = $now;
                $issueLine->created_by_id       = $user_id;
                $issueLine->updated_by_id       = $user_id;
                $issueLine->web_batch_no        = '';
                $issueLine->issueable_id        = isset($line->claim_line_id) ? $line->claim_line_id : (isset($line->pi_line_id) ? $line->pi_line_id : (isset($line->order_line_id) ? $line->order_line_id : null));
                $issueLine->issueable_type      = in_array($invoice_type, ['RMA']) ? 'App\Models\OM\ClaimLine' 
                                                : ($invoice_type === 'PROFORMA' ? 'App\Models\OM\SaleConfirmation\ProformaInvoiceLines' 
                                                : ($invoice_type === 'ORDER' ? 'App\Models\OM\Api\OrderLines' : ''));
                $issueLine->save();

                foreach($line->data_on_hands as $on_hand){
                    $onhand = (object)$on_hand;
                    $mtlParam = MtlParameter::where('organization_code', $onhand->organization_code)->first();
                    $issueLot = new IssueStockLots;
                    $issueLot->issue_line_id            = $issueLine->issue_line_id;
                    $issueLot->item_id                  = isset($line->item_id) ? $line->item_id : null;
                    $issueLot->item_code                = isset($onhand->item_code) ? $onhand->item_code : null;
                    $issueLot->item_description         = isset($onhand->item_description) ? $onhand->item_description : null;
                    $issueLot->inv_org_id               = $mtlParam->organization_id;
                    $issueLot->inv_org_code             = isset($onhand->organization_code) ? $onhand->organization_code : null;
                    $issueLot->inv_org_name             = isset($onhand->organization_name) ? $onhand->organization_name : null;
                    $issueLot->subinventory_code        = isset($onhand->subinventory_code) ? $onhand->subinventory_code : null;
                    $issueLot->subinventory_name        = isset($onhand->subinventory_name) ? $onhand->subinventory_name : null;
                    $issueLot->inventory_location_id    = isset($onhand->locator_id) ? $onhand->locator_id : null;
                    $issueLot->locator                  = isset($onhand->locator) ? $onhand->locator : null;
                    $issueLot->locator_name             = isset($onhand->locator_name) ? $onhand->locator_name : null;
                    $issueLot->loc_segment1             = isset($onhand->loc_segment1) ? $onhand->loc_segment1 : null;
                    $issueLot->loc_segment2             = isset($onhand->loc_segment2) ? $onhand->loc_segment2 : null;
                    $issueLot->lot_number               = isset($onhand->lot_number) ? $onhand->lot_number : null;
                    $issueLot->serial_number            = null;
                    $issueLot->issue_quantity           = isset($onhand->need_qty) ? $onhand->need_qty : null;
                    $issueLot->uom_code                 = $issueLine->uom_code;
                    $issueLot->uom                      = $issueLine->uom;
                    $issueLot->program_code             = 'OMP0100';
                    $issueLot->created_by               = $user_id;
                    $issueLot->creation_date            = $now;
                    $issueLot->last_updated_by          = $user_id;
                    $issueLot->last_update_date         = $now;
                    $issueLot->created_at               = $now;
                    $issueLot->updated_at               = $now;
                    $issueLot->created_by_id            = $user_id;
                    $issueLot->updated_by_id            = $user_id;
                    $issueLot->web_batch_no             = '';
                    $issueLot->save();

                    $nextval = \DB::select('select mtl_material_transactions_s.NEXTVAL from DUAL')[0]->nextval;
                    $transactionInterface = new MtlTransactionsInterface;
                    $transactionInterface->transaction_interface_id = $nextval;
                    $transactionInterface->transaction_header_id    = $issueLine->claim_header_id ?? $issueLine->order_header_id;
                    $transactionInterface->source_code              = $transactionInterface->transaction_interface_id;
                    $transactionInterface->source_line_id           = $issueLine->claim_line_id ?? $issueLine->order_line_id;
                    $transactionInterface->source_header_id         = $issueLine->claim_header_id ?? $issueLine->order_header_id;
                    $transactionInterface->process_flag             = in_array($issueHeader->transaction_type_id, ['15', '33']) ? 9 : 1;
                    $transactionInterface->transaction_mode         = 3;
                    $transactionInterface->lock_flag                = 2;
                    $transactionInterface->last_update_date         = $now;
                    $transactionInterface->last_updated_by          = 1110;
                    $transactionInterface->creation_date            = $now;
                    $transactionInterface->created_by               = 1110;
                    $transactionInterface->item_segment1            = $issueLine->item_code;
                    $transactionInterface->organization_id          = $issueLot->inv_org_id;
                    $transactionInterface->transaction_quantity     = in_array($invoice_type, ['RMA']) ? abs($issueLot->issue_quantity) : (-1) * abs($issueLot->issue_quantity);
                    $transactionInterface->transaction_uom          = $issueLot->uom_code;
                    $transactionInterface->transaction_date         = $issueHeader->transaction_date;
                    $transactionInterface->subinventory_code        = $issueLot->subinventory_code;
                    $transactionInterface->transaction_source_type_id = 121;
                    // $transactionInterface->locator_id               = '';
                    $transactionInterface->loc_segment1             = $issueLot->loc_segment1;
                    $transactionInterface->loc_segment2             = $issueLot->loc_segment2;
                    $transactionInterface->transaction_source_name  = $transaction_source_name;
                    $transactionInterface->transaction_type_id      = $issueHeader->transaction_type_id;
                    $transactionInterface->transaction_reference    = $transaction_source_name;
                    $transactionInterface->dst_segment1             = $issueLine->cogs_segment1;
                    $transactionInterface->dst_segment2             = $issueLine->cogs_segment2;
                    $transactionInterface->dst_segment3             = $issueLine->cogs_segment3;
                    $transactionInterface->dst_segment4             = $issueLine->cogs_segment4;
                    $transactionInterface->dst_segment5             = $issueLine->cogs_segment5;
                    $transactionInterface->dst_segment6             = $issueLine->cogs_segment6;
                    $transactionInterface->dst_segment7             = $issueLine->cogs_segment7;
                    $transactionInterface->dst_segment8             = $issueLine->cogs_segment8;
                    $transactionInterface->dst_segment9             = $issueLine->cogs_segment9;
                    $transactionInterface->dst_segment10            = $issueLine->cogs_segment10;
                    $transactionInterface->dst_segment11            = $issueLine->cogs_segment11;
                    $transactionInterface->dst_segment12            = $issueLine->cogs_segment12;
                    $transactionInterface->attribute13              = $issueLot->program_code;
                    $transactionInterface->save();

                    $lotInterface = new MtlTransactionLotsInterface;
                    $lotInterface->transaction_interface_id = $transactionInterface->transaction_interface_id;
                    $lotInterface->source_code              = $transactionInterface->source_code;
                    $lotInterface->source_line_id           = $transactionInterface->source_line_id;
                    $lotInterface->last_update_date         = $now;
                    $lotInterface->last_updated_by          = 1110;
                    $lotInterface->creation_date            = $now;
                    $lotInterface->created_by               = 1110;
                    $lotInterface->lot_number               = $issueLot->lot_number;
                    $lotInterface->transaction_quantity     = in_array($invoice_type, ['RMA']) ? abs($issueLot->issue_quantity) : (-1) * abs($issueLot->issue_quantity);
                    $lotInterface->save();
                    
                    array_push($mtl_interface_ids, $transactionInterface->transaction_interface_id);
                }
            }

            \DB::commit();

            // $transaction_source_name = $invoice_type === 'CLAIM' ? $issueHeader->claim_number.'-'.Carbon::parse($issueHeader->claim_date)->format('Ymd') : $issueHeader->pick_release_no;

            $data = [
                'status' => 'S',
                'msg' => 'success',
                'issue_header_id' => $issueHeader->issue_header_id,
                // 'consignment' => $consignmentHeader->consignment_header_id,
            ];

            ////// $result = InterfaceRepo::interfacePickShip($batch);
            // $result = InterfaceRepo::interfacePickShip($transaction_source_name);
            // if($result['status'] == 'S'){
            //     $data = [
            //         'status' => 'S',
            //         'msg' => 'success',
            //         // 'consignment' => $consignmentHeader->consignment_header_id,
            //     ];
            // }else {

            //     foreach ($issueHeader->lines as $issueLine) {
            //         foreach ($issueLine->onHands as $issueLot) {
            //             MtlTransactionLotsInterface::whereIn('transaction_interface_id', $mtl_interface_ids)->delete();
            //             MtlTransactionsInterface::whereIn('transaction_interface_id', $mtl_interface_ids)->delete();
            //             $issueLot->delete();
            //         }
            //         $issueLine->delete();
            //     }
            //     $issueHeader->delete();
                
            //     $data = [
            //         'status' => 'E',
            //         'msg' => 'Error Interface WMS',
            //     ];
            // }

        }catch (\Exception $e) {
            \DB::rollBack();

            \Log::error($e->getMessage());
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage(),
            ];
        }
        
        return response()->json($data);
    }

    public function getInvoiceList(Request $request)
    {
        $state = $request->state;
        $query = $request->keyword ? '%'.$request->keyword.'%' : '%';
        $collection = collect();
        if( $state === 'search'){
            $issues = IssueStockHeaders::where(function($q) use ($query){
                $q->where('pick_release_no', 'like', $query)
                ->orWhere('rma_number', 'like', $query)
                ->orWhere('claim_number', 'like', $query);
            })
            ->limit(100)
            ->orderByRaw('pick_release_no asc, rma_number asc, claim_number asc')
            ->get();
            foreach ($issues as $issue) {
                $issue->pick_release_approve_date = $issue->pick_release_approve_date ? Carbon::parse($issue->pick_release_approve_date)->addYears(543)->format('d/m/Y') : $issue->pick_release_approve_date;
                $issue->rma_date = $issue->rma_date ? Carbon::parse($issue->rma_date)->addYears(543)->format('d/m/Y') : $issue->rma_date;
                $transType = $issue->transactionType;
                $customer = $issue->customer;
                $issue_label = $issue->rma_number 
                    ? ($issue->claim_number 
                        ? ($issue->rma_number.' : '.$issue->claim_number) 
                        : ($issue->rma_number)
                    ) 
                    : $issue->pick_release_no;
                $item = (object)[
                    'invoice_type' => 'issue',
                    'invoice_id' => $issue->issue_header_id,
                    'invoice_date' => $issue->rma_date ?? $issue->pick_release_approve_date,
                    'customer' => optional($customer)->customer_name,
                    'sale_class' => optional(SaleTypeV::where('value', strtoupper(optional($customer)->sales_classification_code))->first())->description,
                    'sale_number' => $issue->sales_order_number,
                    'ship_date' => Carbon::parse($issue->delivery_date)->addYears(543)->format('d/m/Y'),
                    'transaction_type' => optional($transType)->transaction_type.' ('.optional($transType)->transaction_type_id.')',
                    'order_type' => optional($transType)->order_type_name,
                    'ebs_number' => $issue->ebs_order_number,
                    'show' => $issue_label.' : '.($issue->rma_date ?? $issue->pick_release_approve_date).' : '.Carbon::parse($issue->transaction_date)->addYears(543)->format('d/m/Y').' : '.optional($customer)->customer_name,
                    'label' => $issue_label,
                    'value' => $issue->issue_header_id,
                    'key' => $issue_label.'_'.$issue->issue_header_id,
                    'class_sale_type' => optional($customer)->sales_classification_code,
                    'remark' => $issue->remark,
                    'transaction_date' => $issue->transaction_date,
                    'status' => $issue->status,
                ];
                $collection->push($item);
            }
        }else {
            $orders = OrderHeader::whereRaw("
                upper(pick_release_status) = 'CONFIRM'
                and upper(close_sale_flag) = 'Y'
                and ebs_order_number is not null
            ")
            ->where(function($q) use ($query){
                $q->where('pick_release_no', 'like', $query);
            })
            ->where(function($q){
                $q->doesnthave('issues')
                ->orWhereHas('lines', function($p){
                    $p->doesnthave('issues')
                    ->orWhereHas('issues', function($r){
                        $r->whereHas('onHands', function($s){
                            $s->whereRaw("
                                PTOM_ISSUE_STOCK_LINES.ISSUE_LINE_ID IN 
                                (   
                                    SELECT PTOM_ISSUE_STOCK_LINES.ISSUE_LINE_ID 
                                    FROM PTOM_ISSUE_STOCK_LINES
                                    WHERE PTOM_ISSUE_STOCK_LINES.ORDER_QUANTITY > (
                                        SELECT SUM(PTOM_ISSUE_STOCK_LOTS.ISSUE_QUANTITY) AMOUNT
                                        FROM PTOM_ISSUE_STOCK_LOTS
                                        WHERE PTOM_ISSUE_STOCK_LOTS.ISSUE_LINE_ID = PTOM_ISSUE_STOCK_LINES.ISSUE_LINE_ID
                                        GROUP BY PTOM_ISSUE_STOCK_LINES.ISSUE_LINE_ID
                                    )
                                )
                            ");
                        });
                    });
                });
            })
            ->with('customer', 'transactionType')
            ->limit(100)
            ->orderBy('pick_release_no')
            ->get();
            $proformas = ProformaInvoiceHeaders::whereRaw("
                upper(pick_release_status) = 'CONFIRM'
                and upper(close_sale_flag) = 'Y'
                and ebs_order_number is not null
            ")
            ->where(function($q) use ($query){
                $q->where('pick_release_no', 'like', $query);
            })
            ->where(function($q){
                $q->doesnthave('issues')
                ->orWhereHas('lines', function($p){
                    $p->doesnthave('issues')
                    ->orWhereHas('issues', function($r){
                        $r->whereHas('onHands', function($s){
                            $s->whereRaw("
                                PTOM_ISSUE_STOCK_LINES.ISSUE_LINE_ID IN 
                                (   
                                    SELECT PTOM_ISSUE_STOCK_LINES.ISSUE_LINE_ID 
                                    FROM PTOM_ISSUE_STOCK_LINES
                                    WHERE PTOM_ISSUE_STOCK_LINES.ORDER_QUANTITY > (
                                        SELECT SUM(PTOM_ISSUE_STOCK_LOTS.ISSUE_QUANTITY) AMOUNT
                                        FROM PTOM_ISSUE_STOCK_LOTS
                                        WHERE PTOM_ISSUE_STOCK_LOTS.ISSUE_LINE_ID = PTOM_ISSUE_STOCK_LINES.ISSUE_LINE_ID
                                        GROUP BY PTOM_ISSUE_STOCK_LINES.ISSUE_LINE_ID
                                    )
                                )
                            ");
                        });
                    });
                });
            })
            ->with('customer', 'transactionType')
            ->limit(100)
            ->orderBy('pick_release_no')
            ->get();
            $rmas = ClaimHeader::whereRaw("
                upper(status_rma) = upper('Confirm')
                and upper(close_sale_flag) = 'Y'
                and ebs_order_number is not null
            ")
            ->where(function($q) use ($query){
                $q->where('rma_number', 'like', $query);
            })
            ->where(function($q){
                $q->doesnthave('issues')
                ->orWhereHas('lines', function($p){
                    $p->doesnthave('issues')
                    ->orWhereHas('issues', function($r){
                        $r->whereHas('onHands', function($s){
                            $s->whereRaw("
                                PTOM_ISSUE_STOCK_LINES.ISSUE_LINE_ID IN 
                                (   
                                    SELECT PTOM_ISSUE_STOCK_LINES.ISSUE_LINE_ID 
                                    FROM PTOM_ISSUE_STOCK_LINES
                                    WHERE PTOM_ISSUE_STOCK_LINES.ORDER_QUANTITY > (
                                        SELECT SUM(PTOM_ISSUE_STOCK_LOTS.ISSUE_QUANTITY) AMOUNT
                                        FROM PTOM_ISSUE_STOCK_LOTS
                                        WHERE PTOM_ISSUE_STOCK_LOTS.ISSUE_LINE_ID = PTOM_ISSUE_STOCK_LINES.ISSUE_LINE_ID
                                        GROUP BY PTOM_ISSUE_STOCK_LINES.ISSUE_LINE_ID
                                    )
                                )
                            ");
                        });
                    });
                });
            })
            ->with('customer')
            ->limit(100)
            ->orderBy('rma_number')
            ->get();
            foreach ($orders as $order) {
                $order->pick_release_approve_date = Carbon::parse($order->pick_release_approve_date)->addYears(543)->format('d/m/Y');
                $transType = $order->transactionType;
                $customer = $order->customer;
                $item = (object)[
                    'invoice_type' => 'order',
                    'invoice_id' => $order->order_header_id,
                    'invoice_date' => $order->pick_release_approve_date,
                    'customer' => optional($customer)->customer_name,
                    'sale_class' => optional(SaleTypeV::where('value', strtoupper(optional($customer)->sales_classification_code))->first())->description,
                    'sale_number' => $order->prepare_order_number,
                    'ship_date' => Carbon::parse($order->delivery_date)->addYears(543)->format('d/m/Y'),
                    'transaction_type' => optional($transType)->transaction_type_id,
                    'order_type' => optional($transType)->order_type_name,
                    'ebs_number' => $order->ebs_order_number,
                    'show' => $order->pick_release_no.' : '.$order->pick_release_approve_date.' : '.optional($customer)->customer_name,
                    'label' => $order->pick_release_no,
                    'value' => $order->pick_release_no,
                    'key' => $order->pick_release_no,
                    'class_sale_type' => optional($customer)->sales_classification_code,
                ];
                $collection->push($item); 
            }
            foreach ($proformas as $proforma) {
                $proforma->pick_release_approve_date = Carbon::parse($proforma->pick_release_approve_date)->addYears(543)->format('d/m/Y');
                $transType = $proforma->transactionType;
                $customer = $proforma->customer;
                $item = (object)[
                    'invoice_type' => 'proforma',
                    'invoice_id' => $proforma->pi_header_id,
                    'invoice_date' => $proforma->pick_release_approve_date,
                    'customer' => optional($customer)->customer_name,
                    'sale_class' => optional(SaleTypeV::where('value', strtoupper(optional($customer)->sales_classification_code))->first())->description,
                    'sale_number' => $proforma->pi_number,
                    'ship_date' => Carbon::parse($proforma->delivery_date)->addYears(543)->format('d/m/Y'),
                    'transaction_type' => optional($transType)->transaction_type_id,
                    'order_type' => optional($transType)->order_type_name,
                    'ebs_number' => $proforma->ebs_order_number,
                    'show' => $proforma->pick_release_no.' : '.$proforma->pick_release_approve_date.' : '.optional($customer)->customer_name,
                    'label' => $proforma->pick_release_no,
                    'value' => $proforma->pick_release_no,
                    'key' => $proforma->pick_release_no,
                    'class_sale_type' => optional($customer)->sales_classification_code,
                ];
                $collection->push($item);
            }
            foreach ($rmas as $rma) {
                $transType = $rma->transactionType;
                $rma->rma_date = Carbon::parse($rma->rma_date)->addYears(543)->format('d/m/Y');
                $customer = $rma->customer;
                $ref = $rma->ref;
                $show_label = $rma->rma_number.($rma->claim_number ? ' : '.$rma->claim_number : '');
                $item = (object)[
                    'invoice_type' => 'rma',
                    'invoice_id' => $rma->claim_header_id,
                    'invoice_date' => $rma->rma_date,
                    'customer' => optional($customer)->customer_name,
                    'sale_class' => optional(SaleTypeV::where('value', strtoupper(optional($customer)->sales_classification_code))->first())->description,
                    'sale_number' => optional($ref)->prepare_order_number ?? optional($ref)->pi_number,
                    'ship_date' => $ref ? Carbon::parse(optional($ref)->delivery_date)->addYears(543)->format('d/m/Y') : '',
                    'transaction_type' => optional($transType)->transaction_type_id,
                    'order_type' => optional($transType)->order_type_name,
                    'ebs_number' => optional($ref)->ebs_order_number,
                    'show' => $show_label.' : '.$rma->rma_date.' : '.optional($customer)->customer_name,
                    'label' => $rma->rma_number,
                    'value' => $rma->rma_number,
                    'key' => $rma->rma_number,
                    'class_sale_type' => optional($customer)->sales_classification_code,
                ];
                $collection->push($item);
            }
        }

        return response()->json($collection);
    }

    public function getInvoiceLines(Request $request)
    {
        $invoice_id = $request->invoice_id;
        $invoice_type = strtoupper($request->invoice_type);
        $class_sale_type = strtoupper($request->class_sale_type);

        if($invoice_type === 'ORDER'){
            $invoice = OrderHeader::find($invoice_id);
            $flag_attr5 = $invoice->attribute5 == 'Y';
            $lines = $flag_attr5 
                ? $invoice->lines()->with('onHands')->get() 
                : $invoice->lines()->where(function($q){
                    $q->where('promo_flag', '!=', 'Y')->orWhereNull('promo_flag');
                })->with('onHands')->get();
        }else if($invoice_type === 'PROFORMA'){
            $invoice = ProformaInvoiceHeaders::find($invoice_id);
            $lines = $invoice->lines()->with('onHands')->get();
        }else if( in_array($invoice_type, ['RMA']) ){
            $invoice = ClaimHeader::find($invoice_id);
            $lines = $invoice->lines()
            ->where(function($p){
                $p->doesnthave('issues')
                ->orWhereHas('issues', function($r){
                    $r->whereHas('onHands', function($s){
                        $s->whereRaw("
                            PTOM_ISSUE_STOCK_LINES.ISSUE_LINE_ID IN 
                            (   
                                SELECT PTOM_ISSUE_STOCK_LINES.ISSUE_LINE_ID 
                                FROM PTOM_ISSUE_STOCK_LINES
                                WHERE PTOM_ISSUE_STOCK_LINES.ORDER_QUANTITY > (
                                    SELECT SUM(PTOM_ISSUE_STOCK_LOTS.ISSUE_QUANTITY) AMOUNT
                                    FROM PTOM_ISSUE_STOCK_LOTS
                                    WHERE PTOM_ISSUE_STOCK_LOTS.ISSUE_LINE_ID = PTOM_ISSUE_STOCK_LINES.ISSUE_LINE_ID
                                    GROUP BY PTOM_ISSUE_STOCK_LINES.ISSUE_LINE_ID
                                )
                            ) 
                        ");
                    });
                });
            })
            ->with('onHands', 'uomV', 'rmaUomV')
            ->get();
        }else if($invoice_type === 'ISSUE'){
            $invoice = IssueStockHeaders::find($invoice_id);
            $lines = $invoice->lines()
            ->with('onHands')
            ->get();
        }else {
            return response()->json([
                'status' => 'E',
                'msg' => 'ไม่พบข้อมูล Invoice Type'
            ]);
        }
        
        $date = $invoice->pick_release_approve_date ?? $invoice->rma_date;

        $budgetYear = getBudgetYear($date);

        foreach ($lines as $line) {
            $transType = $invoice->transactionType ?? optional($invoice->ref)->transactionType;
            $line->segment1 = $transType->cogs_account_segment1;
            $line->segment2 = $transType->cogs_account_segment2;
            $line->segment3 = $transType->cogs_account_segment3;
            $line->segment4 = $transType->cogs_account_segment4;
            $line->segment5 = $transType->cogs_account_segment5 != '00' ? $budgetYear : $transType->cogs_account_segment5;
            $line->segment6 = $transType->cogs_account_segment6;
            $line->segment7 = $transType->cogs_account_segment7;
            $line->segment8 = $transType->cogs_account_segment8;
            $line->segment9 = $transType->cogs_account_segment9;
            $line->segment10 = $transType->cogs_account_segment10;
            $line->segment11 = $transType->cogs_account_segment11;
            $line->segment12 = $transType->cogs_account_segment12;
            $line->account_code = $line->segment1.'.'.$line->segment2.'.'.$line->segment3.'.'.$line->segment4.'.'.
                $line->segment5.'.'.$line->segment6.'.'.$line->segment7.'.'.$line->segment8.'.'.
                $line->segment9.'.'.$line->segment10.'.'.$line->segment11.'.'.$line->segment12;

            $uomV = in_array($invoice_type, ['RMA']) ? $line->rmaUomV : $line->uomV;
            $line->uom = $line->uom ?? ($class_sale_type === 'DOMESTIC' ? optional($uomV)->description : optional($uomV)->unit_of_measure);
            
            $qty = (float)($line->approve_quantity ?? ($line->rma_quantity ?? $line->order_quantity));
            $use_qty = (float)($invoice_type === 'ISSUE' ? (float)0 : (float)($line->issues->sum('total_issue_qty')));
            $line->remain_quantity = (float)($qty - $use_qty);

            foreach ($line->onHands as $onhand) {
                $onhand->input_qty = $invoice_type === 'ISSUE' ? $onhand->issue_quantity : 0;
                $onhand->need_qty = $invoice_type === 'ISSUE' ? $onhand->issue_quantity : 0;
                $onhand->convert_qty = (float)convertUom($line->item_id, $onhand->onhand_quantity ?? $onhand->issue_quantity, $onhand->transaction_uom_code ?? $onhand->uom_code, (in_array($invoice_type, ['RMA']) ? $line->rma_uom_code : $line->uom_code));
            }

            if(in_array($invoice_type, ['RMA'])){

                $line->data_on_hands = $line->onHands;
            }else {
                
                $line->data_on_hands = $line->onHands->where('convert_qty', '>', 0)->values();
            }
        }

        return response()->json($lines);
    }

    public function getAccountList(Request $request)
    {
        $segment = $request->segment;
        $value = $request->value;
        $parentValue = $request->parent_value;

        switch ($segment) {
            case 1:
                $list = (new CoaCompanyVModel)
                    ->select('meaning', 'description')
                    ->when($value, function($q, $value){
                        $q->where('meaning', $value);
                    })
                    ->limit(100)->get();
                break;
            case 2:
                $list = (new CoaEvmVModel)
                    ->select('meaning', 'description')
                    ->when($value, function($q, $value){
                        $q->where('meaning', $value);
                    })
                    ->limit(100)->get();
                break;
            case 3:
                $list = (new CoaDeptCodeVModel)
                    ->select('meaning', 'description')
                    ->when($value, function($q, $value){
                        $q->where('meaning', $value);
                    })
                    ->limit(100)->get();
                break;
            case 4:
                $list = (new CoaCostCenterVModel)
                    ->select('meaning', 'description')
                    ->when($value, function($q, $value){
                        $q->where('meaning', $value);
                    })
                    ->where('department_code', $parentValue)
                    ->limit(100)->get();
                break;
            case 5:
                $list = (new CoaBudgetYearVModel)
                    ->select('meaning', 'description')
                    ->when($value, function($q, $value){
                        $q->where('meaning', $value);
                    })
                    ->limit(100)->get();
                break;
            case 6:
                $list = (new CoaBudgetTypeVModel)
                    ->select('meaning', 'description')
                    ->when($value, function($q, $value){
                        $q->where('meaning', $value);
                    })
                    ->limit(100)->get();
                break;
            case 7:
                $list = (new CoaBudgetDetailVModel)
                    ->select('meaning', 'description')
                    ->when($value, function($q, $value){
                        $q->where('meaning', $value);
                    })
                    ->where('budget_type', $parentValue)
                    ->limit(100)->get();
                break;
            case 8:
                $list = (new CoaBudgetReasonVModel)
                    ->select('meaning', 'description')
                    ->when($value, function($q, $value){
                        $q->where('meaning', $value);
                    })
                    ->limit(100)->get();
                break;
            case 9:
                $list = (new CoaMainAccountVModel)
                    ->select('meaning', 'description')
                    ->when($value, function($q, $value){
                        $q->where('meaning', $value);
                    })
                    ->limit(100)->get();
                break;
            case 10:
                $list = (new CoaSubAccountVModel)
                    ->select('meaning', 'description')
                    ->when($value, function($q, $value){
                        $q->where('meaning', $value);
                    })->where('main_account', $parentValue)
                    ->limit(100)->get();
                break;
            case 11:
                $list = (new CoaSubAccountVModel)
                    ->select('meaning', 'description')
                    ->when($value, function($q, $value){
                        $q->where('meaning', $value);
                    })
                    ->limit(100)->get();
                break;
            case 12:
                $list = (new CoaReserved2VModel)
                    ->select('meaning', 'description')
                    ->when($value, function($q, $value){
                        $q->where('meaning', $value);
                    })
                    ->limit(100)->get();
                break;
            default:
                $list = [];
        }

        return response()->json($list);
    }
}