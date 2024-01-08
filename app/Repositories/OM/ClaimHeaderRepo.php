<?php

namespace App\Repositories\OM;

use App\Models\OM\Api\Customer;
use App\Models\OM\AttachFiles;
use App\Models\OM\Customers;
use App\Models\OM\InvoiceHeaders;
use App\Models\OM\OverdueDebt\ProformaInvoiceHeaders;
use App\Models\OM\PaymentApply;
use App\Models\OM\ProformaInvoiceHeader;
use App\Models\OM\Promotions\UomV;
use App\Models\OM\PtomInvoiceHeader;
use App\Models\OM\RMATransactionTypeId;
use App\Models\OM\TranspotOrder;
use App\Models\Ptom\PtomClaimHeader;
use App\Models\Ptom\PtomClaimLine;
use App\Models\Ptom\PtomClaimStatusV;
use App\Models\Ptom\PtomInvoiceLine;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;
use Intervention\Image\Facades\Image;

class ClaimHeaderRepo
{
    protected $header;

    const CLAIM_REJECTED = 5;
    const OUT_FOR_DELIVERY = 3;
    const ISSUING_CREDIT_NOTE = 4;
    const CLOSED = 8;

    public function __construct(PtomClaimHeader $header)
    {
        $this->header = $header;
    }


    public function getClaimRepo($request)
    {
        $header = $this->header->query();
        $header->whereNotNull('claim_number')
            ->with(['statusClaim', 'customer', 'lines' => function ($q) {
                $q->with([
                    'sequence_ecoms',
                    'uom_description',
                    'enter_uom_description',
                    'attachment' => function ($q) {
                        $q->where('attachment_program_code', 'OMP0081');
                    }
                ]);
            }]);
        $header->when($request->claim_number, function ($q) use ($request) {
            $q->where('claim_number', $request->claim_number);
        })
            ->when($request->customer_id, function ($q) use ($request) {

                $q->where('customer_id', $request->customer_id);
            })
            ->when($request->claim_status, function ($q) use ($request) {

                $q->where('status_claim_code', $request->claim_status);
            })
            ->when($request->claim_date, function ($q) use ($request) {

                $q->whereRaw("TRUNC(claim_date) = TO_DATE('" . \Carbon\Carbon::parse($request->claim_date)->format('Y-m-d') . "', 'YYYY-MM-DD')");
            })
            ->when($request->key, function ($q) use ($request) {
                $q->where('claim_header_id', $request->key);
            })
            ->where('SALES_TYPE', 'EXPORT');
        if ($request->only == 1) {
            $header = $header->first();

            foreach ($header->lines as $line) {
                $line->attachment = $line->attachment->map(function ($item) {
                    $storege = \Storage::url($item->path_name);
                    if (file_exists(public_path($storege))) {
                        try {
                            $item->image_resize  = (string)Image::make(public_path($storege))->resize(800, 800, function ($constraint) {
                                $constraint->aspectRatio();
                            })->encode('data-url');
                        } catch (\Throwable $th) {
                            $item->image_resize = 'Image not available';
                        }
                    } else {
                        $item->image_resize = '';
                    }


                    return $item;
                });
            }
        } else {
            $header = $header->orderBy('claim_date', 'desc')->get()->map(function ($item) {
                foreach ($item->lines as $line) {
                    $line->attachment = $line->attachment->map(function ($item) {
                        $storege = \Storage::url($item->path_name);
                        if (file_exists(public_path($storege))) {
                            try {
                                $item->image_resize  = (string)Image::make(public_path($storege))->resize(800, 800, function ($constraint) {
                                    $constraint->aspectRatio();
                                })->encode('data-url');
                            } catch (\Throwable $th) {
                                $item->image_resize = 'Image not available';
                            }
                        } else {
                            $item->image_resize = '';
                        }

                        switch ($item->attribute1) {
                            case '1':
                                $item->type_name = '(Front Side)';
                                break;
                            case '2':
                                $item->type_name = '(Beside) ';
                                break;
                            case '3':
                                $item->type_name = '(Attach Photo Good Damaged)';
                                break;
                            default:
                                $item->type_name = '';
                                break;
                        }
                        return $item;
                    });
                }

                $item->claim_date = \Carbon\Carbon::parse($item->claim_date)->format('d/m/Y');
                $item->invoice_date = \Carbon\Carbon::parse($item->invoice_date)->format('d/m/Y');
                return $item;
            });
        }

        return $header;
    }

