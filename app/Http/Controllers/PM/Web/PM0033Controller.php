<?php

namespace App\Http\Controllers\PM\Web;

use App\Http\Controllers\PM\Api\PM0033ApiController;
use Illuminate\Http\Request;

class PM0033Controller extends BaseController
{
    /**
     * @var PM0033ApiController
     */
    private $api;

    /**
     * PM0033Controller constructor.
     * @param PM0033ApiController $api
     */
    public function __construct(PM0033ApiController $api)
    {
        $this->api = $api;
    }

    public function index(Request $request)
    {
        $queryString = $request->all();

        $requestDate = PM0033ApiController::getDateOrDefault($queryString);
        if (!isset($requestDate)) {
            $queryString['date'] = date('Y-m-d');
            return redirect()->route('pm.confirm-stamp-using.index', $queryString);
        }

        $info = $this->api->getIndex($request)->getData();
        $data = [
            'init_stamp_usage_date' => $info->stampUsageDate,
            'init_stamp_usage_by_price_group' => $info->stampUsageByPriceGroup,
            'init_stamp_usage_by_brand' => $info->stampUsageByBrand,
            'init_stamp_usage_by_brand_by_machine' => $info->stampUsageByBrandByMachine,
            'init_validate_stamp_usage_by_brand_by_machine' => $info->validateStampUsageByBrandByMachine,
        ];

        return $this->vue('pm0033', $data);
    }
}
