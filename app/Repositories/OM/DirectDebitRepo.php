<?php

namespace App\Repositories\OM;
use Illuminate\Support\Facades\DB;
use App\Models\OM\Api\DirectDebit;
use App\Models\OM\OrderDirectDebit;
use App\Models\OM\Api\OrderCreditGroup;
use App\Models\OM\Customers;
use App\Models\OM\ReceiptBankAccV;
use App\Models\OM\Payment\PaymentMethodDomestic;
use App\Models\OM\Payment\PaymentMethodExport;

use App\Models\OM\SaleConfirmation\ProformaInvoiceHeaders;

class DirectDebitRepo
{
    public static function updateOrderDirectDebitExport($header)
    {
        // $pi = ProformaInvoiceHeaders::where('order_header_id',$header->order_header_id)->orderBy('order_header_id','DESC')->first();

        $directDebit = DirectDebit::where('customer_id',$header->customer_id)->orderBy('direct_debit_id','DESC')->first();

        $customer_id = $header->customer_id;

        $orderCredit = OrderCreditGroup::where('order_header_id',$header->order_header_id)->where('order_line_id',0)->get();

        $paymenyMetchod = PaymentMethodExport::where('lookup_code',$header->payment_method_code)->first();

        // ->where('branch_id',$directDebit->branch_id)
        $receiptBank = ReceiptBankAccV::where('mapping_om_type',$paymenyMetchod->meaning)->where('bank_id',$directDebit->bank_id)->where('class_name','ระบบขายต่างประเทศ')->first();

        $customersOrder = Customers::byCustomerId($customer_id);

        OrderDirectDebit::where('order_header_id',$header->order_header_id)->delete();

        foreach ($orderCredit as $key => $ocd) {

            $orderDirectDebit = new OrderDirectDebit();
            $orderDirectDebit->order_header_id = $header->order_header_id;
            $orderDirectDebit->direct_debit_id = $directDebit->direct_debit_id;
            $orderDirectDebit->credit_group_code = $ocd->credit_group_code;
            $orderDirectDebit->customer_id = $customersOrder->customer_id;
            $orderDirectDebit->customer_number = $customersOrder->customer_number;
            $orderDirectDebit->customer_name = $customersOrder->customer_name;
            $orderDirectDebit->customer_bank_id = $directDebit->bank_id;
            $orderDirectDebit->customer_bank_number = $directDebit->bank_number;
            $orderDirectDebit->customer_short_bank_name = $directDebit->short_bank_name;
            $orderDirectDebit->customer_bank_name = $directDebit->bank_name;
            $orderDirectDebit->customer_branch_id = $directDebit->branch_id;
            $orderDirectDebit->customer_branch_number = $directDebit->branch_number;
            $orderDirectDebit->customer_branch_name = $directDebit->branch_name;
            $orderDirectDebit->customer_account_number = $directDebit->account_number;

            $orderDirectDebit->toat_bank_id = $receiptBank->bank_id;
            $orderDirectDebit->toat_bank_number = $receiptBank->bank_number;
            $orderDirectDebit->toat_short_bank_name = $receiptBank->short_bank_name;
            $orderDirectDebit->toat_bank_name = $receiptBank->bank_name;
            $orderDirectDebit->toat_branch_id = $receiptBank->branch_id;
            $orderDirectDebit->toat_branch_number = $receiptBank->branch_number;
            $orderDirectDebit->toat_branch_name = $receiptBank->branch_name;
            $orderDirectDebit->toat_account_number = $receiptBank->bank_account_number;
            $orderDirectDebit->toat_bank_account_name = $receiptBank->bank_account_name;

            $orderDirectDebit->direct_debit_amount = $ocd->amount;

            $orderDirectDebit->created_by = 1;
            $orderDirectDebit->last_updated_by = 1;
            $orderDirectDebit->program_code = 'OMP0072';

            $orderDirectDebit->save();
        }

    }

