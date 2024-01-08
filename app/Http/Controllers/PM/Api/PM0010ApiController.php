<?php

namespace App\Http\Controllers\PM\Api;

use App\Http\Controllers\Controller;
use App\Models\Mock;
use App\Models\PM\PtpmMesReviewCompletes;
use App\Models\PM\PtpmMesReviewCompletesV;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PM0010ApiController extends Controller
{
    public function index(Request $request)
    {
        $reviewCompletes = PtpmMesReviewCompletesV::with(['itemNumberV']);

        if ($itemNumber = $request->get('item_number')) {
            $reviewCompletes->where('item_number', $itemNumber);
        }
        if ($batchNo = $request->get('batch_no')) {
            $reviewCompletes->where('batch_no', '=', $batchNo);
        }
        if ($opt = $request->get('opt')) {
            $reviewCompletes->where('opt', $opt);
        }
        if ($planCmpltDateFrom = $request->get('plan_cmplt_date_from')) {
            $reviewCompletes->whereDate('plan_cmplt_date', '>=', $planCmpltDateFrom);
        }
        if ($planCmpltDateTo = $request->get('plan_cmplt_date_to')) {
            $reviewCompletes->whereDate('plan_cmplt_date', '<=', $planCmpltDateTo);
        }

//        print_r($reviewCompletes->toSql());
//        print_r($reviewCompletes->get()->toArray());
//        print_r(PtpmMesReviewCompletes::query()->get(['review_product_quantity'])->toArray());

        $list = [];
        foreach ($reviewCompletes->get() as $row) {
            $fromTable = PtpmMesReviewCompletes::query()
                ->where('batch_no', $row->batch_no)
                ->where('opt', $row->opt)
                ->first();
            $row->flavor_issue_flag = $row->issue_flavor_casing_flag;
            $row->tobacco_issue_flag = $row->issue_tobacco_flag;
            $row->product_quantity = $row->qty;
            $row->locator_id = $row->to_locator_id;
            $row->subinventory_code = $row->to_subinventory;
            if ($fromTable) {
                $row = array_merge($row->toArray(), $fromTable->toArray());
                $row['t'] = (object)[
                    'flavor_issue_flag' => $fromTable->flavor_issue_flag,
                    'tobacco_issue_flag' => $fromTable->tobacco_issue_flag,
                    'record_complete_flag' => $fromTable->record_complete_flag,
                ];
            }
            $list[] = (object)$row;
        }

        return response()->json([
            'reviewCompletes' => $list,
        ]);
    }

    public function search(Request $request)
    {
        return $this->index($request);
    }

    public function save(Request $request)
    {
        $reviewCompletes = $request->get('reviewCompletes');
        $results = [];
        foreach ($reviewCompletes as $reviewComplete) {

//            if ($reviewComplete['transaction_date']) {
//                $reviewComplete['transaction_date'] = DB::raw("to_date('{$reviewComplete['transaction_date']}', 'dd/mm/yyyy')");
//            } else {
//                $reviewComplete['transaction_date'] = null;
//            }

            $row = PtpmMesReviewCompletes::query()
                ->where('batch_no', $reviewComplete['batch_no'])
                ->where('opt', $reviewComplete['opt']);

            $data = [
                'batch_no' => $reviewComplete['batch_no'],
                'opt' => $reviewComplete['opt'],
                "organization_id" => $reviewComplete['organization_id'],
                "silo" => $reviewComplete['silo'],
                "batch_id" => $reviewComplete['batch_id'],
                "inventory_item_id" => $reviewComplete['inventory_item_id'],
                "subinventory_code" => $reviewComplete['subinventory_code'],
                "locator_id" => $reviewComplete['locator_id'],
                "product_quantity" => $reviewComplete['product_quantity'],
                "uom_code" => $reviewComplete['uom_code'],
                "tobacco_issue_flag" => $reviewComplete['tobacco_issue_flag'],
                "flavor_issue_flag" => $reviewComplete['flavor_issue_flag'],
                'review_product_quantity' => $reviewComplete['review_product_quantity'],
                //'transaction_date' => $reviewComplete['transaction_date'],
                //'remark_msg' => $reviewComplete['remark_msg'],
            ];

            if (isset($reviewComplete['transaction_date'])) {
                $date = date('Y-m-d', strtotime($reviewComplete['transaction_date']));
                $data['transaction_date'] = DB::raw("to_date('{$date}', 'yyyy-mm-dd')");
            }
            if (isset($reviewComplete['remark_msg'])) {
                $data['remark_msg'] = $reviewComplete['remark_msg'];
            }

            if ($row->first()) {
                $row->update($data);
                $row = $row->first();
            } else {
                $row = PtpmMesReviewCompletes::query()->create($data);
            }

            $fromView = PtpmMesReviewCompletesV::query()
                ->where('batch_no', $row->batch_no)
                ->where('opt', $row->opt)
                ->first();

            $row = array_merge($fromView->toArray(), $row->toArray());

            $results[] = (object)$row;
        }

        return response()->json([
            'reviewCompletes' => $results,
        ]);
    }
}
