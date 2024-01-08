<?php

namespace App\Http\Controllers\OM\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\OM\Settings\AuthoRityList;
use App\Models\OM\Settings\HrUser;

class AuthoRityListController extends Controller
{
    public function index()
    {
        if (!canEnter('/om/settings/authority-list') || !canView('/om/settings/authority-list')) {
            return redirect()->back()->withError(trans('403'));
        }
        $authorities = AuthoRityList::orderBy('employee_name', 'asc')
            ->orderBy('authority_id', 'asc')
            ->get();

        return view('om.settings.authority-list.index', compact('authorities'));
    }

    public function create()
    {
        // dd('create');
        // $employees = User::all();
        // $employees = HrUser::all();
        if (request()->ajax()) {
            $name = request()->name;
            $employees = HrUser::whereRaw("psn_name like '%$name%'")->limit(50)->get();
            return $employees;
        } else {
            $employees = HrUser::limit(10)->get();
        }

        return view('om.settings.authority-list.create', compact('employees'));
    }

    public function store(Request $request)
    {
        // dd('store', request()->all());
        $userID = auth()->user()->user_id;

        request()->validate([
            // 'authority_number'  => 'required',
            'employee_number'   => 'required',
        ], [
            'authority_number.required'  => 'ระบุ ลำดับ',
            'employee_number.required'   => 'เลือก ชื่อผู้มีอำนาจ',
        ]);

        $employee = HrUser::where('pnps_psnl_no', request()->employee_number)->first();

        // dd(request()->all(), $employee);
        
        // $startDate       = request()->start_date ? date('Y-M-d', strtotime(request()->start_date)) : '';
        // $endDate         = request()->end_date   ? date('Y-M-d', strtotime(request()->end_date))   : '';
        $startDate = request()->start_date ? parseFromDateTh(request()->start_date) : '';
        $endDate   = request()->end_date   ? parseFromDateTh(request()->end_date)   : '';

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
        // dd('store', request()->all(), $employee);

        $authority = new AuthoRityList;
        // $authority->authority_number  = request()->authority_number;
        $authority->employee_name     = $employee->psn_name;
        $authority->position_name     = request()->position_name;
        $authority->program_code      = 'OMS0024';
        $authority->created_by        = $userID;
        $authority->last_updated_by   = $userID;
        $authority->start_date        = $startDate;
        $authority->end_date          = $endDate;
        $authority->employee_number   = $employee->pnps_psnl_no;
        $authority->save();

        return redirect()->route('om.settings.authority-list.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
    }

    public function edit($id)
    {
        $authority = AuthoRityList::find($id);
        // $employees = HrUser::all();
        $employees = HrUser::where('pnps_psnl_no', $authority->employee_number)->get();

        return view('om.settings.authority-list.edit', compact('employees', 'authority'));
    }

    public function update(Request $request, $id)
    {
        $userID = auth()->user()->user_id;

        request()->validate([
            // 'authority_number'  => 'required',
            'employee_number'   => 'required',
            // 'position_name'     => 'required',
        ], [
            'authority_number.required'  => 'ระบุ ลำดับ',
            'employee_number.required'   => 'เลือก ชื่อผู้มีอำนาจ',
            // 'position_name.required'     => 'ระบุ ตำแหน่ง',
        ]);
        // dd('update', request()->all());
        // $user = User::find(request()->employee_id);
        $employee = HrUser::where('pnps_psnl_no', request()->employee_number)->first();

        // $startDate       = request()->start_date ? date('Y-M-d', strtotime(request()->start_date)) : '';
        // $endDate         = request()->end_date   ? date('Y-M-d', strtotime(request()->end_date))   : '';
        $startDate = request()->start_date ? parseFromDateTh(request()->start_date) : '';
        $endDate   = request()->end_date   ? parseFromDateTh(request()->end_date)   : '';

        if (request()->start_date && request()->end_date) {
            if (date('Y-m-d', strtotime(request()->end_date)) < date('Y-m-d', strtotime(request()->start_date))) {
                request()->validate([
                    'check_date'    => 'required',
                ], [
                    'check_date.required'    => 'ไม่สามารถเลือกวันที่สิ้นสุดน้อยกว่าวันที่เริ่มต้นได้',
                ]);
            }
        }

        $authority = AuthoRityList::find($id);
        // $authority->authority_number  = request()->authority_number;
        // $authority->employee_name     = $employee->psn_name;
        $authority->position_name     = request()->position_name;
        $authority->program_code      = 'OMS0024';
        $authority->last_updated_by   = $userID;
        $authority->start_date        = $startDate;
        $authority->end_date          = $endDate;
        // $authority->employee_number   = $employee->pnps_psnl_no;
        $authority->save();

        return redirect()->route('om.settings.authority-list.index')->with('success', 'แก้ไขข้อมูลเรียบร้อย');
    }
}