    public static function updateOrderDirectDebot($header)
    {

        $directDebit = DirectDebit::where('customer_id',$header->customer_id)->orderBy('direct_debit_id','DESC')->first();

        $customer_id = $header->customer_id;

        $orderCredit = OrderCreditGroup::where('order_header_id',$header->order_header_id)->where('order_line_id',0)->where('amount','!=',0)->get();

        $paymenyMetchod = PaymentMethodDomestic::where('lookup_code',$header->payment_method_code)->first();

        // ->where('branch_id',$directDebit->branch_id)

        $receiptBank = ReceiptBankAccV::where('mapping_om_type',$paymenyMetchod->meaning)->where('bank_id',$directDebit->bank_id)->where('class_name','ระบบขายในประเทศ')->first();

        $customersOrder = Customers::byCustomerId($customer_id);

        OrderDirectDebit::where('order_header_id',$header->order_header_id)->delete();

        foreach ($orderCredit as $key => $ocd) {

            $orderDirectDebit = new OrderDirectDebit();
            $orderDirectDebit->order_header_id = $header->order_header_id;
            $orderDirectDebit->direct_debit_id = $directDebit->direct_debit_id;
            $orderDirectDebit->credit_group_code = $ocd->credit_group_code;
            $orderDirectDebit->customer_id = $customersOrder->customer_id;
            $orderDirectDebit->customer_number = $customersOrder->customer_number;
            $orderDirectDebit->customer_name = $customersOrder->customer_name;
            $orderDirectDebit->customer_bank_id = $directDebit->bank_id;
            $orderDirectDebit->customer_bank_number = $directDebit->bank_number;
            $orderDirectDebit->customer_short_bank_name = $directDebit->short_bank_name;
            $orderDirectDebit->customer_bank_name = $directDebit->bank_name;
            $orderDirectDebit->customer_branch_id = $directDebit->branch_id;
            $orderDirectDebit->customer_branch_number = $directDebit->branch_number;
            $orderDirectDebit->customer_branch_name = $directDebit->branch_name;
            $orderDirectDebit->customer_account_number = $directDebit->account_number;

            $orderDirectDebit->toat_bank_id = $receiptBank->bank_id;
            $orderDirectDebit->toat_bank_number = $receiptBank->bank_number;
            $orderDirectDebit->toat_short_bank_name = $receiptBank->short_bank_name;
            $orderDirectDebit->toat_bank_name = $receiptBank->bank_name;
            $orderDirectDebit->toat_branch_id = $receiptBank->branch_id;
            $orderDirectDebit->toat_branch_number = $receiptBank->branch_number;
            $orderDirectDebit->toat_branch_name = $receiptBank->branch_name;
            $orderDirectDebit->toat_account_number = $receiptBank->bank_account_number;
            $orderDirectDebit->toat_bank_account_name = $receiptBank->bank_account_name;

            $orderDirectDebit->direct_debit_amount = $ocd->amount;

            $orderDirectDebit->created_by = 1;
            $orderDirectDebit->last_updated_by = 1;
            $orderDirectDebit->program_code = 'OMP0019';

            $orderDirectDebit->save();
        }

    }

    public static function createFileTranferTTBV2()
    {
        $ttbHeader = [
            [
                'type'=>'fixed',
                'name'=>'',
                'length'=>1,
                'value'=>'H'
            ],
            [
                'type'=>'fixed',
                'name'=>'',
                'length'=>6,
                'value'=>'000001'
            ],
            [
                'type'=>'fixed',
                'name'=>'',
                'length'=>3,
                'value'=>'046'
            ],
            [
                'type'=>'fixed',
                'name'=>'account_toat',
                'length'=>10,
                'value'=>'0462703364'
            ],
            [
                'type'=>'fixed',
                'name'=>'company_name',
                'length'=>28,
                'value'=>'THAILAND TOBACCO MONOPOLY'
            ],
            [
                'type'=>'created',
                'name'=>'post_date',
                'length'=>6,
                'value'=>''
            ],
            [
                'type'=>'fixed',
                'name'=>'post_type',
                'length'=>6,
                'value'=>''
            ],
            [
                'type'=>'fixed',
                'name'=>'flag',
                'length'=>71,
                'value'=>self::setSpaceTTB(71)
            ],
        ];

        return $ttbHeader;
    }