    public function getClaimListNumber($request)
    {
        $data = $this->header->query();
        if ($request->field)
            $data->selectRaw($request->field);


        $data->whereNotNull('claim_number');
        $data->where('SALES_TYPE', 'EXPORT');
        $data = $data->whereIn('program_code', ['OMP0081', 'OMP0084']);
        $data->orderBy('claim_date');

        return $data->get();
    }

    public function getHeaders($request)
    {
        $header = $this->header
            ->whereNotNull('status_claim_code')
            ->when(!empty($request->customer_id), function ($q) use ($request) {
                return $q->where('customer_id', $request->customer_id);
            })
            ->when(!empty($request->claim_number), function ($q) use ($request) {
                return $q->where('claim_number', $request->claim_number);
            })
            ->when(!empty($request->claim_date), function ($q) use ($request) {
                $claim_date = \Carbon\Carbon::parse($request->claim_date)->format('Y-m-d');
                return $q->where(DB::raw('TRUNC(claim_date)'), $claim_date);
            })
            ->when(!empty($request->status_claim), function ($q) use ($request) {
                return $q->where('status_claim_code', $request->status_claim);
            });
        $header = $header->where('sales_type', "EXPORT");
        $header = $header->orderBy('claim_date', 'desc')->get();
        $header = $header->map(function ($q) {
            $q->validate_approve_text = false;
            $q->check_type_claim = false;
            $invoiceHeaderId =  ProformaInvoiceHeaders::where('PI_HEADER_ID', $q->invoice_id)->first();
            $q->invoice_header_set = $invoiceHeaderId;
            $q->invoice_id_number = $invoiceHeaderId ? $invoiceHeaderId->pick_release_no : '';
            $q->close_claim_status = in_array($q->status_claim, ['2', '8', '']);
            $q->lines = PtomClaimLine::where('claim_header_id', $q->claim_header_id)->get()->toArray();
            $q->customer = Customers::where('CUSTOMER_ID', $q->customer_id)->first()->toArray() ?? collect(['customer_number' => '', 'customer_name' => '']);
            $q->invoice_date_label = \Carbon\Carbon::parse($q->invoice_date)->format('d/m/Y');
            $q->status_claim_label = ClaimStatusVRepo::findById($q->status_claim_code);
            $q->attachment = AttachFiles::where('attachment_program_code', 'OMP0081')->where('header_id', $q->claim_header_id)->orderBy('line_id')->orderBy('attribute1')->get()->toArray();
            return $q;
        });

        return $header;
    }
    public function closeClaim($request)
    {
        $header = $this->header->where('claim_header_id', $request['claim_header_id'])->first();
        $header->status_claim_code = self::CLOSED;
        $header->status_claim = 'ปิดการเคลม';
        $header->save();
    }
    public function update($request)
    {
        foreach ($request->all() as $item) {
            $header = $this->header->where('claim_header_id', $item['claim_header_id'])->first();
            if (empty($header)) {
                throw new \Exception("ไม่พบข้อมูล CLAIM_HEADER_ID", 1);
            }
            if ($item['approve_type'] == "N") {
                $status                         = PtomClaimStatusV::where('lookup_code', self::CLAIM_REJECTED)->first();
                $header->status_claim           = $status->meaning;
                $header->status_claim_code      = $status->lookup_code;
                $header->status_approve_claim   = 'N';
                $header->remark_approve         = $item['approve_text'];
                $header->pack_quantity          = !empty($item['pack_quantity']) ? $item['pack_quantity'] : null;
                $header->cardboard_box_quantity = !empty($item['cardboard_box_quantity']) ? $item['cardboard_box_quantity'] : null;
                $header->cartons_quantity       = !empty($item['cartons_quantity']) ? $item['cartons_quantity'] : null;
                $header->save();

                // $updateService = $this->updateClaimEcom($header);
                // if ($updateService === false) throw new \Exception("Error Processing Request", 1);
            } elseif ($item['approve_type'] == "Y") {
                if (empty($header->status_approve_claim)) {
                    $header->status_approve_claim   = 'Y';
                    $header->remark_approve         = $item['approve_text'];
                    $header->pack_quantity          = !empty($item['pack_quantity']) ? $item['pack_quantity'] : null;
                    $header->cardboard_box_quantity = !empty($item['cardboard_box_quantity']) ? $item['cardboard_box_quantity'] : null;
                    $header->cartons_quantity       = !empty($item['cartons_quantity']) ? $item['cartons_quantity'] : null;
                    $header->save();
                    // $updateService = $this->updateClaimEcom($header);
                    // if ($updateService === false) throw new \Exception("Error Processing Request", 1);
                } elseif ($header->status_approve_claim == 'Y' && $header->status_claim_code == 2) {
                    // case 1
                    if ($item['type_claim'] == 'send_now') {
                        $result = $this->sendProductAndNotSendProductBack($item, $header);
                        if ($result === false) throw new \Exception("Error Processing Request", 1);
                    }

                    // case 2
                    if ($item['type_claim'] == 'issue_credit_note' && !empty($item['no_product_claim'])) {
                        $result = $this->canclDeliverFlagN($item, $header);
                        if ($result === false) throw new \Exception("Error Processing Request", 1);
                    }

                    // case 3
                    if ($item['type_claim'] == 'issue_credit_note' && empty($item['no_product_claim'])) {

                        $result = $this->canclDeliverFlagRN($item, $header);
                        if ($result === false) throw new \Exception("Error Processing Request", 1);
                    }
                }
            }
            // elseif($item['approve_type'] == "Y" && $header->status_approve_claim == "Y" &&  )
        }
    }
    public function getClaimNumber($request)
    {
        $customer_id = $request->customer_number;
        if (!empty($customer_id)) {
            return $this->header
                ->whereNotNull('claim_number')
                ->where('customer_id', $customer_id)
                ->orderBy('claim_number', 'desc')
                ->where('sales_type', 'EXPORT')
                ->get();
        }
        return $this->header
            ->whereNotNull('claim_number')
            ->orderBy('claim_number', 'desc')
            ->where('sales_type', 'EXPORT')
            ->get();
    }

