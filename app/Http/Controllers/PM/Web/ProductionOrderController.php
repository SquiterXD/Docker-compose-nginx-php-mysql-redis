<?php

namespace App\Http\Controllers\PM\Web;

use App\Http\Controllers\PM\Api\SampleCigarettesApiController;
use App\Models\PM\Lookup\PtpmSampleProductMesV;
use App\Models\PM\Lookup\PtinvItemcatMatgroupV;
use App\Models\PM\Lookup\PtinvOnhandQuantitiesV;
use App\Models\PM\Lookup\PtpmSampleProductV;
use App\Models\PM\Lookup\PtpmItemConvUomV;
use App\Models\PM\Lookup\PtpmItemNumberV;
use App\Models\PM\Lookup\PtpmObjectiveRequest;
use App\Models\PM\Lookup\PtpmRequestTransferStatus;
use App\Models\PM\Lookup\PtpmWipStep;
use App\Repositories\PD\RequestRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProductionOrderController extends BaseController
{

    public function index()
    {
        //return redirect()->route('pm.ProductionOrder');  
        return  $this->vue('production-order-page'
            // 'extra' => [
            // ],
        );
    } 

   
  
}