    public static function createFileTranferTTB()
    {
        $period = [
            [
                'start' => '09:31:00',
                'end'   => '11:30:00',
                'value' => '00001'
            ],
            [
                'start' => '11:31:00',
                'end'   => '13:30:00',
                'value' => '00005'
            ],
            [
                'start' => '13:31:00',
                'end'   => '15:30:00',
                'value' => '00002'
            ],
            [
                'start' => '15:31:00',
                'end'   => '17:30:00',
                'value' => '00003'
            ],
            [
                'start' => '17:31:00',
                'end'   => '09:30:00',
                'value' => '00004'
            ]
        ];

        $time = date('H:i:s');
        $dd_dc = '';

        foreach ($period as $key => $v) {
            if ($time >= $v['start'] && $time <= $v['end']) {
                $dd_dc = $v['value'];
            }
        }

        $ttbHeader = [
            [
                'type'=>'fixed',
                'name'=>'record_identifier',
                'length'=>3,
                'value'=>'TXN'
            ],
            [
                'type'=>'fixed',
                'name'=>'payer_name',
                'length'=>120,
                'value'=>self::setSpaceTTB(120)
            ],
            [
                'type'=>'created',
                'name'=>'beneficiary_name',
                'length'=>130,
                'value'=>''
            ],
            [
                'type'=>'fixed',
                'name'=>'mail_to_name',
                'length'=>40,
                'value'=>self::setSpaceTTB(40)
            ],
            [
                'type'=>'created',
                'name'=>'beneficiary_address_1',
                'length'=>40,
                'value'=>''
            ],
            [
                'type'=>'created',
                'name'=>'beneficiary_address_2',
                'length'=>40,
                'value'=>''
            ],
            [
                'type'=>'created',
                'name'=>'beneficiary_address_3',
                'length'=>40,
                'value'=>''
            ],
            [
                'type'=>'fixed',
                'name'=>'beneficiary_address_4',
                'length'=>40,
                'value'=>self::setSpaceTTB(40)
            ],
            [
                'type'=>'fixed',
                'name'=>'filler',
                'length'=>10,
                'value'=>self::setSpaceTTB(10)
            ],
            [
                'type'=>'created',
                'name'=>'customer_reference',
                'length'=>16,
                'value'=>''
            ],
            [
                'type'=>'created',
                'name'=>'effective_date',
                'length'=>8,
                'value'=>date('dmY')
            ],
            [
                'type'=>'fixed',
                'name'=>'pickup_date',
                'length'=>8,
                'value'=>self::setSpaceTTB(8)
            ],
            [
                'type'=>'created',
                'name'=>'payment_currency',
                'length'=>3,
                'value'=>''
            ],
            [
                'type'=>'fixed',
                'name'=>'comcode_business',
                'length'=>15,
                'value'=>self::setSpaceTTB(15)
            ],
            [
                'type'=>'fixed',
                'name'=>'run_date_identification',
                'length'=>15,
                'value'=>self::setSpaceTTB(15)
            ],
            [
                'type'=>'fixed',
                'name'=>'vendor_code_or_id',
                'length'=>20,
                'value'=>self::setSpaceTTB(20)
            ],
            [
                'type'=>'created',
                'name'=>'debit_account_number',
                'length'=>20,
                'value'=>''
            ],
            [
                'type'=>'created',
                'name'=>'payment_amount',
                'length'=>15,
                'value'=>''
            ],
            [
                'type'=>'created',
                'name'=>'beneficiary_bank_branch',
                'length'=>16,
                'value'=>''
            ],
            [
                'type'=>'created',
                'name'=>'beneficiary_account_number',
                'length'=>20,
                'value'=>''
            ],
            [
                'type'=>'fixed',
                'name'=>'transaction_code',
                'length'=>2,
                'value'=>self::setSpaceTTB(2)
            ],
            [
                'type'=>'fixed',
                'name'=>'objective_code',
                'length'=>2,
                'value'=>self::setSpaceTTB(2)
            ],
            [
                'type'=>'fixed',
                'name'=>'delivery_method',
                'length'=>2,
                'value'=>self::setSpaceTTB(2)
            ],
            [
                'type'=>'fixed',
                'name'=>'pickup_location',
                'length'=>20,
                'value'=>self::setSpaceTTB(20)
            ],
            [
                'type'=>'created',
                'name'=>'advise_mode',
                'length'=>5,
                'value'=> ''
            ],
            [
                'type'=>'created',
                'name'=>'beneficiary_fax_number',
                'length'=>50,
                'value'=> ''
            ],
            [
                'type'=>'created',
                'name'=>'beneficiary_email',
                'length'=>50,
                'value'=> ''
            ],
            [
                'type'=>'created',
                'name'=>'beneficiary_mobile',
                'length'=>50,
                'value'=> ''
            ],
            [
                'type'=>'created',
                'name'=>'charge_on_account',
                'length'=>13,
                'value'=> ''
            ],
            [
                'type'=>'created',
                'name'=>'transaction_type',
                'length'=>3,
                'value'=> 'DCR'
            ],
            [
                'type'=>'created',
                'name'=>'dd_dc',
                'length'=>5,
                'value'=> $dd_dc
            ],
            [
                'type'=>'created',
                'name'=>'comp_id',
                'length'=>4,
                'value'=> ''
            ],
            [
                'type'=>'fixed',
                'name'=>'mix',
                'length'=>1672,
                'value'=> self::setSpaceTTB(1672)
            ],
            [
                'type'=>'fixed',
                'name'=>'end',
                'length'=>3,
                'value'=> 'END'
            ]
        ];

        return $ttbHeader;
    }

