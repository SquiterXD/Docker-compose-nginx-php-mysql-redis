<?php

namespace App\Http\Controllers\PM\Web;


use App\Http\Controllers\PM\Api\PM0011ApiController;
use App\Models\Lookup\PtBiweeklyLookup;

class PM0011Controller extends BaseController
{
    /**
     * @var PM0011ApiController
     */
    private $api;

    /**
     * PM0011Controller constructor.
     * @param PM0011ApiController $api
     */
    public function __construct(PM0011ApiController $api)
    {
        $this->api = $api;
    }


    public function index()
    {
        $user = auth()->user();
        $info = $this->api->index()->getData();

//        $thaiYears = PtBiweeklyLookup::query()
//            ->select('thai_year')
//            ->orderBy('biweekly')
//            ->distinct()
//            ->get();
//
//        $thaiMonths = PtBiweeklyLookup::query()
//            ->select('thai_month')
//            ->orderBy('biweekly')
//            ->distinct()
//            ->get();

        $biweeklyList = PtBiweeklyLookup::query()
            ->orderBy('biweekly')
            ->get();

        return $this->vue('pm0011', [
//            'thai_years' => $thaiYears,
//            'thai_months' => $thaiMonths,
            'biweekly_list' => $biweeklyList,
        ]);
    }
}