    public function updateClaimEcom($header)
    {
        // $response = Http::post(env('APP_ECOM') . '/ecom/api/update-claim-header', $header->toArray());
        // if ($response->ok() === false) return false;

        return true;
    }
    // Case 1 
    public function sendProductAndNotSendProductBack($item, $header)
    {
        try {
            DB::beginTransaction();
            $wms = $this->callWMS('1.13', ['claim_header_id' => $item['claim_header_id'], 'claim_number' => $item['claim_number']]);
            if ($wms === false) return false;
            $status = PtomClaimStatusV::where('lookup_code', self::OUT_FOR_DELIVERY)->first();
            $header->status_claim           = $status->meaning;
            $header->status_claim_code      = $status->lookup_code;
            $header->cancel_deliver_remark  = $item['input_memo'];
            $header->cancel_deliver_flag    = $item['no_product_claim'] == "not_send_product_back" ? 'N' : 'Y';
            $header->replacement_flag       = 'Y';
            $header->interfaced_msg         = $wms;
            $header->interface_status       = strpos((string)$wms, 'Error') !== false ? "E" : "Y";
            $header->save();
            // $updateService = $this->updateClaimEcom($header);

            // if ($updateService === false) throw new \Exception("Error Processing Request", 1);
            DB::commit();
            return true;
        } catch (\Exception $ex) {
            DB::rollback();
            return false;
        }
    }