    public static function createFileTranferKTBV2()
    {
        $ttbHeader = [
            [
                'type'=>'fixed',
                'name'=>'',
                'length'=>1,
                'value'=>'H'
            ],
            [
                'type'=>'fixed',
                'name'=>'',
                'length'=>6,
                'value'=>'000001'
            ],
            [
                'type'=>'fixed',
                'name'=>'',
                'length'=>3,
                'value'=>'006'
            ],
            [
                'type'=>'fixed',
                'name'=>'account_toat',
                'length'=>10,
                'value'=>'0091108322'
            ],
            [
                'type'=>'fixed',
                'name'=>'company_name',
                'length'=>28,
                'value'=>'THAILAND TOBACCO MONOPOLY'
            ],
            [
                'type'=>'created',
                'name'=>'post_date',
                'length'=>6,
                'value'=>''
            ],
            [
                'type'=>'fixed',
                'name'=>'post_type',
                'length'=>1,
                'value'=>' '
            ],
            [
                'type'=>'fixed',
                'name'=>'flag',
                'length'=>1,
                'value'=>0
            ],
            [
                'type'=>'created',
                'name'=>'filler',
                'length'=>75,
                'value'=>0
            ],
        ];

        return $ttbHeader;
    }

    public static function createFileTranferKTB()
    {
        $ktbHeader = [
            [
                'type'=>'fixed',
                'name'=>'file_type',
                'length'=>2,
                'value'=>'10'
            ],
            [
                'type'=>'fixed',
                'name'=>'record_type',
                'length'=>1,
                'value'=>'1'
            ],
            [
                'type'=>'created',
                'name'=>'batch_number',
                'length'=>6,
                'value'=>''
            ],
            [
                'type'=>'fixed',
                'name'=>'sending_bank_code',
                'length'=>3,
                'value'=>'006'
            ],
            [
                'type'=>'created',
                'name'=>'totol_transaction_in_batch',
                'length'=>7,
                'value'=>''
            ],
            [
                'type'=>'created',
                'name'=>'total_amount',
                'length'=>19,
                'value'=>''
            ],
            [
                'type'=>'created',
                'name'=>'effective_date',
                'length'=>8,
                'value'=>date('dmY')
            ],
            [
                'type'=>'fixed',
                'name'=>'transaction_code',
                'length'=>1,
                'value'=>'C'
            ],
            [
                'type'=>'fixed',
                'name'=>'receiver_no',
                'length'=>8,
                'value'=> self::setSpaceKTB(8)
            ],
            [
                'type'=>'fixed',
                'name'=>'company_id',
                'length'=>16,
                'value'=> self::setSpaceKTB(16)
            ],
            [
                'type'=>'fixed',
                'name'=>'user_id',
                'length'=>20,
                'value'=> self::setSpaceKTB(20)
            ],
            [
                'type'=>'fixed',
                'name'=>'fillers',
                'length'=>407,
                'value'=> self::setSpaceKTB(407)
            ],
            [
                'type'=>'fixed',
                'name'=>'carriage_return',
                'length'=>2,
                'value'=> self::setSpaceKTB(2)
            ],
        ];

        return $ktbHeader;
    }

