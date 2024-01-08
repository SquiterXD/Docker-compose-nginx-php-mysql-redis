<?php

namespace App\Http\Controllers\IR\Reports;

use App\Http\Controllers\Controller;
use App\Http\Controllers\IR\Reports\ReportInterface;
use App\Models\IR\Views\PtirVehiclesView;
use Illuminate\Support\Facades\DB;

use PDF;

class IRR9040Controller extends Controller implements ReportInterface
{
	public function export($programCode, $request)
	{
		$vehicles = PtirVehiclesView::select(DB::raw("to_char(insurance_expire_date, 'MONTH yyyy', 'NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE=THAI') insurance_expire_date,
							      group_desc, 
							      insurance_type_desc,
							      vehicle_type_name,
							      vehicle_brand_name,
							      license_plate,
							      to_char(add_months(insurance_expire_date, -12), 'dd MON yyyy', 'NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE=THAI') start_date,
							      to_char(insurance_expire_date, 'dd MON yyyy', 'NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE=THAI') end_date,
							      (select description from ptgl_coa_dept_code_v where department_code = regexp_substr(account_number,'[^.]+', 1, 3)) department_name
							      "))
						->whereRaw("insurance_expire_date between to_date(regexp_substr(?,'[^ ]+', 1), 'dd/mm/yyyy') and to_date(regexp_substr(?,'[^ ]+', 1), 'dd/mm/yyyy')
							    and group_code = nvl(?, group_code)
							    and regexp_substr(account_number,'[^.]+', 1, 3) between nvl(?, regexp_substr(account_number,'[^.]+', 1, 3)) and nvl(?, regexp_substr(account_number,'[^.]+', 1, 3))
							    and insurance_type_code = nvl(?, insurance_type_code)
							    and vehicle_type_code = nvl(?, vehicle_type_code)
							    and vehicle_brand_code = nvl(?, vehicle_brand_code)
							    and license_plate = nvl(?, license_plate)", 
							    [
								request()->period_from,
								request()->period_to,
								request()->group_code,
								request()->department_from,
								request()->department_to,
								request()->insurance_type_code,
								request()->vehicle_type_code,
								request()->vehicle_brand_code,
								request()->license_plate
							    ])
						->get();
	
		$pdf = PDF::loadView('ir.reports.irr9040.pdf.index',
				compact(
				'vehicles', 'programCode'
				))
			->setPaper('a4')
			->setOrientation('landscape')
			->setOption('margin-bottom', 10)
			->setOption('footer-center', 'Page [page] of [toPage]');

		return $pdf->stream($programCode. '.pdf');
	}
}
