<?php

namespace App\Http\Controllers\Planning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\Planning\FollowUpRepo;

use App\Models\Planning\BiWeeklyV;
use App\Models\Planning\ProductType;
use App\Models\Planning\ProductionPlan;
use App\Models\Planning\WorkingHourV;
use App\Models\Planning\ProductionPlanMachine;


use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab1;
use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab21;
use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab22;

use App\Models\Planning\ProductBiweeklyMain;

use App\Models\Planning\FollowUps\PtppPlanFollowMain;
use App\Models\Planning\FollowUps\PtppPlanFollowMainV;
use App\Models\Planning\FollowUps\PtppPlanFollowProductV;

use App\Models\Planning\PtBiweeklyV;
use App\Models\PP\PtppPPR0004V;
use PDF;


class FollowUpController extends Controller
{
    public function index()
    {
        $followUpRepo = new FollowUpRepo;
        $info = $followUpRepo->info(request());

        $followUp = $info->follow_up;
        $modalSearchInput = $info->modal_search_input;
        $url = $info->url;

        // Approve P04
        $approve = ProductBiweeklyMain::where('main_type', 'BIWEEKLY')
                                    ->where('biweekly_id',  $followUp->biweekly_id)
                                    ->whereNotNull('approved_date')
                                    ->get();

        // Adjust P05 
        $adjust = ProductBiweeklyMain::where('main_type', 'ADJUSTMENT')
                                    ->where('biweekly_id',  $followUp->biweekly_id)
                                    ->orderBy('adjust_no', 'desc')
                                    ->first();

        $data = (object)[
            'product_types' => $info->product_types,
            'default_input' => $info->default_input,
            'approve_no' => count($approve),
            'adjust_no' => $adjust? $adjust->version_no: 0
        ];

        return view('planning.follow-ups.show', compact(
            'followUp', 'modalSearchInput', 'url', 'data'
        ));
    }

    public function ppr0004(Request $request)
    {
        $dateItem = $request->dateItem;
        $productType = $request->product_type;
        $programCode = 'PPR0004';
        $currentDate = date('Y-m-d');
        $queryDatas = PtppPPR0004V::where('as_of_date', $currentDate)
                                ->search($productType)
                                ->orderByRaw('stamp_code asc, item_code asc')
                                ->get()
                                ->groupBy('stamp_code');

        $fileName = 'คงคลังบุหรี่ที่อยู่ในโกดังขาย_'. date('Ymdhms');
        $pdf = PDF::loadView('pp.reports.PPR0004.index', compact('queryDatas', 'programCode', 'dateItem', 'productType'))
                    ->setPaper('a4')
                    ->setOrientation('landscape')
                    ->setOption('margin-bottom', 10);

        return $pdf->stream($fileName. '.pdf');
    }
}
