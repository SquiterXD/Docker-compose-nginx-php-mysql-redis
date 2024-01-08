<?php

namespace App\Http\Controllers\PM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use PDF;
use DB;

use App\Repositories\PM\QrCodeRepository;
use App\Repositories\PM\IngredientPreparationRepository;

class IngredientPreparationController extends Controller
{
    public function index()
    {
        // dd('index',);
        
        return view('pm.ingredient-preparation.index');
    }

    public function printPdf()
    {
        // dd('xxxxx', request()->all());
        $user    = auth()->user();
        $orgCode = $user->organization ? $user->organization->organization_code : '';
        $dataM05 = [];
        $hasM05Data  = false;

        if (request()->item) {

            $type = 'detail';
            $item_id = request()->item;
            $planDate = date('Y-m-d', strtotime(request()->plan_date));

            $dataLists = (new IngredientPreparationRepository)->HeaderDetail($user->organization_id, $planDate);

            if ($orgCode == 'M05') {

                $dataM05 = (new IngredientPreparationRepository)->M05Detail($planDate);

                foreach ($dataLists as $key => $value) {

                    $findCal      = $this->findCal($dataM05, $value->inventory_item_id);
                    $value->b_m05 = $findCal ? $findCal : 0;

                }
            }

            $list = $dataLists->where('inventory_item_id', $item_id)->first();
            
            if ($dataM05) {
                $hasM05Data = true;
            }

            $pdf = PDF::loadView('pm.ingredient-preparation.report._template', compact('list', 'planDate', 'type', 'hasM05Data'))
                    ->setPaper('a4')
                    ->setOrientation('portrait')
                    ->setOption('margin-bottom', 0);

            return $pdf->stream('reportQrcode.pdf');

        } else {
            $type = 'summary';

            $planDate = date('Y-m-d', strtotime(request()->plan_date));
            // $dateSelected = date('Y-m-d', strtotime(request()->date_selected));

            // $dataLists = (new QrCodeRepository)->mtlPlan($user->organization_id, $planDate)->groupBy('oprn_desc');
            $dataLists = (new IngredientPreparationRepository)->HeaderDetail($user->organization_id, $planDate)->groupBy('oprn_desc');

            // dd($planDate, request()->plan_date, $dataLists,  date('Y-m-d', strtotime(request()->plan_date)));
            if ($orgCode == 'M05') {

                $dataM05 = (new IngredientPreparationRepository)->M05Detail($planDate);

                foreach ($dataLists as $key => $value) {
                    foreach ($value as $detail) {
                        $findCal       = $this->findCal($dataM05, $detail->inventory_item_id);
                        $detail->b_m05 = $findCal ? $findCal : 0;
                    }
                }
                
            }

            if ($dataM05) {
                $hasM05Data = true;
            }
            

            // dd($dataM05, $hasM05Data);

            $pdf = PDF::loadView('pm.ingredient-preparation.report._template', compact('dataLists', 'planDate', 'type', 'hasM05Data'))
                    ->setPaper('a4')
                    ->setOrientation('portrait')
                    ->setOption('margin-bottom', 0);

            return $pdf->stream('reportQrcode.pdf');
        }

        // dd($dataLists);
        
        // dd('xxxxx', request()->all());
        // dd('printPdf', now(), date('Y-m-d'));
        // $dateSelected = date('Y-m-d', strtotime(request()->date_selected));
        

        // $planDate = date('Y-m-d');

        // $dataLists = (new QrCodeRepository)->mtlPlan($user->organization_id, $planDate);

        // $pdf = PDF::loadView('pm.ingredient-preparation.report._template', compact('dataLists', 'planDate', 'type'))
        //             ->setPaper('a4')
        //             ->setOrientation('portrait')
        //             ->setOption('margin-bottom', 0);

        // return $pdf->stream('reportQrcode.pdf');
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
