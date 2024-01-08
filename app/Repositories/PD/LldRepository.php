<?php
namespace App\Repositories\PD;

use Illuminate\Database\Eloquent\Collection;

use App\Models\PD\Lld\PtpdLldTemp;
use App\Models\PD\Lld\PtpdLldTempT;
use App\Models\PD\Lld\PtpdLldTempV;
use App\Models\PD\Lld\ptpdLldYearClosePeriodV;




use App\Models\PD\SmlCostFmls\PtpdSmlCostFlavourV;
use App\Models\PD\SmlCostFmls\PtpdSmlCostTobaccoTypeV;
use App\Models\PD\SmlCostFmls\PtctCostSumProduct;

use App\Models\PD\SmlCostFmls\PtpdSmlCostFmlHeadT;
use App\Models\PD\SmlCostFmls\PtpdSmlCostLeafHFmlT;
use App\Models\PD\SmlCostFmls\PtpdSmlCostLeafDFmlT;
use App\Models\PD\SmlCostFmls\PtpdSmlCostFlavorFmlT;
use App\Models\PD\SmlCostFmls\PtpdSmlCostWrapCigaFmlT;
use App\Models\PD\SmlCostFmls\PtpdSmlCostCigarFml;
use App\Models\PD\SmlCostFmls\PtpdSmlCostWrappedFml;


use App\Models\PD\SmlCostFmls\PtpdSmlCostFmlHeadV;
use App\Models\PD\SmlCostFmls\PtpdSmlCostLeafHFmlV;
use App\Models\PD\SmlCostFmls\PtpdSmlCostLeafFmlV;
use App\Models\PD\SmlCostFmls\PtpdSmlCostLeafDFmlV;
use App\Models\PD\SmlCostFmls\PtpdSmlCostLeafItemDtlV;
use App\Models\PD\SmlCostFmls\PtpdSmlCostFlavorFmlV;
use App\Models\PD\SmlCostFmls\PtpdSmlCostWrapCigaFmlV;
use App\Models\PD\SmlCostFmls\PtpdSmlCostTotalV;
use App\Models\PD\SmlCostFmls\PtpdCigaReferCostTotalV;
use App\Models\PD\SmlCostFmls\PtpdSmlCostSumProductV;


use App\Models\PD\SmlCostFmls\PtpdSmlCostCasingV;
use App\Models\PD\SmlCostFmls\PtpdSmlCostFlavorV;
use App\Models\PD\SmlCostFmls\PtpdSmlFlavorItemV;
use App\Models\PD\SmlCostFmls\PtpdSmlCostCasingFmlV;
use App\Models\PD\SmlCostFmls\PtpdSmlCostCigarV;
use App\Models\PD\SmlCostFmls\PtpdSmlCasingItemV;
use App\Models\PD\SmlCostFmls\PtpdSmlWrapItemV;
use App\Models\PD\SmlCostFmls\PtpdLldV;
use App\Models\PD\SmlCostFmls\PtpdTotalRawMaterialV;


use App\Models\PD\Lookup\MtlUnitsOfMeasureVl;
use App\Repositories\PD\SmlCostFmlFuncRepository;

// PD08
use App\Models\PD\PtpdFormulaTypeV;
use App\Models\PD\ExpFmls\PtpdFormulaHV;

use DB;
use Arr;
use Carbon\Carbon;

class LldRepository
{
    // const url = '/pd/sml-cost-fmls';
    const url = '/pd/lld';

    function info($request)
    {
        $uom = MtlUnitsOfMeasureVl::selectRaw("uom_code, unit_of_measure")->where('uom_code', 'KG')->first();
        $profile = $this->getProfile($request->lookup_code);
        // $formulaId = $request->formula_id;
        $blendNo = $request->blend_no;
        $tobaccoOrganizationId = $request->tobacco_organization_id;

        // $blendNo = 'MCR081-001';
        // $blendNo = 'MCR_TEST_004';
        // $blendNo = 'TEST_NS';
        // -- web_h_id

        $year = $request->lld_year;
        // $year = '2564';

        $header = (object) [];
        $header->lld_year = $year;
        $header->lines = [];

        $yearList = PtpdLldTempV::selectRaw("lld_year as value, lld_year as lable")->orderByRaw("lld_year")->groupBy("lld_year")->get();
        if (count($yearList)) {
            $yearList = array_values($yearList->toArray());
        }

        $data       = $this->getDataInfo($request, $header, $profile);
        $data->year_list = $yearList;
        $transDate  = trans('date');
        $transBtn   = trans('btn');
        $requestAll = $request->all();
        $url        = $this->url($request, $headerId = -999);

        return (object) [
            'header'        => $header,
            'profile'       => $profile,
            'data'          => $data,
            'url'           => $url,
            'transDate'     => $transDate,
            'transBtn'      => $transBtn,
            'requestAll'    => $requestAll,
        ];

    }

