<?php

namespace App\Http\Controllers\OM;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\OM\AttachmentRepo;
use App\Exports\OM\PaoTaxMtExport;
use App\Imports\OM\PaoTaxMtImport;
use App\Models\OM\PtomCustomer;
use App\Models\OM\PtomPaoTaxMt;
use App\Models\OM\PrepareSaleOrder\ThailandTerritoryModel;
use App\Models\OM\Promotions\Oaom\Itemv;
use App\Models\OM\PtomAllTaxRateV;
use App\Models\OM\TranspotReportModel;
use App\Models\OM\PtomVendorSitesV;
use App\Models\OM\CreditNote\MappingAccountModel;
use App\Repositories\OM\InterfaceRepo;
use App\Models\OM\GLInterfaceModel;
use App\Models\OM\SequenceEcoms;

class PaoTaxMtController extends Controller
{

    public function index(Request $request)
    {
   
        $customerLists = PtomCustomer::whereNotNull('customer_number')
            ->whereIn('customer_type_id', ['20'])
            ->where('sales_classification_code', 'Domestic')
            ->where('status', 'Active')
            ->orderBy('customer_number')->get();
        $bankLists = PtomVendorSitesV::where('vendor_name', 'like', '%ธนาคาร%')->get();
        $default = PtomVendorSitesV::where('vendor_code', '0107537000882')->where('vendor_site_id', '5649')->first();
        $defaultBank = $default->vendor_code.' : '.$default->vendor_name.' : '.$default->vendor_site_code;

        return view('om.pao_tax_mt.index',
                compact(
                    'customerLists',
                    'bankLists',
                    'defaultBank'
                ));
    }

    public function delete(Request $request) {
        $validated = $request->validate([
            'customer_number' => 'required',
            'year' => 'required',
            'month' =>'required'
        ]);
        $year = self::composeYear($request->year);
        $monthNo = $request->month;
        $customerNo = $request->customer_number;
        
        $t = PtomPaoTaxMt::where('year', $year)
            ->where('month_no', $monthNo)
            ->where('customer_number', $customerNo)
            ->delete();

        return ['status' => true];
    }

