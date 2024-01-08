<?php

namespace App\Http\Controllers\OM\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\Settings\QuotaCreditGroup;
// use App\Models\OM\Settings\ItemV;
use App\Models\OM\Settings\SequenceEcom;
use App\Models\OM\Settings\QuotaGroup;
use App\Models\OM\Settings\CreditGroup;

class QuotaCreditGroupController extends Controller
{
    public function index()
    {
        if (!canEnter('/om/settings/quota-credit-group') || !canView('/om/settings/quota-credit-group')) {
            return redirect()->back()->withError(trans('403'));
        }
        $quotaCreditGroups = QuotaCreditGroup::orderBy('item_code', 'asc')->orderBy('created_at', 'asc')->paginate(25);

        return view('om.settings.quota-credit-group.index', compact('quotaCreditGroups'));
    }

    public function create()
    {
        $items  = SequenceEcom::when('start_date' != '', function ($q) {
                        return $q->where('start_date', '<=', date("Y-m-d"));
                    })
                    ->when('end_date' != '', function ($q) {
                        return $q->where('end_date', '>=', date("Y-m-d"));
                    })
                    ->orWhere('start_date', null)
                    ->orWhere('end_date', null)
                    ->where('sale_type_code', 'DOMESTIC')
                    ->orderBy('item_code', 'asc')
                    ->get();

        $quotaGroups  = QuotaGroup::all();
        $creditGroups = CreditGroup::all();

        return view('om.settings.quota-credit-group.create', compact('items', 'quotaGroups', 'creditGroups'));
    }