    function show($request)
    {
        $year = $request->lld_year;
        $lldId = $request->lld_id;
        $hasConfirm = PtpdLldTempV::where("lld_year", $year)->orderByRaw('blend_no, item_code')->count();
        if ($lldId) {
            $lines = PtpdLldTempT::selectRaw("
                        lld_id,
                        lld_year,
                        blend_no,
                        organization_id,
                        inventory_item_id,
                        item_code,
                        item_code_desc,
                        lld_qty
                    ")
                    ->where("lld_id", $lldId)
                    ->orderByRaw('blend_no, item_code')
                    ->get();
        } else {
            $lines = PtpdLldTempV::where("lld_year", $year)->orderByRaw('blend_no, item_code')->get();
        }

        $header = (object) [];
        $header->lld_year = $year;
        $header->has_confirm = $hasConfirm;
        $header->lld_id = $lldId;
        $header->lines = [];
        if (count($lines)) {
            $header->lines = array_values($lines->toArray());
        }

        return (object) [
            'header'        => $header,
        ];
    }

    function url($request, $headerId = -999)
    {
        $url                    = (object)[];
        $prefixRoute            = 'pd.lld';
        $prefixAjaxRoute        = 'pd.ajax.lld';
        // $url->index             = route("{$prefixRoute}.index", request()->all() ?? []);
        $url->index             = route("{$prefixRoute}.index");
        $url->ajax_store        = route("{$prefixAjaxRoute}.store");
        $url->ajax_update       = route("{$prefixAjaxRoute}.update");
        $url->ajax_findDataLov  = route("{$prefixAjaxRoute}.findDataLov");
        $url->ajax_findItemCode  = route("{$prefixAjaxRoute}.findItemCode");

        // $url->ajax_get_lines    = route("{$prefixAjaxRoute}.get-lines");
        // $url->ajax_get_data     = route("{$prefixAjaxRoute}.get-data");
        // $url->ajax_compare_data = route("{$prefixAjaxRoute}.compare-data");
        // $url->ajax_set_status   = route("{$prefixAjaxRoute}.set-status", $headerId);
        return $url;
    }

    function search($request)
    {
        $year            = false;
        if (request()->year != '') {
            $year            = strtolower(request()->year);
        }
        $profile            = $this->getProfile($request->lookup_code);
        $organizationId     = $profile->organization_id;

        if ($request->action == 'search-get-param') {
            $headers = PtpdLldTempV::selectRaw("
                                lld_year as value
                                , lld_year as lable
                            ")
                            ->when($year, function($q) use($year) {
                                $q->whereRaw("(lld_year) like '%{$year}%'");
                            })
                            ->groupByRaw("lld_year")
                            ->get();
        } else {
            $headers = PtpdLldTempV::selectRaw("
                            lld_year
                        ")
                        ->when($year, function($q) use($year) {
                            $q->whereRaw("(lld_year) like '%{$year}%'");
                        })
                        ->groupByRaw("lld_year")
                        ->get();
        }

        if ($request->action == 'search-get-param') {
            $yearList = [];

            if (count($headers)) {
                $yearList = $headers;
            }

            return [
                'year_list' => $yearList,
            ];
        }


        return $headers;
    }

    function getDataInfo($request, $header, $profile)
    {
        $data = (object)[];
        $header->can = $this->getCan($header);

        $budgetYearList = ptpdLldYearClosePeriodV::selectRaw("thai_year budget_year_th")
                            ->orderBy('thai_year')
                            ->get();
        if (count($budgetYearList)) {
            $budgetYearList = $budgetYearList->pluck('budget_year_th', 'budget_year_th')->toArray();
        } else {
            $budgetYearList = [];
        }

        $createInput = (object) [
            'def_budget_year'   => '',
            'def_version'       => '',
            'budget_year_list'  => '',
            'budget_year_version_list'  => $budgetYearList,
        ];
        $data->create_input = $createInput;
        $data->menu = getMenu($this::url);
        return $data;

    }

    function store($request)
    {
        $result = $this->interfaceImort($request);
        if ($result['status'] != 'C') {
            throw new \Exception($result['msg']);
        }
        $data = PtpdLldTempT::where('lld_id', $result['lld_id'])->get();
        $firstData = $data->first();
        if (count($data) == 0) {
            throw new \Exception("ไม่พบข้อมูล");
        }
        $data = [
            'lld_id' => $firstData->lld_id,
            'lld_year' => $firstData->lld_year,
        ];

        return $data;
    }

    function update($request)
    {
        $header     = (object) request()->header;
        $lines      = $header->lines;
        $profile    = $this->getProfile();
        $sysdate    = now();
        $manualLine = (object) request()->manualLine;
        $data = PtpdLldTempT::where('lld_id', $header->lld_id)->get();
        // foreach ($lines as $key => $line) {
        //     $lldId              = data_get($line, 'lld_id');
        //     $organizationId     = data_get($line, 'organization_id');
        //     $inventoryItemId    = data_get($line, 'inventory_item_id');
        //     $blendNo            = data_get($line, 'blend_no');
        //     $lldQty             = data_get($line, 'lld_qty') ?? 0;

        //     \DB::table('PTPD_LLD_TEMP_T')
        //         ->where('lld_id', $header->lld_id)
        //         ->where('organization_id', $organizationId)
        //         ->where('inventory_item_id', $inventoryItemId)
        //         ->where('blend_no', $blendNo)
        //         ->update([
        //             'lld_qty'           => $lldQty,
        //             'updated_by_id'     => $profile->user_id,
        //             'last_updated_by'   => $profile->fnd_user_id,
        //             'updated_at'        => $sysdate,
        //             'last_update_date'  => $sysdate,
        //         ]);
        // }

        foreach ($manualLine as $key => $value) {
            $inventoryItemId = explode(".",$value['cigar_item_id'])[0];
            $itemCode = explode(".",$value['cigar_item_id'])[1];
            
            $header                         = new PtpdLldTempT;
            $header->lld_id                 = data_get($value, 'lld_id');
            $header->lld_year               = data_get($value, 'lld_year');
            $header->blend_no               = data_get($value, 'blend_no');
            $header->organization_id        = $data[0]['organization_id'];
            $header->inventory_item_id      = $inventoryItemId;
            $header->item_code              = $itemCode;
            $header->item_code_desc         = data_get($value, 'item_code_desc');
            $header->lld_qty                = data_get($value, 'lld_qty');
            $header->interface_name         = 'MANUAL_WEB';

            $header->web_status             = 'CREATE';
            $header->created_by             = $profile->fnd_user_id;
            $header->created_by_id          = $profile->user_id;
            $header->created_at             = $sysdate;
            $header->creation_date          = $sysdate;
            $header->program_code           = $profile->program_code;
            $header->updated_by_id          = $profile->user_id;
            $header->last_updated_by        = $profile->fnd_user_id;
            $header->updated_at             = $sysdate;
            $header->last_update_date       = $sysdate;
            $header->web_batch_no           = $data[0]['web_batch_no'];
            $header->save();
        }

        $result = $this->confirmLld($request);
        if ($result['status'] != 'C') {
            throw new \Exception($result['msg']);
        }
        return ;
    }

    function getJsonNullable()
    {
        return json_encode(false);
    }

    function getCan($header)
    {
        $can = (object)[
            'edit' => false,
        ];

        return $can;
    }


    function getProfile()
    {
        $data = getDefaultData($this::url);

        return $data;
    }


    function interfaceImort($request)
    {
        $budgetYear = $request->budget_year;
        $profile = $this->getProfile();
        $sysdate = now();
        $db     =   \DB::connection('oracle')->getPdo();
        $sql    =   "
            declare
                v_P_LLD_ID          number ;
                v_INTERFACE_STATUS  varchar2(1);
                v_INTERFACE_MSG     varchar2(4000);

            begin
            PTPD_IMPORT_LLD_PKG.IMPORT_LLD(P_LLD_YEAR    => '$budgetYear'
                                             ,P_USER_ID   => $profile->fnd_user_id
                                             ,P_LLD_ID    => :v_P_LLD_ID
                                             ,P_INTERFACE_STATUS => :v_INTERFACE_STATUS
                                             ,P_INTERFACE_MSG    => :v_INTERFACE_MSG ) ;
            dbms_output.put_line('v_P_LLD_ID = '||v_P_LLD_ID);
            dbms_output.put_line('v_INTERFACE_STATUS = '||v_INTERFACE_STATUS);
            dbms_output.put_line('v_INTERFACE_MSG = '||v_INTERFACE_MSG);

            end ;
        ";

        \Log::info($sql);
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':v_INTERFACE_STATUS', $result['status'], \PDO::PARAM_STR, 10);
        $stmt->bindParam(':v_INTERFACE_MSG', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':v_P_LLD_ID', $result['lld_id'], \PDO::PARAM_STR, 4000);
        $stmt->execute();
        \Log::info("INF", $result);

        return $result;
    }

    function confirmLld($request)
    {
        $header     = (object) request()->header;
        $budgetYear = $request->budget_year;
        $profile    = $this->getProfile();
        $sysdate    = now();
        $db     =   \DB::connection('oracle')->getPdo();
        $sql    =   "
            declare
                v_P_LLD_ID          number ;
                v_INTERFACE_STATUS  varchar2(1);
                v_INTERFACE_MSG     varchar2(4000);
            begin

            PTPD_IMPORT_LLD_PKG.CONFIRM_LLD( P_LLD_ID    => $header->lld_id
                                             ,P_INTERFACE_STATUS => :v_INTERFACE_STATUS
                                             ,P_INTERFACE_MSG    => :v_INTERFACE_MSG ) ;

            dbms_output.put_line('v_P_LLD_ID = '||v_P_LLD_ID);
            dbms_output.put_line('v_INTERFACE_STATUS = '||v_INTERFACE_STATUS);
            dbms_output.put_line('v_INTERFACE_MSG = '||v_INTERFACE_MSG);
            end ;
        ";

        \Log::info($sql);
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':v_INTERFACE_STATUS', $result['status'], \PDO::PARAM_STR, 10);
        $stmt->bindParam(':v_INTERFACE_MSG', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->execute();
        \Log::info("INF", $result);

        return $result;
    }
}