    // Case 2 
    public function canclDeliverFlagN($item, $header)
    {
        try {
            // สร้าง credit_note
            $rmaDocCn = $this->genarateRMADoc('OMP0077_CN_NUM_EXP');

            $result = $this->cnStoreInvoiceHL($item, $header, $rmaDocCn);

            if ($result === false) return false;
            $auth = getDefaultData('OMP0082');

            DB::beginTransaction();
            $status = PtomClaimStatusV::where('lookup_code', self::ISSUING_CREDIT_NOTE)->first();
            $header->status_claim           = $status->meaning;
            $header->status_claim_code      = $status->lookup_code;
            $header->cancel_deliver_remark  = $item['input_memo'];
            $header->cancel_deliver_flag    = 'Y';
            $header->replacement_flag       = 'N';
            $header->save();


            // $updateService = $this->updateClaimEcom($header);
            // if ($updateService === false) throw new \Exception("Error Processing Request", 1);
            DB::commit();
            return true;
        } catch (\Exception $th) {
            DB::rollback();
            return false;
        }
    }
    public function cnStoreInvoiceHL($item, $header, $rmaDoc)
    {
        try {
            DB::beginTransaction();
            if ($rmaDoc === false) return false;

            $now = now()->format('Y-m-d H:i:s');
            $auth = getDefaultData('OMP0082');

            $proformaHeader = ProformaInvoiceHeaders::where('pi_header_id', $item['invoice_id'])->first();
            $lines = PtomClaimLine::where('claim_header_id', $item['claim_header_id'])->get();

            $lines->map(function ($o) {
                $o->unit_price = TranspotOrder::where('item_id', $o->item_id)->first()->unit_price;
                $o->payment_amount = $o->unit_price * $o->claim_quantity;
            });

            $invoice_amount = $lines->sum('payment_amount');

            $invoiceData = [
                'invoice_headers_number' => $rmaDoc['lv_doc_sequence_number'] ?? '',
                'customer_id'            => $item['customer']['customer_id'],
                'invoice_type'           => 'CN_OTHER',
                'invoice_date'           => $now,
                'invoice_amount'         => $invoice_amount,
                'invoice_status'         => 'Confirm',
                'term_id'                => $proformaHeader->term_id,
                'delivery_date'          => $proformaHeader->delivery_date,
                'document_number'        => $item['claim_header_id'],
                'channel_receiving_code' => 40,
                'ref_invoice_number'     => @$header->ref_invoice_number,
                'program_code'           => 'OMP0082',
                'created_by'             => $auth->user_id ?? -1,
                'creation_date'          => $now,
                'last_updated_by'        => $auth->user_id ?? -1,
                'last_update_date'       => $now,
                'created_by_id'          => $auth->user_id ?? -1,
                'updated_by_id'          => $auth->user_id ?? -1,
                'currency'               => $proformaHeader->currency,
            ];

            $invoiceHeader = new InvoiceHeaders();
            foreach ($invoiceData as $field => $val) $invoiceHeader->{$field} = $val;
            $auth = getDefaultData('OMP0082');
            $invoiceHeader->save();
            $document_id = '';
            foreach ($lines as $line) {
                $dataLine = [
                    'invoice_headers_id' => $invoiceHeader->invoice_headers_id,
                    'item_id'            => $line->item_id,
                    'item_code'          => $line->item_code,
                    'item_description'   => $line->item_description,
                    'uom_code'           => $line->claim_uom_code,
                    'quantity'           => $line->claim_quantity,
                    'document_id'        => $line->claim_header_id,
                    'document_line_id'   => $line->claim_line_id,
                    'payment_amount'     => $line->payment_amount,
                    'ref_invoice_number'     => @$header->ref_invoice_number,
                    'invoice_flag'       => "Y",
                    // 'currency'        => '',
                    'conversion_rate'    => $proformaHeader->exchange_rate,
                    'program_code'       => 'OMP0082',
                    'created_by'         => $auth->user_id ?? -1,
                    'creation_date'      => $now,
                    'last_updated_by'    => $auth->user_id ?? -1,
                    'last_update_date'   => $now,
                    'created_at'         => $now,
                    'updated_at'         => $now,
                    'created_by_id'      => $auth->user_id ?? -1,
                    'updated_by_id'      => $auth->user_id ?? -1,
                ];
                $invoiceLine  = new PtomInvoiceLine();
                foreach ($dataLine as $field => $val) $invoiceLine->{$field} = $val;
                $invoiceLine->save();
            }
            // 650207 แก้ไขเพิ่มเงือนไข ระบบจะตรวจสอบดูว่า สถานะการรับชำระเงิน เป็นกรณีไหน ประชุมคุณผึ้ง 650207.1:14
            // กรณีที่ 1 รับชำระเงินครบแล้ว (หากหาข้อมูลจาก PTOM_OUTSTANDING_DEBT_EXP_V โดย where PTOM_OUTSTANDING_DEBT_EXP_V.PICK_RELEASE_NO = PTOM_INVOICE_LINES.REF_INVOICE_NUMBER แล้วไม่พบข้อมูล
            // กรณีที่ 2 เหลือหนี้ค้างชำระมากกว่าหรือเท่ากับยอดเงินใบลดหนี้ (หากหาข้อมูลจาก PTOM_OUTSTANDING_DEBT_EXP_V โดย where PTOM_OUTSTANDING_DEBT_EXP_V.PICK_RELEASE_NO = PTOM_INVOICE_LINES.REF_INVOICE_NUMBER
            // แล้วพบว่า Sum(PTOM_OUTSTANDING_DEBT_EXP_V.OUTSTANDING_DEBT) มีค่ามากกว่าหรือเท่ากับ Sum(PTOM_INVOICE_LINES.PAYMENT_AMOUNT)
            // กรณีที่ 3 เหลือหนี้ค้างชำระน้อยกว่ายอดเงินใบลดหนี้ (หากหาข้อมูลจาก PTOM_OUTSTANDING_DEBT_EXP_V โดย where PTOM_OUTSTANDING_DEBT_EXP_V.PICK_RELEASE_NO = PTOM_INVOICE_LINES.REF_INVOICE_NUMBER
            // แล้วพบว่า Sum(PTOM_OUTSTANDING_DEBT_EXP_V.OUTSTANDING_DEBT) มีค่าน้อยกว่า Sum(PTOM_INVOICE_LINES.PAYMENT_AMOUNT)
            $ptomOutstandingDebtExpV = DB::table('PTOM_OUTSTANDING_DEBT_EXP_V')->where('PICK_RELEASE_NO', $header->ref_invoice_number)->whereNotNull('PICK_RELEASE_NO')->get();
            $ptomSumLine = PtomInvoiceLine::where('invoice_headers_id', $invoiceHeader->invoice_headers_id)->get();
            $sumLine = $ptomSumLine->sum('payment_amount');
            // $line
            if (count($ptomOutstandingDebtExpV) == 0) { # case 1 กรณีที่ 1 รับชำระเงินครบแล้ว (หากหาข้อมูลจาก PTOM_OUTSTANDING_DEBT_EXP_V โดย where PTOM_OUTSTANDING_DEBT_EXP_V.PICK_RELEASE_NO = PTOM_INVOICE_LINES.REF_INVOICE_NUMBER แล้วไม่พบข้อมูล
                $applyCndn = [
                    'INVOICE_NUMBER' =>  $rmaDoc['lv_doc_sequence_number'],
                    'INVOICE_HEADER_ID' => $invoiceHeader->invoice_headers_id,
                    'INVOICE_AMOUNT' => $sumLine,
                    'ATTRIBUTE1' => '', # แก้ตามเอกสาร650702 'Y' -> ''
                    'ATTRIBUTE2' => 'CN_OTHER',
                    'PROGRAM_CODE' => 'OMP0084',
                    'CREATED_BY' => $auth->user_id ?? -1,
                    'CREATION_DATE' => now()->format('Y-m-d H:i:s'),
                    'LAST_UPDATED_BY' => $auth->user_id ?? -1,
                    'LAST_UPDATE_DATE' => now()->format('Y-m-d H:i:s'),
                ];
                PaymentApply::insert($applyCndn);
            } else if (count($ptomOutstandingDebtExpV) > 0) { #case 2เหลือหนี้ค้างชำระมากกว่าหรือเท่ากับยอดเงินใบลดหนี้ 
                $sumDebtExp = $ptomOutstandingDebtExpV->sum('outstanding_debt');
                if ($sumDebtExp  >= $sumLine) {
                    $applyCndn = [
                        'ORDER_HEADER_ID' => $line->claim_header_id,
                        'PICK_RELEASE_NO' =>  $invoiceHeader->invoice_headers_id,
                        'INVOICE_NUMBER' =>  $rmaDoc['lv_doc_sequence_number'],
                        'INVOICE_HEADER_ID' => $invoiceHeader->invoice_headers_id,
                        'INVOICE_AMOUNT' => $sumLine,
                        'ATTRIBUTE1' => 'Y',
                        'ATTRIBUTE2' => 'CN_OTHER',
                        'PROGRAM_CODE' => 'OMP0084',
                        'CREATED_BY' => $auth->user_id ?? -1,
                        'CREATION_DATE' => now()->format('Y-m-d H:i:s'),
                        'LAST_UPDATED_BY' => $auth->user_id ?? -1,
                        'LAST_UPDATE_DATE' => now()->format('Y-m-d H:i:s'),
                    ];
                    PaymentApply::insert($applyCndn);
                }

                if ($sumDebtExp < $sumLine) {
                    $applyLine1 = $sumLine - $sumDebtExp;
                    $applyCndn = [
                        'ORDER_HEADER_ID' => $line->claim_header_id,
                        'PICK_RELEASE_NO' =>  $invoiceHeader->invoice_headers_id,
                        'INVOICE_NUMBER' =>  $rmaDoc['lv_doc_sequence_number'],
                        'INVOICE_HEADER_ID' => $invoiceHeader->invoice_headers_id,
                        'INVOICE_AMOUNT' => $sumDebtExp,
                        'ATTRIBUTE1' => 'Y',
                        'ATTRIBUTE2' => 'CN_OTHER',
                        'PROGRAM_CODE' => 'OMP0084',
                        'CREATED_BY' => $auth->user_id ?? -1,
                        'CREATION_DATE' => now()->format('Y-m-d H:i:s'),
                        'LAST_UPDATED_BY' => $auth->user_id ?? -1,
                        'LAST_UPDATE_DATE' => now()->format('Y-m-d H:i:s'),
                    ];
                    PaymentApply::insert($applyCndn);
                    unset($applyCndn);
                    $applyCndn = [
                        'INVOICE_NUMBER' =>  $rmaDoc['lv_doc_sequence_number'],
                        'INVOICE_HEADER_ID' => $invoiceHeader->invoice_headers_id,
                        'INVOICE_AMOUNT' => $applyLine1,
                        'ATTRIBUTE2' => 'CN_OTHER',
                        'PROGRAM_CODE' => 'OMP0084',
                        'CREATED_BY' => $auth->user_id ?? -1,
                        'CREATION_DATE' => now()->format('Y-m-d H:i:s'),
                        'LAST_UPDATED_BY' => $auth->user_id ?? -1,
                        'LAST_UPDATE_DATE' => now()->format('Y-m-d H:i:s'),
                    ];
                    PaymentApply::insert($applyCndn);
                }
            }

            // DB::rollback();
            DB::commit();
            return $rmaDoc;
        } catch (\Exception $th) {
            DB::rollback();
            return false;
        }
    }


