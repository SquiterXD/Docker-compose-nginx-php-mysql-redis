<?php

namespace App\Http\Controllers\OM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
	public function export($programCode, $request)
	{
	   dd($request->all());

	}
}

