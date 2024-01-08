<?php

namespace App\Http\Controllers\PM;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Models\Lookup\PtpmItemClassificationsVLookup;
use App\Models\User;
use App\Models\PM\PtglCoaDeptCodeV;
use App\Models\PM\PtpmBiweeklyRequestHeaders;
use App\Models\PM\PtpmPlanningJobHeaders;
use App\Models\PM\PtpmBiweeklyRequestLines;
use App\Models\PM\PtBiweeklyV;
use App\Models\PM\Lookup\PtpmItemConvUomV;
use Exception;

class RequestMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $title = "ประมาณการวัตถุดิบรายปักษ์";
        $profile = getDefaultData('/users');
        $dep_code = $profile->organization_code;
        $orgname = $profile->organization_name;
        $orgfullname = $profile->organization_code . " " . $profile->organization_name;

        // $dep_code = $profile->department_code;
        $req_by = $profile->user_name; //fnd_user_name;
        $biweeklyTable = (new PtBiweeklyV)->getTable();
        $ptpmPlanningJobHeadersTable = (new PtpmPlanningJobHeaders)->getTable();
        $ptpmItemConvUomVTable = (new PtpmItemConvUomV)->getTable();
        $ptpmBiweeklyRequestHeadersTable = (new PtpmBiweeklyRequestHeaders)->getTable();
        $ptpmBiweeklyRequestLinesTable = (new PtpmBiweeklyRequestLines)->getTable();


        $oprn_rows = $this->getOPRN($profile->organization_code);
        $select = [
            "planning.period_year",
            "planning.period_name",
            "planning.period_year + 543 as thai_year",
            "trim(biweekly.thai_month) thai_month",
            "biweekly.biweekly",
            "biweekly.biweekly_id",
            "to_char(biweekly.start_date, 'YYYY-MM-DD') start_date",
            "to_char(biweekly.end_date, 'YYYY-MM-DD') end_date",
            "CASE  WHEN to_char(sysdate, 'YYYYMM') <= to_char(biweekly.start_date, 'YYYYMM') then 1 else 0 end AS is_disable_month"
        ];
        $lookups = DB::table("{$ptpmPlanningJobHeadersTable} AS planning");
        $lookups = $lookups->leftJoin("{$biweeklyTable} AS biweekly", "biweekly.period_year", "=", "planning.period_year", function ($join) {
            $join->on("planning.period_name", '=', "biweekly.period_name");
            $join->on("planning.biweekly", '=', "biweekly.biweekly");
        });
        $lookups = $lookups->select(DB::raw(join(",", $select)));
        $lookups = $lookups->get();
        if (count($lookups)) {
            // $lookups = $lookups->where('is_disable_month', 1);
        }
        if (count($lookups)) {
            $lookups = array_values($lookups->toArray());
        }


        $items = PtpmItemClassificationsVLookup::select('item_classification_code', 'item_classification')->get();

        $def_period_year = date('Y');
        $defPeriodData = collect(DB::select("
            select  period_year + 543 as period_thai_year
            from    pt_biweekly
            where   1=1
            and     TRUNC(SYSDATE)  BETWEEN NVL(start_date, TRUNC(SYSDATE)) AND NVL(end_date, TRUNC(SYSDATE))
            order by period_year desc
        "));
        if (count($defPeriodData) > 0) {
            $def_period_year = $defPeriodData->first()->period_thai_year;
        }

        $transdate = trans('date');
        $transbtn = trans('btn');



        return view('pm.request-raw-materials.index', compact('lookups', 'items', 'title', 'dep_code', 'orgname', 'orgfullname', 'req_by', 'oprn_rows', 'transdate', 'transbtn', 'def_period_year', 'profile'));
    }

    public function getOPRN($orgCode)
    {
        $oprn = DB::table('ptpm_opm_routing_v')->select(DB::raw('distinct owner_organization_id,organization_code,oprn_class_desc,oprn_desc '));
        $oprn = $oprn->where("oprn_no", 'LIKE', "%WIP%")
                    ->where('active_flag', 'Y')
                    ->where('organization_code', $orgCode)
                    ->whereRaw("nvl(attribute4, 'N') = 'Y'")
                    ->orderByRaw("organization_code DESC, oprn_class_desc DESC")
                    ->get();
        return $oprn;
    }

    public function store(Request $request)
    {

        $profile = getDefaultData('/users');

        $req_by = User::where('user_id',  $profile->user_id)->first()->user_id;
        // $dep_desc = PtglCoaDeptCodeV::where('department_code', $request->input('department_code'))->first()->description;
        $productDateTo = null;
        if ($request->input('product_date_to') && $profile->organization_code != 'M02' && $profile->organization_code != 'M03') {
            $productDateTo = parseFromDateTh($request->input('product_date_to'));
        }

        $header = new PtpmBiweeklyRequestHeaders;
        $data = [
            'biweekly_id' => $request->input('biweekly_id'),
            'tobacco_group' => $request->input('tobacco_group'),
            'request_date' => parseFromDateTh($request->input('request_date')),
            'product_date_from' => parseFromDateTh($request->input('product_date_from')),
            'product_date_to' => $productDateTo,
            'department_code' => $profile->department_code,
            'department_desc' => optional($profile->department)->description ?? '',
            'all_wip' => $request->input('wip'),
            'request_by' => $req_by,
            'organization_id' => $profile->organization_id,
            'send_date' => parseFromDateTh($request->input('send_date'))
        ];
        $headerSaved = $header->insert($data);



        if ($headerSaved->bi_request_header_id) {

            $dbLines = new PtpmBiweeklyRequestLines;
            $result = $dbLines->generateLines($headerSaved->biweekly_id, $headerSaved->tobacco_group, $headerSaved->bi_request_header_id);
        }


        // $desc = DB::table('ptinv_uom_v')->where('uom_code', $value)->value('description');

        $lines = $headerSaved->lines();
        $lines = $lines->leftJoin("ptinv_uom_v AS ptinvUomV", "ptinvUomV.uom_code", "=", "ptpm_biweekly_request_lines.uom");
        $lines = $lines->select(['ptpm_biweekly_request_lines.*', 'ptinvUomV.unit_of_measure as uom_thai']);
        $lines = $lines->orderBy("item_code");
        $lines = $lines->get();



        foreach ($lines as $key => $line) {
            $request_qty = '';
            if ($line->product_onhand - $line->total_qty < 0) {
                $request_qty = abs($line->product_onhand - $line->total_qty);
            }
            $reqQty = $line->request_qty;
            // $lines[$key]->qty = $request_qty;
            // $lines[$key]->request_qty = $request_qty;
            // $lines[$key]->uom2 = $line->uom;
            $lines[$key]->uom2 = $line->uom_thai;
            $lines[$key]->request_uom = $line->uom;
            $lines[$key]->qty = ""; //default
            $lines[$key]->request_qty = ""; //default
            // $lines[$key]->request_qty = $reqQty; //default
            $lines[$key]->list_uom2 = $this->getListItemConvUomV($line); //default
        }

        $listUom2 = [];
        // try {
        //     $listUom2 = $this->getListItemConvUomV($lines[0]);
        // } catch (Exception $e) {
        //     $listUom2 = [];
        // }


        return response()->json(['header' => $headerSaved, 'lines' => $lines, 'ret_code' => $result, 'listUom2' => $listUom2]);
    }

    public function getListItemConvUomV($line) //Request $request
    {

        // $inventory_item_id = $request->input('inventory_item_id');
        // $organization_id = $request->input('organization_id');
        // $to_uom_code = $request->input('to_uom_code');


        $inventory_item_id = $line->inventory_item_id;
        $organization_id = $line->organization_id;
        $to_uom_code = $line->uom;

        $select = [
            'organization_id',
            'inventory_item_id',
            'from_uom_code',
            'to_uom_code',
            'from_unit_of_measure',
            'conversion_rate'
        ];

        $listUom2 = PtpmItemConvUomV::select(DB::raw(join(',', $select)))->where([
            "inventory_item_id" => $inventory_item_id,
            "organization_id" => $organization_id,
            "to_uom_code" => $to_uom_code
        ])->get();

        return $listUom2;
        // return response()->json(['listUom2' => $listUom2]);
    }

    public function update(Request $request, $id)
    {
        $reqHeaderIds = [];
        $errors = [];


        $header = PtpmBiweeklyRequestHeaders::find($id);


        foreach ($request->input('lines') as $key => $line) {

            if (is_array($line['uom2'])) {
                // $line['uom2'] = $line['uom2']["from_unit_of_measure"];
                $line['uom2'] = $line['uom2']["to_uom_code"];
                
            }


            try {
                if ($line['qty'] >= 1 && in_array($line['bi_request_line_id'], $request->input('checked'))) {
                    $header->lines()->updateOrCreate([
                        'bi_request_line_id' => $line['bi_request_line_id'],
                    ], [
                        'qty' => $line['qty'],
                        'request_uom' => 1,
                        'request_qty' => $line['request_qty'],
                        // 'request_uom' => $line['request_uom'],
                        // 'uom2' => $line['uom2'],
                        'uom2' => \Arr::get(request()->lines, "$key.uom2.from_uom_code"),
                    ]);
                } else {
                    $header->lines()->where('bi_request_line_id', $line['bi_request_line_id'])->delete();
                }

                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                return $e;
            }
        }

        $biRequestHeaderId = $header->bi_request_header_id;
        $message = '';

        // $db = \DB::connection('oracle')->getPdo();
        $db = DB::getPdo();
        $sql =   "
                DECLARE
                    v_status         varchar2(5);
                    v_err_msg        varchar2(2000);
                BEGIN
                    :v_err_msg := APPS.PTPM_CREATE_REPORT_PKG.REQUEST_OUT(
                        P_SOURCE_TABLE => 'PTPM_BIWEEKLY_REQUEST_HEADERS'
                        , P_SOURCE_ID => {$biRequestHeaderId}
                    );
                    DBMS_OUTPUT.PUT_LINE('Massage : ' || v_err_msg);
                END;
            ";
        $sql = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':v_err_msg', $message, \PDO::PARAM_STR, 2000);
        if ($stmt->execute()) {
            // $reqHeaderIds[] = $biRequestHeaderId;
            $reqHeaderIds[] = explode(' ', $message)[1];
        } else {
            $errors[] = "ไม่สำเร็จ";
        }
        
        return response()->json(['reqHeaderIds' => array_unique($reqHeaderIds), 'errors' => array_unique($errors)]);
    }
}
