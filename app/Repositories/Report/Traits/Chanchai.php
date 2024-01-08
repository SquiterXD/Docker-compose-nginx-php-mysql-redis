<?php

namespace App\Repositories\Report\Traits;

use App\Http\Controllers\PD\Reports\PDR1120Controller;
use App\Http\Controllers\CT\Reports\CTR1050Controller;
use App\Http\Controllers\OM\Reports\OMR0026Controller;
use App\Http\Controllers\OM\Reports\OMR0027Controller;
use App\Http\Controllers\OM\Reports\OMR0029Controller;
use App\Http\Controllers\OM\Reports\OMR0035Controller;
use App\Http\Controllers\OM\Reports\OMR0064Controller;
use App\Http\Controllers\OM\Reports\OMR0069Controller;
use App\Http\Controllers\OM\Reports\OMR0112Controller;
use App\Http\Controllers\OM\Reports\OMR0113Controller;
use App\Http\Controllers\OM\Reports\OMR0125Controller;
use App\Http\Controllers\OM\Reports\OMR0078Controller;
use App\Http\Controllers\OM\Reports\OMR0079Controller;
use App\Http\Controllers\OM\Reports\OMR0088Controller;
use App\Http\Controllers\IR\Reports\IRR0082_3Controller;
use App\Http\Controllers\IR\Reports\IRR0003_2Controller;

trait Chanchai {

	public function IRR0082_3($programCode, $request) 
	{
		return (new IRR0082_3Controller)->export($programCode, $request);
	}

	public function IRR0003_2($programCode, $request) 
	{
		return (new IRR0003_2Controller)->export($programCode, $request);
	}

    public function PDR1120($programCode, $request) 
	{
		return (new PDR1120Controller)->export($programCode, $request);
    }

	public function CTR1050($programCode, $request) 
	{
		return (new CTR1050Controller)->export($programCode, $request);
	}

	public function OMR0026($programCode, $request) 
	{
        return (new OMR0026Controller)->export($programCode, $request);
    }

	public function OMR0027($programCode, $request) 
	{
        return (new OMR0027Controller)->export($programCode, $request);
    }

	public function OMR0029($programCode, $request) 
	{
        return (new OMR0029Controller)->export($programCode, $request);
    }

	public function OMR0035($programCode, $request) 
	{
        return (new OMR0035Controller)->export($programCode, $request);
    }

	public function OMR0064($programCode, $request) 
	{
        return (new OMR0064Controller)->export($programCode, $request);
    }

	public function OMR0069($programCode, $request) 
	{
        return (new OMR0069Controller)->export($programCode, $request);
    }

	public function OMR0112($programCode, $request) 
	{
        return (new OMR0112Controller)->export($programCode, $request);
    }

	public function OMR0113($programCode, $request) 
	{
        return (new OMR0113Controller)->export($programCode, $request);
    }

	public function OMR0125($programCode, $request) 
	{
        return (new OMR0125Controller)->export($programCode, $request);
    }

	public function OMR0078($programCode, $request) 
	{
        return (new OMR0078Controller)->export($programCode, $request);
    }

	public function OMR0079($programCode, $request) 
	{
        return (new OMR0079Controller)->export($programCode, $request);
    }

	public function OMR0088($programCode, $request) 
	{
        return (new OMR0088Controller)->export($programCode, $request);
    }
}