    public static function createDetailFileTranferKTB()
    {
        $ktbDetail = [
            [
                'type'=>'fixed',
                'name'=>'file_type',
                'length'=>2,
                'value'=>'10'
            ],
            [
                'type'=>'fixed',
                'name'=>'seq_no',
                'length'=>1,
                'value'=>'2'
            ],
            [
                'type'=>'created',
                'name'=>'batch_no',
                'length'=>6,
                'value'=>''
            ],
            [
                'type'=>'created',
                'name'=>'receiving_bank',
                'length'=>3,
                'value'=>''
            ],
            [
                'type'=>'created',
                'name'=>'receiving_branch_code',
                'length'=>4,
                'value'=>''
            ],
            [
                'type'=>'created',
                'name'=>'receiving_ac',
                'length'=>11,
                'value'=>''
            ],
            [
                'type'=>'fixed',
                'name'=>'sending_bank_code',
                'length'=>3,
                'value'=>'006'
            ],
            [
                'type'=>'created',
                'name'=>'sending_branch_code',
                'length'=>4,
                'value'=>''
            ],
            [
                'type'=>'created',
                'name'=>'sending_ac',
                'length'=>11,
                'value'=>''
            ],
            [
                'type'=>'created',
                'name'=>'effective_date',
                'length'=>8,
                'value'=>date('dmY')
            ],
            [
                'type'=>'fixed',
                'name'=>'service_type',
                'length'=>2,
                'value'=>'14'
            ],
            [
                'type'=>'fixed',
                'name'=>'clearing_house_code',
                'length'=>2,
                'value'=> self::setSpaceKTB(2)
            ],
            [
                'type'=>'created',
                'name'=>'amount',
                'length'=>17,
                'value'=>''
            ],
            [
                'type'=>'fixed',
                'name'=>'receiver_info',
                'length'=>8,
                'value'=> self::setSpaceKTB(8)
            ],
            [
                'type'=>'fixed',
                'name'=>'receiver_id',
                'length'=>20,
                'value'=> self::setSpaceKTB(10)
            ],
            [
                'type'=>'created',
                'name'=>'receiver_name',
                'length'=>100,
                'value'=> ''
            ],
            [
                'type'=>'fixed',
                'name'=>'sender_name',
                'length'=>100,
                'value'=> 'การยาสูบแห่งประเทศไทย'
            ],
            [
                'type'=>'fixed',
                'name'=>'other_info_1',
                'length'=>40,
                'value'=> self::setSpaceKTB(40)
            ],
            [
                'type'=>'fixed',
                'name'=>'dda_ref_1',
                'length'=> 18,
                'value'=> self::setSpaceKTB(18)
            ],
            [
                'type'=>'fixed',
                'name'=>'reserve_field_1',
                'length'=>2,
                'value'=> self::setSpaceKTB(2)
            ],
            [
                'type'=>'fixed',
                'name'=>'ref_no_dda_ref_2',
                'length'=>18,
                'value'=> self::setSpaceKTB(18)
            ],
            [
                'type'=>'fixed',
                'name'=>'reserve_field_2',
                'length'=>2,
                'value'=> self::setSpaceKTB(2)
            ],
            [
                'type'=>'fixed',
                'name'=>'other_info_2',
                'length'=>20,
                'value'=> self::setSpaceKTB(20)
            ],
            [
                'type'=>'fixed',
                'name'=>'ref_running_number',
                'length'=>6,
                'value'=> self::setSpaceKTB(6)
            ],
            [
                'type'=>'fixed',
                'name'=>'status',
                'length'=>2,
                'value'=> '09'
            ],
            [
                'type'=>'fixed',
                'name'=>'email_address',
                'length'=>40,
                'value'=> self::setSpaceKTB(40)
            ],
            [
                'type'=>'fixed',
                'name'=>'sms_mobile',
                'length'=>20,
                'value'=> self::setSpaceKTB(20)
            ],
            [
                'type'=>'fixed',
                'name'=>'receiving_sub_branch_code',
                'length'=>4,
                'value'=> self::setSpaceKTB(4)
            ],
            [
                'type'=>'fixed',
                'name'=>'fillers',
                'length'=>36,
                'value'=> self::setSpaceKTB(36)
            ],
        ];

        return $ktbDetail;
    }