    public function store(Request $request)
    {
        // dd('store', request()->all());
        request()->validate([
            'item_id'            => 'required',
            // 'quota_group_code'   => 'required',
            'credit_group_code'  => 'required',
        ], [
            'item_id.required'            => 'เลือก Item',
            // 'quota_group_code.required'   => 'เลือก กลุ่มโควต้า',
            'credit_group_code.required'  => 'เลือก กลุ่มวงเงินเขื่อ',
        ]);

        
        $user = auth()->user();
        $item = SequenceEcom::where('item_id', request()->item_id)->first();

        // $startDate       = request()->start_date ? date('Y-M-d', strtotime(request()->start_date)) : '';
        // $endDate         = request()->end_date   ? date('Y-M-d', strtotime(request()->end_date))   : '';

        $startDate       = request()->start_date ? parseFromDateTh(request()->start_date) : '';
        $endDate         = request()->end_date   ? parseFromDateTh(request()->end_date)   : '';

        $old = QuotaCreditGroup::where('item_id', request()->item_id)->orderBy('quota_credit_id', 'desc')->first();

        // dd($old);
        if ($old) {
            if ($old->end_date) {
                if ($startDate) {
                    if (date('Y-m-d', strtotime($startDate)) <= date('Y-m-d', strtotime($old->end_date))) {

                        request()->validate([
                            'check_duplicate'            => 'required',
                        ], [
                            'check_duplicate.required'            => 'ไม่สามารถเลือกผลิตภัณฑ์เดียวกันในช่วงเวลาซ้ำซ้อนกับในระบบ',
                        ]);

                        // return redirect()->back()->with('error', 'ไม่สามารถเลือกผลิตภัณฑ์เดียวกันในช่วงเวลาซ้ำซ้อนกับในระบบ');
                    } 
                } else {

                    request()->validate([
                        'check_duplicate'            => 'required',
                    ], [
                        'check_duplicate.required'            => 'ไม่สามารถเลือกผลิตภัณฑ์เดียวกันในช่วงเวลาซ้ำซ้อนกับในระบบ',
                    ]);

                    // return redirect()->back()->with('error', 'ไม่สามารถเลือกผลิตภัณฑ์เดียวกันในช่วงเวลาซ้ำซ้อนกับในระบบ');
                }
            } else {

                request()->validate([
                    'check_duplicate'            => 'required',
                ], [
                    'check_duplicate.required'            => 'ไม่สามารถเลือกผลิตภัณฑ์เดียวกันในช่วงเวลาซ้ำซ้อนกับในระบบ',
                ]);

                // return redirect()->back()->with('error', 'ไม่สามารถเลือกผลิตภัณฑ์เดียวกันในช่วงเวลาซ้ำซ้อนกับในระบบ');
            }
            
        }


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

        // $checkOverQuotaApproval = OverQuotaApproval::where('over_quota_id', '!=', $id)
        //                                         // ->where('cbb_range_from', request()->cbb_range_from)
        //                                         // ->where('cbb_range_to', '>=', request()->cbb_range_from)
        //                                         ->where(function($q){
        //                                             $q->where('cbb_range_from', '<=', request()->cbb_range_from)
        //                                             ->where('cbb_range_to', '>=', request()->cbb_range_from);
        //                                         })
        //                                         ->first();

        
        // dd($startDate);

        $quotaCreditGroup = new QuotaCreditGroup;
        $quotaCreditGroup->item_id           = $item->item_id;
        $quotaCreditGroup->item_code         = $item->item_code;
        $quotaCreditGroup->item_description  = $item->ecom_item_description;
        $quotaCreditGroup->quota_group_code  = request()->quota_group_code;
        $quotaCreditGroup->credit_group_code = request()->credit_group_code;
        $quotaCreditGroup->program_code      = 'OMS0023';
        $quotaCreditGroup->created_by        = $user->user_id;
        $quotaCreditGroup->last_updated_by   = $user->user_id;
        $quotaCreditGroup->start_date        = $startDate;
        $quotaCreditGroup->end_date          = $endDate;
        $quotaCreditGroup->save();

        return redirect()->route('om.settings.quota-credit-group.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
    }

    public function edit($id)
    {
        $quotaCreditGroup = QuotaCreditGroup::find($id);
        $items  = SequenceEcom::when('start_date' != '', function ($q) {
                        return $q->where('start_date', '<=', date("Y-m-d"));
                    })
                    ->when('end_date' != '', function ($q) {
                        return $q->where('end_date', '>=', date("Y-m-d"));
                    })
                    ->orWhere('start_date', null)
                    ->orWhere('end_date', null)
                    ->where('sale_type_code', 'DOMESTIC')
                    ->orderBy('item_code', 'asc')
                    ->get();
                    
        $quotaGroups   = QuotaGroup::all();
        $creditGroups  = CreditGroup::all();

        return view('om.settings.quota-credit-group.edit', compact('quotaCreditGroup', 'items', 'quotaGroups', 'creditGroups'));
    }

    public function update(Request $request, $id)
    {
        request()->validate([
            'item_id'            => 'required',
            // 'quota_group_code'   => 'required',
            'credit_group_code'  => 'required',
        ], [
            'item_id.required'            => 'เลือก Item',
            // 'quota_group_code.required'   => 'เลือก กลุ่มโควต้า',
            'credit_group_code.required'  => 'เลือก กลุ่มวงเงินเขื่อ',
        ]);
        
        $user = auth()->user();
        $item = SequenceEcom::where('item_id', request()->item_id)->first();

        // $startDate       = request()->start_date ? date('Y-M-d', strtotime(request()->start_date)) : '';
        // $endDate         = request()->end_date   ? date('Y-M-d', strtotime(request()->end_date))   : '';
        $startDate = request()->start_date ? parseFromDateTh(request()->start_date) : '';
        $endDate   = request()->end_date   ? parseFromDateTh(request()->end_date)   : '';
        
        if (!$endDate) {
            // dd('xxx');
            $old = QuotaCreditGroup::where('item_id', request()->item_id)
                                    ->where('quota_credit_id', '!=', $id)
                                    ->whereNull('end_date')
                                    ->orderBy('quota_credit_id', 'desc')
                                    ->first();
            
            if ($old) {
                request()->validate([
                    'check_duplicate'            => 'required',
                ], [
                    'check_duplicate.required'            => 'ไม่สามารถเลือกผลิตภัณฑ์เดียวกันในช่วงเวลาซ้ำซ้อนกับในระบบ',
                ]);
            }
            
        }
        
        $old = QuotaCreditGroup::where('item_id', request()->item_id)
                                ->where('quota_credit_id', '!=', $id)
                                ->where('start_date', '<=', parseFromDateTh(request()->start_date))
                                ->where('end_date', '>=', parseFromDateTh(request()->end_date))
                                ->first();
        
        $old2 = QuotaCreditGroup::where('item_id', request()->item_id)
                                ->where('quota_credit_id', '!=', $id)
                                ->where('start_date', '>=', parseFromDateTh(request()->start_date))
                                ->where('end_date', '>=', parseFromDateTh(request()->end_date))
                                ->first();

        $old3 = QuotaCreditGroup::where('item_id', request()->item_id)
                                ->where('quota_credit_id', '!=', $id)
                                ->where('start_date', '<=', parseFromDateTh(request()->end_date))
                                ->orderBy('quota_credit_id', 'desc')
                                ->first();
        
        // dd($old, $old2, $old3, parseFromDateTh(request()->end_date));

        if ($old || $old2 || $old3) {
            // $old = QuotaCreditGroup::where('item_id', request()->item_id)
            //                         ->where('quota_credit_id', '!=', $id)
            //                         ->whereNull('end_date')
            //                         ->orderBy('quota_credit_id', 'desc')
            //                         ->first();
            request()->validate([
                'check_duplicate'            => 'required',
            ], [
                'check_duplicate.required'            => 'ไม่สามารถเลือกผลิตภัณฑ์เดียวกันในช่วงเวลาซ้ำซ้อนกับในระบบ',
            ]);
        }

        // dd($old, $old2, request()->start_date, request()->end_date);

     

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

        $quotaCreditGroup = QuotaCreditGroup::find($id);
        $quotaCreditGroup->item_id           = $item->item_id;
        $quotaCreditGroup->item_code         = $item->item_code;
        $quotaCreditGroup->item_description  = $item->ecom_item_description;
        $quotaCreditGroup->quota_group_code  = request()->quota_group_code;
        $quotaCreditGroup->credit_group_code = request()->credit_group_code;
        $quotaCreditGroup->last_updated_by   = $user->user_id;
        $quotaCreditGroup->start_date        = $startDate;
        $quotaCreditGroup->end_date          = $endDate;
        $quotaCreditGroup->save();

        return redirect()->route('om.settings.quota-credit-group.index')->with('success', 'แก้ไขข้อมูลเรียบร้อย');
    }
}
