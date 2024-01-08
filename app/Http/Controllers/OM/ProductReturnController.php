<?php

namespace App\Http\Controllers\OM;

use Carbon\Carbon;
use App\Models\OM\OnHandV;
use App\Models\MtlParameter;
use App\Models\OM\SaleTypeV;
use Illuminate\Http\Request;
use App\Models\OM\ClaimHeader;
use App\Models\OM\ReceiptStockLots;
use App\Models\OM\Api\OrderHeader;
use App\Models\OM\ReceiptStockLines;
use Illuminate\Support\Facades\DB;
use App\Models\OM\TransactionTypeAllV;
use App\Http\Controllers\Controller;
use App\Models\OM\ReceiptStockHeaders;
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
use App\Models\OM\SaleConfirmation\Organization;
use App\Models\OM\MtlSecondaryInventoriesFkV;
use App\Models\OM\MtlTransactionType;
use App\Models\OM\MtlItemLocations;
use App\Models\OM\MtlLotNumbersAllV;
use App\Repositories\OM\InterfaceRepo;

class ProductReturnController extends Controller
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
        
        $transactionTypes = MtlTransactionType::select('transaction_type_id', 'transaction_type_name')->orderBy('transaction_type_name')->get();

        return view('om.product_return.index', compact(
            'segment',
            'transactionTypes'
        ));
    }

    public function store(Request $request)
    {
        $rma_data = collect($request->rma_data);
        $line_data = collect($request->line_data);
        $rma_id = $rma_data['rma_id'];
        $rma_type = strtoupper($rma_data['rma_type']);
        $class_sale_type = strtoupper($rma_data['class_sale_type']);

        if($rma_type === 'CLAIM'){
            $rma = ClaimHeader::find($rma_id);
        }else {
            return response()->json([
                'status' => 'E',
                'msg' => 'ไม่พบข้อมูล Type'
            ]);
        }

        $rma_ref = $class_sale_type === 'EXPORT' ? $rma->proforma : ($rma->consignment ?? $rma->orderHeader);
        // dd($rma_data, $line_data, $class_sale_type, $rma_ref);
        $rmaTransType = $rma->rma_number && strtoupper($rma->status_rma) === 'CONFIRM' ? $rma->rmaTransType : ($rma->cancel_deliver_flag != 'Y' && $rma->status_approve_claim == 'Y' ? TransactionTypeAllV::where('order_type_name', 'CLAIM')->first() : null);

        \DB::beginTransaction();
        try {

            $mtl_interface_ids = [];

            $now = Carbon::now();
            $user_id = getDefaultData('/users')->user_id;

            $receiptHeader                              = new ReceiptStockHeaders;
            $receiptHeader->claim_header_id             = $rma->claim_header_id;
            $receiptHeader->claim_number                = $rma->claim_number;
            $receiptHeader->claim_date                  = $rma->claim_date;
            $receiptHeader->rma_number                  = $rma->rma_number;
            $receiptHeader->rma_date                    = $rma->rma_date;
            $receiptHeader->pick_release_no             = $rma->ref_invoice_number;
            $receiptHeader->pick_release_approve_date   = $rma->invoice_date;
            $receiptHeader->credit_note_no              = $rma->credit_note_number;
            $receiptHeader->credit_note_date            = optional($rma->creditNote)->invoice_date;
            $receiptHeader->order_header_id             = $rma->invoice_id;
            $receiptHeader->sales_order_number          = optional($rma_ref)->pi_number ?? optional($rma_ref)->consignment_no ?? optional($rma_ref)->prepare_order_number;
            $receiptHeader->customer_id                 = $rma->customer_id;
            $receiptHeader->customer_number             = optional($rma->customer)->customer_number;
            $receiptHeader->sales_type                  = optional($rma->customer)->sales_classification_code;
            $receiptHeader->rma_order_type_id           = $rma->rma_order_type_id;
            $receiptHeader->transaction_type_id         = optional($rmaTransType)->transaction_type_id ?? $rma_data['transaction_type'];
            $receiptHeader->transaction_date            = Carbon::parse($rma_data['transaction_date']);
            $receiptHeader->ebs_order_number            = $rma_data['ebs_number'];
            $receiptHeader->remark                      = isset($rma_data['remark']) ? $rma_data['remark'] : null;
            $receiptHeader->status                      = 'Confirm';
            $receiptHeader->program_code                = 'OMP0101';
            $receiptHeader->created_by                  = $user_id;
            $receiptHeader->creation_date               = $now;
            $receiptHeader->last_updated_by             = $user_id;
            $receiptHeader->last_update_date            = $now;
            $receiptHeader->created_at                  = $now;
            $receiptHeader->created_by_id               = $user_id;
            $receiptHeader->updated_by_id               = $user_id;
            $receiptHeader->web_batch_no                = '';
            $receiptHeader->receiptable_id              = $rma_id;
            $receiptHeader->receiptable_type            = 'App\Models\OM\ClaimHeader';
            $receiptHeader->save();

            foreach($line_data as $line) {
                $line = (object)$line;
                $receiptLine = new ReceiptStockLines;
                $receiptLine->receipt_header_id     = $receiptHeader->receipt_header_id;
                $receiptLine->order_header_id       = $rma->invoice_id;
                $receiptLine->order_line_id         = isset($line->order_line_id) ? $line->order_line_id : null;
                $receiptLine->claim_header_id       = isset($line->claim_header_id) ? $line->claim_header_id : null;
                $receiptLine->claim_line_id         = isset($line->claim_line_id) ? $line->claim_line_id : null;
                $receiptLine->item_id               = isset($line->item_id) ? $line->item_id : null;
                $receiptLine->item_code             = isset($line->item_code) ? $line->item_code : null;
                $receiptLine->item_description      = isset($line->item_description) ? $line->item_description : null;
                $receiptLine->receipt_quantity      = $receiptHeader->rma_number ? (isset($line->rma_quantity) ? $line->rma_quantity : null) : (isset($line->claim_quantity) ? $line->claim_quantity : null);
                $receiptLine->uom_code              = $receiptHeader->rma_number ? (isset($line->rma_uom_code) ? $line->rma_uom_code : null) : (isset($line->claim_uom_code) ? $line->claim_uom_code : null);
                $receiptLine->uom                   = isset($line->uom) ? $line->uom : null;
                $receiptLine->cogs_segment1         = isset($line->segment1) ? $line->segment1 : null;
                $receiptLine->cogs_segment2         = isset($line->segment2) ? $line->segment2 : null;
                $receiptLine->cogs_segment3         = isset($line->segment3) ? $line->segment3 : null;
                $receiptLine->cogs_segment4         = isset($line->segment4) ? $line->segment4 : null;
                $receiptLine->cogs_segment5         = isset($line->segment5) ? $line->segment5 : null;
                $receiptLine->cogs_segment6         = isset($line->segment6) ? $line->segment6 : null;
                $receiptLine->cogs_segment7         = isset($line->segment7) ? $line->segment7 : null;
                $receiptLine->cogs_segment8         = isset($line->segment8) ? $line->segment8 : null;
                $receiptLine->cogs_segment9         = isset($line->segment9) ? $line->segment9 : null;
                $receiptLine->cogs_segment10        = isset($line->segment10) ? $line->segment10 : null;
                $receiptLine->cogs_segment11        = isset($line->segment11) ? $line->segment11 : null;
                $receiptLine->cogs_segment12        = isset($line->segment12) ? $line->segment12 : null;
                $receiptLine->program_code          = 'OMP0101';
                $receiptLine->created_by            = $user_id;
                $receiptLine->creation_date         = $now;
                $receiptLine->last_updated_by       = $user_id;
                $receiptLine->last_update_date      = $now;
                $receiptLine->created_at            = $now;
                $receiptLine->updated_at            = $now;
                $receiptLine->created_by_id         = $user_id;
                $receiptLine->updated_by_id         = $user_id;
                $receiptLine->web_batch_no          = '';
                $receiptLine->receiptable_id        = $line->claim_line_id;
                $receiptLine->receiptable_type      = 'App\Models\OM\ClaimLine';
                $receiptLine->save();

                foreach($line->lots as $lot){
                    $lot = (object)$lot;
                    $org = Organization::where('organization_id', $lot->inv)->first();

                    $receiptLot = new ReceiptStockLots;
                    $receiptLot->receipt_line_id            = $receiptLine->receipt_line_id;
                    $receiptLot->receipt_header_id          = $receiptLine->receipt_header_id;
                    $receiptLot->item_id                    = isset($line->item_id) ? $line->item_id : null;
                    $receiptLot->item_code                  = isset($line->item_code) ? $line->item_code : null;
                    $receiptLot->item_description           = isset($line->item_description) ? $line->item_description : null;
                    $receiptLot->inv_org_id                 = optional($org)->organization_id;
                    $receiptLot->inv_org_code               = optional($org)->organization_code;
                    $receiptLot->inv_org_name               = optional($org)->organization_name;
                    $receiptLot->subinventory_code          = isset($lot->sub_inv) ? $lot->sub_inv : null;
                    $receiptLot->loc_segment1   = $segment1 = isset($lot->locator_segment1) ? $lot->locator_segment1 : null;
                    $receiptLot->loc_segment2   = $segment2 = isset($lot->locator_segment2) ? $lot->locator_segment2 : null;
                    $receiptLot->lot_number                 = isset($lot->lot_number) ? $lot->lot_number : null;

                    $mtlItem = MtlItemLocations::where('subinventory_code', $receiptLot->subinventory_code)
                    ->when($segment1, function($q, $segment1){
                        $q->where('segment1', $segment1);
                    })
                    ->when($segment2, function($q, $segment2){
                        $q->where('segment2', $segment2);
                    })
                    ->first();

                    $receiptLot->inventory_location_id  = optional($mtlItem)->inventory_location_id;
                    $receiptLot->locator                = $receiptLot->loc_segment2 ? $receiptLot->loc_segment1.'.'.$receiptLot->loc_segment2 : $receiptLot->loc_segment1;
                    $receiptLot->serial_number          = null;
                    $receiptLot->quantity               = isset($lot->pick_quantity) ? $lot->pick_quantity : null;
                    $receiptLot->uom_code               = $receiptLine->uom_code;
                    $receiptLot->uom                    = $receiptLine->uom;
                    $receiptLot->program_code           = 'OMP0101';
                    $receiptLot->created_by             = $user_id;
                    $receiptLot->creation_date          = $now;
                    $receiptLot->last_updated_by        = $user_id;
                    $receiptLot->last_update_date       = $now;
                    $receiptLot->created_at             = $now;
                    $receiptLot->updated_at             = $now;
                    $receiptLot->created_by_id          = $user_id;
                    $receiptLot->updated_by_id          = $user_id;
                    $receiptLot->web_batch_no           = '';
                    $receiptLot->save();

                    $nextval = \DB::select('select PTOM_MTL_TRANS_INF_S.NEXTVAL from DUAL')[0]->nextval;
                    $transactionInterface = new MtlTransactionsInterface;
                    $transactionInterface->transaction_interface_id = $nextval;
                    $transactionInterface->transaction_header_id    = $receiptLine->receipt_header_id;
                    $transactionInterface->source_code              = $transactionInterface->transaction_interface_id;
                    $transactionInterface->source_line_id           = $receiptLine->receipt_line_id;
                    $transactionInterface->source_header_id         = $receiptLine->receipt_header_id;
                    $transactionInterface->process_flag             = $receiptHeader->transaction_type_id == '15' ? 9 : 1;
                    $transactionInterface->transaction_mode         = 3;
                    $transactionInterface->lock_flag                = 2;
                    $transactionInterface->last_update_date         = $now;
                    $transactionInterface->last_updated_by          = 1110;
                    $transactionInterface->creation_date            = $now;
                    $transactionInterface->created_by               = 1110;
                    $transactionInterface->item_segment1            = $receiptLine->item_code;
                    $transactionInterface->organization_id          = $receiptLot->inv_org_id;
                    $transactionInterface->transaction_quantity     = $receiptLot->quantity; // (-1) * abs($receiptLot->quantity);
                    $transactionInterface->transaction_uom          = $receiptLot->uom_code;
                    $transactionInterface->transaction_date         = $receiptHeader->transaction_date;
                    $transactionInterface->subinventory_code        = $receiptLot->subinventory_code;
                    // $transactionInterface->locator_id               = '';
                    $transactionInterface->loc_segment1             = $receiptLot->loc_segment1;
                    $transactionInterface->loc_segment2             = $receiptLot->loc_segment2;
                    $transactionInterface->transaction_source_name  = $receiptHeader->rma_number ? $receiptHeader->credit_note_number.'-'.Carbon::parse($receiptHeader->credit_note_date)->format('Ymd') : $receiptHeader->claim_number.'-'.Carbon::parse($receiptHeader->claim_date)->format('Ymd');
                    $transactionInterface->transaction_type_id      = $receiptHeader->transaction_type_id;
                    $transactionInterface->transaction_reference    = $receiptHeader->rma_number ? $receiptHeader->credit_note_number.'-'.Carbon::parse($receiptHeader->credit_note_date)->format('Ymd') : $receiptHeader->claim_number.'-'.Carbon::parse($receiptHeader->claim_date)->format('Ymd');
                    $transactionInterface->dst_segment1             = $receiptLine->cogs_segment1;
                    $transactionInterface->dst_segment2             = $receiptLine->cogs_segment2;
                    $transactionInterface->dst_segment3             = $receiptLine->cogs_segment3;
                    $transactionInterface->dst_segment4             = $receiptLine->cogs_segment4;
                    $transactionInterface->dst_segment5             = $receiptLine->cogs_segment5;
                    $transactionInterface->dst_segment6             = $receiptLine->cogs_segment6;
                    $transactionInterface->dst_segment7             = $receiptLine->cogs_segment7;
                    $transactionInterface->dst_segment8             = $receiptLine->cogs_segment8;
                    $transactionInterface->dst_segment9             = $receiptLine->cogs_segment9;
                    $transactionInterface->dst_segment10            = $receiptLine->cogs_segment10;
                    $transactionInterface->dst_segment11            = $receiptLine->cogs_segment11;
                    $transactionInterface->dst_segment12            = $receiptLine->cogs_segment12;
                    $transactionInterface->attribute13              = $receiptLot->program_code;
                    $transactionInterface->save();

                    $lotInterface = new MtlTransactionLotsInterface;
                    $lotInterface->transaction_interface_id = $transactionInterface->transaction_interface_id;
                    $lotInterface->source_code              = $transactionInterface->source_code;
                    $lotInterface->source_line_id           = $transactionInterface->source_line_id;
                    $lotInterface->last_update_date         = $now;
                    $lotInterface->last_updated_by          = 1110;
                    $lotInterface->creation_date            = $now;
                    $lotInterface->created_by               = 1110;
                    $lotInterface->lot_number               = $receiptLot->lot_number;
                    $lotInterface->transaction_quantity     = $receiptLot->quantity; // (-1) * abs($receiptLot->receipt_quantity);
                    $lotInterface->save();
                    
                    array_push($mtl_interface_ids, $transactionInterface->transaction_interface_id);
                }
            }

            \DB::commit();

            $transaction_source_name = $receiptHeader->rma_number ? $receiptHeader->credit_note_number.'-'.Carbon::parse($receiptHeader->credit_note_date)->format('Ymd') : $receiptHeader->claim_number.'-'.Carbon::parse($receiptHeader->claim_date)->format('Ymd');

            ////// $result = InterfaceRepo::interfacePickShip($batch);
            $result = InterfaceRepo::interfaceRMA($transaction_source_name);
            // $result = [
            //     'status' => 'S',
            //     'msg' => '',
            // ];

            if($result['status'] == 'S'){
                $data = [
                    'status' => 'S',
                    'msg' => 'success',
                    // 'consignment' => $consignmentHeader->consignment_header_id,
                ];
            }else {

                foreach ($receiptHeader->lines as $receiptLine) {
                    foreach ($receiptLine->lots as $receiptLot) {
                        MtlTransactionLotsInterface::whereIn('transaction_interface_id', $mtl_interface_ids)->delete();
                        MtlTransactionsInterface::whereIn('transaction_interface_id', $mtl_interface_ids)->delete();
                        $receiptLot->delete();
                    }
                    $receiptLine->delete();
                }
                $receiptHeader->delete();
                
                $data = [
                    'status' => 'E',
                    'msg' => 'Error Interface WMS',
                ];
            }

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

    public function getRmaList(Request $request)
    {
        $state = $request->state;
        $query = $request->keyword ? '%'.$request->keyword.'%' : null;
        $collection = collect();
        if( $state === 'search'){
            $receipts = ReceiptStockHeaders::when($query, function($q, $query) {
                $q->where(function($p) use ($query){
                    $p->where('claim_number', 'like', $query)
                    ->orWhere('rma_number', 'like', $query);
                });
            })
            ->limit(100)
            ->orderBy('claim_number')
            ->orderBy('rma_number')
            ->get();
            foreach ($receipts as $receipt) {
                $receipt->credit_note_date = Carbon::parse($receipt->credit_note_date)->addYears(543)->format('d/m/Y');
                $receipt->pick_release_approve_date = Carbon::parse($receipt->pick_release_approve_date)->addYears(543)->format('d/m/Y');
                $rmaTransType = $receipt->rmaTransType;
                $transType = $receipt->transactionType;
                $customer = $receipt->customer;
                $item = (object)[
                    'rma_type' => 'receipt',
                    'rma_id' => $receipt->receipt_header_id,
                    'rma_date' => $receipt->pick_release_approve_date,
                    'customer' => optional($customer)->customer_name,
                    'sale_class' => optional(SaleTypeV::where('value', strtoupper(optional($customer)->sales_classification_code))->first())->description,
                    'invoice_number' => $receipt->pick_release_no,
                    'invoice_date' => $receipt->pick_release_approve_date,
                    'cn_number' => $receipt->credit_note_no,
                    'cn_date' => $receipt->credit_note_date,
                    'rma_order_type' => optional($rmaTransType)->order_type_name ??  optional($transType)->order_type_name,
                    'sale_number' => $receipt->sales_order_number,
                    'ebs_number' => $receipt->ebs_order_number,
                    'transaction_type' => $transType ? $transType->transaction_type.' ('.$transType->transaction_type_id.')' : '',
                    'show' => $receipt->rma_number ? $receipt->rma_number.' : '.$receipt->rma_date.' : '.optional($customer)->customer_name : $receipt->claim_number.' : '.$receipt->claim_date.' : '.optional($customer)->customer_name,
                    'label' => $receipt->rma_number ?? $receipt->claim_number,
                    'value' => $receipt->rma_number ?? $receipt->claim_number,
                    'key' => $receipt->rma_number ?? $receipt->claim_number,
                    'class_sale_type' => optional($customer)->sales_classification_code,
                    'remark' => $receipt->remark,
                    'transaction_date' => $receipt->transaction_date,
                    'status' => $receipt->status,
                ];
                $collection->push($item);
            }
        }else {
            $claims = ClaimHeader::where(function($q){
                $q->where(function($p){
                    $p->whereRaw("upper(status_rma) = 'CONFIRM'")
                    ->whereNull('claim_number');
                })
                ->orWhere(function($p){
                    $p->where('status_approve_claim', 'Y')
                    ->where('status_claim_code', '!=', '9');
                });
            })
            ->when($query, function($q, $query) {
                $q->where(function($p) use ($query){
                    $p->where('claim_number', 'like', $query)
                    ->orWhere('rma_number', 'like', $query);
                });
            })
            ->where(function($q){
                $q->doesnthave('receipts')
                ->orWhereHas('lines', function($p){
                    $p->doesnthave('receipts')
                    ->orWhereHas('receipts', function($r){
                        $r->whereHas('lots', function($s){
                            $s->whereRaw("
                                PTOM_RECEIPT_STOCK_LINES.RECEIPT_LINE_ID IN 
                                (   
                                    SELECT PTOM_RECEIPT_STOCK_LINES.RECEIPT_LINE_ID 
                                    FROM PTOM_RECEIPT_STOCK_LINES
                                    WHERE PTOM_RECEIPT_STOCK_LINES.RECEIPT_QUANTITY > (
                                        SELECT SUM(PTOM_RECEIPT_STOCK_LOTS.QUANTITY) AMOUNT
                                        FROM PTOM_RECEIPT_STOCK_LOTS
                                        WHERE PTOM_RECEIPT_STOCK_LOTS.RECEIPT_LINE_ID = PTOM_RECEIPT_STOCK_LINES.RECEIPT_LINE_ID
                                        GROUP BY PTOM_RECEIPT_STOCK_LINES.RECEIPT_LINE_ID
                                    )
                                )
                            ");
                        });
                    });
                });
            })
            ->with('customer')
            ->limit(100)
            ->orderBy('claim_number')
            ->orderBy('rma_number')
            ->get();
            foreach ($claims as $claim) {
                $check_case_1 = strtoupper($claim->status_rma) === 'CONFIRM';
                $rmaTransType = $claim->rma_number && strtoupper($claim->status_rma) === 'CONFIRM' ? $claim->rmaTransType : ($claim->cancel_deliver_flag != 'Y' && $claim->status_approve_claim == 'Y' ? TransactionTypeAllV::where('order_type_name', 'CLAIM')->first() : null);
                $claim->rma_date = Carbon::parse($claim->rma_date)->addYears(543)->format('d/m/Y');
                $claim->claim_date = Carbon::parse($claim->claim_date)->addYears(543)->format('d/m/Y');
                $claim->invoice_date = Carbon::parse($claim->invoice_date)->addYears(543)->format('d/m/Y');
                $credit_note = $claim->creditNote;
                $cn_date = $credit_note ? Carbon::parse($credit_note->invoice_date)->addYears(543)->format('d/m/Y') : null;
                $customer = $claim->customer;
                // $ref = $claim->ref;
                $item = (object)[
                    'rma_type' => 'claim',
                    'rma_id' => $claim->claim_header_id,
                    'rma_date' => $check_case_1 ? $claim->rma_date : $claim->claim_date,
                    'customer' => optional($customer)->customer_name,
                    'sale_class' => optional(SaleTypeV::where('value', strtoupper(optional($customer)->sales_classification_code))->first())->description,
                    'invoice_number' => $claim->ref_invoice_number,
                    'invoice_date' => $claim->invoice_date,
                    'cn_number' => $claim->credit_note_number,
                    'cn_date' => $cn_date,
                    'rma_order_type' => optional($rmaTransType)->order_type_name,
                    // 'sale_number' => optional($ref)->prepare_order_number ?? optional($ref)->pi_number,
                    'ebs_number' => $claim->ebs_order_number,
                    'transaction_type' => $rmaTransType ? $rmaTransType->transaction_type.' ('.$rmaTransType->transaction_type_id.')' : '',
                    'show' => $check_case_1 ? $claim->rma_number.' : '.$claim->rma_date.' : '.optional($customer)->customer_name : $claim->claim_number.' : '.$claim->claim_date.' : '.optional($customer)->customer_name,
                    'label' => $check_case_1 ? $claim->rma_number : $claim->claim_number,
                    'value' => $check_case_1 ? $claim->rma_number : $claim->claim_number,
                    'key' => $check_case_1 ? $claim->rma_number : $claim->claim_number,
                    'class_sale_type' => optional($customer)->sales_classification_code,
                ];
                $collection->push($item);
            }
        }

        return response()->json($collection);
    }

    public function getRmaLines(Request $request)
    {
        $rma_id = $request->rma_id;
        $rma_type = strtoupper($request->rma_type);
        $class_sale_type = strtoupper($request->class_sale_type);

        if($rma_type === 'CLAIM'){
            $rma = ClaimHeader::find($rma_id);
            $lines = $rma->lines()
            ->where(function($p){
                $p->doesnthave('receipts')
                ->orWhereHas('receipts', function($r){
                    $r->whereHas('lots', function($s){
                        $s->whereRaw("
                            PTOM_RECEIPT_STOCK_LINES.RECEIPT_LINE_ID IN 
                            (   
                                SELECT PTOM_RECEIPT_STOCK_LINES.RECEIPT_LINE_ID
                                FROM PTOM_RECEIPT_STOCK_LINES
                                WHERE PTOM_RECEIPT_STOCK_LINES.RECEIPT_QUANTITY > (
                                    SELECT SUM(PTOM_RECEIPT_STOCK_LOTS.QUANTITY) AMOUNT
                                    FROM PTOM_RECEIPT_STOCK_LOTS
                                    WHERE PTOM_RECEIPT_STOCK_LOTS.RECEIPT_LINE_ID = PTOM_RECEIPT_STOCK_LINES.RECEIPT_LINE_ID
                                    GROUP BY PTOM_RECEIPT_STOCK_LINES.RECEIPT_LINE_ID
                                )
                            )
                        ");
                    });
                });
            })
            ->with('rmaUomV', 'claimUomV')
            ->get();
        }else if($rma_type === 'RECEIPT'){
            $rma = receiptStockHeaders::find($rma_id);
            $lines = $rma->lines()
            ->with('lots')
            ->get();
        }else {
            return response()->json([
                'status' => 'E',
                'msg' => 'ไม่พบข้อมูล Type'
            ]);
        }

        $check_rma = $rma->rma_number != null;
        foreach ($lines as $line) {
            $rmaTransType = $rma->rmaTransType ?? TransactionTypeAllV::where('order_type_name', 'CLAIM')->first();
            $line->segment1 = $rma_type === 'RECEIPT' ? $line->cogs_segment1 : $rmaTransType->cogs_account_segment1;
            $line->segment2 = $rma_type === 'RECEIPT' ? $line->cogs_segment2 : $rmaTransType->cogs_account_segment2;
            $line->segment3 = $rma_type === 'RECEIPT' ? $line->cogs_segment3 : $rmaTransType->cogs_account_segment3;
            $line->segment4 = $rma_type === 'RECEIPT' ? $line->cogs_segment4 : $rmaTransType->cogs_account_segment4;
            $line->segment5 = $rma_type === 'RECEIPT' ? $line->cogs_segment5 : $rmaTransType->cogs_account_segment5;
            $line->segment6 = $rma_type === 'RECEIPT' ? $line->cogs_segment6 : $rmaTransType->cogs_account_segment6;
            $line->segment7 = $rma_type === 'RECEIPT' ? $line->cogs_segment7 : $rmaTransType->cogs_account_segment7;
            $line->segment8 = $rma_type === 'RECEIPT' ? $line->cogs_segment8 : $rmaTransType->cogs_account_segment8;
            $line->segment9 = $rma_type === 'RECEIPT' ? $line->cogs_segment9 : $rmaTransType->cogs_account_segment9;
            $line->segment10 = $rma_type === 'RECEIPT' ? $line->cogs_segment10 : $rmaTransType->cogs_account_segment10;
            $line->segment11 = $rma_type === 'RECEIPT' ? $line->cogs_segment11 : $rmaTransType->cogs_account_segment11;
            $line->segment12 = $rma_type === 'RECEIPT' ? $line->cogs_segment12 : $rmaTransType->cogs_account_segment12;
            $line->account_code =  $rma_type === 'RECEIPT' ? (
                $line->segment1.'.'.$line->segment2.'.'.$line->segment3.'.'.$line->segment4.'.'.
                $line->segment5.'.'.$line->segment6.'.'.$line->segment7.'.'.$line->segment8.'.'.
                $line->segment9.'.'.$line->segment10.'.'.$line->segment11.'.'.$line->segment12
            ) : $rmaTransType->cogs_account;

            $uomV = $check_rma ? $line->rmaUomV : $line->claimUomV;
            $line->uom_code = $rma_type === 'RECEIPT' ? $line->uom_code : ($check_rma ? $line->rma_uom_code : $line->claim_uom_code);
            $line->uom = $rma_type === 'RECEIPT' ? $line->uom : ($class_sale_type === 'EXPORT' ? $uomV->description : $uomV->unit_of_measure);
            
            $qty = (float)($rma_type === 'RECEIPT' ? $line->receipt_quantity : ($check_rma ? $line->rma_quantity : $line->claim_quantity));
            $use_qty = (float)($rma_type === 'RECEIPT' ? (float)0 : (float)($line->receipts->sum('total_receipt_qty')));
            $line->remain_quantity = (float)($qty - $use_qty);
            $line->lots = $line->lots ?? [];

            foreach ($line->lots as $lot) {
                $lot->input_qty = $rma_type === 'RECEIPT' ? $lot->quantity : 0;
                $lot->need_qty = $rma_type === 'RECEIPT' ? $lot->quantity : 0;
                $lot->convert_qty = (float)convertUom($line->item_id, $lot->onhand_quantity ?? $lot->quantity, $lot->transaction_uom_code ?? $lot->uom_code, $line->uom_code);
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

    public function getInvList()
    {
        $list = Organization::orderBy('organization_code')->get();

        return response()->json($list);
    }

    public function getSubInvList(Request $request)
    {
        $inv_id = $request->inv;
        $list = MtlSecondaryInventoriesFkV::select('secondary_inventory_name as sub_inv_name', 'organization_id', 'description', 'locator_type')
        ->whereRaw("upper(status_code) = 'ACTIVE'")
        ->where('organization_id', $inv_id)
        ->orderBy('sub_inv_name')
        ->get();

        return response()->json($list);
    }

    public function getLocateSeg1List(Request $request)
    {
        $inv_id = $request->inv;
        $sub_inv = $request->sub_inv;
        $sub = MtlSecondaryInventoriesFkV::select('secondary_inventory_name as sub_inv_name', 'organization_id', 'description', 'locator_type')
        ->whereRaw("upper(status_code) = 'ACTIVE'")
        ->where('organization_id', $inv_id)
        ->where('secondary_inventory_name', $sub_inv)
        ->first();
        if(optional($sub)->locator_type != '1'){
            $list = MtlItemLocations::select('segment1')
            ->whereRaw("upper(enabled_flag) = 'Y'")
            ->where('organization_id', $inv_id)
            ->where('subinventory_code', $sub_inv)
            ->groupBy('segment1')
            ->orderBy('segment1')
            ->get();
        }else $list = [];

        return response()->json($list);
    }

    public function getLocateSeg2List(Request $request)
    {
        $inv_id = $request->inv;
        $sub_inv = $request->sub_inv;
        $segment1 = $request->locator_segment1;
        $sub = MtlSecondaryInventoriesFkV::select('secondary_inventory_name as sub_inv_name', 'organization_id', 'description', 'locator_type')
        ->whereRaw("upper(status_code) = 'ACTIVE'")
        ->where('organization_id', $inv_id)
        ->where('secondary_inventory_name', $sub_inv)
        ->first();
        if(optional($sub)->locator_type != '1'){
            $list = MtlItemLocations::select('description', 'segment1', 'segment2')
            ->whereRaw("upper(enabled_flag) = 'Y'")
            ->where('organization_id', $inv_id)
            ->where('subinventory_code', $sub_inv)
            ->where('segment1', $segment1)
            ->orderBy('segment2')
            ->get();
        }else $list = [];

        return response()->json($list);
    }

    public function getLotNumberList(Request $request)
    {
        $inv_id = $request->inv;
        $item_id = $request->item_id;
        $list = MtlLotNumbersAllV::select('lot_number', 'description')
        ->whereRaw("upper(status_code) = 'ACTIVE'")
        ->where('inventory_item_id', $item_id)
        ->where('organization_id', $inv_id)
        ->orderBy('lot_number')
        ->get();

        return response()->json($list);
    }
}