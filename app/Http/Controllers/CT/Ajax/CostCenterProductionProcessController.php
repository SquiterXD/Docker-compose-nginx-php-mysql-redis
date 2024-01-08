<?php

namespace App\Http\Controllers\CT\Ajax;
use App\Models\CT\CostCenterProductionProcess;
use App\Models\CT\CostCenter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use PDO;

class CostCenterProductionProcessController extends Controller
{
    /**
	 * Eager Loader Relationship
	 *
	 * @var array
	 */
	private $relationship = [
		'costCenters',
	];

    /**
     * Show the given CostCenterProductionProcess
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $cost_center_id
     * @return \Illuminate\Http\Response
     */
    public function show($cost_center_id)
    {
        // $costCenterProductionProcess = CostCenterProductionProcess::with($this->relationship)->where('cost_center_id', $cost_center_id)->get();
        
        $costCenterProductionProcess = DB::table('ptct_wip_process_v')->where('cost_code', $cost_center_id)->get();

        return response()->json($costCenterProductionProcess);
    }
    public function pkgCalling($p_routing_id, $p_oprn_id, $p_cost_code, $p_dl_absorption_rate, $p_voh_absorption_rate, $p_foh_absorption_rate) {
        $db     =  DB::connection('oracle')->getPdo();
        $result = [];
        
        // -- dbms_output.put_line('V_MESSAGE : '|| l_msg);
        // -- dbms_output.put_line('V_STATUS : '|| l_status);
        $sql = "declare
                    l_status varchar2(100);
                    l_msg varchar2(100);
                begin
                    PTCT_M005_PKG.UPDATE_DATA( p_routing_id => {$p_routing_id}
                                    ,p_oprn_id   => {$p_oprn_id}
                                    ,p_cost_code => '{$p_cost_code}'
                                    ,p_dl_absorption_rate   => '{$p_dl_absorption_rate}'
                                    ,p_voh_absorption_rate  => '{$p_voh_absorption_rate}'
                                    ,p_foh_absorption_rate => '{$p_foh_absorption_rate}'
                                    ,V_MESSAGE  => :l_msg
                                    ,V_STATUS   => :l_status
                                    );
                end;";
        $sql  = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':l_status', $result['l_status'], PDO::PARAM_STR, 3);
        $stmt->bindParam(':l_msg', $result['l_msg'], PDO::PARAM_STR,4000);
        $stmt->execute();

        return $result;
    }
    /**
     * Update the given CostCenterProductionProcess
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $cost_center_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $input = $request->all();

        DB::beginTransaction();
        try {
            foreach ($input as $key => $value) {
                $result = $this->pkgCalling($value['routing_id'], $value['oprn_id'], $value['cost_code'], $value['percen_of_wage'], $value['percen_of_cp_vc'], $value['percen_of_cp_fe']);
                // $costCenterProductionProcess = CostCenterProductionProcess::find($value['id']);
                // $costCenterProductionProcess->cc_production_process_id = $costCenterProductionProcess->cc_production_process_id;
                // $costCenterProductionProcess->percen_of_wage = $value['percen_of_wage'];
                // $costCenterProductionProcess->percen_of_cp_vc = $value['percen_of_cp_vc'];
                // $costCenterProductionProcess->percen_of_cp_fe = $value['percen_of_cp_fe'];
                // $costCenterProductionProcess->save();
            }

            DB::commit();
            return response()->json(['msg' => "success"], 200);
        } catch (\Exception $e) {
            // ERROR CREATE REIMBURSEMENT
            DB::rollBack();

            return response()->json([
                'msg' => 'error',
                'error' => $e->getMessage()
            ], 403);
        }
    }
}
