<?php

namespace App\Http\Controllers\OM\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\Settings\NotAutoReleaseReceipt;
use App\Models\OM\Settings\Customer;

class NotAutoReleaseReceiptController extends Controller
{
    public function index()
    {
        if (!canEnter('/om/settings/not-auto-release') || !canView('/om/settings/not-auto-release')) {
            return redirect()->back()->withError(trans('403'));
        }
        $notAutoReleases = NotAutoReleaseReceipt::orderBy('release_id', 'asc')->paginate(25);

        return view('om.settings.not-auto-release.index', compact('notAutoReleases'));
    }

    public function create()
    {
        $customers = Customer::where('sales_classification_code', 'Domestic')->where('status', 'Active')->orderBy('customer_number', 'asc')->get();

        return view('om.settings.not-auto-release.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        request()->validate([
            'customer_id'  => 'required',
        ], [
            'customer_id.required'      => 'เลือก ร้านค้า',
        ]);

        $old = NotAutoReleaseReceipt::where('customer_id', request()->customer_id)->orderBy('release_id', 'desc')->first();
        
        if ($old) {
            if ($old->end_date) {
                if (date('Y-m-d', strtotime(request()->start_date)) < date('Y-m-d', strtotime($old->end_date))) {
                    request()->validate([
                        'check_date'    => 'required',
                    ], [
                        'check_date.required'    => 'ร้านค้าเดียวกัน ไม่สามารถเลือกช่วงเวลาซ้ำกันได้',
                    ]);
                }
            } else {
                request()->validate([
                    'check_date'    => 'required',
                ], [
                    'check_date.required'    => 'ร้านค้าเดียวกัน ไม่สามารถเลือกช่วงเวลาซ้ำกันได้',
                ]);
            }
        }

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

        $notAutoRelease = new NotAutoReleaseReceipt;
        $notAutoRelease->customer_id      = request()->customer_id;
        $notAutoRelease->program_code     = 'OMS0029';
        $notAutoRelease->created_by       = $user->user_id;
        $notAutoRelease->last_updated_by  = $user->user_id;
        $notAutoRelease->start_date       = $startDate;
        $notAutoRelease->end_date         = $endDate;
        $notAutoRelease->save();

        return redirect()->route('om.settings.not-auto-release.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
    }
    
    public function edit($id)
    {
        $notAutoRelease = NotAutoReleaseReceipt::find($id);
        $customers = Customer::where('sales_classification_code', 'Domestic')->where('status', 'Active')->orderBy('customer_number', 'asc')->get();

        return view('om.settings.not-auto-release.edit', compact('notAutoRelease', 'customers'));
    }
    
    public function update(Request $request, $id)
    {
        $user = auth()->user();

        request()->validate([
            'customer_id'  => 'required',
        ], [
            'customer_id.required'      => 'เลือก ร้านค้า',
        ]);

        $old = NotAutoReleaseReceipt::where('release_id', '!=', $id)
                                    ->where('customer_id', request()->customer_id)
                                    ->orderBy('release_id', 'desc')
                                    ->first();
        
        if ($old) {
            if ($old->end_date) {
                if (date('Y-m-d', strtotime(request()->start_date)) < date('Y-m-d', strtotime($old->end_date))) {
                    request()->validate([
                        'check_date'    => 'required',
                    ], [
                        'check_date.required'    => 'ร้านค้าเดียวกัน ไม่สามารถเลือกช่วงเวลาซ้ำกันได้',
                    ]);
                }
            } else {
                request()->validate([
                    'check_date'    => 'required',
                ], [
                    'check_date.required'    => 'ร้านค้าเดียวกัน ไม่สามารถเลือกช่วงเวลาซ้ำกันได้',
                ]);
            }
        }

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

        $notAutoRelease = NotAutoReleaseReceipt::find($id);
        $notAutoRelease->customer_id      = request()->customer_id;
        $notAutoRelease->last_updated_by  = $user->user_id;
        $notAutoRelease->start_date       = $startDate;
        $notAutoRelease->end_date         = $endDate;
        $notAutoRelease->save();

        return redirect()->route('om.settings.not-auto-release.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
    }
}