    public function search(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required'
        ]);

        $year = self::composeYear($request->year);
        $monthNo = $request->month;
        $customerNo = $request->customer_number;

        $result = PtomPaoTaxMt::with('customer', 'province', 'item', 'uomV')
                ->where('year', $year)
                ->when($monthNo, function ($q, $monthNo){
                    return $q->where('month_no', $monthNo);
                })
                ->when($customerNo, function ($q, $customerNo){
                    return $q->where('customer_number', $customerNo);
                })
                ->get();

        $data = [
            'status' => 'S',
            'result' => $result,
        ];

        return response()->json($data);
    }

    public function validateData(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required',
            'month' => 'required',
            'file' => 'required',
        ]);

        $requestYear = self::composeYear($request->year);
        $requestMonth = $request->month;
        $requestCustomerNo = $request->customer_number;

        $msg = '';
        $canInsert = [];
        $errors = [];
        $status = 'S';
        $collection = Excel::toCollection(new PaoTaxMtImport, $request->file);

        foreach ($collection as $sheet => $rows) {

            foreach ($rows as $row_num => $row) {

                if( count($row) >= 8 ){

                    $year = self::composeYear($row[0]);
                    $monthNo = self::composeMonthNo($row[1]);
                    if($monthNo === 0) {
                        $status = 'E';
                        $msg = 'กรุณาตรวจสอบ Columns เดือนให้ถูกต้อง แล้วลองใหม่อีกครั้ง';
                        break;
                    }
                    $customer = PtomCustomer::where('customer_number', $row[2])->first();
                    $province = ThailandTerritoryModel::where('province_thai', $row[4])->first();
                    $item = Itemv::where('item_code', $row[5])->first();

                    $has_interfaces = PtomPaoTaxMt::where('year', $year)
                    ->where(function($q){
                        return $q->whereHas('interfaces', function($q){
                            return $q->whereIn('interface_status', ['C', 'S']);
                        })
                        ->orwhereHas('glinterfaces', function($q){
                            return $q->whereIn('interface_status', ['C', 'S']);
                        });
                    })
                    ->when($monthNo, function ($q, $monthNo){
                        return $q->where('month_no', $monthNo);
                    })
                    ->when($customer, function ($q, $customer){
                        return $q->where('customer_number', $customer->customer_number);
                    })
                    ->get();

                    $found = PtomPaoTaxMt::where('year', $year)
                    ->when($monthNo, function ($q, $monthNo){
                        return $q->where('month_no', $monthNo);
                    })
                    ->when($customer, function ($q, $customer){
                        return $q->where('customer_number', $customer->customer_number);
                    })
                    ->get();

                    if( $year != $requestYear ){
                        $status = 'W';
                        $errors['input_year'][$row[0]] = 'มีข้อมูลปี'.$row[0].' ไม่ตรงกับปีที่ต้องการนำเข้าระบบ';
                    }

                    if( $monthNo != $requestMonth ){
                        $status = 'W';
                        $errors['input_month'][$row[1]] = 'มีข้อมูลเดือน'.$row[1].' ไม่ตรงกับเดือนที่ต้องการนำเข้าระบบ';
                    }

                    if( $row[2] != $requestCustomerNo && $requestCustomerNo != null ){
                        $status = 'W';
                        $errors['input_customer'][$row[2]] = 'มีข้อมูลรหัสร้านค้า'.$row[2].' ไม่ตรงกับรหัสร้านค้าที่ต้องการนำเข้าระบบ';
                    }

                    if( !$customer ){
                        $status = 'W';
                        $errors['customer_not_found'][$row[2]] = 'ไม่พบรหัสร้านค้า'.$row[2].'ในระบบ';
                    }else {
                        if( in_array($customer->status, ['Inactive']) ){
                            $status = 'E';
                            $msg = 'ร้านค้านี้ยกเลิกไปแล้วไม่สามารถ Upload ได้';
                            break;
                        }
                    }

                    if( !$province ){
                        $status = 'W';
                        $errors['province_not_found'][$row[4]] = 'ไม่พบจังหวัด'.$row[4].'ในระบบ';
                    }

                    if( !$item ){
                        $status = 'W';
                        $errors['item_not_found'][$row[5]] = 'ไม่พบรหัสสินค้า'.$row[5].'ในระบบ';
                    }

                    if( $has_interfaces->count()) {
                        $status = 'W';
                        $errors['already_interface'][$row[0].'-'.$monthNo.'-'.$row[2]] = 'มีการ Interface ข้อมูลของรหัสร้านค้า'.$row[2].' ของปี'.$row[0].'ประจำเดือน'.$row[1].' แล้ว';
                        $canInsert[] = $row_num;
                    }else {
                        if($found->count()){
                            $status = 'W';
                            $errors['already_exist'][$row[0].'-'.$monthNo.'-'.$row[2]] = 'มีการ Upload ข้อมูลของรหัสร้านค้า'.$row[2].' ของปี'.$row[0].'ประจำเดือน'.$row[1].' แล้ว';
                        }
                        $canInsert[] = $row_num;
                    }

                }else {

                    $status = 'W';
                    $errors['data_not_complete']['data_not_complete'] = 'มีข้อมูลที่จะนำเข้าระบุข้อมูลไม่ครบ';
                }
            }
        }

        if(!count($canInsert) && $status != 'E'){
            $status = 'E';
            $msg = 'ข้อมูลชุดนี้ไม่สามารถนำเข้าข้อมูลได้';
        }

        $data = [
            'status' => $status,
            'errors' => $errors,
            'msg' => $msg,
        ];

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required',
            'month' => 'required',
            'file' => 'required',
        ]);

        \DB::beginTransaction();
        try {

            $data = [];
            $checkCustomer = [];
            $requestYear = self::composeYear($request->year);
            $requestMonth = $request->month;
            $requestCustomerNo = $request->customer_number;

            $remove_already_exist = PtomPaoTaxMt::where('year', $requestYear)
            ->when($requestMonth, function ($q, $requestMonth){
                return $q->where('month_no', $requestMonth);
            })
            ->when($requestCustomerNo, function ($q, $requestCustomerNo){
                return $q->where('customer_number', $requestCustomerNo);
            })
            ->delete();

            $collection = Excel::toCollection(new PaoTaxMtImport, $request->file);
            $file = $request->file;
            $file_name = $file->getClientOriginalName();
            $taxRate = PtomAllTaxRateV::where('meaning', 'อัตราภาษีอบจ.')->first();
            $multiply = (float)$taxRate->tag/1000;

            foreach ($collection as $sheet => $rows) {
                // $groupPV = $rows->groupBy(function ($item, $key) {
                //     return $item['4'];
                // });

                // $amountByPV = []; 
                // foreach ($groupPV as $groupName => $itemPvs) {
                //     foreach ($itemPvs as $index => $itemPv) {
                //         if( array_key_exists($groupName, $amountByPV) ){
                //             $amountByPV[$groupName] += $itemPv['7'];
                //         }else {
                //             $amountByPV[$groupName] = $itemPv['7'];
                //         }
                //     }
                // }

                foreach ($rows as $row_num => $row) {

                    if( count($row) >= 8 ){

                        $year = self::composeYear($row[0]);
                        $monthNo = self::composeMonthNo($row[1]);
                        $customer = PtomCustomer::where('customer_number', $row[2])->first();
                        $province = ThailandTerritoryModel::where('province_thai', $row[4])->first();
                        $item = Itemv::where('item_code', $row[5])->first();

                        if( $year && $monthNo && $province && $customer && $item ){
                            if($year == $requestYear && $monthNo == $requestMonth && ( $requestCustomerNo ? $customer->customer_number == $requestCustomerNo : true )){

                                $hasInterface = null;
                                if( !in_array($customer->customer_number, $checkCustomer) ){

                                    $hasInterface = PtomPaoTaxMt::where('year', $year)
                                    ->when($monthNo, function ($q, $monthNo){
                                        return $q->where('month_no', $monthNo);
                                    })
                                    ->when($customer, function ($q, $customer){
                                        return $q->where('customer_number', $customer->customer_number);
                                    })
                                    ->whereNotNull('ap_web_batch_no')
                                    ->count();

                                    if( !$hasInterface ){
                                        PtomPaoTaxMt::where('year', $year)
                                        ->when($monthNo, function ($q, $monthNo){
                                            return $q->where('month_no', $monthNo);
                                        })
                                        ->when($customer, function ($q, $customer){
                                            return $q->where('customer_number', $customer->customer_number);
                                        })->delete();
                                    }

                                    $checkCustomer[] = $customer->customer_number;
                                }else {

                                    $hasInterface = PtomPaoTaxMt::where('year', $year)
                                        ->when($monthNo, function ($q, $monthNo){
                                            return $q->where('month_no', $monthNo);
                                        })
                                        ->when($customer, function ($q, $customer){
                                            return $q->where('customer_number', $customer->customer_number);
                                        })
                                        ->whereNotNull('ap_web_batch_no')
                                        ->count();
                                }

                                if( !$hasInterface ){
                                    $paoTax = new PtomPaoTaxMt;
                                    $paoTax->year               = $year;
                                    $paoTax->month_no           = $monthNo;
                                    $paoTax->file_name          = $file_name;
                                    $paoTax->path_name          = 'none';
                                    $paoTax->customer_id        = $customer->customer_id;
                                    $paoTax->customer_number    = $row[2];
                                    $paoTax->province_id        = $province->province_id;
                                    $paoTax->province_name      = $row[4];
                                    $paoTax->item_id            = $item->inventory_item_id;
                                    $paoTax->uom_code           = 'CG';
                                    $paoTax->item_code          = $row[5];
                                    $paoTax->quantity_cg        = $row[7];
                                    // $paoTax->pao_amount_by_pv   = (float)($amountByPV[$row[4]] * $multiply);
                                    $paoTax->pao_amount         = (float)($row[7] * $multiply);
                                    $paoTax->adjust_amount      = (float)($row[7] * $multiply);
                                    $paoTax->dif_amount         = 0;
                                    $paoTax->program_code       = 'OMP0089';
                                    $paoTax->created_by         = \Auth::user()->user_id;
                                    $paoTax->last_updated_by    = \Auth::user()->user_id;
                                    $paoTax->created_by_id      = \Auth::user()->user_id;
                                    $paoTax->updated_by_id      = \Auth::user()->user_id;
                                    $paoTax->save();
                                }
                            }
                        }
                    }
                }
            }

            \DB::commit();

            $data = [
                'status' => 'S',
                'msg' => 'SUCCESS'
            ];
        }
        catch (\Exception $e) {
            \DB::rollBack();
            \Log::error($e->getMessage());
        }

        return response()->json($data);
    }

    public function update(Request $request)
    {
        
        \DB::beginTransaction();
        try {

            $lists = $request->adjust_lists;
            foreach ($lists as $id => $amt) {
                $paoTax = PtomPaoTaxMt::find($id);
                $paoTax->adjust_amount = (float)$amt;
                $paoTax->dif_amount =  (float)$paoTax->pao_amount - (float)$amt;
                $paoTax->save();
            }

            \DB::commit();

            $data = [
                'status' => 'S',
                'msg' => 'SUCCESS'
            ];
        }
        catch (\Exception $e) {
            \DB::rollBack();
            \Log::error($e->getMessage());
        }

        return response()->json($data);
    }

    public function remove(Request $request)
    {
        \DB::beginTransaction();
        try {

            $id = $request->pao_tax_id;
            $paoTax = PtomPaoTaxMt::find($id);
            $paoTax->delete();

            \DB::commit();

            $data = [
                'status' => 'S',
                'msg' => 'SUCCESS'
            ];
        }
        catch (\Exception $e) {
            \DB::rollBack();
            \Log::error($e->getMessage());
        }

        return response()->json($data);
    }

    public function exReport(Request $request)
    {
        $year = $request->year ? self::composeYear($request->year) : date('Y');
        $monthNo = $request->month;
        $customerNo = $request->customer_number;

        $customer = PtomCustomer::whereNotNull('customer_number')->where('customer_number', $customerNo)->first() ?? PtomCustomer::whereNotNull('customer_number')->first();

        $result = PtomPaoTaxMt::with('customer', 'province', 'item')
                ->where('year', $year)
                ->when($monthNo, function ($q, $monthNo){
                    return $q->where('month_no', $monthNo);
                })
                ->when($customerNo, function ($q, $customerNo){
                    return $q->where('customer_number', $customerNo);
                })
                ->get();

        $defaultItems = \DB::select("
            select item_code, report_item_display 
            from ptom_sequence_ecoms
            where sale_type_code = 'DOMESTIC'
            and product_type_code = '10'
            order by screen_number 
        ");

        return Excel::download(new PaoTaxMtExport($year, $monthNo, $customer, $result, $defaultItems), 'example.xlsx');
    }

    public function interface(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required',
            'month' => 'required',
            'bank' => 'required',
        ]);

        \DB::beginTransaction();
        try {

            $data = [];
            $year = self::composeYear($request->year);
            $monthNo = $request->month;
            $customerNo = $request->customer_number;
            $bank = explode(' : ', $request->bank);

            if( count($bank) != 3 ){
                $data = [
                    'status' => 'E',
                    'msg' => 'ข้อมูลธนาคารไม่อยู่ในรูปแบบที่ถูกต้อง',
                ];
                return response()->json($data);
            }else {

                $vendor_num = $bank[0];
                $vendor_name = $bank[1];
                $vendor_site_code = $bank[2];

                $vendor = PtomVendorSitesV::where('vendor_name', 'like', '%ธนาคาร%')
                        ->where('vendor_code', $vendor_num)
                        ->where('vendor_name', $vendor_name)
                        ->where('vendor_site_code', $vendor_site_code)
                        ->first();

                $unit_id = $vendor->operating_unit; // 81
                $operating_unit = $vendor->organization_code; // 'การยาสูบแห่งประเทศไทย';

            }

            $carbon_last_date = Carbon::parse($year.'-'.$monthNo.'-01')->endOfMonth();
            $carbon_now = Carbon::now();

            $program_code = 'OMP0089';
            $group_id = getGroupID();
            $budgetYear = self::getBudgetYear();
            $prefix = $budgetYear.date('m');
            $invoiceNum = getInvoiceNumber($prefix);
            $user_id = getDefaultData('/users')->user_id;

            $batch_no = null;
            
            $account_code = 'TRX-DOM-AP Invoice-04';
            $account = MappingAccountModel::where('account_code', $account_code)->first();
            $combine = explode('.', $account->account_combine);
            $combine[4] = empty($combine[4]) ? '00' : $combine[4]; // $budgetYear;
            $interface_name = 'ค่าภาษีอบจ. ม.1';
            $description = $interface_name.' ประจำเดือน '.monthFormatThaiString($monthNo).' '.($request->year);
            $invoice_batch = $this->getInvoiceBatch($user_id, $carbon_now);

            $find = PtomPaoTaxMt::with('customer', 'province', 'item')
                ->where('year', $year)
                ->when($monthNo, function ($q, $monthNo){
                    return $q->where('month_no', $monthNo);
                })
                ->when($customerNo, function ($q, $customerNo){
                    return $q->where('customer_number', $customerNo);
                })
                ->where(function($q){
                    return $q->whereNull('ap_interface_status')
                    ->orWhere('ap_interface_status', '!=', 'S');
                })
                ->get();

            if( !!$find->count() ){
                $batch_no = $group_id;
                $sum_amount = $find->sum('adjust_amount');

                ///// INSERT DATA /////
                $interface = new TranspotReportModel;
                $interface->group_id                    = $group_id;
                $interface->interface_module            = 'AP';
                $interface->from_program_code           = $program_code;
                $interface->interface_name              = $interface_name;
                
                $interface->invoice_batch               = $invoice_batch; // getDefaultData('/users')->user_id . '/AP3/' . strtoupper(date('d-M-Y')) . '/ค่าภาษี อบจ. ม.1';
                $interface->batch_date                  = $carbon_last_date->format('Y-M-d');
                $interface->invoice_source              = 'SALE';
                $interface->org_id                      = $unit_id; /// 81
                $interface->operating_unit              = $operating_unit; /// การยาสูบแห่งประเทศไทย
                $interface->invoice_type                = 'STANDARD';
                $interface->document_category           = 'SALE';

                $interface->vendor_id                   = $vendor->vendor_id;
                $interface->vendor_num                  = $vendor_num;
                $interface->vendor_name                 = $vendor_name;
                $interface->vendor_site_id              = $vendor->vendor_site_id;
                $interface->vendor_site_code            = $vendor_site_code;
                $interface->vendor_site_name            = $vendor_site_code;

                $interface->invoice_date                = $carbon_last_date->format('Y-M-d');
                $interface->gl_date                     = $carbon_last_date->format('Y-M-d');

                $interface->expense_account_id          = $account->account_id;
                $interface->expense_account_code        = $account_code;

                $interface->exp_segment1                = $combine[0];
                $interface->exp_segment2                = $combine[1];
                $interface->exp_segment3                = $combine[2];
                $interface->exp_segment4                = $combine[3];
                $interface->exp_segment5                = $combine[4];
                $interface->exp_segment6                = $combine[5];
                $interface->exp_segment7                = $combine[6];
                $interface->exp_segment8                = $combine[7];
                $interface->exp_segment9                = $combine[8];
                $interface->exp_segment10               = $combine[9];
                $interface->exp_segment11               = $combine[10];
                $interface->exp_segment12               = $combine[11];
                $interface->exp_account_combine         = implode('.', $combine);

                $interface->invoice_amount_included_vat = $sum_amount;
                $interface->line_amount_excluded_vat    = $sum_amount;
                $interface->invoice_currency            = 'THB';
                $interface->invoice_number              = $invoiceNum;
                $interface->header_description          = $description;
                $interface->line_description            = $description;
                $interface->line_number                 = 1;
                $interface->line_type                   = 'ITEM';
                $interface->program_code                = $program_code;
                $interface->created_by                  = $user_id;
                $interface->last_updated_by             = $user_id;
                $interface->web_batch_no                = $batch_no;
                $interface->save();

                //// UPDATE INVOICE BATCH //// 
                foreach ($find as $key => $item) {
                    $item->ap_web_batch_no = $batch_no;
                    $item->save();
                }
            }
            
            \DB::commit();

            if($batch_no){
                $result = InterfaceRepo::interfaceAP($batch_no);
                if(in_array($result['status'], ['C', 'S'])){
                    $data = [
                        'group_id' => $group_id,
                        'status' => 'S',
                        'msg' => 'SUCCESS'
                    ];
                    //// UPDATE INTERFACE STATUS //// 
                    foreach ($find as $key => $item) {
                        $item->ap_interface_status = 'S';
                        $item->save();
                    }
                }else{
                    $data = [
                        'status' => 'E',
                        'msg' => optional(TranspotReportModel::where('web_batch_no', $batch_no)->where('interface_status', 'E')->first())->interfaced_msg ?? $result['message']
                    ];
                }
            }else {
                $data = [
                    'status' => 'E',
                    'msg' => 'ไม่มีข้อมูลสำหรับ interface'
                ];
            }
        }
        catch (\Exception $e) {
            \DB::rollBack();
            // \Log::error($e->getMessage());
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }


        return response()->json($data);
    }

    public function sendGL(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required',
            'month' => 'required',
        ]);

        \DB::beginTransaction();
        try {

            $data = [];
            $batch_no = null;
            $year = self::composeYear($request->year);
            $monthNo = $request->month;
            $customerNo = $request->customer_number;

            $find = PtomPaoTaxMt::with('customer', 'province', 'item')
            ->where('year', $year)
            ->when($monthNo, function ($q, $monthNo){
                return $q->where('month_no', $monthNo);
            })
            ->when($customerNo, function ($q, $customerNo){
                return $q->where('customer_number', $customerNo);
            })
            ->where(function($q){
                return $q->whereNull('gl_interface_status')
                ->orWhere('gl_interface_status', '!=', 'S');
            })
            ->orderByRaw("year desc, month_no desc")
            ->get();

            $now = Carbon::now();
            $org_id = DB::select("SELECT ORGANIZATION_ID FROM OAOM.PTOM_OPERATING_UNITS_V WHERE SHORT_CODE = 'TOAT'");
            $unit_id = $org_id[0]->organization_id ?? ''; // 81
            $operating_unit = 'การยาสูบแห่งประเทศไทย';

            $userId = getDefaultData('/users')->user_id;
            $program_code = 'OMP0089';
            $group_id = getGroupID();

            $last_date_data = $find->first();
            $carbon_last_date = Carbon::parse($last_date_data->year.'-'.$last_date_data->month_no.'-01');
            $accounting_date = $carbon_last_date->endOfMonth()->format('Y-m-d');
            $period = strtoupper($carbon_last_date->endOfMonth()->format('M-y'));
            $batch_name = '284/'.$carbon_last_date->endOfMonth()->format('m/Y');
            $batch_desc = 'ปรับปรุงรายได้รายตราร้านค้า ม.1 ตามเอกสารแนบ';

            $budgetYear = self::getBudgetYear($accounting_date);
            $dr_account_code = 'DOMESTIC';
            $dr_account = MappingAccountModel::where('account_code', $dr_account_code)->first();
            $dr_combine = explode('.', $dr_account->account_combine);

            $dr_combine = array(
                $dr_combine[0],   // segment1
                $dr_combine[1],   // segment2
                $dr_combine[2],   // segment3
                $dr_combine[3],   // segment4
                $budgetYear,        // segment5
                $dr_combine[5],   // segment6
                $dr_combine[6],   // segment7
                $dr_combine[7],   // segment8
                $dr_combine[8],   // segment9
                $dr_combine[9],   // segment10
                $dr_combine[10],   // segment11
                $dr_combine[11],   // segment12
            );

            $cr_account_code = 'TRX-DOM-AP Invoice-04';
            $cr_account = MappingAccountModel::where('account_code', $cr_account_code)->first();
            $cr_combine = explode('.', $cr_account->account_combine);
            $journal_name = 'ปรับปรุงรายได้รายตราร้านค้า ม.1 ตามเอกสารแนบ';
            $journal_description = 'ปรับปรุงรายการปรับรายได้รายตราร้านค้า ม.1 เดือน '.monthFormatThaiString($monthNo).' '.($request->year);
            $line_num = 0;

            if( !!$find->count() ){

                $batch_no = $group_id;

                $groupItem = $find->groupBy(['item_id']);

                foreach($groupItem as $item_id => $items){
                    
                    $sum_dr = $items->sum('adjust_amount');

                    if(round($sum_dr) == 0){
                        continue;
                    }
                    $seq_ecom = SequenceEcoms::where('item_id', $item_id)->first();
                    $line_num++;

                    $dr                             = new GLInterfaceModel;
                    $dr->group_id                   = $group_id;
                    $dr->interface_module           = 'GL';
                    $dr->org_id                     = $unit_id; /// 81
                    $dr->ledger_name                = $operating_unit; /// การยาสูบแห่งประเทศไทย
                    $dr->accounting_date            = $accounting_date;
                    $dr->period_name                = $period;
                    $dr->currency_code              = 'THB';
                    $dr->actual_flag                = 'A';
                    $dr->user_je_category_name      = 'WEB OP Sales Invoice';
                    $dr->user_je_source_name        = 'WEB ระบบขาย';
                    $dr->batch_name                 = $batch_name;
                    $dr->batch_description          = $batch_desc;
                    $dr->journal_name               = $journal_name;
                    $dr->journal_description_head   = $journal_description;// 'ปรับปรุงรายได้รายตราร้านค้า ม.1 เดือน คุลาคม 2565';
                    $dr->je_line_num                = $line_num;
                    $dr->code_combination_id        = '';
                    $dr->segment1                   = $dr_combine[0];
                    $dr->segment2                   = $dr_combine[1];
                    $dr->segment3                   = $dr_combine[2];
                    $dr->segment4                   = $dr_combine[3];
                    $dr->segment5                   = $dr_combine[4];
                    $dr->segment6                   = $dr_combine[5];
                    $dr->segment7                   = $dr_combine[6];
                    $dr->segment8                   = $dr_combine[7];
                    $dr->segment9                   = $dr_combine[8];
                    $dr->segment10                  = $seq_ecom->sub_account_code;
                    $dr->segment11                  = $dr_combine[10];
                    $dr->segment12                  = $dr_combine[11];
                    $dr->entered_dr                 = $sum_dr;
                    $dr->entered_cr                 = '';
                    $dr->accounted_dr               = $dr->entered_dr;
                    $dr->accounted_cr               = $dr->entered_cr;
                    $dr->journal_description_line   = 'Journal Import Created';
                    $dr->account_code               = '';
                    $dr->program_code               = $program_code;
                    $dr->created_by                 = $userId;
                    $dr->creation_date              = $now;
                    $dr->last_updated_by            = $userId;
                    $dr->last_update_date           = $now;
                    $dr->created_at                 = $now;
                    $dr->updated_at                 = $now;
                    $dr->created_by_id              = $userId;
                    $dr->updated_by_id              = $userId;
                    $dr->web_batch_no               = $batch_no;
                    $dr->save();
                }

                $sum_cr = $find->sum('adjust_amount');
                $line_num++;

                $cr                             = new GLInterfaceModel;
                $cr->group_id                   = $group_id;
                $cr->interface_module           = 'GL';
                $cr->org_id                     = $unit_id; /// 81
                $cr->ledger_name                = $operating_unit; /// การยาสูบแห่งประเทศไทย
                $cr->accounting_date            = $accounting_date;
                $cr->period_name                = $period;
                $cr->currency_code              = 'THB';
                $cr->actual_flag                = 'A';
                $cr->user_je_category_name      = 'WEB OP Sales Invoice';
                $cr->user_je_source_name        = 'WEB ระบบขาย';
                $cr->batch_name                 = $batch_name;
                $cr->batch_description          = $batch_desc;
                $cr->journal_name               = $journal_name;
                $cr->journal_description_head   = $journal_description;// 'ปรับปรุงรายได้รายตราร้านค้า ม.1 เดือน คุลาคม 2565';
                $cr->je_line_num                = $line_num;
                $cr->code_combination_id        = '';
                $cr->segment1                   = $cr_combine[0];
                $cr->segment2                   = $cr_combine[1];
                $cr->segment3                   = $cr_combine[2];
                $cr->segment4                   = $cr_combine[3];
                $cr->segment5                   = '00';
                $cr->segment6                   = $cr_combine[5];
                $cr->segment7                   = $cr_combine[6];
                $cr->segment8                   = $cr_combine[7];
                $cr->segment9                   = $cr_combine[8];
                $cr->segment10                  = $cr_combine[9];
                $cr->segment11                  = $cr_combine[10];
                $cr->segment12                  = $cr_combine[11];
                $cr->entered_dr                 = '';
                $cr->entered_cr                 = $sum_cr;
                $cr->accounted_dr               = $cr->entered_dr;
                $cr->accounted_cr               = $cr->entered_cr;
                $cr->journal_description_line   = 'Journal Import Created';
                $cr->account_code               = '';
                $cr->program_code               = $program_code;
                $cr->created_by                 = $userId;
                $cr->creation_date              = $now;
                $cr->last_updated_by            = $userId;
                $cr->last_update_date           = $now;
                $cr->created_at                 = $now;
                $cr->updated_at                 = $now;
                $cr->created_by_id              = $userId;
                $cr->updated_by_id              = $userId;
                $cr->web_batch_no               = $batch_no;
                $cr->save();

                //// UPDATE GL BATCH //// 
                foreach ($find as $key => $item) {
                    $item->gl_web_batch_no = $batch_no;
                    $item->save();
                }
            }

            \DB::commit();

            if($batch_no){
                $result = InterfaceRepo::interfaceGL($batch_no);
                if(in_array($result['status'], ['C', 'S'])){
                    $data = [
                        'group_id' => $group_id,
                        'status' => 'S',
                        'msg' => 'SUCCESS'
                    ];
                    //// UPDATE INTERFACE STATUS //// 
                    foreach ($find as $key => $item) {
                        $item->gl_interface_status = 'S';
                        $item->save();
                    }
                }else{
                    $data = [
                        'status' => 'E',
                        'msg' => optional(GLInterfaceModel::where('web_batch_no', $batch_no)->where('interface_status', 'E')->first())->interfaced_msg ?? $result['message']
                    ];
                }
            }else {
                $data = [
                    'status' => 'E',
                    'msg' => 'ไม่มีข้อมูลสำหรับ interface'
                ];
            }
        }
        catch (\Exception $e) {
            \DB::rollBack();
            // \Log::error($e->getMessage());
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        return response()->json($data);
    }

    private static function composeYear($val)
    {
        $year = (int)$val - 543;

        return $year;
    }

    private static function composeMonthNo($val)
    {
        $monthLists = [
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
            '12' => 'ธันวาคม',
        ];

        $monthNo = (int)array_search($val, $monthLists);

        return $monthNo;
    }

    private static function getBudgetYear($date = null)
    {
		$currentYear = $date ? date('Y', strtotime($date)) : date('Y');
	    $cycle = date('Y-m-d', strtotime($currentYear.'-9-30'));
        $now = $date ? date('Y-m-d', strtotime($date)) : date('Y-m-d');
		$offset = $now > $cycle ? 44 : 43;
        $year = substr( ( $date ? (int)date('y', strtotime($date)) : (int)date('y')) + $offset , -2);

		return $year;
    }

    private static function getGroupID()
    {
        return date('YmdHis');

        // $group = TranspotReportModel::orderByDesc('ap_interface_id')->first(['group_id']);
        // if (empty($group)) {
        //     $newnumber = sprintf('%07d', 1);
        // } else {
        //     $last_number = substr($group->group_id, 2);
        //     if (is_numeric($last_number)) {
        //         $newnumber = sprintf('%07d', $last_number + 1);
        //     } else {
        //         $newnumber = sprintf('%07d', 1);
        //     }
        // }

        // $year = date('Y') + 543;

        // return substr($year, 2) . $newnumber;
    }

    private static function getInvoiceNumber()
    {
        $invoice = TranspotReportModel::orderByDesc('ap_interface_id')->first(['invoice_number']);
        if (empty($invoice)) {
            $newnumber = sprintf('%05d', 1);
        } else {
            $last_number = substr($invoice->invoice_number, 4);
            if (is_numeric($last_number)) {
                $newnumber = sprintf('%05d', $last_number + 1);
            } else {
                $newnumber = sprintf('%05d', 1);
            }
        }

        $year = date('Y') + 543;

        return substr($year, 2) . date('m') . $newnumber;
    }

    private static function interfaceAP($batch)
    {
    	try {

            $db     =   \DB::connection('oracle')->getPdo();

            $sql    =   "

                        DECLARE
                            LV_RETURN_STATUS      VARCHAR2(10)    :=  NULL;
                            LV_RETURN_MSG         VARCHAR2(4000)  :=  NULL;
                        BEGIN
                        
                            PTOM_WEB_UTILITIES_PKG.CREATE_AP_INTERFACE(
                                P_BATCH_NO        =>  :batch
                                ,O_RETURN_STATUS  =>  :LV_RETURN_STATUS
                                ,O_RETURN_MSG     =>  :LV_RETURN_MSG 
                            );
                            
                        END;

                        ";

            // $sql = preg_replace("/[\r\n]*/","",$sql);
            $stmt = $db->prepare($sql);

            $result = [];
            $stmt->bindParam(':batch', $batch, \PDO::PARAM_STR);
            $stmt->bindParam(':LV_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 1000);
            $stmt->bindParam(':LV_RETURN_MSG', $result['message'], \PDO::PARAM_STR, 4000);
            $stmt->execute();

            $db = null;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 1);
        }

        return $result;
    }

    private static function getInvoiceBatch($user_id, $carbon_date)
    {
        $batch =  'ระบบงานขาย/AP3/' . strtoupper($carbon_date->format('d-M-Y')) . '/ค่าภาษี อบจ. ม.1'; // $user_id . '/AP3/' . strtoupper(date('d-M-Y')) . '/ค่าภาษีอบจ.ป.1';
        
        $exist = TranspotReportModel::where('program_code', 'OMP0089')
        ->where('invoice_batch', 'like', '%'.$batch.'%')
        ->whereIn('interface_status', ['F', 'C', 'S'])
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