    // public static function createHeaderFileTranferSCBV2()
    // {
    //     $scbHeader = [
    //         [
    //             'type'=>'fixed',
    //             'name'=>'',
    //             'length'=>8,
    //             'value'=>self::setSpaceKTB(8)
    //         ],
    //         [
    //             'type'=>'fixed',
    //             'name'=>'',
    //             'length'=>1,
    //             'value'=>'M'
    //         ],
    //         [
    //             'type'=>'fixed',
    //             'name'=>'',
    //             'length'=>6,
    //             'value'=>'001001'
    //         ],
    //         [
    //             'type'=>'fixed',
    //             'name'=>'company_name',
    //             'length'=>30,
    //             'value'=>'THAILAND TOBACCO MONOPOLY'
    //         ],
    //         [
    //             'type'=>'fixed',
    //             'name'=>'',
    //             'length'=>1,
    //             'value'=>'S'
    //         ],
    //         [
    //             'type'=>'fixed',
    //             'name'=>'',
    //             'length'=>1,
    //             'value'=>'A'
    //         ],
    //         [
    //             'type'=>'created',
    //             'name'=>'',
    //             'length'=>6,
    //             'value'=>date('dmy')
    //         ],
    //         [
    //             'type'=>'created',
    //             'name'=>'',
    //             'length'=>5,
    //             'value'=>''
    //         ]
    //     ];

    //     return $scbHeader;
    // }

    public static function createHeaderFileTranferSCB()
    {
        $scbHeader = [
            [
                'type'=>'fixed',
                'name'=>'record_type',
                'length'=>3,
                'value'=>'001'
            ],
            [
                'type'=>'created',
                'name'=>'company_id',
                'length'=>12,
                'value'=>'ttmo797'
            ],
            [
                'type'=>'created',
                'name'=>'customer_ref',
                'length'=>32,
                'value'=>''
            ],
            [
                'type'=>'fixed',
                'name'=>'file_date',
                'length'=>8,
                'value'=>date('Ymd')
            ],
            [
                'type'=>'fixed',
                'name'=>'file_time',
                'length'=>6,
                'value'=>date('His')
            ],
            [
                'type'=>'fixed',
                'name'=>'channel_id',
                'length'=>3,
                'value'=>'BCM'
            ],
            [
                'type'=>'created',
                'name'=>'batch_ref',
                'length'=>32,
                'value'=>sprintf("%32s", ' ')
            ]
        ];

        return $scbHeader;
    }

