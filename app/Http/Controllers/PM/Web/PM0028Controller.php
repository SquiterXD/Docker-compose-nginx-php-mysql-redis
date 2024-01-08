<?php

namespace App\Http\Controllers\PM\Web;

use App\Http\Controllers\PM\Api\PM0028ApiController;
use App\Models\Lookup\PtpmItemNumberVLookup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PM0028Controller extends BaseController
{
    /**
     * @var PM0028ApiController
     */
    private $api;

    /**
     * PM0028Controller constructor.
     * @param PM0028ApiController $api
     */
    public function __construct(PM0028ApiController $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        return redirect()->route('pm.free-products.date', ['date' => date('Y-m-d')]);
    }

    public function getProductByDate(Request $request, string $date)
    {
        if($date === 'now') :
            $date = now()->format('Y-m-d');
        endif;
        $headers = $this->api->getProductByDate($request, $date)->getData();
        $user = auth()->user();
        $defaultData = getDefaultData('/pm/free-products/');
        // $itemNumberLookUp = PtpmItemNumberVLookup::query()
        //                     ->where('ORGANIZATION_ID', $defaultData->organization_id)
        //                     ->where('INVENTORY_ITEM_STATUS_CODE', 'Active')
        //                     ->where('ENABLED_FLAG', 'Y')
        //                     ->where('ITEM_TYPE', 'FG')
        //                     ->whereNotIn('TOBACCO_TYPE_CODE', ['9999'])
        //                     ->orderBy('ITEM_NUMBER')
        //                     ->get();
        $auth = auth()->user();
        $itemNumberLookUp = DB::select("SELECT  ORGANIZATION_ID
        ,       INVENTORY_ITEM_ID
        ,       ITEM_NUMBER
        ,       ITEM_DESC
        ,       PLAN_START_DATE
        ,       PLAN_END_DATE
        FROM    PTMES_PLAN_PROCESS_DETAILS
        WHERE   1=1
        AND ITEM_NUMBER LIKE '%1501%' 
        AND organization_id = {$auth->organization_id}
        AND TO_DATE('{$date}', 'YYYY-mm-dd') between PLAN_START_DATE AND PLAN_END_DATE
        ORDER BY BIWEEKLY, ITEM_NUMBER");
        foreach($headers as $header) {
            $header->qty = number_format($header->qty,0);
        }

        if($request->api == 'callback') {
            return response()->json([
                'init_lines' => $headers,
                'user' => $user,
                'date' => $date,
                'item_number_look_up' => $itemNumberLookUp
            ]);
        }
        return $this->vue('pm0028', [
            'init_lines' => $headers,
            'user' => $user,
            'date' => $date,
            'item_number_look_up' => $itemNumberLookUp
        ]);
    }
}
