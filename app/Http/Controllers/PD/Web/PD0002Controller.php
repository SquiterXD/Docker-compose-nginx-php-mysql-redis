<?php

namespace App\Http\Controllers\PD\Web;

use App\Models\PD\Lookup\PtpdRawMateFlavorV;
use App\Models\PD\PtpdSimuAdditiveH;
use Illuminate\Support\Facades\DB;

class PD0002Controller extends BaseController
{

    public function index()
    {
        $data = [];
        // $data['program_code'] = "PDP0001";
        // $data['title'] = 'PDP0002 : Flavor No.';
        // $data['description'] = 'จำลองและคำนวณต้นทุน / Flavor No.';
        $url = "/pd/flavor-simu-additive";
        $menu = getMenu($url);
        // $data['program_code'] = "PDP0001";
        // $data['title'] = 'PDP0001 : Casing No.';
        // $data['description'] = 'จำลองและคำนวณต้นทุน / Casing No.';
        $data['title'] = "$menu->program_code : $menu->menu_title";
        $data['description'] = $menu->menu_title;

        // $org = findOrg("A12");
        $org = findOrg("A12"); // แก้จาก M12  to A12 
        // get header
        $headers = PtpdSimuAdditiveH::where('simu_type', 'FLAVOR')
                        ->selectRaw("simu_formula_id,
                        simu_formula_no, description,
                        remark_formula,
                        to_char(creation_date, 'yyyy-mm-dd') creation_date,
                        created_by,
                        to_char(last_update_date, 'yyyy-mm-dd') last_update_date,
                        last_updated_by")
                        ->orderBy('simu_formula_no')
                        ->get();

        // get data for lookup
        //$raw_materials = PtpdRawMateFlavorV::orderBy('item_code')->get();
        $raw_materials = DB::SELECT("SELECT RM.*, U.UNIT_OF_MEASURE uom_display
                                            FROM OAPD.PTPD_RAW_MATE_FLAVOR_V RM
                                            LEFT JOIN  APPS.MTL_UNITS_OF_MEASURE_VL U
                                            ON U.UOM_CODE = RM.UOM
                                                WHERE RM.organization_id = '$org->organization_id'
                                                OR RM.status  ='จำลอง'
                                            ORDER BY RM.ITEM_CODE");

        // $uoms = DB::select('SELECT UOM.INVENTORY_ITEM_ID,
        //                                    UOM.ORGANIZATION_ID,
        //                                    UOM.FROM_UOM_CODE CODE,
        //                                    UOM.CONVERSION_RATE,
        //                                    UOM.TO_UOM_CODE,
        //                                    UOM.FROM_UNIT_OF_MEASURE UOM_DISPLAY
        //                             FROM PTPM_ITEM_CONV_UOM_V UOM
        //                             JOIN PTPD_RAW_MATE_FLAVOR_V RAW_MAT
        //                             ON RAW_MAT.INVENTORY_ITEM_ID = UOM.INVENTORY_ITEM_ID
        //                             AND RAW_MAT.ORGANIZATION_ID = UOM.ORGANIZATION_ID
        //                             ORDER BY UOM.FROM_UOM_CODE');
        // $normalUoms = collect(DB::select("select unit_of_measure,
        //         uom_code,
        //         uom_class,
        //         base_uom_flag,
        //         unit_of_measure_tl
        //             from MTL_UNITS_OF_MEASURE_VL
        //             where uom_class  = 'ทั่วไป'
        //             and base_uom_flag = 'N'
        //             order by uom_code
        //         "));

        //     $uomTypeNormal =  collect($uoms)
        //         ->whereIn('code', $normalUoms->pluck('uom_code'))
        //         ->unique('code');
        // $arr = [];

        // foreach ($uomTypeNormal as $key => $value) {
        //     $arr[] =     [
        //         'inventory_item_id' => $value->inventory_item_id ,
        //         'organization_id' => $value->organization_id ,
        //         'code' => $value->code ,
        //         'conversion_rate' => $value->conversion_rate,
        //         'to_uom_code' => $value->to_uom_code,
        //         'uom_display' => $value->uom_display
        //     ];
        // }

        return $this->vue('pd0002', [
            'btn' => trans('btn'),
            'default_data' => getDefaultData(),
            'headers_data' => $headers,
            'raw_materials_data' => $raw_materials,
            'profile' => (object)$data
            // 'uoms_data' => $uoms,
            // 'uom_type_normal' => $arr
        ]);
    }
}
