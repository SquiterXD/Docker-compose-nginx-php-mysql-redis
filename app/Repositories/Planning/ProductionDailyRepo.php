<?php 

namespace App\Repositories\Planning;

use App\Models\Planning\ProductionDaily\ProductionDailyT;
use App\Models\Planning\ProductionDaily\ProductionDailyPlan;
use App\Models\Planning\ProductionDaily\ProductionDailyMachine;
use App\Models\Planning\ProductionDaily\ItemCigarette;

use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyPlan;
use App\Models\Planning\ProductBiweeklyMain\ProductBiweeklyTab22;

use App\Models\Planning\MachineBiWeeklyHeader;
use App\Models\Planning\MachineBiWeeklyLinesV;
use App\Models\Planning\EamWorkingOrderV;
use App\Models\Planning\HolidayV;
use App\Models\Planning\BiWeeklyV;

use Carbon\Carbon;
use Illuminate\Support\Str;

class ProductionDailyRepo
{
    public function create($search, $productTypes, $biWeekly, $defaultWorkingHour, $dailyPlan = [])
    {
        // try {
            \DB::beginTransaction();
            $productMain = $search->product_main;
            // Machine BiWeekly
            $machineBiweekly = MachineBiWeeklyHeader::where('biweekly_id', $biWeekly->biweekly_id)->where('product_type', $search->product_type)->first();

            if (!$dailyPlan) {
                // Daily Plan
                $dailyPlan                     = new ProductionDailyPlan;
                $dailyPlan->res_plan_h_id      = $machineBiweekly->res_plan_h_id;
                $dailyPlan->biweekly_id        = $biWeekly->biweekly_id;
                $dailyPlan->product_type       = $search->product_type;
                $dailyPlan->as_of_date         =  date('Y-m-d');
                $dailyPlan->program_code       = 'PPP0007';
                $dailyPlan->created_at         = now();
                $dailyPlan->updated_at         = now();
                $dailyPlan->creation_date      = now();
                $dailyPlan->last_update_date   = now();
                $dailyPlan->created_by_id      = auth()->user()->user_id; //web
                $dailyPlan->created_by         = auth()->user()->fnd_user_id;
                $dailyPlan->approved_status    = 'Inactive';
                $dailyPlan->save();
            }

            $bacth_no = date('YmdHis'). Str::random(5);
            if ($search->removeItems) {
                $date_from = date('Y-m-d', strtotime($search->date_from));
                $date_to = date('Y-m-d', strtotime($search->date_to));
                foreach ($search->removeItems as $item) {
                    $daily = ProductionDailyT::where('item_code', $item['item_code'])
                                ->where('machine_group', $search->machine_group)
                                ->where('biweekly', $search->bi_weekly)
                                ->where('tran_type', strtoupper('Insert'))
                                ->orderBy('batch_no', 'desc')
                                ->first();

                    if ($daily) {
                        if ($daily->efficiency_product - $item['item_efficiency'] > 0) {
                            // ลบข้อมูลเก่าที่มีการ insert ครั้งแรกหรือก่อนลบ
                            $isStampDelDaily                   = $daily->replicate();
                            $isStampDelDaily->batch_no         = $bacth_no;
                            $isStampDelDaily->daily_id         = $dailyPlan->daily_id;
                            $isStampDelDaily->tran_type        = strtoupper('Delete');
                            $isStampDelDaily->created_at       = now();
                            $isStampDelDaily->updated_at       = now();
                            $isStampDelDaily->creation_date    = now();
                            $isStampDelDaily->last_update_date = now();
                            $isStampDelDaily->created_by_id    = auth()->user()->user_id; //web
                            $isStampDelDaily->created_by       = auth()->user()->fnd_user_id;
                            $isStampDelDaily->save();

                            $isReplicateDaily                   = $daily->replicate();
                            $isReplicateDaily->batch_no         = $bacth_no;
                            $isReplicateDaily->daily_id         = $dailyPlan->daily_id;
                            $isReplicateDaily->efficiency_product = $daily->efficiency_product - $item['item_efficiency'];
                            $isReplicateDaily->tran_type        = strtoupper('Insert');
                            $isReplicateDaily->created_at       = now();
                            $isReplicateDaily->updated_at       = now();
                            $isReplicateDaily->creation_date    = now();
                            $isReplicateDaily->last_update_date = now();
                            $isReplicateDaily->created_by_id    = auth()->user()->user_id; //web
                            $isReplicateDaily->created_by       = auth()->user()->fnd_user_id;
                            $isReplicateDaily->save();
                        }

                        $isReplicateDaily                   = $daily->replicate();
                        $isReplicateDaily->batch_no         = $bacth_no;
                        $isReplicateDaily->daily_id         = $dailyPlan->daily_id;
                        $isReplicateDaily->start_date       = parseFromDateTh($date_from);
                        $isReplicateDaily->end_date         = parseFromDateTh($date_to);
                        $isReplicateDaily->efficiency_product = $item['item_efficiency'];
                        $isReplicateDaily->tran_type        = strtoupper('Delete');
                        $isReplicateDaily->created_at       = now();
                        $isReplicateDaily->updated_at       = now();
                        $isReplicateDaily->creation_date    = now();
                        $isReplicateDaily->last_update_date = now();
                        $isReplicateDaily->created_by_id    = auth()->user()->user_id; //web
                        $isReplicateDaily->created_by       = auth()->user()->fnd_user_id;
                        $isReplicateDaily->save();
                    }
                }
            }

            $getLineNo = ProductionDailyT::where('batch_no', $bacth_no)->orderBy('line_no', 'desc')->first();
            $biWeekly = BiWeeklyV::where('biweekly_id', $biWeekly->biweekly_id)->first();
            $start_date = date('Y-m-d', strtotime($biWeekly->start_date));
            $end_date = date('Y-m-d', strtotime($biWeekly->end_date));
            $efficiency = MachineBiWeeklyLinesV::selectRaw('machine_group, machine_group_description, SUM(CASE
                WHEN nvl(efficiency_product_per_min,0) < 0 THEN 0 ELSE nvl(efficiency_product_per_min,0) END) grp_efficiency_product')
                            ->whereRaw("trunc(res_plan_date) >= TO_DATE('{$start_date}','YYYY-mm-dd')")
                            ->whereRaw("trunc(res_plan_date) <= TO_DATE('{$end_date}','YYYY-mm-dd')")
                            ->where('machine_group', $search->machine_group)
                            ->groupBy('machine_group', 'machine_group_description')
                            ->first();

            foreach ($search->items as $index => $item) {
                // Daily T
                $cigarette = ItemCigarette::selectRaw('product_type, stamp, stamp_desc, item_code, organization_id, organization_code')
                                ->where('item_code', $item['item_code'])
                                ->where('product_type', $search->product_type)
                                ->first();
                $lineNo = optional($getLineNo)->line_no ?? $index;
                $date_from = date('Y-m-d', strtotime($search->date_from));
                $date_to = date('Y-m-d', strtotime($search->date_to));
                $daily                      = new ProductionDailyT;
                $daily->batch_no            = $bacth_no;
                $daily->start_date          = parseFromDateTh($date_from);
                $daily->end_date            = parseFromDateTh($date_to);
                $daily->biweekly_id         = $biWeekly->biweekly_id;
                $daily->biweekly            = $search->bi_weekly;
                $daily->product_type        = $search->product_type;
                $daily->daily_id            = $dailyPlan->daily_id;
                $daily->machine_group       = $search->machine_group;
                $daily->line_no             = $index+1;
                $daily->item_id             = $item['item_id'];
                $daily->item_code           = $item['item_code'];
                $daily->item_description    = $item['item_description'];
                // $daily->machine_efficiency_product  = $search->efficiency_product; //efficiency_product_header
                $daily->machine_efficiency_product = optional($efficiency)->grp_efficiency_product ?? 0;
                $daily->efficiency_product  = $item['item_efficiency'];
                $daily->tran_type           = strtoupper('Insert');
                $daily->stamp               = optional($cigarette)->stamp ?? 10;
                $daily->organization_id     = $cigarette? $cigarette->organization_id: 147;
                $daily->program_code        = 'PPP0007';
                $daily->created_at          = now();
                $daily->updated_at          = now();
                $daily->creation_date       = now();
                $daily->last_update_date    = now();
                $daily->created_by_id       = auth()->user()->user_id; //web
                $daily->created_by          = auth()->user()->fnd_user_id;
                $daily->save();
            }
            $result = (new ProductionDailyMachine)->callDailyPlanUpdate($bacth_no);
            if ($result['status'] == 'E') {
                \DB::rollback();
                $data = [
                    'status' => $result['status'],
                    'msg' => $result['msg']
                ];
                return $data;
            }
            \DB::commit();
 
            $data = ['status' => 'S', 'res_plan_h_id' => $dailyPlan->res_plan_h_id];
            return $data;
        // } catch (Exception $e) {
        //     \DB::rollback();
        //     $data = [
        //         'status' => 'E',
        //         'msg' => $e->message()
        //     ];
        //     return $data;
        // }
    }
}
