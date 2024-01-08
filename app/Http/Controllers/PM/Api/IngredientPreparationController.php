<?php

namespace App\Http\Controllers\PM\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\PM\QrCodeRepository;
use App\Repositories\PM\IngredientPreparationRepository;

class IngredientPreparationController extends Controller
{
    public function index()
    {
        $user    = auth()->user();
        $orgCode = $user->organization ? $user->organization->organization_code : '';

        $dateSelected = date('Y-m-d', strtotime(request()->date_selected));
        $dataM05 = [];

        // $data = (new QrCodeRepository)->mtlPlan($user->organization_id, $dateSelected)->groupBy('oprn_desc');
        $data = (new IngredientPreparationRepository)->HeaderDetail($user->organization_id, $dateSelected)->groupBy('oprn_desc');

        if ($orgCode == 'M05') {
            $dataM05 = (new IngredientPreparationRepository)->M05Detail($dateSelected);
        }

        foreach ($data as $key => $value) {
            foreach ($value as $detail) {
                $findCal       = $this->findCal($dataM05, $detail->inventory_item_id);
                $detail->b_m05 = $findCal ? $findCal : 0;
            }
        }
       
        // dd($data, $dataM05);
        
        return response()->json([
            'data' => [
                'data'    => $data,
                'dataM05' => $dataM05,
            ]
        ]);

        // return response()->json($data);
    }

    public function getLineDetail()
    {
        // $list = request()->list;
        // dd(request()->all());
        $orgId    = request()->org_id;
        $planDate = date('d-M-Y', strtotime(request()->plan_date));
        $item     = request()->item_id;

        // $data = getLineDetail($orgId,  $planDate, $item);
        $data = (new IngredientPreparationRepository)->LineDetail($orgId,  $planDate, $item);

        // dd($data);

        return response()->json($data);
    }

    public function findCal($array, $id)
    {
        // dd('func findCal', $id);
        foreach ($array as $key => $value) {
            if ($id == $value->inventory_item_id) {
               return $value->b;
            }
        }
    }
}
