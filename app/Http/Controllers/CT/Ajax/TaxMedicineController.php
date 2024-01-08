<?php

namespace App\Http\Controllers\CT\Ajax;

use App\Http\Controllers\Controller;
use App\Models\CT\TaxMedicine;
use App\Models\CT\PtpmItemNumberV;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaxMedicineController extends Controller
{
    /*
     *
     * ดึงข้อมูลกำหนดรหัสภาษีใบยาที่เป็นสถานะ กำหนดแล้ว
     */
    public function index()
    {
        $res = TaxMedicine::all();
        return response()->json($res);
    }

    /*
     *
     * ดึงข้อมูลกำหนดรหัสภาษีใบยาที่เป็นสถานะ กำหนดแล้ว
     */
    public function determine()
    {
        $res = TaxMedicine::all();
        return response()->json($res);
    }

    /*
     *
     * ดึงข้อมูลกำหนดรหัสภาษีใบยาที่เป็นสถานะ ยังไม่กำหนด
     */
    public function notDetermine()
    {        
        $itemNumber = TaxMedicine::select('item_number')->get()->toArray();
        $res = PtpmItemNumberV::select('item_number', 'item_desc')
            ->where('organization_code', 'A16')
            ->whereNotIn('item_number', $itemNumber)
            ->get();

        return response()->json($res);
    }

    public function store(Request $request)
    { 
        $request->validate([
            'item_number' => 'required|unique:oracle_oact.oact.ptct_tax_medicines',
            'code' => 'required',
            'name' => 'required',
        ]);

        DB::beginTransaction();
        try {
            TaxMedicine::create([
                'item_number' => $request->item_number,
                'code' => $request->code,
                'name' => $request->name,
            ]);

            DB::commit();

            return response()->json(['msg' => 'success'], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'msg' => 'error',
                'error' => $e->getMessage()
            ], 403);
        }
    }

    public function update($item_number, Request $request)
    { 
        $request->validate([
            'item_number' => 'required',
            'code' => 'required',
            'name' => 'required',
            'tax_medicine_id' => 'required'
        ]);

        $check_unique = TaxMedicine::where('tax_medicine_id', '!=' , $request->tax_medicine_id)->where('item_number', $item_number)->first();
        if ($check_unique) 
        {
            return response()->json([
                'msg' => 'error',
                'errors' => [
                    'item_number' => array('The item number has already been taken.')
                ]
            ], 403);
        }
            
        DB::beginTransaction();
        try {
            $taxMedicine = TaxMedicine::where('item_number', $item_number)->first();
            $taxMedicine->item_number = $request->item_number;
            $taxMedicine->code = $request->code;
            $taxMedicine->name = $request->name;
            $taxMedicine->save();

            DB::commit();

            return response()->json(['msg' => 'success'], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'msg' => 'error',
                'error' => $e->getMessage()
            ], 403);
        }
    }

    public function show($item_number)
    { 
        $res = TaxMedicine::where('item_number', $item_number)->first();
        return response()->json($res);
    }


}
