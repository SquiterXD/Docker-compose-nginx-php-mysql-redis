<?php

namespace App\Http\Controllers\OM\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\Settings\OrderPeriodHeaders;
use App\Models\OM\Settings\OrderPeriodLines;

class OrderPeriodController extends Controller
{
    public function index()
    {
        $headers = OrderPeriodHeaders::orderBy('budget_year', 'asc')->get();
        
        // dd($header);

        return view('om.settings.order-period.index', compact('headers'));
    }

    public function create()
    {
        return view('om.settings.order-period.create');
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        // dd(request()->all());

        $old = OrderPeriodHeaders::where('budget_year', request()->budget_year - 543)->first();

        if ($old) {
            return response()->json(['message' => \Exception('ปีงบประมาณนี้มีอยู่แล้ว')]);
        }

        // \DB::beginTransaction();
        // try {
            $header = new OrderPeriodHeaders;
            $header->budget_year       = request()->budget_year - 543;
            $header->start_buget_year  = parseFromDateTh(request()->periodLists[0]['start_period']);
            $header->program_code      = 'OMS0002';
            $header->created_by        = $user->user_id;
            $header->last_updated_by   = $user->user_id;
            $header->save();

            foreach (request()->periodLists as $list) {
                $line = new OrderPeriodLines;
                $line->period_id    = $header->period_id;
                $line->period_no    = $list['period_no'];
                $line->start_period = parseFromDateTh($list['start_period']);
                $line->end_period   = parseFromDateTh($list['end_period']);
                $line->save();
            }
        //     \DB::commit();
        // }catch (\Exception $e) {
        //     \DB::rollBack();
        //     \Log::error($e->getMessage());

        //     return response()->json(['message' => \Exception($e->getMessage())]);
        // }

        // return response()->json(['data' => ['header' => $header]]);

        

        return redirect()->route('om.settings.order-period.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
    }

    public function edit($id)
    {
        dd($id);
    }

    public function update(Request $request, $id)
    {
        dd($id, request()->all());
    }
}
