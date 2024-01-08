<?php

namespace App\Http\Controllers\PD\Web;

use App\Models\PD\Lookup\PtpdRawMateCasingV;
use App\Models\PD\PtpdSimuAdditiveH;
use Illuminate\Support\Facades\DB;

class PD0001Controller extends BaseController
{
    public function index()
    {
        $profile = getDefaultData('/pd/casing-simu-additive');
        $url = "/pd/casing-simu-additive";
        $menu = getMenu($url);
        $data = [];
        // $data['program_code'] = "PDP0001";
        // $data['title'] = 'PDP0001 : Casing No.';
        // $data['description'] = 'จำลองและคำนวณต้นทุน / Casing No.';
        $data['title'] = "$menu->program_code : $menu->menu_title";
        $data['description'] = $menu->menu_title;
        // $org = findOrg("A12");


        $org = findOrg("A12"); // แก้จาก M12  to 

        // get header
        $headers = PtpdSimuAdditiveH::where('simu_type', 'CASING')
                        ->selectRaw("simu_formula_id,
                                    simu_formula_no,
                                    description,
                                    remark_formula,
                                    to_char(creation_date, 'yyyy-mm-dd') creation_date,
                                    created_by,
                                    to_char(last_update_date, 'yyyy-mm-dd') last_update_date,
                                    last_updated_by")
                        ->orderBy('simu_formula_no')
                        ->get();

        // get data for lookup
        $raw_materials = DB::SELECT("SELECT RM.*, U.UNIT_OF_MEASURE uom_display
                                            FROM OAPD.PTPD_RAW_MATE_CASING_V RM
                                            LEFT JOIN  APPS.MTL_UNITS_OF_MEASURE_VL U
                                            ON U.UOM_CODE = RM.UOM
                                            WHERE RM.organization_id = '$org->organization_id'
                                                OR RM.status  ='จำลอง'
                                            ORDER BY RM.ITEM_CODE");

        // $uoms = DB::select('select uom.inventory_item_id,
        //                                    uom.organization_id,
        //                                    uom.from_uom_code code,
        //                                    uom.conversion_rate,
        //                                    uom.to_uom_code,
        //                                    uom.from_unit_of_measure uom_display
        //                             from ptpm_item_conv_uom_v uom
        //                             join ptpd_raw_mate_casing_v raw_mat
        //                             on raw_mat.inventory_item_id = uom.inventory_item_id
        //                             and raw_mat.organization_id = uom.organization_id
        //                             order by uom.from_uom_code');


        $normalUoms = collect(DB::select("select unit_of_measure,
                        uom_code,
                        uom_class,
                        base_uom_flag,
                        unit_of_measure_tl
                            from MTL_UNITS_OF_MEASURE_VL
                            where uom_class  = 'ทั่วไป'
                            and base_uom_flag = 'N'
                            order by uom_code
                        "));

        // $uomTypeNormal =  collect($uoms)
        //     ->whereIn('code', $normalUoms->pluck('uom_code'))
        //     ->unique('code');

            $arr = [];
            $uoms = [];
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


        return $this->vue('pd0001', [
            'btn' => $btnTrans = trans('btn'),
            'default_data' => getDefaultData(),
            'headers_data' => $headers,
            'raw_materials_data' => $raw_materials,
            // 'uoms_data' => $uoms,
            'profile' => (object)$data,
            // 'uom_type_normal' => $arr
        ]);
    }
}
