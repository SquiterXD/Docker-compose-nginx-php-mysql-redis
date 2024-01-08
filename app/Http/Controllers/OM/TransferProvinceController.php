<?php

namespace App\Http\Controllers\OM;

use App\Http\Controllers\Controller;
use App\Models\OM\Api\OrderHeader;
use App\Models\OM\PtomAllTaxRateV;
use App\Models\OM\TranspotReportModel;
use App\Models\OM\PtomVendorSitesV;
use App\Models\OM\CreditNote\MappingAccountModel;
use Carbon\Carbon;
use FormatDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\OM\SoOutstandingV;

use App\Repositories\OM\InterfaceRepo;

class TransferProvinceController extends Controller
{
    public function index()
    {
        $bankLists = PtomVendorSitesV::where('vendor_name', 'like', '%ธนาคาร%')->get();
        return view('om.transferprovince.index', compact('bankLists'));
    }

    public function calculate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'bank' => 'required',
        ], [
            'start_date.required' => 'กรุณาระบุวันที่เริ่มต้น',
            'start_date.date' => 'รูปแบบวันที่เริ่มต้นไม่ถูกต้อง',
            'end_date.required' => 'กรุณาระบุวันที่สิ้นสุด',
            'end_date.date' => 'รูปแบบวันที่สิ้นสุดไม่ถูกต้อง',
            'bank.required' => 'กรุณาระบุรหัสธนาคาร',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'data' => $validator->errors()->first(), 'number' => '']);
        }

        $start = Carbon::parse($request->start_date)->format('Y-m-d');
        $end = Carbon::parse($request->end_date)->format('Y-m-d');
        $bank = explode(' : ', $request->bank);

        if( count($bank) != 3 ){
            return response()->json(['status' => 'error', 'data' => 'ข้อมูลธนาคารไม่อยู่ในรูปแบบที่ถูกต้อง', 'number' => '']);
        }

        $vendor_num = $bank[0];
        $vendor_name = $bank[1];
        $vendor_site_code = $bank[2];

        $vendor = PtomVendorSitesV::where('vendor_name', 'like', '%ธนาคาร%')
                ->where('vendor_code', $vendor_num)
                ->where('vendor_name', $vendor_name)
                ->where('vendor_site_code', $vendor_site_code)
                ->first();

        $batch_no = $groupid = getGroupID();
        $budgetYear = self::getBudgetYear();
        $prefix = $budgetYear.date('m');
        $invoice_num = getInvoiceNumber($prefix);
        $creation_date = Carbon::now();
        $budgetYear = '00';
        $number = $this->insertData($batch_no, $groupid, $budgetYear, $invoice_num, $start, $end, $vendor, $creation_date);

        if ($number == 0) {
            return response()->json(['status' => 'error', 'data' => 'ไม่พบรายการที่ดำเนินการได้', 'number' => '']);
        }

        $result = InterfaceRepo::interfaceAP($batch_no);

        if(in_array($result['status'], ['C', 'S'])){

            $invoice_batch = optional(TranspotReportModel::where('web_batch_no', $batch_no)->where('interface_status', 'S')->first())->invoice_batch;
            return response()->json(['status' => 'success', 'data' => $invoice_batch, 'number' => $number]);
        }else{
            $msg = optional(optional(TranspotReportModel::where('web_batch_no', $batch_no)->where('interface_status', 'E')->first())->interface_msg ?? $result['message']) ?? 'Interface Error';

            return response()->json(['status' => 'error', 'data' => $msg, 'number' => '']);
        }
    }

    private function insertData($batch_no, $groupid, $budgetYear, $invoice_num, $start, $end, $vendor, $creation_date)
    {
        $case_1 = SoOutstandingV::selectRaw("
            ptom_customers.address_line1, 
            ptom_customers.alley, 
            ptom_customers.district, 
            ptom_customers.city,
            ptom_customers.postal_code,
            ptom_customers.customer_number,
            ptom_customers.region_code,
            (case when ptom_customers.region_code = 'ภาคกลาง' then
                1
            when ptom_customers.region_code = 'ภาคเหนือ' then
                2
            when ptom_customers.region_code = 'ภาคตะวันออกเฉียงเหนือ' then
                3
            when ptom_customers.region_code = 'ภาคใต้' then
                4
            else
                5
            end) as region_order,
            ptom_customers.customer_id,
            ptom_customers.customer_name,
            ptom_pao_percent_inv.tax_pao_percent,
            to_char(ptom_pao_percent_inv.province_code) province_code,
            to_char(ptom_pao_percent_inv.province_name) province_name, 
            ptom_so_outstanding_v.order_header_id,
            ptom_so_outstanding_v.item_code,
            ptom_so_outstanding_v.item_description,
            ptom_so_outstanding_v.approve_quantity,
            ptom_so_outstanding_v.approve_quantity as p_qty
        ")
        ->join('ptom_pao_percent_inv', 'ptom_so_outstanding_v.order_header_id', '=', 'ptom_pao_percent_inv.order_header_id')
        ->join('ptom_customers', 'ptom_so_outstanding_v.customer_id', '=', 'ptom_customers.customer_id')
        ->whereRaw("
            1=1
            and ptom_pao_percent_inv.province_name = ptom_customers.province_name
            and ptom_so_outstanding_v.customer_type_id != 20 
            and ptom_so_outstanding_v.province_code != 10 
            and ptom_so_outstanding_v.product_type_code = 10 
            and trunc(nvl(ptom_so_outstanding_v.consignment_date, ptom_so_outstanding_v.pick_release_approve_date)) 
            between to_date('$start', 'yyyy-mm-dd') and to_date('$end', 'yyyy-mm-dd')
            and approve_quantity <= 10
        ");

        $case_2 = SoOutstandingV::selectRaw("
            ptom_customers.address_line1, 
            ptom_customers.alley, 
            ptom_customers.district, 
            ptom_customers.city,
            ptom_customers.postal_code,
            ptom_customers.customer_number,
            ptom_customers.region_code,
            (case when ptom_customers.region_code = 'ภาคกลาง' then
                1
            when ptom_customers.region_code = 'ภาคเหนือ' then
                2
            when ptom_customers.region_code = 'ภาคตะวันออกเฉียงเหนือ' then
                3
            when ptom_customers.region_code = 'ภาคใต้' then
                4
            else
                5
            end) as region_order,
            ptom_customers.customer_id,
            ptom_customers.customer_name,
            ptom_pao_percent_inv.tax_pao_percent,
            to_char(ptom_pao_percent_inv.province_code) province_code,
            to_char(ptom_pao_percent_inv.province_name) province_name, 
            ptom_so_outstanding_v.order_header_id,
            ptom_so_outstanding_v.item_code,
            ptom_so_outstanding_v.item_description,
            ptom_so_outstanding_v.approve_quantity,
            round(ptom_so_outstanding_v.approve_quantity * ptom_pao_percent_inv.tax_pao_percent / 100, -1) as p_qty
        ")
        ->join('ptom_pao_percent_inv', 'ptom_so_outstanding_v.order_header_id', '=', 'ptom_pao_percent_inv.order_header_id')
        ->join('ptom_customers', 'ptom_so_outstanding_v.customer_id', '=', 'ptom_customers.customer_id')
        ->whereRaw("
            1=1
            and ptom_pao_percent_inv.province_name = ptom_customers.province_name
            and ptom_so_outstanding_v.customer_type_id != 20 
            and ptom_so_outstanding_v.province_code != 10 
            and ptom_so_outstanding_v.product_type_code = 10 
            and trunc(nvl(ptom_so_outstanding_v.consignment_date, ptom_so_outstanding_v.pick_release_approve_date)) 
            between to_date('$start', 'yyyy-mm-dd') and to_date('$end', 'yyyy-mm-dd')
            and approve_quantity > 10
        ");

        $case_3 = SoOutstandingV::selectRaw("
            ptom_customers.address_line1, 
            ptom_customers.alley, 
            ptom_customers.district, 
            ptom_customers.city,
            ptom_customers.postal_code,
            ptom_customers.customer_number,
            ptom_customers.region_code,
            (case when ptom_customers.region_code = 'ภาคกลาง' then
                1
            when ptom_customers.region_code = 'ภาคเหนือ' then
                2
            when ptom_customers.region_code = 'ภาคตะวันออกเฉียงเหนือ' then
                3
            when ptom_customers.region_code = 'ภาคใต้' then
                4
            else
                5
            end) as region_order,
            ptom_customers.customer_id,
            ptom_customers.customer_name,
            ptom_pao_percent_inv.tax_pao_percent,
            to_char(ptom_pao_percent_inv.province_code) province_code,
            to_char(ptom_pao_percent_inv.province_name) province_name, 
            ptom_so_outstanding_v.order_header_id,
            ptom_so_outstanding_v.item_code,
            ptom_so_outstanding_v.item_description,
            ptom_so_outstanding_v.approve_quantity,
            ptom_so_outstanding_v.approve_quantity - round(ptom_so_outstanding_v.approve_quantity * (100 - ptom_pao_percent_inv.tax_pao_percent) / 100, -1) as p_qty
        ")
        ->join('ptom_pao_percent_inv', 'ptom_so_outstanding_v.order_header_id', '=', 'ptom_pao_percent_inv.order_header_id')
        ->join('ptom_customers', 'ptom_so_outstanding_v.customer_id', '=', 'ptom_customers.customer_id')
        ->whereRaw("
            1=1
            and ptom_pao_percent_inv.province_name <> ptom_customers.province_name
            and ptom_so_outstanding_v.customer_type_id != 20 
            and ptom_so_outstanding_v.province_code != 10 
            and ptom_so_outstanding_v.product_type_code = 10 
            and trunc(nvl(ptom_so_outstanding_v.consignment_date, ptom_so_outstanding_v.pick_release_approve_date)) 
            between to_date('$start', 'yyyy-mm-dd') and to_date('$end', 'yyyy-mm-dd')
            and approve_quantity > 10
        ");

        $case_4 = SoOutstandingV::selectRaw("
            ptom_customers.address_line1, 
            ptom_customers.alley, 
            ptom_customers.district, 
            ptom_customers.city,
            ptom_customers.postal_code,
            ptom_customers.customer_number,
            ptom_customers.region_code,
            (case when ptom_customers.region_code = 'ภาคกลาง' then
                1
            when ptom_customers.region_code = 'ภาคเหนือ' then
                2
            when ptom_customers.region_code = 'ภาคตะวันออกเฉียงเหนือ' then
                3
            when ptom_customers.region_code = 'ภาคใต้' then
                4
            else
                5
            end) as region_order,
            ptom_customers.customer_id,
            ptom_customers.customer_name,
            100 as tax_pao_percent,
            to_char(ptom_so_outstanding_v.province_code) province_code,
            to_char(ptom_so_outstanding_v.province_name) province_name, 
            ptom_so_outstanding_v.order_header_id,
            ptom_so_outstanding_v.item_code,
            ptom_so_outstanding_v.item_description,
            ptom_so_outstanding_v.approve_quantity,
            ptom_so_outstanding_v.approve_quantity as p_qty
        ")
        ->join('ptom_customers', 'ptom_so_outstanding_v.customer_id', '=', 'ptom_customers.customer_id')
        ->whereRaw("
            1=1
            and ptom_so_outstanding_v.customer_type_id != 20 
            and ptom_so_outstanding_v.province_code != 10 
            and ptom_so_outstanding_v.product_type_code = 10 
            and trunc(nvl(ptom_so_outstanding_v.consignment_date, ptom_so_outstanding_v.pick_release_approve_date)) 
            between to_date('$start', 'yyyy-mm-dd') and to_date('$end', 'yyyy-mm-dd')
            and order_header_id not in (
                select distinct order_header_id  
                from ptom_pao_percent_inv 
            )
        ");

        $province_orders = $case_1->union($case_2)
            ->union($case_3)
            ->union($case_4)
            ->orderByRaw("region_order asc, province_name asc, customer_name asc")
            ->get();

        $province_qty = $province_orders->sum(function ($item) {
            return $item->p_qty;
        });

        // $club_qty = $club_orders->sum(function ($order) {
        //     return $order->getTotalActualQty();
        // });

        // $total_qty = $province_qty + $club_qty;
        $total_qty = $province_qty;

        $tax = PtomAllTaxRateV::whereDate('start_date_active', '<=', $start)
            ->where(function ($q) use ($end) {
                $q->whereDate('end_date_active', '>=', $end);
                $q->orWhereNull('end_date_active');
            })->first();

        $tax_rate = $tax->tag == null || $tax->tag == 0 ? 1 : $tax->tag;

        $grand_total = $total_qty * $tax_rate;

        $province_number =  $this->provinceInsert($province_orders, $batch_no, $groupid, $budgetYear, $invoice_num, $grand_total, $start, $end, $vendor, $tax_rate, $creation_date);
        // $club_number =  $this->clubInsert($club_orders, $batch_no, $groupid, $budgetYear, $invoice_num, $grand_total, $start, $end, $vendor, $tax_rate, $creation_date);
        // $number = $province_number + $club_number;
        $number = $province_number;

        return $number;
    }

    private function provinceInsert($orders, $batch_no, $groupid, $budgetYear, $invoice_num, $grand_total, $start, $end, $vendor, $tax, $creation_date)
    {
        $groupOrder = $orders->groupBy('order_header_id');
        $data = [];
        $number = 0;
        $exp_end = explode('-', $end);
        $account_code = 'TRX-DOM-AP Invoice-04';
        $account = MappingAccountModel::where('account_code', $account_code)->first();
        $combine = explode('.', $account->account_combine);
        $combine[4] = $budgetYear;
        $description = 'ค่าภาษีอบจ. ป.1 ประจำเดือน ' . FormatDate::Monthonly($end) .' '. ( (int)($exp_end[0]) + 543);

        $user_id = getDefaultData('/users')->user_id;
        $invoice_batch = $this->getInvoiceBatch($user_id);
        $batch_date = date('Y-M-d');
        $inv_date = Carbon::parse($end)->format('Y-M-d');
        $gl_date = Carbon::parse($end)->format('Y-M-d');

        foreach ($groupOrder as $order_id => $items) {

            $order = OrderHeader::find($order_id);

            $exist = TranspotReportModel::where('program_code', 'OMP0048')
                ->where('doc_ref_id', $order->order_header_id)
                ->where('interface_status', 'C')
                ->get();

            if( !$exist->count() ){

                $pao_tax_amount = $items->sum(function ($item) {
                    return $item->p_qty;
                }) * $tax;

                TranspotReportModel::create([
                    'group_id' => $groupid,
                    'interface_module' => 'AP',
                    'from_program_code' => 'OMP0048',
                    'interface_name' => 'ค่าภาษีอบจ. ป.1',
                    'invoice_batch' => $invoice_batch,
                    'batch_date' => $batch_date,
                    'invoice_source' => 'SALE',
                    'org_id' => $vendor->operating_unit,
                    'operating_unit' => $vendor->organization_code,
                    'invoice_type' => 'STANDARD',
                    'document_category' => 'SALE',
                    'vendor_id' => $vendor->vendor_id,
                    'vendor_num' => $vendor->vendor_code,
                    'vendor_name' => $vendor->vendor_name,
                    'vendor_site_id'=> $vendor->vendor_site_id,
                    'vendor_site_code' => $vendor->vendor_site_code,
                    'vendor_site_name' => $vendor->vendor_site_code,
                    'invoice_date' => $inv_date,
                    'gl_date' => $gl_date,
                    'invoice_number' => $invoice_num,
                    'invoice_currency' => $order->currency,
                    'invoice_amount_included_vat' => $grand_total,
                    'header_description' => $description,
                    'line_number' => 1,
                    'line_type' => 'ITEM',
                    'line_description' => $description,
                    'line_amount_excluded_vat' => $grand_total, 
                    'expense_account_id' => $account->account_id,
                    'expense_account_code' => $account_code,
                    'exp_segment1' => $combine[0],
                    'exp_segment2' => $combine[1],
                    'exp_segment3' => $combine[2],
                    'exp_segment4' => $combine[3],
                    'exp_segment5' => $combine[4],
                    'exp_segment6' => $combine[5],
                    'exp_segment7' => $combine[6],
                    'exp_segment8' => $combine[7],
                    'exp_segment9' => $combine[8],
                    'exp_segment10' => $combine[9],
                    'exp_segment11' => $combine[10],
                    'exp_segment12' => $combine[11],
                    'exp_account_combine' => implode('.', $combine),
                    'doc_ref_id' => $order->order_header_id,
                    'doc_ref_code' => $order->pick_release_no,
                    'doc_ref_date' => $order->delivery_date,
                    'doc_ref_status' => $order->pick_release_status,
                    'customer_id' => $order->customer_id,
                    'pao_tax_amount' => $pao_tax_amount,
                    'program_code' => 'OMP0048',
                    'created_by' => $user_id,
                    'last_updated_by' => $user_id,
                    'creation_date' => $creation_date,
                    'last_update_date' => $creation_date,
                    'web_batch_no' => $batch_no,
                ]);

                $number++;
            }
        }

        return $number;
    }

    private function clubInsert($orders, $batch_no, $groupid, $budgetYear, $invoice_num, $grand_total, $start, $end, $vendor, $tax, $creation_date)
    {
        $data = [];
        $number = 0;
        $exp_end = explode('-', $end);
        $account_code = 'TRX-DOM-AP Invoice-04';
        $account = MappingAccountModel::where('account_code', $account_code)->first();
        $combine = explode('.', $account->account_combine);
        $combine[4] = $budgetYear;
        $description = 'ค่าภาษีอบจ. ป.1 ประจำเดือน ' . FormatDate::Monthonly($end) .' '. ( (int)($exp_end[0]) + 543);

        foreach ($orders as $order) {

            $consignments = $order->consignments()
                ->whereBetween('consignment_date', [$start, $end])
                ->confirm()->get();

            foreach ($consignments as $consignment) {
                $exist = TranspotReportModel::where('program_code', 'OMP0048')
                ->where('doc_ref_id', $order->order_header_id)
                ->where('consignment_headers_id', $consignment->consignment_header_id)
                ->where('interface_status', 'C')
                ->get();

                if( !$exist->count() ){
                    TranspotReportModel::create([
                        'group_id' => $groupid,
                        'interface_module' => 'AP',
                        'from_program_code' => 'OMP0048',
                        'interface_name' => 'ค่าภาษีอบจ. ป.1',
                        'invoice_batch' => 'ระบบงานขาย/AP3/' . strtoupper(date('d-M-Y')) . '/ค่าภาษีอบจ.ป.1',// getDefaultData('/users')->user_id . '/AP3/' . strtoupper(date('d-M-Y')) . '/ค่าภาษีอบจ.ป.1',
                        'batch_date' => date('Y-M-d'),
                        'invoice_source' => 'SALE',
                        'org_id' => $vendor->operating_unit,
                        'operating_unit' => $vendor->organization_code,
                        'invoice_type' => 'STANDARD',
                        'document_category' => 'SALE',
                        'vendor_id' => $vendor->vendor_id,
                        'vendor_num' => $vendor->vendor_code,
                        'vendor_name' => $vendor->vendor_name,
                        'vendor_site_id'=> $vendor->vendor_site_id,
                        'vendor_site_code' => $vendor->vendor_site_code,
                        'vendor_site_name' => $vendor->vendor_site_code,
                        'invoice_date' => date('Y-M-d'),
                        'gl_date' => date('Y-M-d'),
                        'invoice_number' => $invoice_num,
                        'invoice_currency' => $order->currency,
                        'invoice_amount_included_vat' => $grand_total,
                        'expense_account_id' => $account->account_id,
                        'expense_account_code' => $account_code,
                        'exp_segment1' => $combine[0],
                        'exp_segment2' => $combine[1],
                        'exp_segment3' => $combine[2],
                        'exp_segment4' => $combine[3],
                        'exp_segment5' => $combine[4],
                        'exp_segment6' => $combine[5],
                        'exp_segment7' => $combine[6],
                        'exp_segment8' => $combine[7],
                        'exp_segment9' => $combine[8],
                        'exp_segment10' => $combine[9],
                        'exp_segment11' => $combine[10],
                        'exp_segment12' => $combine[11],
                        'exp_account_combine' => implode('.', $combine),
                        'header_description' => $description,
                        'line_number' => 1,
                        'line_type' => 'ITEM',
                        'line_description' => $description,
                        'line_amount_excluded_vat' => $grand_total, 
                        'consignment_headers_id' => $consignment->consignment_header_id,
                        'doc_ref_id' => $order->order_header_id,
                        'doc_ref_code' => $consignment->consignment_no,
                        'doc_ref_date' => $consignment->consignment_date,
                        'doc_ref_status' => $consignment->consignment_status,
                        'customer_id' => $order->customer_id,
                        'pao_tax_amount' => $consignment->getTotalActualQty() * $tax,
                        'program_code' => 'OMP0048',
                        'created_by' => getDefaultData('/users')->user_id,
                        'last_updated_by' => getDefaultData('/users')->user_id,
                        'creation_date' => $creation_date,
                        'last_update_date' => $creation_date,
                        'web_batch_no' => $batch_no,
                    ]);

                    $number++;
                }
            }
        }

        return $number;
    }

    private static function getBudgetYear()
    {
        $currentYear = date('Y');
        $cycle = date('Y-m-d', strtotime($currentYear.'-9-30'));
        $now = date('Y-m-d');
        $offset = $now > $cycle ? 44 : 43;
        $year = substr( (int)date('y') + $offset , -2);

        return $year;
    }

    private static function getInvoiceBatch($user_id)
    {
        $batch =  'ระบบงานขาย/AP3/' . strtoupper(date('d-M-Y')) . '/ค่าภาษีอบจ.ป.1'; // $user_id . '/AP3/' . strtoupper(date('d-M-Y')) . '/ค่าภาษีอบจ.ป.1';
        
        $exist = TranspotReportModel::where('program_code', 'OMP0048')
        ->where('invoice_batch', 'like', '%'.$batch.'%')
        ->whereIn('interface_status', ['F', 'C'])
        ->latest()
        ->first();

        if($exist){
            $old_batch = $exist->invoice_batch;
            $str = explode("/", $old_batch);
            if(count($str) == 4){
                $batch = $batch.'/1';
            }else{
                $batch = $batch.'/'.((int)$str[4]+1);
            }
        }

        return $batch;
    }
}
