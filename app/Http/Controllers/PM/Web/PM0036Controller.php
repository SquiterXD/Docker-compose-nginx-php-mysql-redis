<?php

namespace App\Http\Controllers\PM\Web;

use App\Http\Controllers\PM\Api\PM0036ApiController;
use App\Models\Lookup\PtBiweeklyLookup;
use App\Models\Mock;
use Illuminate\Http\Request;

class PM0036Controller extends BaseController
{
    /**
     * @var PM0036ApiController
     */
    private $api;

    /**
     * PM0033Controller constructor.
     * @param PM0036ApiController $api
     */
    public function __construct(PM0036ApiController $api)
    {
        $this->api = $api;
    }

    public function index(Request $request)
    {
        $startDate = $request->get('startDate');
        $endDate = $request->get('endDate');
        $month = $request->get('month');
        $year = $request->get('year');
        $biweekly = $request->get('biweekly');

        $biweeklyList = PtBiweeklyLookup::query()
            ->orderBy('biweekly')
            ->get();

        $info = $this->api->index($request)->getData();

        $user = Mock::getMockUser();

        return $this->vue('pm0036', [
            'user' => $user,
            'biweekly_list' => $biweeklyList,
            'init_summary_batches' => $info->summaryBatches,
            'start_date' => $info->startDate,
            'end_date' => $info->endDate,
            'init_filter' => [
                'month' => $month,
                'year' => $year,
                'biweekly' => $biweekly,
            ],
        ]);
    }
}
