<?php

namespace App\Http\Controllers\OM\Settings;

use App\Http\Controllers\Controller;
use App\Models\OM\Api\FormOrderHeader;
use Illuminate\Http\Request;

use App\Models\OM\Settings\GrantSpacialCase;
use App\Models\OM\Settings\Customer;

class GrantSpacialCaseController extends Controller
{
    public function index()
    {
        if (!canEnter('/om/settings/grant-spacial-case') || !canView('/om/settings/grant-spacial-case')) {
            return redirect()->back()->withError(trans('403'));
        }

        $defaultCustomer    = request()->customer_id;
        $defaultDate        = request()->allowed_order_date ? parseFromDateTh(request()->allowed_order_date) : '';
        $grants             = GrantSpacialCase::search($defaultCustomer, $defaultDate)
                                                ->orderBy('grant_special_id', 'desc')
                                                ->paginate(15);
        $customers          = Customer::where('sales_classification_code', 'Domestic')
                                        ->where('status', 'Active')
                                        ->orderBy('customer_number', 'asc')
                                        ->get();

        return view('om.settings.grant-spacial-case.index', compact('grants', 'customers', 'defaultCustomer', 'defaultDate'));
    }

    public function create()
    {
        $customers  = Customer::where('sales_classification_code', 'Domestic')
                                ->where('status', 'Active')
                                ->orderBy('customer_number', 'asc')
                                ->get();

        return view('om.settings.grant-spacial-case.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        request()->validate([
            'customer_id'        => 'required',
            'allowed_order_date' => 'required',
        ], [
            'customer_id.required'        => 'โปรดเลือก รหัส - ชื่อลูกค้า',
            'allowed_order_date.required' => 'โปรดระบุ วันที่อนุญาติให้สั่งซื้อได้ ',
        ]);

        if (!request()->grant_special_flag && !request()->second_order_flag) {
            if (!request()->grant_special_flag) {
                request()->validate([
                    'grant_special_flag' => 'required',
                ], [
                    'grant_special_flag.required'  => 'โปรดเลือกสั่งซื้อกรณีพิเศษ หรือ สั่งซื้อครั้งที่สองในวัน',
                ]);
            }
        }

        $grant                     = new GrantSpacialCase;
        $grant->customer_id        = request()->customer_id;
        $grant->grant_special_flag = request()->grant_special_flag ? 'Y' : 'N';
        $grant->second_order_flag  = request()->second_order_flag ? 'Y' : 'N';
        $grant->allowed_order_date = request()->allowed_order_date ? parseFromDateTh(request()->allowed_order_date) : '';
        $grant->program_code       = 'OMS0021';
        $grant->created_by         = $user->user_id;
        $grant->last_updated_by    = $user->user_id;
        $grant->save();

        return redirect()->route('om.settings.grant-spacial-case.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
    }

    public function edit($id)
    {
        $grant      = GrantSpacialCase::find($id);
        $customers  = Customer::where('sales_classification_code', 'Domestic')
                                ->where('status', 'Active')
                                ->orderBy('customer_number', 'asc')
                                ->get();

        return view('om.settings.grant-spacial-case.edit', compact('grant', 'customers'));
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        request()->validate([
            'customer_id' => 'required',
            'allowed_order_date' => 'required',
        ], [
            'customer_id.required'        => 'โปรดเลือก รหัส - ชื่อลูกค้า',
            'allowed_order_date.required' => 'โปรดระบุ วันที่อนุญาติให้สั่งซื้อได้ ',
        ]);

        if (!request()->grant_special_flag && !request()->second_order_flag) {
            if (!request()->grant_special_flag) {
                request()->validate([
                    'grant_special_flag' => 'required',
                ], [
                    'grant_special_flag.required'  => 'โปรดเลือกสั่งซื้อกรณีพิเศษ หรือ สั่งซื้อครั้งที่สองในวัน',
                ]);
            }
        }

        $grant                     = GrantSpacialCase::find($id);
        $grant->customer_id        = request()->customer_id;
        $grant->grant_special_flag = request()->grant_special_flag ? 'Y' : 'N';
        $grant->second_order_flag  = request()->second_order_flag ? 'Y' : 'N';
        $grant->allowed_order_date = request()->allowed_order_date ? parseFromDateTh(request()->allowed_order_date) : '';
        if($grant->form_header_id != '') {
            $formHeader = FormOrderHeader::find($grant->form_header_id);
            if($formHeader) {
                $formHeader->to_period_date = $grant->allowed_order_date;
                $formHeader->save();
            }
        }
        $grant->last_updated_by    = $user->user_id;
        $grant->save();

        return redirect()->route('om.settings.grant-spacial-case.index')->with('success', 'แก้ไขข้อมูลเรียบร้อย');
    }

    public function destroy($id)
    {
        $grant  = GrantSpacialCase::find($id);
        if($grant->form_header_id != '') {
            $formHeader = FormOrderHeader::find($grant->form_header_id);
            if($formHeader) {
                $formHeader->approve_status = 'ไม่อนุมัติ';
                $formHeader->save();
            }
        }
        $grant->delete();

        return redirect()->route('om.settings.grant-spacial-case.index')->with('success', 'ทำการลบข้อมูลเรียบร้อยแล้ว');
    }
}
