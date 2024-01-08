<?php

namespace App\Http\Controllers\OM;

use App\Http\Controllers\Controller;
use App\Models\OM\Api\Customer;
use App\Models\OM\FormOrderHeader;
use App\Models\OM\FormOrderLine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FormOrderHeaderController extends Controller
{
    public function index()
    {
        $follows = new FormOrderHeader();
        $follows = $follows->join('ptom_customers', 'ptom_form_order_headers.customer_id', '=', 'ptom_customers.customer_id', 'left');
        if (request()->customer_number) {
            $follows = $follows->where('ptom_customers.customer_number', request()->customer_number);
        }
        if (request()->period_date) {
            $follows = $follows->whereDate('ptom_form_order_headers.to_period_date', date_format(date_create(request()->to_period_date), "Y-m-d"));
        }
        if (request()->approve_status) {
            $follows = $follows->where('ptom_form_order_headers.approve_status', request()->approve_status);
        }
        $follows = $follows->where('ptom_form_order_headers.form_type', 'SPECIAL')->get(['ptom_form_order_headers.form_header_id', 'ptom_customers.customer_number', 'ptom_customers.customer_name', 'ptom_form_order_headers.approve_status', 'ptom_form_order_headers.from_period_date', 'ptom_form_order_headers.to_period_date', 'ptom_form_order_headers.reason', 'ptom_form_order_headers.creation_date']);
        $customers = Customer::get();

        return view('om.formorderspecial.index', compact('follows', 'customers'));
    }

    public function show($id)
    {
        $queryInfo = DB::table('ptom_form_order_headers')->select(
            'ptom_form_order_headers.employee_approve1',
            'ptom_form_order_headers.employee_approve2',
            'ptom_form_order_headers.employee_approve3',
            'ptom_form_order_headers.form_header_id',
            'ptom_form_order_headers.province',
            'ptom_form_order_headers.reason',
            'ptom_form_order_headers.approve_status',
            'ptom_form_order_headers.approve_date',
            'ptom_form_order_headers.creation_date',
            'ptom_form_order_headers.from_period_date',
            'ptom_form_order_headers.to_period_date',
            'ptom_form_order_headers.to_period_id',
            'ptom_customers.customer_number',
            'ptom_customers.customer_name',
            'ptom_customers.address_line1',
            'ptom_customers.address_line2',
            'ptom_customers.address_line3',
            'ptom_customers.alley',
            'ptom_customers.district',
            'ptom_customers.city',
            'ptom_customers.postal_code'
        )->join('ptom_customers', 'ptom_form_order_headers.customer_id', '=', 'ptom_customers.customer_id', 'left')->where('ptom_form_order_headers.form_header_id', $id);
        $quotas = DB::table('ptom_form_order_lines')->select(
            'form_line_id',
            'form_number',
            'item_description',
            'quantity',
            'approve_quantity'
        )->where('form_header_id', $id)->orderBy('form_number', 'ASC')->get();
        $emps = DB::table('ptom_authority_lists')->select('authority_id', 'employee_name')->get();
        $info = $queryInfo->first();

        $actings = DB::select("SELECT PTOM_CUSTOMER_OWNERS.OWNER_NO,PTOM_CUSTOMER_OWNERS.PREFIX,PTOM_CUSTOMER_OWNERS.OWNER_FIRST_NAME,PTOM_CUSTOMER_OWNERS.OWNER_LAST_NAME FROM PTOM_CUSTOMER_OWNERS,PTOM_CUSTOMERS WHERE PTOM_CUSTOMER_OWNERS.STATUS <> 'INACTIVE' AND PTOM_CUSTOMER_OWNERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID AND PTOM_CUSTOMERS.CUSTOMER_NUMBER = '" . $info->customer_number . "' ORDER BY PTOM_CUSTOMER_OWNERS.OWNER_NO ASC FETCH FIRST 1 ROWS ONLY");
        $act = $actings[0];

        $actingDropdown = DB::table('ptom_acting_position_v')->select('meaning')->where('enabled_flag', 'Y')->get();
        $to_period_id = $info->to_period_id;
        $getBudgetYear = DB::table('PTOM_PERIOD_V')->select('BUDGET_YEAR')->where('period_line_id', $to_period_id)->first()->BUDGET_YEAR ?? date("Y");
        $countFromHeaderId = $queryInfo->count();

        return view('om.formorderspecial.show', compact('info', 'quotas', 'emps', 'act', 'countFromHeaderId', 'getBudgetYear', 'actingDropdown'));
    }

    public function report($id)
    {
        $queryInfo = DB::table('ptom_form_order_headers')->select(
            'ptom_form_order_headers.form_header_id',
            'ptom_form_order_headers.province',
            'ptom_form_order_headers.reason',
            'ptom_form_order_headers.approve_status',
            'ptom_form_order_headers.approve_date',
            'ptom_form_order_headers.creation_date',
            'ptom_form_order_headers.from_period_date',
            'ptom_form_order_headers.to_period_date',
            'ptom_form_order_headers.to_period_id',
            'ptom_customers.customer_name',
            'ptom_customers.address_line1',
            'ptom_customers.address_line2',
            'ptom_customers.address_line3',
            'ptom_customers.alley',
            'ptom_customers.district',
            'ptom_customers.city',
            'ptom_customers.postal_code'
        )->join('ptom_customers', 'ptom_form_order_headers.customer_id', '=', 'ptom_customers.customer_id', 'left')->where('ptom_form_order_headers.form_header_id', $id);
        $info = $queryInfo->first();

        $quotas = DB::table('ptom_form_order_lines')->select('form_line_id', 'form_number', 'item_description', 'quantity', 'approve_quantity')->where('form_header_id', $id)->orderBy('form_number', 'ASC')->get();
        $actings = DB::select("SELECT PTOM_CUSTOMER_OWNERS.OWNER_NO,PTOM_CUSTOMER_OWNERS.PREFIX,PTOM_CUSTOMER_OWNERS.OWNER_FIRST_NAME,PTOM_CUSTOMER_OWNERS.OWNER_LAST_NAME FROM PTOM_CUSTOMER_OWNERS,PTOM_CUSTOMERS WHERE PTOM_CUSTOMER_OWNERS.STATUS <> 'INACTIVE' AND PTOM_CUSTOMER_OWNERS.CUSTOMER_ID = PTOM_CUSTOMERS.CUSTOMER_ID AND PTOM_CUSTOMERS.CUSTOMER_NUMBER = '" . $info->customer_number . "' ORDER BY PTOM_CUSTOMER_OWNERS.OWNER_NO ASC FETCH FIRST 1 ROWS ONLY");
        $act = $actings[0];

        $to_period_id = $info->to_period_id;
        $getBudgetYear = DB::table('PTOM_PERIOD_V')->select('BUDGET_YEAR')->where('period_line_id', $to_period_id)->first()->BUDGET_YEAR ?? date("Y");
        $countFromHeaderId = $queryInfo->count();

        return view('om.formorderspecial.showreport', compact('info', 'quotas', 'act', 'countFromHeaderId', 'getBudgetYear'));
    }

    public function approve(Request $request)
    {
        if ($request->updateStatus == 'อนุมัติ') {
            $validator = Validator::make($request->all(), [
                'employee_approve1' => 'required',
                'employee_approve2' => 'required',
                'employee_approve3' => 'required',
                'approve_quantity.*' => 'required',
            ], [
                'employee_approve1.required' => 'กรุณาเลือกผู้ทำการกองบริหารการขาย',
                'employee_approve2.required' => 'กรุณาเลือกผู้ทำการโปรดพิจารณา',
                'employee_approve3.required' => 'กรุณาเลือกผู้ทำการผู้อนุมัติ',
                'approve_quantity.*.required' => 'กรุณาระบุจำนวนอนุมัติ',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator->errors()->first())->withInput($request->all());
            }
        }
        $approve = FormOrderHeader::find($request->id);
        if (!$approve) {
            return back()->withErrors('ไม่พบข้อมูล');
        }
        $approve->approve_status = $request->updateStatus;
        $approve->employee_approve1 = $request->updateStatus == 'อนุมัติ' ? $request->employee_approve1 : '';
        $approve->acting_position_approve1 = $request->updateStatus == 'อนุมัติ' ? $request->acting_position_approve1 : '';
        $approve->employee_approve2 = $request->updateStatus == 'อนุมัติ' ? $request->employee_approve2 : '';
        $approve->acting_position_approve2 = $request->updateStatus == 'อนุมัติ' ? $request->acting_position_approve2 : '';
        $approve->employee_approve3 = $request->updateStatus == 'อนุมัติ' ? $request->employee_approve3 : '';
        $approve->acting_position_approve3 = $request->updateStatus == 'อนุมัติ' ? $request->acting_position_approve3 : '';
        $approve->last_updated_by = '1';
        $approve->last_update_date = now();
        $approve->save();

        if ($request->updateStatus == 'อนุมัติ') {
            foreach ($request->form_line_id as $key => $formid) {
                FormOrderLine::find($formid)->update(['approve_quantity' => $request->approve_quantity[$key], 'last_updated_by' => '1', 'last_update_date' => now()]);
            }

            DB::table('ptom_grant_special_case')->insert([
                'customer_id' => $approve->customer_id,
                'grant_special_flag' => 'Y',
                'allowed_order_date' => $approve->from_period_date,
                'start_date' => $approve->created_at
            ]);
        }

        return redirect()->to('om/form-order')->with('success', $request->updateStatus . 'เรียบร้อยแล้ว');
    }
}
