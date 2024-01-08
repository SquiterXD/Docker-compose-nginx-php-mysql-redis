<?php

namespace App\Http\Controllers\CT\Reports;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\CT\PtctCtr1050t;
use Carbon\Carbon;
use PDF;

class CTR1050Controller extends Controller
{
    public function export($programCode, Request $request)
    {
    	// dd($request->all());
    	// Add export by product : Piyawut 20221223
    	$product_type = $request->product_type == 'no'? 'N': 'Y';
        $date_from = Carbon::createFromFormat('d/m/Y', $request->date_from)->format('Y-m-d');
		$date_to = Carbon::createFromFormat('d/m/Y', $request->date_to)->format('Y-m-d');
		$cost_code = $request->cost_code ?? '';

		$oneDate = $date_from === $date_to;
		$type = $oneDate ? 'DAY' : 'MONTH';
		$batch_no = getGroupID().'-'.uniqid();

		$attempt = (int)DB::select('select OACT.PTCT_CTR1050_RPT_S.NEXTVAL from DUAL')[0]->nextval;

		$db		=   DB::connection('oracle')->getPdo();

		$sql = "
			DECLARE
			BEGIN
				PTCT_CTR1050_RPT.MAIN(
					P_DATE_FROM			=> '$date_from'
					, P_DATE_TO 		=> '$date_to'
					, P_REQUEST_ID		=> $attempt
					, P_TYPE			=> '$type'
					, P_WEB_BATCH_NO 	=> '$batch_no'
					, P_COST_CODE		=> '$cost_code'
					, P_PRODUCT_FLAG 	=> '$product_type'
				);
			END;
		";

		$stmt = $db->prepare($sql);
		$stmt->execute();
        // $batch_no = '20221126120030-63819d6e97449';

		$query = PtctCtr1050t::where('web_batch_no', $batch_no)
		->whereRaw("
			(
				nvl(receive_wip_sheet, 0) + 
				nvl(receive_wip_item, 0) +
				nvl(sum_receive_wip_234, 0) +
				nvl(sum_receive_wip_1234, 0) +
				nvl(product_qty_sheet, 0) +
				nvl(product_qty_item, 0) +
				nvl(transfer_qty_wip3, 0) +
				nvl(loss_qty, 0) +
				nvl(loss_percent, 0) +
				nvl(transfer_wip_sheet, 0) +
				nvl(transfer_wip_item, 0) +
				nvl(transfer_wip_234, 0) +
				nvl(transfer_wip_1234, 0)
			) > 0
		")
		->orderByRaw('cost_code asc, product_group asc, item_product asc, batch_no asc')->get();

		$groupByCost = $query->groupBy([
			"cost_code",
			function ($item) {
				return $item['product_group'].' : '.$item['product_group_desc'];
			}
		]);

		$maxLine = 13;
        $line_num = 0;
        $page = 0;
        $data = [];

		foreach($groupByCost as $cost_code => $groupByProductGroup){
			foreach($groupByProductGroup as $group_desc => $groups){

				if($line_num >= $maxLine){
					$line_num = 0;
					$page++;
					$data[$page]['dataAll'] = $query;
				}
				$line_num++;
				foreach ($groups as $desc => $line) {  

					$data[$page]['dataAll'] = $query;
					$data[$page]['groupData'][$cost_code][$group_desc]['end_flag'] = false;
					if($line_num >= $maxLine){
						$line_num = 1;
						$page++;
						$data[$page]['dataAll'] = $query;
					}
					$data[$page]['groupData'][$cost_code][$group_desc]['lines'][] = $line;
					$line_num++;
				}

				$data[$page]['groupData'][$cost_code][$group_desc]['end_flag'] = true;
			}
		}
		// dd($data);

		$pdf = PDF::loadView('ct.Reports.CTR1050._template', compact('product_type','query', 'attempt', 'data', 'date_from', 'date_to', 'oneDate'))
			->setPaper('a4')
			->setOrientation('landscape')
			->setOption('margin-top', 5)
			->setOption('margin-bottom', 5)
			->setOption('margin-left', 8)
			->setOption('margin-right', 8);

        return $pdf->stream($programCode. '.pdf');
    }
}
