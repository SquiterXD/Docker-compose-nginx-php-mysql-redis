<?php

namespace App\Http\Controllers\CT\Ajax;

use App\Http\Controllers\Controller;
use App\Models\CT\PtpmItemNumberV;
use App\Models\CT\PtctItemTax;

use Illuminate\Http\Request;


class PtpmItemNumberVController extends Controller
{
    public function getCategory()
    {
        $res = PtpmItemNumberV::select('item_cat_code', 'item_cat_desc')
            ->groupBy('item_cat_code', 'item_cat_desc')
            ->get();

        return response()->json($res);
    }

    /*
     * ดึงข้อมูลวัตถุดิบ A16
     * 
     */
    public function getRawMaterial()
    {
        $res = PtpmItemNumberV::select('item_number', 'item_desc')
            ->where('organization_code', 'A16')
            ->get();

        return response()->json($res);
    }

    /*
     * ดึงข้อมูลรหัสวัตถุดิบภาษี A18
     * 
     */
    public function getRawMaterialTax(Request $request)
    {
        // validate data RawMaterial A16
        $data = [];
        $item = $request->item;
        $taxMedicine = PtctItemTax::where('item_number', $item)->get();
        if (count($taxMedicine) > 0) {
            $data = ['status' => 'E', 'msg' => 'มีข้อมูลวัตถุดิบ: '.$item.' ในระบบแล้ว'];
            return response()->json($data);
        }

        $split = substr($item, 4);
        $materialTax = PtpmItemNumberV::select('item_number', 'item_desc')
            ->where('item_number', 'like', '%'.$split)
            ->where('organization_code', 'A18')
            ->where('tobacco_group_code', '1080')
            ->get();

        $defaultMaterialTax = $materialTax->first();
        $data = ['status' => 'S', 'materialTax' => $materialTax, 'defaultMaterialTax' => $defaultMaterialTax];

        return response()->json($data);
    }

}