    public static function createDebitDetailFileTranferSCB()
    {
        $scbDebitDetail = [
            [
                'type'=>'fixed',
                'name'=>'record_type',
                'length'=>3,
                'value'=>'002'
            ],
            [
                'type'=>'fixed',
                'name'=>'product_code',
                'length'=>3,
                'value'=>'DCP'
            ],
            [
                'type'=>'fixed',
                'name'=>'value_date',
                'length'=>8,
                'value'=>date('Ymd')
            ],
            [
                'type'=>'created',
                'name'=>'debit_account_no',
                'length'=>25,
                'value'=>''
            ],
            [
                'type'=>'created',
                'name'=>'account_type_of_debit',
                'length'=>2,
                'value'=>sprintf("%2s", ' ')
            ],
            [
                'type'=>'created',
                'name'=>'debit_branch_code',
                'length'=>4,
                'value'=>sprintf("%4s", ' ')
            ],
            [
                'type'=>'fixed',
                'name'=>'debit_currency',
                'length'=>3,
                'value'=>'THB'
            ],
            [
                'type'=>'created',
                'name'=>'debit_amount',
                'length'=>16,
                'value'=>''
            ],
            [
                'type'=>'created',
                'name'=>'internal_ref',
                'length'=>8,
                'value'=>'0000001'
            ],
            [
                'type'=>'created',
                'name'=>'no_of_credit',
                'length'=>6,
                'value'=>'000003'
            ],
            [
                'type'=>'created',
                'name'=>'fee_debit_account',
                'length'=>15,
                'value'=>''
            ],
            [
                'type'=>'created',
                'name'=>'filler',
                'length'=>9,
                'value'=>sprintf("%9s", ' ')
            ],
            [
                'type'=>'created',
                'name'=>'media_clearing',
                'length'=>1,
                'value'=>' '
            ],
            [
                'type'=>'created',
                'name'=>'account_type_fee',
                'length'=>2,
                'value'=>sprintf("%2s", ' ')
            ],
            [
                'type'=>'created',
                'name'=>'debit_branch_code_fee',
                'length'=>4,
                'value'=>sprintf("%4s", ' ')
            ]
        ];

        return $scbDebitDetail;
    }

    public static function createCreditDetailFileTranferSCB()
    {
        $scbDebitDetail = [
            [
                'type'=>'fixed',
                'name'=>'record_type',
                'length'=>3,
                'value'=>'003'
            ],
            [
                'type'=>'created',
                'name'=>'credit_sequence_number',
                'length'=>6,
                'value'=>'000001'
            ],
            [
                'type'=>'created',
                'name'=>'credit_account',
                'length'=>25,
                'value'=>''
            ],
            [
                'type'=>'created',
                'name'=>'credit_amount',
                'length'=>16,
                'value'=>''
            ],
            [
                'type'=>'fixed',
                'name'=>'credit_currency',
                'length'=>3,
                'value'=>'THB'
            ],
            [
                'type'=>'created',
                'name'=>'internal_reference',
                'length'=>8,
                'value'=>'0000001'
            ],
            [
                'type'=>'fixed',
                'name'=>'wht_present',
                'length'=>1,
                'value'=>'N'
            ],
            [
                'type'=>'fixed',
                'name'=>'invoice_details_present',
                'length'=>1,
                'value'=>'N'
            ],
            [
                'type'=>'fixed',
                'name'=>'credit_advice_required',
                'length'=>1,
                'value'=>'Y'
            ],
            [
                'type'=>'fixed',
                'name'=>'delivery_mode',
                'length'=>1,
                'value'=>'S'
            ],
            [
                'type'=>'created',
                'name'=>'pickup_location',
                'length'=>4,
                'value'=>sprintf("%4s", ' ')
            ],
            [
                'type'=>'fixed',
                'name'=>'wht_form_type',
                'length'=>2,
                'value'=>'00'
            ],
            [
                'type'=>'fixed',
                'name'=>'wht_tax_running_no',
                'length'=>14,
                'value'=>sprintf("%014d", ' ')
            ],
            [
                'type'=>'fixed',
                'name'=>'wht_attach_no',
                'length'=>6,
                'value'=>'0000000'
            ],
            [
                'type'=>'fixed',
                'name'=>'no_of_wht_details',
                'length'=>2,
                'value'=>'00'
            ],
            [
                'type'=>'fixed',
                'name'=>'total_wht_amount',
                'length'=>16,
                'value'=>sprintf("%016d", ' ')
            ],
            [
                'type'=>'fixed',
                'name'=>'no_of_invoice_details',
                'length'=>6,
                'value'=>sprintf("%06d", ' ')
            ],
            [
                'type'=>'fixed',
                'name'=>'total_invoice_amount',
                'length'=>16,
                'value'=>sprintf("%016d", ' ')
            ],
            [
                'type'=>'fixed',
                'name'=>'wht_pay_type',
                'length'=>1,
                'value'=>'0'
            ],
            [
                'type'=>'fixed',
                'name'=>'wht_remark',
                'length'=>40,
                'value'=>sprintf("%40s", ' ')
            ],
            [
                'type'=>'fixed',
                'name'=>'wht_deduct_date',
                'length'=>8,
                'value'=>sprintf("%8s", ' ')
            ],
            [
                'type'=>'fixed',
                'name'=>'receiving_bank_code',
                'length'=>3,
                'value'=>'014'
            ],
            [
                'type'=>'fixed',
                'name'=>'receiving_bank_name',
                'length'=>35,
                'value'=>sprintf("%35s", ' ')
            ],
            [
                'type'=>'fixed',
                'name'=>'receiving_branch_code',
                'length'=>4,
                'value'=>sprintf("%4s", ' ')
            ],
            [
                'type'=>'fixed',
                'name'=>'receiving_branch_name',
                'length'=>35,
                'value'=>sprintf("%35s", ' ')
            ],
            [
                'type'=>'fixed',
                'name'=>'wht_signatory',
                'length'=>1,
                'value'=>' '
            ],
            [
                'type'=>'fixed',
                'name'=>'beneficiary_notification',
                'length'=>1,
                'value'=>' '
            ],
            [
                'type'=>'fixed',
                'name'=>'customer_reference_number',
                'length'=>20,
                'value'=>sprintf("%20s", ' ')
            ],
            [
                'type'=>'fixed',
                'name'=>'Cheque Reference Document Type',
                'length'=>1,
                'value'=>' '
            ],
            [
                'type'=>'fixed',
                'name'=>'Payment Type Code',
                'length'=>3,
                'value'=>sprintf("%3s", ' ')
            ],
            [
                'type'=>'fixed',
                'name'=>'ServicesType',
                'length'=>2,
                'value'=>sprintf("%2s", ' ')
            ],
            [
                'type'=>'fixed',
                'name'=>'Remark',
                'length'=>50,
                'value'=>sprintf("%50s", ' ')
            ],
            [
                'type'=>'fixed',
                'name'=>'SCB Remark',
                'length'=>18,
                'value'=>sprintf("%18s", ' ')
            ],
            [
                'type'=>'fixed',
                'name'=>'Beneficiary Charge',
                'length'=>2,
                'value'=>sprintf("%2s", ' ')
            ]
        ];

        return $scbDebitDetail;
    }

