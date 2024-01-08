<?php

namespace App\Http\Controllers\Planning\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Planning\Setup\PPS0012V;

// New Reuirement 22072022
class PPS0012Controller extends Controller
{
    public function index()
    {
        $profile = getDefaultData('/planning/setup/pps0012');
        $pps0012 = PPS0012V::where('enabled_flag', 'Y')->orderBy('sortby')->get();

        return view('planning.setup.pps0012.index', compact('profile', 'pps0012'));
    }

    public function show($code)
    {
        $profile = getDefaultData('/planning/setup/pps0012');
        $pps0012 = PPS0012V::where('day_code', $code)->first();

        return view('planning.setup.pps0012.show', compact('profile', 'pps0012'));
    }

    public function update(Request $request, $code)
    {
        $data = $request;
        // Validate data
        $pps0012 = PPS0012V::whereNotNull('past_days')->get();
        if ($pps0012) {
            // if (count($pps0012) >= 2 && !in_array($code, $pps0012->pluck('day_code')->toArray())) {
            //     return redirect()->back()->withInput()->with('error', 'ไม่สามารถระบุค่าปริมาณที่สั่งซื้อล่วงหน้าเพียงพอมากกว่า 2 รายการได้ กรุณาตรวจสอบ');
            // }
            if ($pps0012->whereNotIn('day_code', [$code])->sum('past_days') + $data->past_days > 7) {
                return redirect()->back()->withInput()->with('error', 'ไม่สามารถระบุค่าปริมาณที่สั่งซื้อล่วงหน้าเพียงพอเกิน 7 วันได้ กรุณาตรวจสอบ');
            }
        }

        $result = (new PPS0012V)->callPackageUpdatePPS0012($data, $code);

        if ( $result['status'] == 'C') {
            return redirect()->route('planning.setup.pps0012.index')->with('success', 'ทำการอัพเดตปริมาณที่สั่งซื้อล่วงหน้าเพียงพอเรียบร้อยแล้ว');
        }
        return redirect()->back()->withInput()->with('error', $result['msg']);
    }
}
