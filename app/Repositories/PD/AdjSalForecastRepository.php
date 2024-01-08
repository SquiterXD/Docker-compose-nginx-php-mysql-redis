<?php
namespace App\Repositories\PD;

use Illuminate\Database\Eloquent\Collection;

use DB;
use Arr;
use App\Models\PD\AdjSalForecasts\PtpdAdjSalesForecastH;
use App\Models\PD\AdjSalForecasts\PtpdAdjSalesForecastL;

use App\Models\PD\AdjSalForecasts\PtpdAdjSalForecastHT;
use App\Models\PD\AdjSalForecasts\PtpdAdjSalForecastLT;

use App\Models\PD\AdjSalForecasts\PtpdBudgetYearV;
use App\Models\PD\AdjSalForecasts\PtpdBudgetYearItemV;
use App\Models\PD\AdjSalForecasts\PtpdAdjSalItemCigarV;



class AdjSalForecastRepository
{
    const url = '/pd/adj-sal-forecasts';

    function info($request)
    {
        $profile = $this->getProfile();
        $hWebId = $request->h_adj_sale_for_id ?? -1;

        $header = PtpdAdjSalesForecastH::selectRaw("
                        h_adj_sale_for_id,
                        budget_year,
                        budget_year_version,
                        version_no,
                        adjust_percent,
                        created_at,
                        updated_at
                    ")
                    ->where('h_adj_sale_for_id', $hWebId)->first();

        if (!$header) {
            $header = new PtpdAdjSalesForecastH;
        }

        $data       = $this->getDataInfo($request, $header, $profile);
        $transDate  = trans('date');
        $transBtn   = trans('btn');
        $requestAll = $request->all();
        $url        = $this->url($request, $hWebId);

        return (object) [
            'profile'       => $profile,
            'data'          => $data,
            'header'        => $header,
            'url'           => $url,
            'transDate'     => $transDate,
            'transBtn'      => $transBtn,
            'requestAll'    => $requestAll,
        ];
    }

    function url($request, $hWebId = -999)
    {
        $url                    = (object)[];
        $preFixRoute            = 'pd.adj-sal-forecasts';
        $preFixAjaxRoute        = 'pd.ajax.adj-sal-forecasts';
        $url->index             = route("{$preFixRoute}.index", request()->all() ?? []);
        $url->index             = route("{$preFixRoute}.index");
        $url->ajax_store        = route("{$preFixAjaxRoute}.store");
        $url->ajax_update       = route("{$preFixAjaxRoute}.update", $hWebId);
        $url->ajax_duplicate    = route("{$preFixAjaxRoute}.duplicate", $hWebId);
        $url->ajax_modal_create_details = route("{$preFixAjaxRoute}.modal-create-details");
        $url->ajax_modal_search_details = route("{$preFixAjaxRoute}.modal-search-details");
        // $url->ajax_get_lines    = route("{$preFixAjaxRoute}.get-lines");
        // $url->ajax_get_data     = route("{$preFixAjaxRoute}.get-data");
        // $url->ajax_compare_data = route("{$preFixAjaxRoute}.compare-data");
        // $url->ajax_set_status   = route("{$preFixAjaxRoute}.set-status", $headerId);
        return $url;
    }

    function search($request)
    {
        $budgetYear = $request->budget_year;
        $budgetYearVersion = $request->budget_year_version;
        $version = $request->version_no;

        $headers = PtpdAdjSalesForecastH::when($budgetYear, function($q) use($budgetYear) {
                        $q->where("budget_year", $budgetYear - 543);
                    })
                    ->when($budgetYearVersion, function($q) use($budgetYearVersion) {
                        $q->where("budget_year_version", $budgetYearVersion);
                    })
                    ->when($version, function($q) use($version) {
                        $q->where("version_no", $version);
                    })
                    ->with(['createdBy'])
                    ->orderBy('budget_year', 'desc')
                    ->orderBy('budget_year_version', 'desc')
                    ->orderBy('version_no', 'desc')
                    ->whereNotNull('version_no')
                    ->limit(20)
                    ->get();
        if (count($headers)) {
            $headers = array_values($headers->toArray());
        }
        return $headers;
    }

    function store($request)
    {
        $budgetYear = $request->budget_year;
        $budgetYearVersion = $request->budget_year_version;
        $versionNo = $request->version_no;
        $profile = $this->getProfile();
        $sysdate = now();

        $budgetYear = PtpdBudgetYearV::where('budget_year', $budgetYear - 543)
                        ->where('budget_year_version', $budgetYearVersion)
                        ->first();

        // $header = new PtpdAdjSalesForecastH;
        // $header->h_adj_sale_for_id = PtpdAdjSalesForecastH::max('h_adj_sale_for_id') + 1;

        $header                     = new PtpdAdjSalForecastHT;
        // $header->h_web_id           = PtpdAdjSalForecastHT::max('h_web_id') + 1;
        $header->org_id             = $budgetYear->org_id;
        $header->budget_year        = $budgetYear->budget_year;
        $header->budget_year_version = $budgetYear->budget_year_version;
        // $header->version_no         = $versionNo;

        $header->web_status         = 'CREATE';
        $header->created_by         = $profile->fnd_user_id;
        $header->created_by_id      = $profile->user_id;
        $header->created_at         = $sysdate;
        $header->creation_date      = $sysdate;
        $header->program_code       = $profile->program_code;

        $header->updated_by_id      = $profile->user_id;
        $header->last_updated_by    = $profile->fnd_user_id;
        $header->updated_at         = $sysdate;
        $header->last_update_date   = $sysdate;
        $header->web_batch_no       = '-';
        $header->save();
        $header->web_batch_no       = $header->h_web_id;
        $header->save();

        $header->refresh();
        $lines = PtpdBudgetYearItemV::where('budget_year', $budgetYear->budget_year)
                    ->where('budget_year_version', $budgetYear->budget_year_version)
                    ->where('org_id', $budgetYear->org_id)
                    ->get();

        foreach ($lines as $key => $line) {
            // $newLine = new PtpdAdjSalesForecastL;
            // $newLine->l_adj_sale_for_id = PtpdAdjSalesForecastL::max('l_adj_sale_for_id') + 1;
            // $newLine->h_adj_sale_for_id = $header->h_adj_sale_for_id;

            $newLine                    = new PtpdAdjSalForecastLT;
            // $newLine->l_web_id          = PtpdAdjSalForecastLT::max('l_web_id') + 1;
            $newLine->h_web_id          = $header->h_web_id;
            $newLine->org_id            = $line->org_id;
            $newLine->budget_year_version = $line->budget_year_version;
            // $newLine->version_no        = $versionNo;
            $newLine->yearly_id         = $line->yearly_id;
            $newLine->item_id           = $line->item_id;
            $newLine->item_code         = $line->item_code;
            $newLine->item_description  = $line->item_description;
            $newLine->quantity          = $line->quantity;
            $newLine->adjust_quantity   = $line->quantity;
            $newLine->created_by         = $header->created_by;
            $newLine->created_by_id      = $header->created_by_id;
            $newLine->created_at         = $header->created_at;
            $newLine->creation_date      = $header->creation_date;
            $newLine->program_code       = $header->program_code;

            $newLine->web_status         = 'CREATE';
            $newLine->updated_by_id      = $header->updated_by_id;
            $newLine->last_updated_by    = $header->last_updated_by;
            $newLine->updated_at         = $header->updated_at;
            $newLine->last_update_date   = $header->last_update_date;
            $newLine->web_batch_no       = $header->web_batch_no;
            $newLine->save();
        }


        $result = $this->interfaceImort($header);
        if ($result['status'] != 'C') {
            throw new \Exception($result['msg']);
        }
        $header->refresh();
        $headerData = PtpdAdjSalesForecastH::find($result['p_h_adj_sale_for_id']);
        if (is_null($headerData)) {
            throw new \Exception("ไม่พบข้อมูล");
        }

        return $headerData;
    }

    function duplicate(PtpdAdjSalesForecastH $adjSalForecastHT, $request)
    {
        $versionNo = $this->getCurrentVersion($adjSalForecastHT->budget_year, $adjSalForecastHT->budget_year_version);
        $versionNo = $versionNo + 1;
        $profile = $this->getProfile();
        $sysdate = now();

        $header                     = new PtpdAdjSalForecastHT;
        $header->org_id             = $adjSalForecastHT->org_id;
        $header->budget_year        = $adjSalForecastHT->budget_year;
        $header->budget_year_version = $adjSalForecastHT->budget_year_version;
        // $header->version_no         = $versionNo;
        $header->web_status         = 'CREATE';
        $header->created_by         = $profile->fnd_user_id;
        $header->created_by_id      = $profile->user_id;
        $header->created_at         = $sysdate;
        $header->creation_date      = $sysdate;
        $header->program_code       = $profile->program_code;

        $header->updated_by_id      = $profile->user_id;
        $header->last_updated_by    = $profile->fnd_user_id;
        $header->updated_at         = $sysdate;
        $header->last_update_date   = $sysdate;
        $header->web_batch_no       = '-';
        $header->save();
        $header->web_batch_no       = $header->h_web_id;
        $header->save();

        $lines = PtpdAdjSalesForecastL::where('h_adj_sale_for_id', $adjSalForecastHT->h_adj_sale_for_id)->get();
        foreach ($lines as $key => $line) {
            $newLine                    = new PtpdAdjSalForecastLT;
            $newLine->h_web_id          = $header->h_web_id;
            $newLine->org_id            = $line->org_id;
            $newLine->budget_year_version = $line->budget_year_version;
            // $newLine->version_no        = $versionNo;
            $newLine->yearly_id         = $line->yearly_id;
            $newLine->item_id           = $line->item_id;
            $newLine->item_code         = $line->item_code;
            $newLine->item_description  = $line->item_description;
            $newLine->quantity          = $line->quantity;
            $newLine->adjust_quantity   = $line->adjust_quantity;
            $newLine->created_by         = $header->created_by;
            $newLine->created_by_id      = $header->created_by_id;
            $newLine->created_at         = $header->created_at;
            $newLine->creation_date      = $header->creation_date;
            $newLine->program_code       = $header->program_code;

            $newLine->web_status         = 'CREATE';
            $newLine->updated_by_id      = $header->updated_by_id;
            $newLine->last_updated_by    = $header->last_updated_by;
            $newLine->updated_at         = $header->updated_at;
            $newLine->last_update_date   = $header->last_update_date;
            $newLine->web_batch_no       = $header->web_batch_no;
            $newLine->save();
        }

        $result = $this->interfaceImort($header);
        if ($result['status'] != 'C') {
            throw new \Exception($result['msg']);
        }
        $header->refresh();

        // $headerData = PtpdAdjSalesForecastH::find($header->h_adj_sale_for_id);
        $headerData = PtpdAdjSalesForecastH::find($result['p_h_adj_sale_for_id']);
        if (is_null($headerData)) {
            throw new \Exception("ไม่พบข้อมูล");
        }

        return $headerData;
    }

    function update(PtpdAdjSalesForecastH $adjSalForecastHT, $request)
    {
        $adjustPercent = Arr::get($request->all(), 'header.adjust_percent', null);
        $lines = Arr::get($request->all(), 'header.lines', []) ?? [];

        $profile = $this->getProfile();
        $sysdate = now();

        // $adjSalForecastHT->adjust_percent     = $adjustPercent;
        // $adjSalForecastHT->updated_by_id      = $profile->user_id;
        // $adjSalForecastHT->last_updated_by    = $profile->fnd_user_id;
        // $adjSalForecastHT->updated_at         = $sysdate;
        // $adjSalForecastHT->last_update_date   = $sysdate;
        // $adjSalForecastHT->save();

        $header                     = new PtpdAdjSalForecastHT;
        $header->h_adj_sale_for_id  = $adjSalForecastHT->h_adj_sale_for_id;
        $header->adjust_percent     = $adjustPercent;
        $header->org_id             = $adjSalForecastHT->org_id;
        $header->budget_year        = $adjSalForecastHT->budget_year;
        $header->budget_year_version = $adjSalForecastHT->budget_year_version;
        $header->version_no         = $adjSalForecastHT->version_no;

        $header->web_status         = 'UPDATE';
        $header->created_by         = $profile->fnd_user_id;
        $header->created_by_id      = $profile->user_id;
        $header->created_at         = $sysdate;
        $header->creation_date      = $sysdate;
        $header->program_code       = $profile->program_code;

        $header->updated_by_id      = $profile->user_id;
        $header->last_updated_by    = $profile->fnd_user_id;
        $header->updated_at         = $sysdate;
        $header->last_update_date   = $sysdate;
        $header->web_batch_no       = '-';
        $header->save();
        $header->web_batch_no       = $header->h_web_id;
        $header->save();


        foreach ($lines as $key => $line) {
            $line = (object) $line;
            $updateLine                     = PtpdAdjSalesForecastL::find($line->l_adj_sale_for_id);
            // $updateLine->adjust_quantity    = $line->adjust_quantity;
            // $updateLine->updated_by_id      = $adjSalForecastHT->updated_by_id;
            // $updateLine->last_updated_by    = $adjSalForecastHT->last_updated_by;
            // $updateLine->updated_at         = $adjSalForecastHT->updated_at;
            // $updateLine->last_update_date   = $adjSalForecastHT->last_update_date;
            // $updateLine->save();


            $newLine                    = new PtpdAdjSalForecastLT;

            if ($updateLine) { // รายการ item ตามฝ่ายขาย
                $newLine->l_adj_sale_for_id = $updateLine->l_adj_sale_for_id;
                $newLine->org_id            = $updateLine->org_id;
                $newLine->budget_year_version = $updateLine->budget_year_version;
                $newLine->version_no        = $updateLine->version_no;
                $newLine->yearly_id         = $updateLine->yearly_id;
                $newLine->item_id           = $updateLine->item_id;
                $newLine->item_code         = $updateLine->item_code;
                $newLine->item_description  = $updateLine->item_description;
                $newLine->quantity          = $updateLine->quantity;
                $newLine->web_status        = $header->web_status;
            } else { //เพิ่ม รายการใหม่
                $newLine->org_id            = $line->org_id;
                $newLine->item_id           = $line->item_id;
                $newLine->item_code         = $line->item_code;
                $newLine->item_description  = $line->item_description;
                $newLine->quantity          = $line->quantity;
                $newLine->budget_year_version = $header->budget_year_version;
                $newLine->version_no        = $header->version_no;
                $newLine->web_status        = 'CREATE';
            }

            $newLine->h_adj_sale_for_id = $adjSalForecastHT->h_adj_sale_for_id;
            $newLine->h_web_id          = $header->h_web_id;
            $newLine->adjust_quantity   = $line->adjust_quantity;
            $newLine->created_by        = $header->created_by;
            $newLine->created_by_id     = $header->created_by_id;
            $newLine->created_at        = $header->created_at;
            $newLine->creation_date     = $header->creation_date;
            $newLine->program_code      = $header->program_code;

            $newLine->updated_by_id     = $header->updated_by_id;
            $newLine->last_updated_by   = $header->last_updated_by;
            $newLine->updated_at        = $header->updated_at;
            $newLine->last_update_date  = $header->last_update_date;
            $newLine->web_batch_no      = $header->web_batch_no;
            $newLine->save();
        }

        $result = $this->interfaceImort($header);
        if ($result['status'] != 'C') {
            throw new \Exception($result['msg']);
        }
        $headerData = PtpdAdjSalesForecastH::find($result['p_h_adj_sale_for_id']);

        return $headerData;
    }

    function interface(PtpdFormulaHT $formula)
    {
        $db     =   \DB::connection('oracle')->getPdo();
        $sql    =   "
            DECLARE
                V_STAUTS VARCHAR2(10);
                V_MSG VARCHAR2(4000);
            BEGIN

                PTPD_FORMULA_PKG.MAIN_IMORT(P_WEB_BATCH_NO       =>'{$formula->web_batch_no}'
                                               , P_INTERFACE_STATUS => :V_STAUTS
                                               , P_INTERFACE_MSG    => :V_MSG);

            END ;
        ";

        $formula->interface_name = $sql;
        $formula->save();
        \Log::info("{$formula->web_batch_no} INF", [$sql]);
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':V_STAUTS', $result['status'], \PDO::PARAM_STR, 10);
        $stmt->bindParam(':V_MSG', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        \Log::info("{$formula->web_batch_no} INF", [$result]);

        return $result;
    }

    function getDataInfo($request, $header, $profile)
    {
        $budgetYearList = [];
        $table = (new PtpdBudgetYearV)->getTable();
        $budgetYearList = PtpdBudgetYearV::selectRaw("budget_year + 543 budget_year_th, {$table}.*")
                            ->orderBy('budget_year')
                            ->orderBy('budget_year_version')
                            ->get();

        // $bgList = $budgetYearList->groupBy('budget_year_th');
        // if ($bgList) {
        //     $bgList = $bgList->map(function ($o)  {
        //         return array_values($o->sortByDesc('budget_year_version')->toArray());
        //     });
        // }

        $budgetYearVersionList = $budgetYearList->groupBy('budget_year_version');
        if ($budgetYearVersionList) {
            $budgetYearVersionList = $budgetYearVersionList->map(function ($o)  {
                return array_values($o->sortByDesc('budget_year_th')->toArray());
            });
        }
        $createInput = (object) [
            'def_budget_year'   => '',
            'def_version'       => '',
            'budget_year_list'  => '',
            'budget_year_version_list'  => $budgetYearVersionList,
        ];

        $table = (new PtpdAdjSalesForecastH)->getTable();
        $budgetYearList = PtpdAdjSalesForecastH::selectRaw("budget_year + 543 budget_year_th, {$table}.*")
                            ->whereNotNull('version_no')
                            ->orderBy('budget_year')
                            ->orderBy('budget_year_version')
                            ->get();
        $budgetYearVersionList = $budgetYearList->groupBy('budget_year_version');
        if ($budgetYearVersionList) {
            $budgetYearVersionList = $budgetYearVersionList->map(function ($o)  {
                return array_values($o->sortByDesc('budget_year_th')->pluck('budget_year_th', 'budget_year_th')->toArray());
            });
        }

        $searchInput = (object) [
            'def_budget_year'   => '',
            'def_version'       => '',
            // 'budget_year_list'  => $bgList,
            'budget_year_list'  => [],
            'budget_year_version_list'  => $budgetYearVersionList,
        ];

        $data = (object)[];
        $data->create_input = $createInput;
        $data->search_input = $searchInput;
        $data->menu = getMenu($this::url);
        $data->item_list = [];

        $header->lines = [];
        if ($header) {
            $lines = PtpdAdjSalesForecastL::selectRaw("
                        l_adj_sale_for_id,
                        h_adj_sale_for_id,
                        item_code,
                        item_description,
                        quantity,
                        adjust_quantity,
                        adjust_quantity old_adjust_quantity
                        ")
                        ->where('h_adj_sale_for_id', $header->h_adj_sale_for_id)
                        // ->orderBy('item_code')
                        ->get();
            $header->lines = $lines;
            $header->sum_quantity = $lines->sum('quantity');

            $can = (object) [];
            $can->edit = $header->created_at == $header->updated_at;
            $header->can = $can;
        } else {
            $can = (object) [];
            $can->edit = true;
            $header->can = $can;
        }

        if ($header->can && $header->h_adj_sale_for_id) {
            $exceptItemArray = $lines->pluck('item_code', 'item_code')->all();
            $itemList = PtpdAdjSalItemCigarV::selectRaw("
                            distinct
                            organization_id
                            , inventory_item_id value
                            , inventory_item_code || ': ' || description label
                            , inventory_item_code
                            , description
                        ")
                        ->when(count($exceptItemArray) > 0, function($q) use($exceptItemArray) {
                            $q->whereNotIn("inventory_item_code", $exceptItemArray);
                        })
                        ->orderBy('inventory_item_code')
                        ->get();
            $data->item_list = $itemList;
        }

        return $data;
    }

    function getJsonNullable()
    {
        return json_encode(false);
    }

    function getCan($status, $lookupCode)
    {

        $can = (object)[
            'edit' => true,
            // Tab: cigarettes
            'cigarettes' => (object) [
                'multi_cigarettes' => true,
            ],
            // Tab: leaf_formulas
            'leaf_formulas' => (object) [
                'ingredient' => (object) [
                    'add_lot_number' => false
                ]
            ],
        ];
        // data_set($can, 'leaf_formulas.leaf_formulas.ingredient.add_lot_number', true);
        // dd('zz', $can);

        // $lookupCode
        // 1   สูตรใช้จริง
        // 2   สูตรมาตรฐาน
        // 3   สูตรทดลอง

        if (strtoupper($status) == 'ACTIVE' || true) {
            if ($lookupCode == 1) {
                $can->leaf_formulas->ingredient->add_lot_number = true;
                $can->cigarettes->multi_cigarettes = true;
            }
        }

        // if ($this->wip_request_status) {

        //     switch ($this->wip_request_status) {
        //         case '1': // ยังไม่ส่งข้อมูล
        //             $can->edit = true;
        //             $can->transfer = true;
        //             $can->cancel_transfer = true;
        //             break;
        //         case '2': // บันทึกผลผลิตเข้าคลังเรียบร้อย
        //             if ($this->interface_status) {
        //                 $can->edit = false;
        //                 $can->transfer = false;
        //                 $can->cancel_transfer = false;
        //                 break;
        //             }
        //         case '3': // ยกเลิกการบันทึกผลผลิตเข้าคลัง
        //             $can->edit = false;
        //             $can->transfer = false;
        //             $can->cancel_transfer = false;
        //             break;
        //         case '4': // ยกเลิกใบส่งผลผลิตเข้าคลัง
        //             $can->edit = false;
        //             $can->transfer = false;
        //             $can->cancel_transfer = false;
        //             break;
        //     }
        // }


        return $can;
    }


    function getProfile($lookupCode = false)
    {
        $data = getDefaultData("/pd/adj-sal-forecasts");
        return $data;
    }


    function interfaceImort($tmp)
    {
        $db     =   \DB::connection('oracle')->getPdo();
        $sql    =   "
            DECLARE
                V_STATUS    VARCHAR2(10);
                V_MSG       VARCHAR2(4000);
                V_H_ADJ_SALE_FOR_ID Number;
            BEGIN
                    PTPD_ADJ_SAL_FORECAST_PKG.MAIN_IMPORT(P_WEB_BATCH_NO        => '$tmp->web_batch_no'
                                                        , P_INTERFACE_STATUS    => :V_STATUS
                                                        , P_INTERFACE_MSG       => :V_MSG
                                                        , P_H_ADJ_SALE_FOR_ID   => :V_H_ADJ_SALE_FOR_ID);

            END;
        ";

        $tmp->interface_name = $sql;
        $tmp->save();
        \Log::info("{$tmp->web_batch_no} INF", [$sql]);
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':V_STATUS', $result['status'], \PDO::PARAM_STR, 10);
        $stmt->bindParam(':V_MSG', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':V_H_ADJ_SALE_FOR_ID', $result['p_h_adj_sale_for_id'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        \Log::info("{$tmp->web_batch_no} INF", [$result]);

        return $result;
    }

    function getCurrentVersion($budgetYear, $budgetYearVersion)
    {
        $versionNo = PtpdAdjSalesForecastH::where('budget_year', $budgetYear)
                    ->where('budget_year_version', $budgetYearVersion)
                    ->max('version_no');
        return $versionNo;
    }

}