    public function getOrderTypeId($header)
    {
        try {
            $rmaTransTypeId = RMATransactionTypeId::select('RMA_TRANSACTION_TYPE_ID')
                ->where('ORDER_TYPE_ID', function ($query) use ($header) {
                    $query->select('ORDER_TYPE_ID')
                        ->from((new ProformaInvoiceHeader)->getTable())
                        ->where('PI_HEADER_ID', $header->invoice_id)
                        ->first();
                })->first();
            return $rmaTransTypeId;
        } catch (\Throwable $ex) {
            throw new \Exception("Error Processing getOrderTypeId", 1);
        }
    }
    // Case 3
    public function canclDeliverFlagRN($item, $header)
    {
        try {
            $rmaDoc = $this->genarateRMADoc('OMP0084_RMA_NUM_EXP');

            // อัพเดท RMA ใน HEADER
            if ($rmaDoc === false) return false;

            $header->rma_number   = $rmaDoc['lv_doc_sequence_number'];
            $header->rma_date     = $rmaDoc['date_current'];
            $header->status_rma   = 'Confirm';
            $header->program_code = 'OMP0084';
            $orderTypeId = $this->getOrderTypeId($header);
            $header->rma_order_type_id = $orderTypeId->rma_transaction_type_id;

            foreach ($header->lines as $line) {
                $line->rma_quantity        = $line->claim_quantity;
                $line->rma_uom_code        = $line->claim_uom_code;
                $line->enter_rma_quantity  = $line->enter_claim_quantity;
                $line->enter_rma_uom       = $line->enter_claim_uom;
                $line->rma_quantity_cbb    = $line->claim_quantity_cbb;
                $line->rma_quantity_carton = $line->claim_quantity_carton;
                $line->rma_quantity_pack   = $line->claim_quantity_pack;
                $line->save();
            }

            $header->save();

            // สร้าง credit_note
            $rmaDocCn = $this->genarateRMADoc('OMP0077_CN_NUM_EXP');
            $header->credit_note_number = $rmaDocCn['lv_doc_sequence_number'];
            $header->save();

            // ส่งค่าไปให้ PKG function
            $wms = $this->callWMS('1.14', ['claim_header_id' => $item['claim_header_id'], 'i_rma_number' => $rmaDoc['lv_doc_sequence_number']]);

            // บันทึกลง Invoice Header and Line
            $result = $this->cnStoreInvoiceHL($item, $header, $rmaDocCn);

            // ตรวจสอบข้อมูลการทำรายการ
            if ($wms === false || $rmaDoc === false || $result === false) return false;

            // บันทึกสถานะลง HEADER
            DB::beginTransaction();
            $status = PtomClaimStatusV::where('lookup_code', self::ISSUING_CREDIT_NOTE)->first();
            $header->status_claim           = $status->meaning;
            $header->status_claim_code      = $status->lookup_code;
            $header->cancel_deliver_remark  = $item['input_memo'];
            $header->cancel_deliver_flag    = 'N';
            $header->replacement_flag       = 'N';
            $header->interfaced_msg         = $wms;
            $header->interface_status       = strpos((string)$wms, 'Error') !== false ? "E" : "Y";
            $header->save();


            // $updateService = $this->updateClaimEcom($header);
            // if ($updateService === false) throw new \Exception("Error Processing Request", 1);
            DB::commit();
            return true;
        } catch (\Exception $th) {
            DB::rollback();
            return false;
        }
    }
    public function genarateRMADoc($doc_code)
    {
        try {
            $lv_doc_sequence_number = '';
            $lv_return_status = '';
            $lv_return_msg = '';
            $command = "DECLARE 
            LV_DOC_SEQUENCE_NUMBER VARCHAR2(100) := NULL;
            LV_RETURN_STATUS VARCHAR2(100) := NULL;
            LV_RETURN_MSG VARCHAR2(4000) := NULL;
            BEGIN
                PTOM_WEB_UTILITIES_PKG.GENERATE_DOC_SEQUENCE_NUMBER (	
                I_DOCUMENT_CODE => '{$doc_code}', 
                O_DOC_SEQUENCE_NUMBER => :LV_DOC_SEQUENCE_NUMBER, 
                O_RETURN_STATUS => :LV_RETURN_STATUS, 
                O_RETURN_MSG => :LV_RETURN_MSG 
                );
            END;";
            $pdo = DB::getPdo();
            $stmt = $pdo->prepare($command);
            $stmt->bindParam(':LV_DOC_SEQUENCE_NUMBER', $lv_doc_sequence_number, \PDO::PARAM_STR, 100);
            $stmt->bindParam(':LV_RETURN_STATUS', $lv_return_status, \PDO::PARAM_STR, 100);
            $stmt->bindParam(':LV_RETURN_MSG', $lv_return_msg, \PDO::PARAM_STR, 4000);
            $ret_code = $stmt->execute();

            return ['lv_doc_sequence_number' => $lv_doc_sequence_number, 'date_current' => now(), 'lv_return_status' => $lv_return_status, 'lv_return_msg' => $lv_return_msg];
        } catch (\Exception $th) {
            return false;
        }
    }
    // WMS 1.13
    public function callWMS($package, $data)
    {
        try {
            $o_result = null;

            switch ($package) {
                case '1.13':
                    if (empty($data['claim_header_id']) && empty($data['claim_number'])) return false;

                    $command = "DECLARE                 
                    o_result    VARCHAR2(4000) := NULL;             
                    BEGIN                   
                        PTOM_WEB_SALE_INF_WMS_PKG.main_process_1_13(
                            i_claim_header_id       => {$data['claim_header_id']}   
                            ,i_claim_number         => '{$data['claim_number']}'     
                            ,o_result               => :o_result);
                    END;";
                    break;
                case '1.14':
                    if (empty($data['claim_header_id']) && empty($data['i_rma_number'])) return false;

                    $command = "DECLARE                 
                    o_result    VARCHAR2(4000) := NULL;             
                    BEGIN                   
                        PTOM_WEB_SALE_INF_WMS_PKG.main_process_1_14(
                            i_claim_header_id       => {$data['claim_header_id']}   
                            ,i_rma_number         => '{$data['i_rma_number']}'     
                            ,o_result               => :o_result);
                    END;";
                    break;
                default:
                    return false;
                    break;
            }
            $pdo = DB::getPdo();
            $stmt = $pdo->prepare($command);
            $stmt->bindParam(':o_result', $o_result, \PDO::PARAM_STR, 4000);
            $stmt->execute();
            return $o_result;
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function store($request, $number)
    {
        $data = $this->setDataHeader($request, $number);
        foreach ($data as $key => $value) {
            $this->header->{$key} = $value;
        }
        $this->header->save();
        return $this->header;
    }

    public function setDataHeader($request, $number)
    {

        // $customer = Customer::where('customer_number', $request->customer_number)->first();
        $now = now()->format('Y-m-d H:i:s');
        // $auth = getDefaultData('OMP0081');
        $auth = null;
        $customer = Customer::where('customer_number', $request->customer_number)->first();
        $customer_id = $customer->customer_id ?? '-1';
        $data =  [
            'claim_number'                        => $number,
            'claim_date'                          => $now,
            'ref_invoice_number'                  => @$request->pick_release_no,
            'invoice_id'                          => $request->pi_header_id,
            'invoice_date'                        => $request->pick_release_approve_date,
            // 'cardboard_box_quantity'              => $request->cardboard_box_quantity,
            // 'cartons_quantity'                    => $request->cartons_quantity,
            // 'pack_quantity'                       => $request->pack_quantity,
            'customer_id'                         => $customer->customer_id ?? 0,
            'source_system'                       => $request->source_system,
            'remark_source_system'                => ($request->remark_source_system != "null" && !empty($request->remark_source_system)) ? $request->remark_source_system : '',
            'ship_to_site_id'                     => $request->ship_to_site_id,
            'symptom_description'                 => $request->symptom_description,
            'status_claim_code'                   => 2,
            'status_claim'                        => 'อยู่ระหว่างการตรวจสอบ',
            'program_code'                        => 'OMP0081',
            'sales_type'                          => 'EXPORT',
            'created_by'                          => $auth->user_id ?? -1,
            'creation_date'                       => $now,
            'last_updated_by'                     => $auth->user_id ?? -1,
            'last_update_date'                    => $now,
            'created_at'                          => $now,
            'updated_at'                          => $now,
            'created_by_id'                       => $auth->fnd_user_id ?? 0,
            'updated_by_id'                       => $auth->fnd_user_id ?? 0,
        ];
        return $data;
    }
}
