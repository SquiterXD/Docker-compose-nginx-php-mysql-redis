<?php

namespace App\Http\Controllers\OM\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\Settings\OverQuotaApproval;
use App\Models\OM\Settings\AuthoRityList;

class OverQuotaApprovalController extends Controller
{
    public function index()
    {
        $overQuotaApprovals = OverQuotaApproval::orderBy('cbb_range_from', 'asc')->paginate(25);

        return view('om.settings.over-quota-approval.index', compact('overQuotaApprovals'));
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

        return view('om.settings.over-quota-approval.create', compact('authoRityLists'));
    }

    public function store(Request $request)
    {        
        request()->validate([
            'cbb_range_from'            => 'required',
            'cbb_range_to'              => 'required',
            'authority_id3'             => 'required',
            'sales_division_id'         => 'required',
            'sales_division_additional' => 'required',
            'authority_id3_additional'  => 'required'
        ], [
            'cbb_range_from.required'               => 'โปรดระบุ ช่วงหีบ',
            'cbb_range_to.required'                 => 'โปรดระบุ ช่วงหีบ',
            'authority_id3.required'                => 'โปรดเลือก ผู้มีอำนาจอนุมัติ',
            'sales_division_id.required'            => 'โปรดเลือก กองบริหารขาย',
            'sales_division_additional.required'    => 'โปรดระบุ ตำแหน่งที่แสดงในรายงาน ของ กองบริหารขาย',
            'authority_id3_additional.required'     => 'โปรดระบุ ตำแหน่งที่แสดงในรายงาน ของ ผู้มีอำนาจอนุมัติ'
        ]);

        if(request()->authority_id1 != null){
            request()->validate([
                'authority_id1_additional'              => 'required',
            ], [
                'authority_id1_additional.required'     => 'โปรดกรอก ตำแหน่งที่แสดงในรายงาน ของ ผู้เรียนพิจารณา 1',
            ]);
        }

        if(request()->authority_id2 != null){
            request()->validate([
                'authority_id2_additional'              => 'required',
            ], [
                'authority_id2_additional.required'     => 'โปรดกรอก ตำแหน่งที่แสดงในรายงาน ของ ผู้เรียนพิจารณา 2',
            ]);
        }
         
        if (request()->cbb_range_to <= request()->cbb_range_from) {
            return redirect()->back()->with('error', 'ช่วงหีบซ้ำซ้อนกัน');
        }

        $checkOverQuotaApproval = OverQuotaApproval::where('cbb_range_from', request()->cbb_range_from)
                                               ->orWhere('cbb_range_to', '>=', request()->cbb_range_from)
                                               ->first();

        if ($checkOverQuotaApproval) {
            if ($checkOverQuotaApproval->end_date) {
                if (date('Y-m-d', strtotime(request()->start_date)) < date('Y-m-d', strtotime($checkOverQuotaApproval->end_date))) {
                    request()->validate([
                        'check_date'    => 'required',
                    ], [
                        'check_date.required'    => 'ช่องหีบเดียวกัน ไม่สามารถเลือกช่วงเวลาซ้ำกันได้',
                    ]);
                }
            } else {
                request()->validate([
                    'check_date'    => 'required',
                ], [
                    'check_date.required'    => 'ช่องหีบเดียวกัน ไม่สามารถเลือกช่วงเวลาซ้ำกันได้',
                ]);
            }
            
        }

        $startDate       = request()->start_date ? parseFromDateTh(request()->start_date) : '';
        $endDate         = request()->end_date   ? parseFromDateTh(request()->end_date)   : '';

        if (request()->start_date && request()->end_date) {
            if (date('Y-m-d', strtotime(request()->end_date)) < date('Y-m-d', strtotime(request()->start_date))) {
                request()->validate([
                    'check_date'    => 'required',
                ], [
                    'check_date.required'    => 'ไม่สามารถเลือกวันที่สิ้นสุดน้อยกว่าวันที่เริ่มต้นได้',
                ]);
            }
        }

        $user = auth()->user();

        $overQuotaApproval  = new OverQuotaApproval;
        $overQuotaApproval->cbb_range_from              = request()->cbb_range_from;
        $overQuotaApproval->cbb_range_to                = request()->cbb_range_to;
        $overQuotaApproval->authority_id1               = request()->authority_id1;
        $overQuotaApproval->authority_id2               = request()->authority_id2;
        $overQuotaApproval->authority_id3               = request()->authority_id3;
        $overQuotaApproval->sales_division_id           = request()->sales_division_id;
        $overQuotaApproval->program_code                = 'OMS0025';
        $overQuotaApproval->created_by                  = $user->user_id;
        $overQuotaApproval->last_updated_by             = $user->user_id;
        $overQuotaApproval->start_date                  = $startDate;
        $overQuotaApproval->end_date                    = $endDate;
        $overQuotaApproval->authority_id1_additional    = request()->authority_id1_additional;
        $overQuotaApproval->authority_id2_additional    = request()->authority_id2_additional;
        $overQuotaApproval->authority_id3_additional    = request()->authority_id3_additional;
        $overQuotaApproval->sales_division_additional   = request()->sales_division_additional;
        $overQuotaApproval->save();

        return redirect()->route('om.settings.over-quota-approval.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
    }

    public function edit($id)
    {
        $overQuotaApproval  = OverQuotaApproval::find($id);
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

        return view('om.settings.over-quota-approval.edit', compact('overQuotaApproval', 'authoRityLists'));
    }

    public function update(Request $request, $id)
    {
        request()->validate([
            'cbb_range_from'            => 'required',
            'cbb_range_to'              => 'required',
            'authority_id3'             => 'required',
            'sales_division_id'         => 'required',
            'sales_division_additional' => 'required',
            'authority_id3_additional'  => 'required'
        ], [
            'cbb_range_from.required'               => 'โปรดระบุ ช่วงหีบ',
            'cbb_range_to.required'                 => 'โปรดระบุ ช่วงหีบ',
            'authority_id3.required'                => 'โปรดเลือก ผู้มีอำนาจอนุมัติ',
            'sales_division_id.required'            => 'โปรดเลือก กองบริหารขาย',
            'sales_division_additional.required'    => 'โปรดระบุ ตำแหน่งที่แสดงในรายงาน ของ กองบริหารขาย',
            'authority_id3_additional.required'     => 'โปรดระบุ ตำแหน่งที่แสดงในรายงาน ของ ผู้มีอำนาจอนุมัติ'
        ]);

        if(request()->authority_id1 != null){
            request()->validate([
                'authority_id1_additional'              => 'required',
            ], [
                'authority_id1_additional.required'     => 'โปรดกรอก ตำแหน่งที่แสดงในรายงาน ของ ผู้เรียนพิจารณา 1',
            ]);
        }

        if(request()->authority_id2 != null){
            request()->validate([
                'authority_id2_additional'              => 'required',
            ], [
                'authority_id2_additional.required'     => 'โปรดกรอก ตำแหน่งที่แสดงในรายงาน ของ ผู้เรียนพิจารณา 2',
            ]);
        }
         
        if (request()->cbb_range_to <= request()->cbb_range_from) {
            return redirect()->back()->with('error', 'ช่วงหีบซ้ำซ้อนกัน');
        }

        $checkOverQuotaApproval = OverQuotaApproval::where('over_quota_id', '!=', $id)
                                                    ->where(function($q){
                                                        $q->where('cbb_range_from', '<=', request()->cbb_range_from)
                                                        ->where('cbb_range_to', '>=', request()->cbb_range_from);
                                                    })
                                                    ->first();

        if ($checkOverQuotaApproval) {
            if ($checkOverQuotaApproval->end_date) {
                if (date('Y-m-d', strtotime(request()->start_date)) < date('Y-m-d', strtotime($checkOverQuotaApproval->end_date))) {
                    request()->validate([
                        'check_date'    => 'required',
                    ], [
                        'check_date.required'    => 'ช่องหีบเดียวกัน ไม่สามารถเลือกช่วงเวลาซ้ำกันได้',
                    ]);
                }
            } else {
                request()->validate([
                    'check_date'    => 'required',
                ], [
                    'check_date.required'    => 'ช่องหีบเดียวกัน ไม่สามารถเลือกช่วงเวลาซ้ำกันได้',
                ]);
            }
            
        }

        $startDate       = request()->start_date ? parseFromDateTh(request()->start_date) : '';
        $endDate         = request()->end_date   ? parseFromDateTh(request()->end_date)   : '';

        if (request()->start_date && request()->end_date) {
            if (date('Y-m-d', strtotime(request()->end_date)) < date('Y-m-d', strtotime(request()->start_date))) {
                request()->validate([
                    'check_date'    => 'required',
                ], [
                    'check_date.required'    => 'ไม่สามารถเลือกวันที่สิ้นสุดน้อยกว่าวันที่เริ่มต้นได้',
                ]);
            }
        }


        $user = auth()->user();

        $overQuotaApproval  = OverQuotaApproval::find($id);
        $overQuotaApproval->cbb_range_from              = request()->cbb_range_from;
        $overQuotaApproval->cbb_range_to                = request()->cbb_range_to;
        $overQuotaApproval->authority_id1               = request()->authority_id1;
        $overQuotaApproval->authority_id2               = request()->authority_id2;
        $overQuotaApproval->authority_id3               = request()->authority_id3;
        $overQuotaApproval->sales_division_id           = request()->sales_division_id;
        $overQuotaApproval->program_code                = 'OMS0025';
        $overQuotaApproval->last_updated_by             = $user->user_id;
        $overQuotaApproval->start_date                  = $startDate;
        $overQuotaApproval->end_date                    = $endDate;
        $overQuotaApproval->authority_id1_additional    = request()->authority_id1_additional;
        $overQuotaApproval->authority_id2_additional    = request()->authority_id2_additional;
        $overQuotaApproval->authority_id3_additional    = request()->authority_id3_additional;
        $overQuotaApproval->sales_division_additional   = request()->sales_division_additional;
        $overQuotaApproval->save();

        return redirect()->route('om.settings.over-quota-approval.index')->with('success', 'แก้ไขข้อมูลเรียบร้อย');
    }
}
