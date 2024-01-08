<?php

namespace App\Http\Controllers\IR\Reports;

use App\Http\Controllers\Controller;
use App\Http\Controllers\IR\Reports\ReportInterface;
use Illuminate\Support\Facades\DB;

use PDF;
use stdClass;

class IRR9110Controller extends Controller implements ReportInterface
{
	public function export($programCode, $request)
	{
		$expenseCarGas = DB::table('ptir_expense_car_gas a')->select(DB::raw("to_char(to_date(a.period_name, 'Mon-yy'), 'MONTH yyyy', 'NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE=THAI') period_name,
											a.renew_type,
											(select group_desc 
											from PTIR_POLICY_SET_HEADERS_V
											where policy_set_header_id = a.policy_set_header_id) group_desc,
											a.department_name,
											c.vehicle_type_name,
											c.vehicle_brand_name,
											a.license_plate,
											a.expense_account,
											a.expense_account_desc,
											ROUND(a.net_amount, 2) net_amount
										"))
									->leftJoin('ptir_vehicles b', 'a.license_plate', '=', 'b.license_plate')
									->leftJoin('ptir_fa_vehicles_v c', 'b.license_plate', '=', 'c.license_plate')
									->whereRaw("to_date(a.period_name, 'Mon-yy') between to_date(regexp_substr(?,'[^ ]+', 1), 'dd/mm/yyyy') and to_date(regexp_substr(?,'[^ ]+', 1), 'dd/mm/yyyy')
											and a.renew_type_code = ?
											and a.group_code = nvl(?, a.group_code)
											and a.department_code between nvl(?, a.department_code) and nvl(?, a.department_code)
											and b.vehicle_type_code = nvl(?, b.vehicle_type_code)
											and b.vehicle_brand_code = nvl(?, b.vehicle_brand_code)
											and a.license_plate = nvl(?, a.license_plate)",[
											request()->period_from,
											request()->period_to,
											request()->renew_type,
											request()->group_code,
											request()->department_from,
											request()->department_to,
											request()->vehicle_type_code,
											request()->vehicle_brand_code,
											request()->license_plate])
									->get();
		
		$pdf = PDF::loadView('ir.reports.irr9110.pdf.index',
				compact(
				'expenseCarGas', 'programCode'
				))
			->setPaper('a4')
			->setOrientation('landscape')
			->setOption('margin-bottom', 10)
			->setOption('footer-center', 'Page [page] of [toPage]');

		return $pdf->stream($programCode. '.pdf');
	}
}
