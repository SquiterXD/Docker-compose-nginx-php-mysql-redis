<?php

namespace App\Http\Controllers\PM\Web;

use App\Helpers\Utils;
use App\Http\Controllers\PM\Api\PM0022ApiController;
use Illuminate\Http\Request;

class PM0022Controller extends BaseController
{
    /**
     * @var PM0022ApiController
     */
    private $api;

    /**
     * PM0033Controller constructor.
     * @param PM0022ApiController $api
     */
    public function __construct(PM0022ApiController $api)
    {
        $this->api = $api;
    }

    public function index(Request $request)
    {
        $queryString = $request->all();
        $date = $queryString['date'] ?? null;

        if (!isset($date) || !Utils::isValidDate($date, 'Y-m-d')){
            redirect()->route('pm.ingredient-preparation-list.index', ['date' => date('Y-m-d')]);
        }

        $apiRequest = new Request([
            'date' => $date,
        ]);

        $response = $this->api->index($apiRequest);
        if (!$response->isSuccessful()){
            return $response;
        }

        $responseData = $response->getData();
        $data = [
            'daily_raw_materials' => $responseData->dailyRawMaterials,
            'date' => $responseData->date,
        ];

        return $this->vue('pm0022', $data);
    }
}
