<?php

namespace App\Http\Controllers\OM\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\Settings\ApproverOrder;
use App\Models\OM\Settings\AuthoRityList;

class ApproverOrderExportController extends Controller
{
    public function index()
    {
        // if (!canEnter('/om/settings/approver-order-export') || !canView('/om/settings/approver-order-export')) {
        //     return redirect()->back()->withError(trans('403'));
        // }
        $approverOrders = ApproverOrder::where('attribute1', 'EXPORT')->orderBy('approver_number', 'asc')->paginate(25);

        return view('om.settings.approver-order-export.index', compact('approverOrders'));
    }

    public function create()
    {
        $authoRityLists = AuthoRityList::when('start_date' != '', function ($q) {
                    return $q->where('start_date', '<=', date("Y-m-d"));
                })
                ->when('end_date' != '', function ($q) {
                    return $q->where('end_date', '>=', date("Y-m-d"));
                })
                ->orWhere('start_date', null)
                ->orWhere('end_date', null)
                ->orderBy('employee_name', 'asc')
                ->get();
        
        // dd($authoRityLists);

        return view('om.settings.approver-order-export.create', compact('authoRityLists'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        request()->validate([
            'approver_number'  => 'required',
            'authority_id'     => 'required',
        ], [
            'approver_number.required'  => 'ระบุ ลำดับ',
            'authority_id.required'     => 'เลือก ชื่อผู้อนุมัติ',
        ]);

        $old = ApproverOrder::where('authority_id', request()->authority_id)->where('attribute1', 'EXPORT')->orderBy('approver_order_id', 'desc')->first();

        if ($old) {
            if ($old->end_date) {
                if (date('Y-m-d', strtotime(request()->start_date)) < date('Y-m-d', strtotime($old->end_date))) {
                    request()->validate([
                        'check_date'    => 'required',
                    ], [
                        'check_date.required'    => 'ผู้อนุมัติคนเดียวกัน ไม่สามารถเลือกช่วงเวลาซ้ำกันได้',
                    ]);
                }
            } else {
                request()->validate([
                    'check_date'    => 'required',
                ], [
                    'check_date.required'    => 'ผู้อนุมัติคนเดียวกัน ไม่สามารถเลือกช่วงเวลาซ้ำกันได้',
                ]);
            }
        }

        if (request()->default_flag) {
            $checkDefault = ApproverOrder::where('default_flag', 'Y')->where('attribute1', 'EXPORT')->orderBy('approver_order_id', 'desc')->first();
            if ($checkDefault) {
                if ($checkDefault->end_date) {
                    if (date('Y-m-d', strtotime(request()->start_date)) < date('Y-m-d', strtotime($checkDefault->end_date))) {
                        request()->validate([
                            'check_date'    => 'required',
                        ], [
                            'check_date.required'    => 'Default ไม่สามารถเลือกช่วงเวลาซ้ำกันได้',
                        ]);
                    }
                } else {
                    request()->validate([
                        'check_date'    => 'required',
                    ], [
                        'check_date.required'    => 'Default ไม่สามารถเลือกช่วงเวลาซ้ำกันได้',
                    ]);
                }
            }
        }

        $startDate       = request()->start_date ? date('Y-M-d', strtotime(request()->start_date)) : '';
        $endDate         = request()->end_date   ? date('Y-M-d', strtotime(request()->end_date))   : '';   

        if (request()->start_date && request()->end_date) {
            if (date('Y-m-d', strtotime(request()->end_date)) < date('Y-m-d', strtotime(request()->start_date))) {
                request()->validate([
                    'check_date'    => 'required',
                ], [
                    'check_date.required'    => 'ไม่สามารถเลือกวันที่สิ้นสุดน้อยกว่าวันที่เริ่มต้นได้',
                ]);
            }
        }

        
        $authoRityList = AuthoRityList::find(request()->authority_id);

        $approverOrder = new ApproverOrder;
        $approverOrder->approver_number  = request()->approver_number;
        $approverOrder->authority_id     = $authoRityList->authority_id;
        $approverOrder->employee_id      = '-1';
        $approverOrder->approver_name    = $authoRityList->employee_name;
        $approverOrder->default_flag     = request()->default_flag ? 'Y' : 'N';
        $approverOrder->program_code     = 'OMS0030';
        $approverOrder->created_by       = $user->user_id;
        $approverOrder->last_updated_by  = $user->user_id;
        $approverOrder->start_date       = $startDate;
        $approverOrder->end_date         = $endDate;
        $approverOrder->employee_number  = $authoRityList->employee_number;
        $approverOrder->attribute1       = 'EXPORT';
        $approverOrder->save();

        return redirect()->route('om.settings.approver-order-export.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');

    }

    public function edit($id)
    {
        $approverOrder = ApproverOrder::find($id);
        $authoRityLists = AuthoRityList::when('start_date' != '', function ($q) {
                            return $q->where('start_date', '<=', date("Y-m-d"));
                        })
                        ->when('end_date' != '', function ($q) {
                            return $q->where('end_date', '>=', date("Y-m-d"));
                        })
                        ->orWhere('start_date', null)
                        ->orWhere('end_date', null)
                        ->orderBy('employee_name', 'asc')
                        ->get();

        return view('om.settings.approver-order-export.edit', compact('approverOrder', 'authoRityLists'));
    }
    
    public function update(Request $request, $id)
    {
        $user = auth()->user();

        request()->validate([
            'approver_number'  => 'required',
            'authority_id'     => 'required',
        ], [
            'approver_number.required'  => 'ระบุ ลำดับ',
            'authority_id.required'     => 'เลือก ชื่อผู้อนุมัติ',
        ]);

        $startDate       = request()->start_date ? date('Y-M-d', strtotime(request()->start_date)) : '';
        $endDate         = request()->end_date   ? date('Y-M-d', strtotime(request()->end_date))   : '';
        
    
        if (request()->start_date && request()->end_date) {
            if (date('Y-m-d', strtotime(request()->end_date)) < date('Y-m-d', strtotime(request()->start_date))) {
                // return redirect()->back()->with('error', 'ไม่สามารถเลือกวันที่สิ้นสุดน้อยกว่าวันที่เริ่มต้นได้');
                request()->validate([
                    'check_date'    => 'required',
                ], [
                    'check_date.required'    => 'ไม่สามารถเลือกวันที่สิ้นสุดน้อยกว่าวันที่เริ่มต้นได้',
                ]);
            }
        }

        $old = ApproverOrder::where('approver_order_id', '!=', $id)->where('attribute1', 'EXPORT')->where('authority_id', request()->authority_id)->orderBy('approver_order_id', 'desc')->first();

        if ($old) {
            if ($old->end_date) {
                if (date('Y-m-d', strtotime(request()->start_date)) < date('Y-m-d', strtotime($old->end_date))) {
                    request()->validate([
                        'check_date'    => 'required',
                    ], [
                        'check_date.required'    => 'ผู้อนุมัติคนเดียวกัน ไม่สามารถเลือกช่วงเวลาซ้ำกันได้',
                    ]);
                }
            } else {
                request()->validate([
                    'check_date'    => 'required',
                ], [
                    'check_date.required'    => 'ผู้อนุมัติคนเดียวกัน ไม่สามารถเลือกช่วงเวลาซ้ำกันได้',
                ]);
            }
        }

        if (request()->default_flag) {
            $checkDefault = ApproverOrder::where('approver_order_id', '!=', $id)->where('attribute1', 'EXPORT')->where('default_flag', 'Y')->orderBy('approver_order_id', 'desc')->first();
            if ($checkDefault) {
                if ($checkDefault->end_date) {
                    if (date('Y-m-d', strtotime(request()->start_date)) < date('Y-m-d', strtotime($checkDefault->end_date))) {
                        request()->validate([
                            'check_date'    => 'required',
                        ], [
                            'check_date.required'    => 'Default ไม่สามารถเลือกช่วงเวลาซ้ำกันได้',
                        ]);
                    }
                } else {
                    request()->validate([
                        'check_date'    => 'required',
                    ], [
                        'check_date.required'    => 'Default ไม่สามารถเลือกช่วงเวลาซ้ำกันได้',
                    ]);
                }
            }
        }

        $authoRityList = AuthoRityList::find(request()->authority_id);

        $approverOrder = ApproverOrder::find($id);
        $approverOrder->approver_number  = request()->approver_number;
        $approverOrder->authority_id     = $authoRityList->authority_id;
        $approverOrder->employee_id      = '-1';
        $approverOrder->approver_name    = $authoRityList->employee_name;
        $approverOrder->default_flag     = request()->default_flag ? 'Y' : 'N';
        $approverOrder->last_updated_by  = $user->user_id;
        $approverOrder->start_date       = $startDate;
        $approverOrder->end_date         = $endDate;
        $approverOrder->employee_number  = $authoRityList->employee_number;
        $approverOrder->save();

        return redirect()->route('om.settings.approver-order-export.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
    }
}