    public static function createPayeeDetailFileTranferSCB()
    {
        $scbPayeeDetail = [
            [
                'type'=>'fixed',
                'name'=>'record_type',
                'length'=>1,
                'value'=>'004'
            ],
            [
                'type'=>'fixed',
                'name'=>'payee_detail',
                'length'=>813,
                'value'=>sprintf("%813s", ' ')
            ],
        ];

        return $scbPayeeDetail;
    }

    public static function createWHTDetailFileTranferSCB()
    {
        $scbPayeeDetail = [
            [
                'type'=>'fixed',
                'name'=>'wht_detail',
                'length'=>138,
                'value'=>sprintf("%138s", ' ')
            ],
        ];

        return $scbPayeeDetail;
    }
    
    public static function createTrailerDetailFileTranferSCB()
    {
        $scbTrailerDetail = [
            [
                'type'=>'fixed',
                'name'=>'record_type',
                'length'=>3,
                'value'=>'999'
            ],
            [
                'type'=>'created',
                'name'=>'total_no_of_debit',
                'length'=>6,
                'value'=>'000001'
            ],
            [
                'type'=>'created',
                'name'=>'total_no_of_credit',
                'length'=>6,
                'value'=>'000001'
            ],
            [
                'type'=>'created',
                'name'=>'total_amount',
                'length'=>16,
                'value'=>''
            ]
        ];

        return $scbTrailerDetail;
    }

    public static function setSpaceKTB($length,$value='0')
    {
        $spaceKTB = '';
        for ($i=0; $i < $length; $i++) {
            $spaceKTB .= $value;
        }

        return $spaceKTB;
    }

    public static function setSpaceTTB($length,$value=' ')
    {
        $spaceTTB = '';
        for ($i=0; $i < $length; $i++) {
            $spaceTTB .= $value;
        }

        return $spaceTTB;
    }

}