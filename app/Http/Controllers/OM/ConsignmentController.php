<?php

namespace App\Http\Controllers\OM;

use App\Http\Controllers\Controller;
use App\Models\OM\Api\Customer;
use App\Models\OM\ApproveSaleOrder\PrepareSaleOrderModel;
use App\Models\OM\Consignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Validator;
use PDO;

class ConsignmentController extends Controller
{
    public function cancel()
    {
        if (request()->all()) {
            $lists = new Consignment();
            $lists = $lists->leftJoin('ptom_customers', 'ptom_consignment_headers.customer_number', '=', 'ptom_customers.customer_number');

            if (request()->consignment_date && request()->consignment_date != '') {
                $lists = $lists->whereRaw("PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_DATE = DATE '" . parseFromDateTh(request()->consignment_date) . "'");
            }
            if (request()->consignment_no && request()->consignment_no != '') {
                $lists = $lists->where('ptom_consignment_headers.consignment_no', request()->consignment_no);
            }
            if (request()->customer_number && request()->customer_number != '') {
                $lists = $lists->where('ptom_customers.customer_number', request()->customer_number);
            }
            $lists = $lists->whereRaw("PTOM_CONSIGNMENT_HEADERS.CONSIGNMENT_STATUS != 'Cancelled'")->select('ptom_consignment_headers.consignment_no', 'ptom_consignment_headers.consignment_date', 'ptom_customers.customer_name', 'ptom_consignment_headers.total_amount', 'ptom_consignment_headers.consignment_status', 'ptom_consignment_headers.consignment_header_id')->orderBy('ptom_consignment_headers.consignment_no', 'DESC')->paginate(15);
        } else {
            $lists = [];
        }

        $orders = Consignment::where('consignment_status', '!=', 'Cancelled')->orderBy('consignment_no', 'DESC')->get();


        // $customers = Customer::whereRaw("UPPER(sales_classification_code) = 'DOMESTIC'")->where(function($q){
        //     $q->where('customer_type_id','30');
        //     $q->orWhere('customer_type_id','40');
        // })->orderBy('customer_number', 'ASC')->get();
        $customers = Consignment::join('ptom_customers', 'ptom_consignment_headers.customer_number', 'ptom_customers.customer_number', 'left')->groupBy(['ptom_consignment_headers.customer_number', 'ptom_customers.customer_name'])->orderBy('ptom_consignment_headers.customer_number', 'ASC')->get(['ptom_consignment_headers.customer_number', 'ptom_customers.customer_name']);

        return view('om.consignments.cancel', compact('lists', 'customers', 'orders'));
    }

    public function canceled(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'consignment_id' => 'required'
        ], [
            'consignment_id.required' => 'กรุณาเลือกรายการที่ต้องการยกเลิก'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors()->first());
        }

        $lists = Consignment::whereIn('consignment_header_id', $request->consignment_id)->get();
        if (empty($lists)) {
            return back()->withErrors('กรุณาเลือกรายการที่ต้องการยกเลิก');
        }

        FacadesDB::beginTransaction();
        try {
            foreach ($lists as $list) {
                $webno = Consignment::where('consignment_header_id', $list->consignment_header_id)->first();
                $checkWMS = FacadesDB::table('PTOM_ORDER_T_WMS')->where('oaom_order_no', $list->consignment_no)->first();

                if (empty($checkWMS) && $webno->close_sale_flag != 'Y') {
                    $consignmentdata = [
                        'consignment_status' => 'Cancelled',
                        'last_updated_by' => getDefaultData('/users')->user_id,
                        'last_update_date' => now()
                    ];

                    FacadesDB::table('ptom_consignment_headers')->where('consignment_header_id', $list->consignment_header_id)->update($consignmentdata);

                    $wms_update = [
                        'record_status' => 'C'
                    ];
                    FacadesDB::table('PTOM_ORDER_T_WMS')->where('oaom_order_no', $list->consignment_no)->update($wms_update);
                } elseif($checkWMS->oaom_wms6_inven != 'Y' && $webno->close_sale_flag != 'Y') {
                    $consignmentdata = [
                        'consignment_status' => 'Cancelled',
                        'last_updated_by' => getDefaultData('/users')->user_id,
                        'last_update_date' => now()
                    ];

                    FacadesDB::table('ptom_consignment_headers')->where('consignment_header_id', $list->consignment_header_id)->update($consignmentdata);

                    $wms_update = [
                        'record_status' => 'C'
                    ];
                    FacadesDB::table('PTOM_ORDER_T_WMS')->where('oaom_order_no', $list->consignment_no)->update($wms_update);
                } else {
                    FacadesDB::rollBack();
                    return back()->withErrors('ไม่สามารถยกเลิกรายการได้  เนื่องจากได้ทำการปิดการขายประจำวัน หรือ ข้อมูลเข้าระบบ WMS แล้ว');
                }
            }
            FacadesDB::commit();

            // return back()->with('success', 'ดำเนินการเรียบร้อยแล้ว');
            return redirect()->to('/om/consignment/cancel')->with('success', 'ดำเนินการเรียบร้อยแล้ว');
        } catch (\Throwable $th) {
            FacadesDB::rollBack();
            // return back()->withErrors($th->getMessage());
            return redirect()->to('/om/consignment/cancel')->withErrors('ไม่สามารถยกเลิกรายการได้  เนื่องจากได้ทำการปิดการขายประจำวัน หรือ ข้อมูลเข้าระบบ WMS แล้ว');
        }
    }
}
