<?php

namespace App\Http\Controllers\IR\Reports;

use App\Http\Controllers\Controller;

interface ReportInterface 
{	
	public function export($programCode, $request);
}
