<?php

namespace App\Http\Controllers\PD\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PD\PtpdSimuAdditiveH;
use App\Models\PD\PtpdSimuAdditiveL;
use App\Models\PD\PtpdMixProcess;
use App\Models\PD\PtpdInstruction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PD0002ApiController extends Controller
{
    const URL_PATH = '/pd/flavor-simu_additive';
    const MOCK_PROGRAM_CODE = 'PD0002';

    public function store(Request $request)
    {
        $defaultData = (array)getDefaultData($this::URL_PATH);
        $header = [];
        $lines = [];
        $mixs = [];
        $instructions = [];

        $request_header = $request->input('header');
        $historyDescriptions = historyDescriptions();

        if ($request->input('new_simu_formula_no') != '') {
            $header_from = PtpdSimuAdditiveH::find($request->input('simu_formula_id'));

            $header = PtpdSimuAdditiveH::create([
                'simu_formula_no' => $request->input('new_simu_formula_no'),
                'description' => $header_from->description,
                'remark_formula' => $header_from->remark_formula,
                'creation_date' => Carbon::now(),
                'created_by' => $request->input('user_id'),
                'last_update_date' => Carbon::now(),
                'last_updated_by' => $request->input('user_id'),
                'simu_type' => 'FLAVOR',
                'program_code' => $defaultData['program_code'] ? : $this::MOCK_PROGRAM_CODE
            ]);

            foreach($header_from->lines()->get() as $line_from) {
                $lines[] = $header->lines()->create([
                    'raw_material_id' => $line_from['raw_material_id'],
                    'raw_material_num' => $line_from['raw_material_num'],
                    'description' => $line_from['description'],
                    'actual_qty' => $line_from['actual_qty'],
                    'actual_uom' => $line_from['actual_uom'],
                    'actual_cost' => $line_from['actual_cost'],
                    'created_by' => $request->input('user_id'),
                    'last_updated_by' => $request->input('user_id'),
                    'program_code' => $defaultData['program_code'] ? : $this::MOCK_PROGRAM_CODE
                ]);
            }

            foreach($header_from->mixs()->get() as $mix_from) {
                $mixs[] = $header->mixs()->create([
                    'mix_no' => $mix_from['mix_no'],
                    'mix_desc' => $mix_from['mix_desc'],
                    'created_by' => $request->input('user_id'),
                    'last_updated_by' => $request->input('user_id'),
                    'program_code' => $defaultData['program_code'] ? : $this::MOCK_PROGRAM_CODE
                ]);
            }

            foreach($header_from->instructions()->get() as $instruction_from) {
                $instructions[] = $header->instructions()->create([
                    'instruction_no' => $instruction_from['instruction_no'],
                    'instruction_desc' => $instruction_from['instruction_desc'],
                    'created_by' => $request->input('user_id'),
                    'last_updated_by' => $request->input('user_id'),
                    'program_code' => $defaultData['program_code'] ? : $this::MOCK_PROGRAM_CODE
                ]);
            }
        } else {
            $header = PtpdSimuAdditiveH::create([
                'simu_formula_no' => $request_header['simu_formula_no'],
                'description' => $request_header['description'],
                'remark_formula' => $request_header['remark_formula'],
                'creation_date' => Carbon::now(),
                'last_update_date' => Carbon::now(),
                'created_by' => $request->input('user_id'),
                'last_updated_by' => $request->input('user_id'),
                'simu_type' => 'FLAVOR',
                'program_code' => $defaultData['program_code'] ? : $this::MOCK_PROGRAM_CODE
            ]);

            foreach($request->input('lines') as $line) {
                $lines[] = $header->lines()->create([
                    'raw_material_id' => $line['raw_material_id'],
                    'raw_material_num' => $line['raw_material_num'],
                    'description' => $line['description'],
                    'actual_qty' => $line['actual_qty'],
                    'actual_uom' => $line['actual_uom'],
                    'actual_cost' => $line['actual_cost'],
                    'created_by' => $request->input('user_id'),
                    'last_updated_by' => $request->input('user_id'),
                    'program_code' => $defaultData['program_code'] ? : $this::MOCK_PROGRAM_CODE
                ]);
            }

            $no = 1;
            foreach($request->input('mixs') as $mix) {
                $mixs[] = $header->mixs()->create([
                    'mix_no' => $no,
                    'mix_desc' => $mix['mix_desc'],
                    'created_by' => $request->input('user_id'),
                    'last_updated_by' => $request->input('user_id'),
                    'program_code' => $defaultData['program_code'] ? : $this::MOCK_PROGRAM_CODE
                ]);
                $no += 1;
            }


            $no = 1;
            foreach($request->input('instructions') as $instruction) {
                $instructions[] = $header->instructions()->create([
                    'instruction_no' => $no,
                    'instruction_desc' => $instruction['instruction_desc'],
                    'created_by' => $request->input('user_id'),
                    'last_updated_by' => $request->input('user_id'),
                    'program_code' => $defaultData['program_code'] ? : $this::MOCK_PROGRAM_CODE
                ]);

                $no += 1;
            }
        }

        $lines = DB::SELECT("SELECT DISTINCT L.SIMU_FORMULA_LINE_ID,
                                        L.RAW_MATERIAL_ID,
                                        L.RAW_MATERIAL_NUM,
                                        RM.DESCRIPTION,
                                        L.ACTUAL_QTY,
                                        L.ACTUAL_UOM,
                                        L.ACTUAL_COST,
                                        RM.STATUS,
                                        RM.PRICE_PER_UNIT,
                                        RM.UOM,
                                        U.UNIT_OF_MEASURE UOM_DISPLAY
                                        FROM OAPD.PTPD_SIMU_ADDITIVE_L L
                                        LEFT JOIN  OAPD.PTPD_RAW_MATE_FLAVOR_V RM
                                        ON RM.ITEM_CODE = L.RAW_MATERIAL_NUM
                                        LEFT JOIN  APPS.MTL_UNITS_OF_MEASURE_VL U
                                        ON U.UOM_CODE = RM.UOM
                                        WHERE L.simu_formula_id = '$header->simu_formula_id'
                                        ");

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

        if(User::where('user_id', $header->created_by)->first() !== null){
            $created_by = User::where('user_id', $header->created_by)->first()->name;
        }else{
            $created_by = "";
        }

        if(User::where('user_id', $header->last_updated_by)->first() !== null){
            $last_updated_by = User::where('user_id', $header->last_updated_by)->first()->name;
        }else{
            $last_updated_by = "";
        }

        return response()->json([
            'headers' => $headers,
            'header' => $header,
            'lines' => $lines,
            'mixs' => $mixs,
            'instructions' => $instructions,
            'histories' => [],
            'created_by' => $created_by,
            'last_updated_by' => $last_updated_by,
            'historyDescriptions'   => $historyDescriptions
        ]);
    }

    public function show($id)
    {
        $historyDescriptions = historyDescriptions();
        $header = PtpdSimuAdditiveH::where('simu_formula_id', $id)->first();
        $org = findOrg("A12"); // แก้จาก M12  to A12 

        $lines = DB::SELECT("SELECT DISTINCT L.SIMU_FORMULA_LINE_ID,
                                        L.RAW_MATERIAL_ID,
                                        L.RAW_MATERIAL_NUM,
                                        RM.inventory_item_id,
                                        RM.DESCRIPTION,
                                        L.ACTUAL_QTY,
                                        L.ACTUAL_UOM,
                                        L.ACTUAL_COST,
                                        RM.STATUS,
                                        RM.PRICE_PER_UNIT,
                                        RM.UOM,
                                        RM.organization_id,
                                        U.UNIT_OF_MEASURE UOM_DISPLAY
                                        FROM OAPD.PTPD_SIMU_ADDITIVE_L L
                                        LEFT JOIN  OAPD.PTPD_RAW_MATE_FLAVOR_V RM
                                        ON RM.ITEM_CODE = L.RAW_MATERIAL_NUM
                                        LEFT JOIN  APPS.MTL_UNITS_OF_MEASURE_VL U
                                        ON U.UOM_CODE = RM.UOM
                                        WHERE L.simu_formula_id = '$id'
                                        ");

        $items = implode(', ', collect($lines)->pluck('inventory_item_id')->toArray());
        $uoms = collect(DB::select("SELECT UOM.INVENTORY_ITEM_ID,
                    UOM.ORGANIZATION_ID,
                    UOM.FROM_UOM_CODE CODE,
                    UOM.CONVERSION_RATE,
                    UOM.TO_UOM_CODE,
                    UOM.FROM_UNIT_OF_MEASURE UOM_DISPLAY
                    FROM PTPM_ITEM_CONV_UOM_V UOM
                    JOIN PTPD_RAW_MATE_FLAVOR_V RAW_MAT
                    ON RAW_MAT.INVENTORY_ITEM_ID = UOM.INVENTORY_ITEM_ID
                    AND RAW_MAT.ORGANIZATION_ID = UOM.ORGANIZATION_ID
                    AND UOM.INVENTORY_ITEM_ID in ($items)
                    ORDER BY UOM.FROM_UOM_CODE"));

 
        foreach ($lines as $key => $line) {
            $check  =  $uoms
            ->where('inventory_item_id', $line->inventory_item_id)
            ->where('organization_id' , $line->organization_id)
            ->where('code', $line->actual_uom);
            if(count($check) == 0){
                $line->actual_uom = "";
            }
        }

        $mixs = DB::table('ptpd_mix_process')
                    ->select('mix_id', 'mix_desc')
                    ->where('simu_formula_id', $id)
                    ->orderBy('mix_id')
                    ->get();

        $instructions = DB::table('ptpd_instruction')
                            ->select('instruction_id', 'instruction_desc')
                            ->where('simu_formula_id', $id)
                            ->orderBy('instruction_id')
                            ->get();

        $histories = DB::table('ptpd_simu_additive_history')
                        ->select('simu_for_history_id', 'edit_by', 'edit_date', 'edit_field', 'edit_no', 'old_data', 'new_data')
                        ->where('simu_formula_id', $id)
                        ->where('edit_field', '!=', 'actual_cost')
                        ->orderBy('edit_no', 'DESC')
                        ->get();

        //$created_by = User::where('user_id', $header->created_by)->first()->name;

        if(User::where('user_id', $header->created_by)->first() !== null){
            $created_by = User::where('user_id', $header->created_by)->first()->name;
        }else{
            $created_by = "";
        }

        if(User::where('user_id', $header->last_updated_by)->first() !== null){
            $last_updated_by = User::where('user_id', $header->last_updated_by)->first()->name;
        }else{
            $last_updated_by = "";
        }

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
        $uomTypeNormal = collect($uoms)
                        ->whereIn('code', $normalUoms->pluck('uom_code'))
                        ->unique('code');

        $arr = [];
        foreach ($uomTypeNormal as $key => $value) {
            $arr[] = [
                'inventory_item_id' => $value->inventory_item_id ,
                'organization_id' => $value->organization_id ,
                'code' => $value->code ,
                'conversion_rate' => $value->conversion_rate,
                'to_uom_code' => $value->to_uom_code,
                'uom_display' => $value->uom_display
            ];
        }

        return response()->json([
            'created_by' => $created_by,
            'last_updated_by' => $last_updated_by,
            'header' => $header,
            'lines' => $lines,
            'mixs' => $mixs,
            'instructions' => $instructions,
            'histories' => $histories,
            'historyDescriptions' => $historyDescriptions,
            'uoms_data' => $uoms,
            'uom_type_normal' => $arr
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        $historyDescriptions = historyDescriptions();
        $request_header = $request->input('header');
        $header = PtpdSimuAdditiveH::find($id);
        $header->description = $request_header['description'];
        $header->remark_formula = $request_header['remark_formula'];
        $header->last_update_date = Carbon::now();
        $header->last_updated_by =  $request->input('user_id');
        $header->save();

        $lines = [];
        foreach($request->input('lines') as $line) {
            $lines[] = $header->lines()->updateOrCreate([
                'simu_formula_line_id' => isset($line['simu_formula_line_id']) ? $line['simu_formula_line_id']: '',
            ],
            [
                'raw_material_id' => $line['raw_material_id'],
                'raw_material_num' => $line['raw_material_num'],
                'description' => $line['description'],
                'actual_qty' => $line['actual_qty'],
                'actual_uom' => $line['actual_uom'],
                'actual_cost' => $line['actual_cost'],
                'created_by' => $request->input('user_id'),
                'last_updated_by' => $request->input('user_id'),
            ]);
        }

        $mixs = [];
        $no = 1;
        foreach($request->input('mixs') as $mix) {
            $mixs[] = $header->mixs()->updateOrCreate([
                'mix_no' => $no,
            ],[
                'mix_desc' => $mix['mix_desc'],
                'created_by' => $request->input('user_id'),
                'last_updated_by' => $request->input('user_id'),
            ]);
            $no += 1;
        }

        $instructions = [];
        $no = 1;
        foreach($request->input('instructions') as $instruction) {
            $instructions[] = $header->instructions()->updateOrCreate([
                'instruction_no' => $no,
            ],[
                'instruction_desc' => $instruction['instruction_desc'],
                'created_by' => $request->input('user_id'),
                'last_updated_by' => $request->input('user_id'),
            ]);
            $no += 1;
        }

        DB::commit();

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

//        $lines = DB::table('ptpd_simu_additive_l')
//                    ->join('ptpd_raw_mate_CASING_v', 'ptpd_raw_mate_CASING_v.item_code', '=', 'ptpd_simu_additive_l.raw_material_num')
//                    ->select('simu_formula_line_id', 'raw_material_id', 'raw_material_num', 'ptpd_simu_additive_l.description', 'actual_qty', 'actual_uom', 'actual_cost', 'ptpd_raw_mate_CASING_v.status', 'ptpd_raw_mate_CASING_v.price_per_unit', 'ptpd_raw_mate_CASING_v.uom')
//                    ->where('simu_formula_id', $header->simu_formula_id)
//                    ->get();

        $lines = DB::SELECT("SELECT DISTINCT L.SIMU_FORMULA_LINE_ID,
                                        L.RAW_MATERIAL_ID,
                                        L.RAW_MATERIAL_NUM,
                                        RM.DESCRIPTION,
                                        L.ACTUAL_QTY,
                                        L.ACTUAL_UOM,
                                        L.ACTUAL_COST,
                                        RM.STATUS,
                                        RM.PRICE_PER_UNIT,
                                        RM.UOM,
                                        U.UNIT_OF_MEASURE UOM_DISPLAY
                                        FROM OAPD.PTPD_SIMU_ADDITIVE_L L
                                        LEFT JOIN  OAPD.PTPD_RAW_MATE_FLAVOR_V RM
                                        ON RM.ITEM_CODE = L.RAW_MATERIAL_NUM
                                        LEFT JOIN  APPS.MTL_UNITS_OF_MEASURE_VL U
                                        ON U.UOM_CODE = RM.UOM
                                        WHERE L.simu_formula_id = '$header->simu_formula_id'
                                        ");


        if(User::where('user_id', $header->created_by)->first() !== null){
            $created_by = User::where('user_id', $header->created_by)->first()->name;
        }else{
            $created_by = "";
        }

        if(User::where('user_id', $header->last_updated_by)->first() !== null){
            $last_updated_by = User::where('user_id', $header->last_updated_by)->first()->name;
        }else{
            $last_updated_by = "";
        }
        $result = $this->interface($header->simu_formula_id);
        if ($result['status'] != 'S' && $result['status'] != 'C') {
            return response()->json(['error_message' => $result['msg']. "เกิดข้อผิดพลาตการอัพเดท ข้อมูลในสูตร"]);
        }

        return response()->json([
            'created_by' => $created_by,
            'last_updated_by' => $last_updated_by,
            'headers' => $headers,
            'header' => $header,
            'lines' => $lines,
            'mixs' => $mixs,
            'instructions' => $instructions,
            'histories' => $header->history()->where('edit_field', '!=', 'actual_cost')->orderBy('edit_no', 'DESC')->get(),
            'historyDescriptions' => $historyDescriptions
        ]);
    }

    public function remove_lines(Request $request)
    {
        if($request->input('data_type') === 'lines') {
            foreach($request->input('id') as $id) {
                $line = PtpdSimuAdditiveL::find($id);
                $simuFormulaId = $line->simu_formula_id;
                if($line) {
                    $line->delete();
                }
            }

            $result = $this->interface($simuFormulaId);
            if ($result['status'] != 'S' && $result['status'] != 'C') {
                return response()->json(['error_message' => $result['msg'] . "เกิดข้อผิดพลาตการอัพเดท ข้อมูอในสูตร"]);
            }
        }
        DB::beginTransaction();
        if($request->input('data_type') === 'mixs') {
            foreach($request->input('id') as $id) {
                $mix = PtpdMixProcess::find($id);
                if($mix) {
                    $mix->delete();
                }
            }
        }
        if($request->input('data_type') === 'instructions') {
            foreach($request->input('id') as $id) {
                $instruction = PtpdInstruction::find($id);
                if($instruction) {
                    $instruction->delete();
                }
            }
        }
        DB::commit();
        return response()->json();
    }


    function interface($simuFormulaId)
    {
        $db     =   \DB::connection('oracle')->getPdo();
        $sql    =   "
            DECLARE
                V_FLAG                      VARCHAR2(250);
                V_ERR_MSG                   VARCHAR2(4000);
            BEGIN
                PTPD_CAS_FLA_UP_FORMULA_PKG.MAIN (P_SIMU_FORMULA_ID   => $simuFormulaId
                                                  ,P_SIMU_TYPE        => 'FLAVOR'
                                                  ,P_INTERFACE_STATUS => :V_FLAG
                                                  ,P_INTERFACE_MSG    => :V_ERR_MSG );
                dbms_output.put_line('V_FLAG = '|| :V_FLAG);
                dbms_output.put_line('V_ERR_MSG = '|| :V_ERR_MSG);
            END ;
        ";

        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':V_FLAG', $result['status'], \PDO::PARAM_STR, 10);
        $stmt->bindParam(':V_ERR_MSG', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->execute();
        return $result;
    }
}
