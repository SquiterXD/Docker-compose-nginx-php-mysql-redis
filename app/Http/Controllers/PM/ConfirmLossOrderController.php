<?php

namespace App\Http\Controllers\PM;

use App\Http\Controllers\Controller;
use App\Models\PM\PtmesProductDistribution;
use App\Models\PM\PtpmWipStep;
use Illuminate\Http\Request;
use App\Models\PM\PtmesProductHeader;
use App\Models\PM\PtmesProductHeaderv;
use App\Models\PM\PtmesProductLine;
use App\Models\PM\PtpmProductPeriod;
use Carbon\Carbon;

class ConfirmLossOrderController extends Controller
{
    public function index()
    {
        // $db     =   \DB::connection('oracle')->getPdo();
        // $sql    =   "
        //                 declare
        //                     v_status         varchar2(5);
        //                     v_err_msg        varchar2(2000);
        //                 begin
        //                     PTPM_MES_PRODUCT_PKG.mes_product_load( V_MESSAGE  => :v_err_msg
        //                                                     ,V_STATUS  => :v_status );
        //                     dbms_output.put_line('Status : ' || v_status);
        //                     dbms_output.put_line('Error : ' || v_err_msg);
        //                 end;
        //             ";
        // # $sql = preg_replace("/[\r\n]*/","",$sql);
        // \Log::info('ConfirmLossOrderController', [$sql]);
        // $stmt = $db->prepare($sql);
        // $stmt->bindParam(':v_status', $result['status'], \PDO::PARAM_STR, 10);
        // $stmt->bindParam(':v_err_msg', $result['message'], \PDO::PARAM_STR, 4000);
        // $stmt->execute();
        // \Log::info('ConfirmLossOrderController', [$result]);

        $userProfile = getDefaultData('/pm/confirm-order');
        $organization_id = $userProfile->organization_id;
        $organization_code = $userProfile->organization_code;
        $department = $userProfile->department;
//        $productHeader = PtmesProductHeaderv::all(); // For dev
        $productHeader = PtmesProductHeader::where('organization_id',$organization_id)->get(); // For production

        $url = (object)[];
        $url->ajax_get_distributions = route('pm.ajax.confirm-order.get-distributions');
        $url->ajax_get_wipstep = route('pm.ajax.confirm-order.get-wipstep');
        $url->ajax_get_lines = route('pm.ajax.confirm-order.get-lines');
        $url->ajax_get_search = route('pm.ajax.confirm-order.get-search');
        $url->ajax_get_headers_by_date = route('pm.ajax.confirm-order.get-headers-by-date');
        $url->ajax_update_orders = route('pm.ajax.confirm-order.update-orders');
        $url->ajax_fetch_lov = route('pm.ajax.confirm-order.fetch-lov-new');
        $product_period = PtpmProductPeriod::where('organization_id', $organization_code)->get();
        $now = array();
        $now['value'] = Carbon::now()->addYears(543)->format('Y-m-d');
        $now['show'] = Carbon::now()->addYears(543)->format('d/m/Y');
       return view('pm.confirm-order.index',compact('now', 'productHeader', 'url','department','organization_id', 'organization_code', 'product_period'));
    }

    public function ptpmReport()
    {

    }
}
