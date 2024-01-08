<?php

namespace App\Repositories\Planning;

use App\Models\Planning\BiWeeklyV;
use App\Models\Planning\ProductType;
use App\Models\Planning\ProductionPlan;
use App\Models\Planning\WorkingHourV;
use App\Models\Planning\ProductionPlanMachine;


use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab1;
use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab21;
use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab22;

use App\Models\Planning\FollowUps\PtppPlanFollowMain;
use App\Models\Planning\FollowUps\PtppPlanFollowMainV;
use App\Models\Planning\ProductBiweeklyMainV;

class FollowUpRepo
{
    public function info($request)
    {
        $followMainId = -1;
        $asOfFormat = 'Y-m-d';
        $asOfDate =  date($asOfFormat); // ณ วันที่ปัจจุบัน
        // $asOfDate =  now()->addDays(1)->format($asOfFormat);
        // $asOfDate =  now()->subDays(1)->format($asOfFormat);
        $currentBiweekly = BiWeeklyV::whereRaw("TRUNC(TO_DATE('{$asOfDate}','YYYY-MM-DD')) BETWEEN START_DATE AND END_DATE")->first();

        $follow = PtppPlanFollowMainV::where('biweekly_id', $currentBiweekly->biweekly_id)->first();

        if (is_null($follow)) {
            $header = ProductBiweeklyMainV::isApproved()
                        ->where('biweekly_id', $currentBiweekly->biweekly_id)
                        ->orderBy('product_main_id', 'desc')
                        ->first();

            $profile = getDefaultData('/planning/follow-ups/-1');
            $sysdate = now();
            $newFollowUp = new PtppPlanFollowMain;
            $newFollowUp->biweekly_id       = $currentBiweekly->biweekly_id;
            $newFollowUp->day_for_sale      = $currentBiweekly->day_for_sale;

            // $newFollowUp->program_code       = $profile->program_code ?? 'PPP0006';
            $newFollowUp->program_code       = 'PPP0006';
            $newFollowUp->created_by_id      = $profile->user_id;
            $newFollowUp->updated_by_id      = $profile->user_id;
            $newFollowUp->created_by         = $profile->fnd_user_id;
            $newFollowUp->last_updated_by    = $profile->fnd_user_id;

            $newFollowUp->created_at         = $sysdate;
            $newFollowUp->updated_at         = $sysdate;
            $newFollowUp->last_update_date   = $sysdate;
            $newFollowUp->creation_date      = $sysdate;
            $newFollowUp->save();

            $follow = $newFollowUp;
            $result = (new PtppPlanFollowMain)->followPackage($newFollowUp, $asOfDate);
            logger($result);
        }

        if ($follow) {
            $followMainId = $follow->follow_main_id;

            $product = $follow->products->first();
            $checkAsOfDate = null;
            if ($product && $product->as_of_date) {
                $checkAsOfDate = $product->as_of_date->format($asOfFormat);
            }
            if ($checkAsOfDate != $asOfDate) {
                $result = (new PtppPlanFollowMain)->followPackage($follow, $asOfDate);
                logger($result);
            }
        }


        $followUp = (new PtppPlanFollowMainV)->getFindWithData($followMainId);

        // Modaul Search
        $modalSearchInput = (object) [
            "budget_years"  => BiWeeklyV::selectRaw('distinct thai_year')->orderBy('thai_year')->get(),
            "biweekly"     => BiWeeklyV::selectRaw('distinct biweekly, thai_year, thai_month')->orderBy('biweekly')->get()
        ];

        $url = (object)[];
        $url->ajax_follow_ups_search = route('planning.ajax.follow-ups.search');
        $url->ajax_follow_ups_get_data = route('planning.ajax.follow-ups.get-data');
        $url->get_report_follow_ups_ppr0004 = route('planning.follow-ups.ppr0004');

        $productTypes = ProductType::active()->where('lookup_code', '<>', 'KK')->get();
        $defaultInput = (object)[];
        $tag = $productTypes->where('tag', 'Y');
        if ($tag->isNotEmpty()) {
            $defaultInput->product_type = $tag->first()->lookup_code;
        } else {
            if ($productTypes->isNotEmpty()) {
                $defaultInput->product_type = $productTypes->first()->lookup_code;
            }
        }

        $data = [
            'follow_up' => $followUp,
            'product_types' => $productTypes,
            'default_input' => $defaultInput,
            'modal_search_input' => $modalSearchInput,
            'url' => $url,
        ];

        return (object) $data;
    }

}
