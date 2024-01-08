<?php
namespace App\Repositories\PD;

use Illuminate\Database\Eloquent\Collection;

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

class SmlCostFmlRepository
{
    // const url = '/pd/sml-cost-fmls';
    const url = '/pd/sml-cost-fmls';

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

        $blendId = $request->blend_id;
        // $blendId = 24;
        // $blendId = 16;
        // $blendId = 34;
        // $blendId = 523;
        // $blendId = 523;
        // $blendId = 518;
        // $blendId = 522;
        // $blendId = 634;
        // $blendId = 640;
        // $blendId = 655;
        if ($blendId) {
            $header = PtpdSmlCostFmlHeadV::where('blend_id', $blendId)->first();
            $header->create_transaction_date_format = parseToDateTh($header->create_transaction_date);
            $header->last_transaction_date_format = parseToDateTh($header->last_transaction_date);

            $header->period_year = Carbon::parse($header->create_transaction_date)->format('Y');
            $header->has_tmp_table = true;
            $header->formula_type_code = data_get($header, 'formula_type_code', '');
            $header->formula_type = data_get($header, 'formula_type', '');
            $header->recipe_fiscal_year = data_get($header, 'recipe_fiscal_year', '');
            $header->total_raw_material = $this->getTotalRawMaterial($header->blend_id);
            $header->sum_total_raw_material = $header->total_raw_material->sum('leaf_qyt_total');
            $header->lld_qty = $header->lld_qty ?? 0;

        } else {
            $header = (object) [];
            $header->web_h_id = '';
            $header->blend_id = '';
            $header->blend_no = '';
            $header->example_no = '';
            $header->flag_cost_standard = 'Y';
            $header->create_transaction_date_format = parseToDateTh(now());
            $header->last_transaction_date_format = null;
            $header->flavour = '';
            $header->flavour_desc = '';
            $header->quantity = 10000;
            $header->uom = $uom->uom_code;
            $header->uom_name = $uom->unit_of_measure;
            $header->user_name = $profile->user_name;
            $header->cigarate_refer_cost_item = null;
            $header->cigarate_refer_cost_desc = null;
            $header->cigarate_pack_cost_item = null;
            $header->cigarate_pack_cost_desc = null;
            $header->details = null;
            $header->note = null;
            $header->tobacco_type_code      = null;

            $header->period_year = now()->format('Y');
            $header->has_tmp_table = false;

            $header->std_period_name = '';
            $header->formula_type_code = 'A';
            $header->formula_type = '';
            $header->recipe_fiscal_year = '';
            $header->lld_brand_code = '';
            $header->lld_brand_desc = '';
            $header->lld_qty = 0;
            $header->total_raw_material = $this->getTotalRawMaterial($header->blend_id);
            $header->sum_total_raw_material = 0;

            $header->wc_ciga_cost = '';
            $header->wc_cost_price_adjus = '';
            $header->wc_cost_price_reduc_increase = '';
            $header->wc_cost_after_price_adjus = '';

            $header->wage_cost = '';
            $header->wage_cost_price_adjus = '';
            $header->wage_cost_price_reduc_increase = '';
            $header->wage_cost_after_price_adjus = '';

            $header->ovh_cost = '';
            $header->ovh_cost_price_adjus = '';
            $header->ovh_cost_price_reduc_increase = '';
            $header->ovh_cost_after_price_adjus = '';
        }



        $data       = $this->getDataInfo($request, $header, $profile);
        $transDate  = trans('date');
        $transBtn   = trans('btn');
        $requestAll = $request->all();
        $url        = $this->url($request, $headerId = -999);

        $currentPeriodYear = (new ExpFmlFuncRepository)->getCurrentPeriodYear();
        $header->def_recipe_fiscal_year = '';
        if ($currentPeriodYear) {
            $header->def_recipe_fiscal_year = $currentPeriodYear->period_year + 543;
        }


        return (object) [
            'header'        => $header,
            'profile'       => $profile,
            'data'          => $data,
            'url'           => $url,
            'transDate'     => $transDate,
            'transBtn'      => $transBtn,
            'requestAll'    => $requestAll,
        ];

        if (!$header) {
            $model = collect([]);
            $can                            = $model->can;
            $header                         = (object)[];
            $header->can                    = $can;
            $header->formula_id             = '';
            $header->blend_id               = '';
            $header->blend_no               = '';
            $header->formula_no             = '';
            $header->product_item_code      = '';
            $header->description            = '';
            $header->comments               = '';
            $header->quantity               = 100;
            $header->uom                    = '';

            $header->flavour_code           = '';
            $header->flavour                = '';
            $header->formula_organization_code = '';
            $header->organization_code      = '';
            $header->department             = '';
            $header->formula_status         = 'Inactive';
            // $header->formula_status         = 'Active';


            $header->or_formula_id          = '';
            $header->or_formula_organization_id = '';
            $header->formula_vers           = '';
            $header->or_formula_vers        = '';
            $header->organization_id        = '';

            // $header->formula_id = 1903;
            // $header->blend_no = "4444";
            // $header->formula_no = '4444';
            // $header->product_item_code      = '100704444';
            // $header->comments = "test";
            // $header->department = "61000200";
            // $header->description = "ยาเส้นปรุงทดลอง. 802";
            // $header->flavour_code = "50";
            // $header->flavour = "ทดลอง";
            // $header->formula_no = "10910EX28";
            // $header->formula_organization_code = "M02";
            // $header->organization_code = "A04";
            // $header->quantity = 100;
            // $header->uom = "KG";

            // New
            $header->has_tmp_table = false;
            $header->recipe_routing_no = '';
        } else {
            $header->has_tmp_table = true;
        }


        if ($header->formula_id || $header->blend_id) {
            // $flavourType = $this->getFormulaTypeCode($header->formula_type_code);
            // $header->lookup_code                    = $flavourType->lookup_code;
            $header->user_name                      = $header->user_name;
            $header->formula_creation_date_format   = parseToDateTh(now());   // วันที่สรา้ง
            $header->formula_last_update_date_format = parseToDateTh(now());  // วัันที่แก้ไขล่าสุด

            $header->formula_creation_date_format   = $header->formula_creation_date_format;   // วันที่สรา้ง
            $header->formula_last_update_date_format = $header->formula_last_update_date_format;  // วัันที่แก้ไขล่าสุด

            $header->formula_approval_date_format   = $header->formula_approval_date_format;   // วันที่ี่อนุมัติ
            $header->formula_start_date_format      = $header->formula_start_date_format;   // วันที่เริ้มใช้

        } else {
            // $flavourType = $this->getFormulaTypeCode($request->lookup_code ?? 1);
            // $header->lookup_code                    = $flavourType->lookup_code;
            $header->user_name                      = $profile->fnd_user_name;
            $header->web_user_name                  = $profile->user_name;
            $header->formula_creation_date_format   = parseToDateTh(now());   // วันที่สรา้ง
            $header->formula_last_update_date_format = '';  // วัันที่แก้ไขล่าสุด

            $header->formula_approval_date_format   = '';   // วันที่ี่อนุมัติ
            $header->formula_start_date_format      = '';   // วันที่เริ้มใช้

            $header->product_item_id = '';
            $header->recipe_fiscal_year = '';
            $header->tobacco_type_desc = '';
            $header->product_item_desc = '';
            $header->old_formula_id = '';
            $header->old_formula_no = '';
            $header->old_version = '';
            $header->old_organization_code = '';
        }

        // dd('xx', $header->toArray());

        $currentPeriodYear = (new ExpFmlFuncRepository)->getCurrentPeriodYear();
        $header->def_recipe_fiscal_year = '';
        if ($currentPeriodYear) {
            $header->def_recipe_fiscal_year = $currentPeriodYear->period_year + 543;
        }

        $data       = $this->getDataInfo($request, $header, $profile);
        $transDate  = trans('date');
        $transBtn   = trans('btn');
        $requestAll = $request->all();
        $url        = $this->url($request, $headerId = -999);

        dd('xxx');

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

    function url($request, $headerId = -999)
    {
        $url                    = (object)[];
        $prefixRoute            = 'pd.sml-cost-fmls';
        $prefixAjaxRoute        = 'pd.ajax.sml-cost-fmls';
        // $url->index             = route("{$prefixRoute}.index", request()->all() ?? []);
        $url->index             = route("{$prefixRoute}.index");
        $url->ajax_store        = route("{$prefixAjaxRoute}.store");
        $url->ajax_get_lines    = route("{$prefixAjaxRoute}.get-lines");
        $url->ajax_get_data     = route("{$prefixAjaxRoute}.get-data");
        $url->ajax_compare_data = route("{$prefixAjaxRoute}.compare-data");
        $url->ajax_set_status   = route("{$prefixAjaxRoute}.set-status", $headerId);
        return $url;
    }

    function checkVersion($request)
    {
        $inputHeader = (object) $request->header;
        $blendNo = strtolower($inputHeader->blend_no);
        $profile = $this->getProfile();
        $organizationId = $profile->organization_id;
        $maxVersion = PtpdSmlCostFmlHeadV::when($blendNo, function($q) use($blendNo) {
                    $q->whereRaw("LOWER(blend_no) = '{$blendNo}'");
                })
                ->when($organizationId, function($q) use($organizationId) {
                    $q->where("tobacco_organization_id", $organizationId);
                })
                ->where('example_no', '>', 0)
                ->max('example_no');
        return (object) ['max_version' => $maxVersion ?? 0];
    }

    function searchPd08($request)
    {
        $blendNo            = false;
        if (request()->blend_no != '') {
            $blendNo            = strtolower(request()->blend_no);
        }
        $profile            = $this->getProfile();
        $organizationId     = $profile->organization_id;
        $tobaccoTypeCode    = request()->tobacco_type_code;
        $formulaTypeCode    = request()->formula_type_code;
        $recipeFiscalYear   = request()->recipe_fiscal_year;
        $formulaStatus      = request()->formula_status;

        $headers = PtpdFormulaHV::selectRaw("
                        formula_id
                        , formula_type
                        , blend_no
                        , formula_vers
                        , recipe_fiscal_year
                        , formula_status
                        , formula_approval_date
                        , tobacco_type_desc
                    ")
                    ->when($blendNo, function($q) use($blendNo) {
                        $q->whereRaw("LOWER(blend_no) like '%{$blendNo}%'");
                    })
                    ->when($organizationId, function($q) use($organizationId) {
                        $q->where("tobacco_organization_id", $organizationId);
                    })
                    ->when($tobaccoTypeCode != '', function($q) use($tobaccoTypeCode) {
                        $q->where("tobacco_type_code", $tobaccoTypeCode);
                    })
                    ->when($formulaTypeCode != '', function($q) use($formulaTypeCode) {
                        $q->where("formula_type_code", $formulaTypeCode);
                    })
                    ->when($recipeFiscalYear != '', function($q) use($recipeFiscalYear) {
                        $q->where("recipe_fiscal_year", $recipeFiscalYear);
                    })
                    ->when($formulaStatus != '', function($q) use($formulaStatus) {
                        $q->where("formula_status", $formulaStatus);
                    })
                    ->when($formulaTypeCode != 'P', function($q) use($formulaStatus) { // เฉพาะ ชนป.
                        $q->whereNotNull('formula_id');
                    })
                    ->orderByRaw("formula_id, formula_type, blend_no, formula_vers, recipe_fiscal_year")
                    ->get();

        return $headers;
    }

    function search($request)
    {
        $blendNo            = false;
        if (request()->blend_no != '') {
            $blendNo            = strtolower(request()->blend_no);
        }
        $profile            = $this->getProfile($request->lookup_code);
        $organizationId     = $profile->organization_id;
        $formulaType        = $this->getFormulaTypeCode($request->formula_type_code);

        if ($request->action == 'search-get-param') {
            $headers = PtpdSmlCostFmlHeadV::selectRaw("
                                distinct blend_no
                            ")
                            ->when($blendNo, function($q) use($blendNo) {
                                $q->whereRaw("LOWER(blend_no) like '%{$blendNo}%'");
                            })
                            ->when($organizationId, function($q) use($organizationId) {
                                $q->where("tobacco_organization_id", $organizationId);
                            })
                            ->when($formulaType, function($q) use($formulaType) {
                                // $q->where("formula_type_code", $formulaType->lookup_code);
                            })
                            ->where('example_no', '>', 0)
                            ->orderBy('blend_no')
                            // ->limit(20)
                            ->get();
        } else {

            $headers = PtpdSmlCostFmlHeadV::selectRaw("
                            blend_id,
                            blend_no,
                            example_no,
                            created_by_id
                        ")
                        ->with(['createdBy'])
                        ->when($blendNo, function($q) use($blendNo) {
                            $q->whereRaw("LOWER(blend_no) like '%{$blendNo}%'");
                        })
                        ->when($organizationId, function($q) use($organizationId) {
                            $q->where("tobacco_organization_id", $organizationId);
                        })
                        ->when($formulaType, function($q) use($formulaType) {
                            // $q->where("formula_type_code", $formulaType->lookup_code);
                        })
                        ->where('example_no', '>', 0)
                        ->orderBy('blend_no')
                        ->orderBy('example_no')
                        ->groupByRaw("blend_id, blend_no, example_no, created_by_id")
                        ->get();
        }

        if ($request->action == 'search-get-param') {
            $blendNoList = [];

            if (count($headers)) {
                $blendNoList = $headers;
            }

            return [
                'blend_no_list' => $blendNoList,
            ];
        }


        return $headers;
    }

    function copyToPd08($request)
    {
        $url                    = (object)[];
        $preFixRoute            = 'pd.exp-fmls';
        $url->pd08_url        = route("{$preFixRoute}.index", ['blend_no' => 'NS_001']);
        return $url;


        $inputHeader    = (object) $request->header;
        $profile        = $this->getProfile($inputHeader->formula_type_code);
        $organizationId = $profile->organization_id;
        $orgCode        = $profile->organization_code;
        $sysdate        = now();


        $itemRef = $cigarateReferCostItemList = $this->getItemRefer(
            $itemId = false,
            $inputHeader->cigarate_refer_cost_item
        )->first();
        $itemPack = $cigaratePackCostItemList = $this->getItemPack(
            $itemId = false,
            $inputHeader->cigarate_pack_cost_item
        )->first();
        $flavourHeader = null;
        if ($inputHeader->flavour) {
            $flavourHeader = $this->getFlavourHeader($inputHeader->flavour)->first();
        }
        $tobaccoType = $this->tobaccoTypeCode($inputHeader->tobacco_type_code)->first();

        $header = new PtpdSmlCostFmlHeadT;
        $header->created_by         = $profile->fnd_user_id;
        $header->created_by_id      = $profile->user_id;
        $header->created_at         = $sysdate;
        $header->creation_date      = $sysdate;
        $header->program_code       = $profile->program_code;
        $header->updated_by_id      = $profile->user_id;
        $header->last_updated_by    = $profile->fnd_user_id;
        $header->updated_at         = $sysdate;
        $header->last_update_date   = $sysdate;
        $header->web_batch_no       = '-1';

        $formulaType = PtpdFormulaTypeV::select(['lookup_code', 'meaning', 'description'])
                            ->where('lookup_code', $inputHeader->formula_type_code)
                            ->first();
        $header->formula_type_code      = optional($formulaType)->lookup_code;
        $header->formula_type           = optional($formulaType)->description;
        $header->recipe_fiscal_year     = $inputHeader->recipe_fiscal_year;


        $header->blend_id               = $inputHeader->blend_id;
        $header->blend_no               = $inputHeader->blend_no;
        $header->example_no             = $inputHeader->example_no;
        $header->flag_cost_standard     = $inputHeader->flag_cost_standard;
        $header->std_period_name        = data_get($inputHeader, 'std_period_name');
        $header->create_transaction_date = $sysdate;
        $header->last_transaction_date  = $sysdate;
        $header->flavour                = $flavourHeader ? $flavourHeader->flavour_code : null;
        $header->flavour_desc           = $flavourHeader ? $flavourHeader->flavour_desc : null;
        $header->quantity               = $inputHeader->quantity;
        $header->uom                    = $inputHeader->uom;
        $header->uom_name               = $inputHeader->uom_name ?? '-';
        $header->user_name              = $profile->user_name;
        $header->cigarate_refer_cost_item = $itemRef->item_no;
        $header->cigarate_refer_cost_desc = $itemRef->item_desc;
        $header->cigarate_pack_cost_item  = $itemPack->item_no;
        $header->cigarate_pack_cost_desc  = $itemPack->item_desc;
        $header->details                = $inputHeader->details;
        $header->note                   = $inputHeader->note;
        $header->tobacco_type_code      = $tobaccoType->tobacco_type_code;
        $header->tobacco_type_desc      = $tobaccoType->tobacco_type_desc;
        $header->tobacco_organization_id = $tobaccoType->tobacco_organization_id;
        $header->tobacco_organization_code = $tobaccoType->tobacco_organization_code;

        $header->example_no             = $inputHeader->example_no;
        $header->web_status             = 'CREATE';

        $batchDate                      = now()->format("YmdHisu");
        $header->save();
        $header->web_batch_no           = "COPY-{$batchDate}-{$header->program_code}-{$header->web_h_id}";
        $header->save();

        // $checkBlend = PtpdFormulaHV::where('blend_no', $header->blend_no)->count();

        $result = $this->interfaceCopyToPd08($header);
        if ($result['status'] != 'S' && $result['status'] != 'C') {
            throw new \Exception($result['msg']);
        }

        $pd08 = PtpdFormulaHV::where('blend_no', $header->blend_no)->first();
        if (!$pd08) {
            throw new \Exception("ไม่พบข้อมูล $header->blend_no: หน้าสร้าง Blend No");
        }

        $url                    = (object)[];
        $preFixRoute            = 'pd.exp-fmls';
        $url->pd08_url        = route("{$preFixRoute}.index", ['blend_no' => $header->blend_no]);
        return $url;
    }

    function storeFromPd08($request)
    {
        $inputHeader    = (object) $request->header;

        $blend = PtpdFormulaHV::where('formula_id', $inputHeader->formula_id)->first();
        if (!$blend) {
            throw new \Exception("ไม่พบข้อมูล Blend No : $inputHeader->blend_no");
        }

        $profile        = $this->getProfile();
        $organizationId = $profile->organization_id;
        $orgCode        = $profile->organization_code;
        $sysdate        = now();

        $header = new PtpdSmlCostFmlHeadT;
        $header->created_by         = $profile->fnd_user_id;
        $header->created_by_id      = $profile->user_id;
        $header->created_at         = $sysdate;
        $header->creation_date      = $sysdate;
        $header->program_code       = $profile->program_code;
        $header->updated_by_id      = $profile->user_id;
        $header->last_updated_by    = $profile->fnd_user_id;
        $header->updated_at         = $sysdate;
        $header->last_update_date   = $sysdate;
        $header->web_batch_no       = '-1';
        $header->formula_type_code      = $blend->formula_type_code;
        $header->formula_type           = $blend->formula_type;
        $header->formula_id             = $blend->formula_id;
        $header->formula_no             = $blend->formula_no;
        $header->formula_vers           = $blend->formula_vers;
        $header->recipe_fiscal_year     = $blend->recipe_fiscal_year;
        $header->recipe_routing_no      = $blend->recipe_routing_no;
        $header->product_item_id        = $blend->product_item_id;
        $header->product_item_code      = $blend->product_item_code;

        $header->blend_id               = null;
        $header->blend_no               = $blend->blend_no;
        $header->example_no             = null;
        $header->flag_cost_standard     = 'Y';
        $header->std_period_name              = null;
        $header->create_transaction_date = $sysdate;
        $header->last_transaction_date = $sysdate;
        $header->flavour                = $blend->flavour_code;
        $header->flavour_desc           = $blend->flavour;
        $header->quantity               = $blend->quantity;
        $header->uom                    = $blend->uom;
        $header->uom_name               = $blend->uom_name ?? '-';
        $header->user_name              = $profile->user_name;
        $header->cigarate_refer_cost_item = null;
        $header->cigarate_refer_cost_desc = null;
        $header->cigarate_pack_cost_item  = null;
        $header->cigarate_pack_cost_desc  = null;
        $header->details                = $blend->details;
        $header->note                   = $blend->note;
        $header->tobacco_type_code      = $blend->tobacco_type_code;
        $header->tobacco_type_desc      = $blend->tobacco_type_desc;
        $header->tobacco_organization_id = $blend->tobacco_organization_id;
        $header->tobacco_organization_code = $blend->tobacco_organization_code;

        $header->web_status             = 'CREATE';
        $batchDate                  = now()->format("YmdHisu");
        $header->save();
        $header->web_batch_no       = "COPYPD08-{$batchDate}-{$header->program_code}-{$header->web_h_id}";
        $header->save();

        $result = $this->interfaceCopyFromPd08($header);
        if ($result['status'] != 'S' && $result['status'] != 'C') {
            throw new \Exception($result['msg']);
        }

        $header = PtpdSmlCostFmlHeadV::where('blend_id', $result['blend_id'])->first();
        if (!$header) {
            throw new \Exception("ไม่พบข้อมูล $header->blend_no: หน้าสร้าง Blend No");
        }

        return $header;
    }

    function reCalCost($request)
    {
        $inputHeader    = (object) $request->header;
        $profile        = $this->getProfile();
        $organizationId = $profile->organization_id;
        $orgCode        = $profile->organization_code;
        $sysdate        = now();
        $stdPeriodNameValue = $this->stdPeriodName(data_get($inputHeader, 'std_period_name'), 'to_period');

        $createTransDate    = $inputHeader->create_transaction_date_format ? parseFromDateTh($inputHeader->create_transaction_date_format , 'H:i:s') : '';
        $lastTransDate      = $inputHeader->last_transaction_date_format ? parseFromDateTh($inputHeader->last_transaction_date_format , 'H:i:s') : $sysdate;
        $lastTransDate      = $sysdate;

        $itemRef = false;
        $itemPack = false;
        if (data_get($inputHeader, 'cigarate_refer_cost_item', false)) {
            $itemRef = $cigarateReferCostItemList = $this->getItemRefer(
                $itemId = false,
                $inputHeader->cigarate_refer_cost_item
            )->first();
        }
        if (data_get($inputHeader, 'cigarate_pack_cost_item', false)) {
            $itemPack = $cigaratePackCostItemList = $this->getItemPack(
                $itemId = false,
                $inputHeader->cigarate_pack_cost_item
            )->first();
        }

        $flavourHeader = null;
        if ($inputHeader->flavour) {
            $flavourHeader = $this->getFlavourHeader($inputHeader->flavour)->first();
        }
        $tobaccoType = $this->tobaccoTypeCode($inputHeader->tobacco_type_code)->first();

        $header = new PtpdSmlCostFmlHeadT;
        $header->created_by         = $profile->fnd_user_id;
        $header->created_by_id      = $profile->user_id;
        $header->created_at         = $sysdate;
        $header->creation_date      = $sysdate;
        $header->program_code       = $profile->program_code;
        $header->updated_by_id      = $profile->user_id;
        $header->last_updated_by    = $profile->fnd_user_id;
        $header->updated_at         = $sysdate;
        $header->last_update_date   = $sysdate;
        $header->web_batch_no       = '-1';


         $formulaType = PtpdFormulaTypeV::select(['lookup_code', 'meaning', 'description'])
                            ->where('lookup_code', $inputHeader->formula_type_code)
                            ->first();
        $header->formula_type_code      = optional($formulaType)->lookup_code;
        $header->formula_type           = optional($formulaType)->description;

        $header->lld_brand_code         = data_get($inputHeader, 'lld_brand_code', '');
        $header->lld_brand_desc         = data_get($inputHeader, 'lld_brand_desc', '');
        $header->lld_qty                = data_get($inputHeader, 'lld_qty', '');

        $header->formula_id             = data_get($inputHeader, 'formula_id', '');
        $header->formula_no             = data_get($inputHeader, 'formula_no', '');
        $header->formula_vers           = data_get($inputHeader, 'formula_vers', '');
        $header->recipe_fiscal_year     = data_get($inputHeader, 'recipe_fiscal_year', '');
        $header->recipe_routing_no      = data_get($inputHeader, 'recipe_routing_no', '');
        $header->product_item_id        = data_get($inputHeader, 'product_item_id', '');
        $header->product_item_code      = data_get($inputHeader, 'product_item_code', '');

        $header->refer_blend_id         = data_get($inputHeader, 'refer_blend_id', '');
        $header->refer_blend_no         = data_get($inputHeader, 'refer_blend_no', '');
        $header->refer_example_no       = data_get($inputHeader, 'refer_example_no', '');

        $header->wc_ciga_cost           = data_get($inputHeader, 'wc_ciga_cost', '');
        $header->wc_cost_price_adjus    = data_get($inputHeader, 'wc_cost_price_adjus', '');
        $header->wc_cost_price_reduc_increase = data_get($inputHeader, 'wc_cost_price_reduc_increase', '');
        $header->wc_cost_after_price_adjus = data_get($inputHeader, 'wc_cost_after_price_adjus', '');
        $header->wage_cost              = data_get($inputHeader, 'wage_cost', '');
        $header->wage_cost_price_adjus  = data_get($inputHeader, 'wage_cost_price_adjus', '');
        $header->wage_cost_price_reduc_increase = data_get($inputHeader, 'wage_cost_price_reduc_increase', '');
        $header->wage_cost_after_price_adjus = data_get($inputHeader, 'wage_cost_after_price_adjus', '');
        $header->ovh_cost               = data_get($inputHeader, 'ovh_cost', '');
        $header->ovh_cost_price_adjus   = data_get($inputHeader, 'ovh_cost_price_adjus', '');
        $header->ovh_cost_price_reduc_increase = data_get($inputHeader, 'ovh_cost_price_reduc_increase', '');
        $header->ovh_cost_after_price_adjus = data_get($inputHeader, 'ovh_cost_after_price_adjus', '');

        $header->blend_id               = $inputHeader->blend_id;
        $header->blend_no               = $inputHeader->blend_no;
        $header->example_no             = $inputHeader->example_no;
        $header->flag_cost_standard     = $inputHeader->flag_cost_standard;
        $header->std_period_name        = ($header->flag_cost_standard == 'N') ? $stdPeriodNameValue : '';
        $header->create_transaction_date = $createTransDate;
        $header->last_transaction_date = $lastTransDate;
        $header->flavour                = $flavourHeader ? $flavourHeader->flavour_code : null;
        $header->flavour_desc           = $flavourHeader ? $flavourHeader->flavour_desc : null;
        $header->quantity               = $inputHeader->quantity;
        $header->uom                    = $inputHeader->uom;
        $header->uom_name               = $inputHeader->uom_name ?? '-';
        $header->user_name              = $profile->user_name;
        $header->cigarate_refer_cost_item = optional($itemRef)->item_no;
        $header->cigarate_refer_cost_desc = optional($itemRef)->item_desc;
        $header->cigarate_pack_cost_item  = optional($itemPack)->item_no;
        $header->cigarate_pack_cost_desc  = optional($itemPack)->item_desc;
        $header->details                = $inputHeader->details;
        $header->note                   = $inputHeader->note;
        $header->tobacco_type_code      = $tobaccoType->tobacco_type_code;
        $header->tobacco_type_desc      = $tobaccoType->tobacco_type_desc;
        $header->tobacco_organization_id = $tobaccoType->tobacco_organization_id;
        $header->tobacco_organization_code = $tobaccoType->tobacco_organization_code;

        $header->example_no             = $inputHeader->example_no;
        $header->web_status             = 'UPDATE';
        $batchDate                      = now()->format("YmdHisu");
        $header->save();
        $header->web_batch_no           = "SAVE-AND-RECAL-{$batchDate}-{$header->program_code}-{$header->web_h_id}";
        $header->save();

        $result = $this->interface($header);
        if ($result['status'] != 'S' && $result['status'] != 'C') {
            throw new \Exception($result['msg']);
        }

        $result = $this->interfaceReCalCost($header);
        if ($result['status'] != 'S' && $result['status'] != 'C') {
            throw new \Exception($result['msg']);
        }


        $header = PtpdSmlCostFmlHeadV::where('blend_id', $inputHeader->blend_id)->first();
        if (!$header) {
            throw new \Exception("ไม่พบข้อมูล $header->blend_no: หน้าสร้าง Blend No");
        }
        return $header;
    }

    function confirmSave($request)
    {
        $inputHeader    = (object) $request->header;
        $result = $this->interfaceConfirmSave($inputHeader);
        if ($result['status'] != 'S' && $result['status'] != 'C') {
            throw new \Exception($result['msg']);
        }

        $header = PtpdSmlCostFmlHeadV::where('blend_id', $inputHeader->blend_id)->first();
        if (!$header) {
            throw new \Exception("ไม่พบข้อมูล $header->blend_no: หน้าสร้าง Blend No");
        }
        return $header;
    }

    function duplicate($request)
    {
        $inputHeader    = (object) $request->header;

        $inputHeader = PtpdSmlCostFmlHeadV::where('blend_id', $inputHeader->blend_id)->first();
        if (!$inputHeader) {
            throw new \Exception("ไม่พบข้อมูล Blend No : $inputHeader->blend_no");
        }

        $profile        = $this->getProfile();
        $organizationId = $profile->organization_id;
        $orgCode        = $profile->organization_code;
        $sysdate        = now();

        $header = new PtpdSmlCostFmlHeadT;
        $header->created_by         = $profile->fnd_user_id;
        $header->created_by_id      = $profile->user_id;
        $header->created_at         = $sysdate;
        $header->creation_date      = $sysdate;
        $header->program_code       = $profile->program_code;
        $header->updated_by_id      = $profile->user_id;
        $header->last_updated_by    = $profile->fnd_user_id;
        $header->updated_at         = $sysdate;
        $header->last_update_date   = $sysdate;
        $header->web_batch_no       = '-1';

        $header->formula_type_code      = $inputHeader->formula_type_code;
        $header->formula_type           = $inputHeader->formula_type;
        $header->formula_id             = data_get($inputHeader, 'formula_id', '');
        $header->formula_no             = data_get($inputHeader, 'formula_no', '');
        $header->formula_vers           = data_get($inputHeader, 'formula_vers', '');
        $header->recipe_fiscal_year     = data_get($inputHeader, 'recipe_fiscal_year', '');
        $header->recipe_routing_no      = data_get($inputHeader, 'recipe_routing_no', '');
        $header->product_item_id        = data_get($inputHeader, 'product_item_id', '');
        $header->product_item_code      = data_get($inputHeader, 'product_item_code', '');

        $header->blend_id               = $inputHeader->blend_id;
        $header->blend_no               = $inputHeader->blend_no;
        $header->example_no             = $inputHeader->example_no;
        $header->flag_cost_standard     = $inputHeader->flag_cost_standard;
        $header->std_period_name        = $this->stdPeriodName(data_get($inputHeader, 'std_period_name'), 'to_period');
        $header->create_transaction_date = $sysdate;
        $header->last_transaction_date  = $sysdate;

        $header->flavour                = $inputHeader->flavour;
        $header->flavour_desc           = $inputHeader->flavour_desc;
        $header->quantity               = $inputHeader->quantity;
        $header->uom                    = $inputHeader->uom;
        $header->uom_name               = $inputHeader->uom_name ?? '-';
        $header->user_name              = $profile->user_name;
        $header->cigarate_refer_cost_item = $inputHeader->cigarate_refer_cost_item;
        $header->cigarate_refer_cost_desc = $inputHeader->cigarate_refer_cost_desc;
        $header->cigarate_pack_cost_item  = $inputHeader->cigarate_pack_cost_item;
        $header->cigarate_pack_cost_desc  = $inputHeader->cigarate_pack_cost_desc;
        $header->details                = $inputHeader->details;
        $header->note                   = $inputHeader->note;
        $header->tobacco_type_code      = $inputHeader->tobacco_type_code;
        $header->tobacco_type_desc      = $inputHeader->tobacco_type_desc;
        $header->tobacco_organization_id = $inputHeader->tobacco_organization_id;
        $header->tobacco_organization_code = $inputHeader->tobacco_organization_code;

        $header->lld_brand_code         = $inputHeader->lld_brand_code;
        $header->lld_brand_desc         = $inputHeader->lld_brand_desc;
        $header->lld_qty                = $inputHeader->lld_qty;

        $header->wc_ciga_cost           = data_get($inputHeader, 'wc_ciga_cost', '');
        $header->wc_cost_price_adjus    = data_get($inputHeader, 'wc_cost_price_adjus', '');
        $header->wc_cost_price_reduc_increase = data_get($inputHeader, 'wc_cost_price_reduc_increase', '');
        $header->wc_cost_after_price_adjus = data_get($inputHeader, 'wc_cost_after_price_adjus', '');
        $header->wage_cost              = data_get($inputHeader, 'wage_cost', '');
        $header->wage_cost_price_adjus  = data_get($inputHeader, 'wage_cost_price_adjus', '');
        $header->wage_cost_price_reduc_increase = data_get($inputHeader, 'wage_cost_price_reduc_increase', '');
        $header->wage_cost_after_price_adjus = data_get($inputHeader, 'wage_cost_after_price_adjus', '');
        $header->ovh_cost               = data_get($inputHeader, 'ovh_cost', '');
        $header->ovh_cost_price_adjus   = data_get($inputHeader, 'ovh_cost_price_adjus', '');
        $header->ovh_cost_price_reduc_increase = data_get($inputHeader, 'ovh_cost_price_reduc_increase', '');
        $header->ovh_cost_after_price_adjus = data_get($inputHeader, 'ovh_cost_after_price_adjus', '');

        $header->refer_blend_id         = $inputHeader->blend_id;
        $header->refer_blend_no         = $inputHeader->blend_no;
        $header->refer_example_no       = $inputHeader->example_no;
        $header->web_status             = 'CREATE';
        $batchDate                      = now()->format("YmdHisu");
        $header->save();
        $header->web_batch_no           = "COPYPD03-{$batchDate}-{$header->program_code}-{$header->web_h_id}";
        $header->save();

        $result = $this->interfaceDuplicate($header);
        if ($result['status'] != 'S' && $result['status'] != 'C') {
            throw new \Exception($result['msg']);
        }

        $header = PtpdSmlCostFmlHeadV::where('blend_id', $result['blend_id'])->first();
        if (!$header) {
            throw new \Exception("ไม่พบข้อมูล $header->blend_no: หน้าสร้าง Blend No");
        }

        return $header;
    }

    function validate($request)
    {
        $result = ['valid'=> true, 'err_html'=> ''];
        $inputHeader = (object) $request->header;

        $error = '';
        if (! $inputHeader->blend_no) {
            $error .= $this->errorHtml('โปรดระบุ Blend No.');
        }

        if ($inputHeader->flag_cost_standard == 'N' && (!$inputHeader->std_period_name || $inputHeader->std_period_name == 'Invalid date')) {
            $error .= $this->errorHtml('โปรดระบุ ราคา ณ วันที่');
        }


        if (! $inputHeader->tobacco_type_code) {
            $error .= $this->errorHtml('ประเภทยาเส้น');
        }

        if ($error != '') {
            $result['valid'] = false;
            $result['err_html'] = $error;
        }

        return $result;
    }

    function errorHtml($error)
    {
        $html = '<div class="text-danger">';
        $html .= $error;
        $html .= '</div>';
        return $html;
    }

    function store($request)
    {
        $inputHeader    = (object) $request->header;
        $profile        = $this->getProfile();
        $organizationId = $profile->organization_id;
        $orgCode        = $profile->organization_code;
        $sysdate        = now();
        $stdPeriodNameValue = $this->stdPeriodName(data_get($inputHeader, 'std_period_name'), 'to_period');

        $createTransDate    = $inputHeader->create_transaction_date_format ? parseFromDateTh($inputHeader->create_transaction_date_format , 'H:i:s') : '';
        $lastTransDate      = $inputHeader->last_transaction_date_format ? parseFromDateTh($inputHeader->last_transaction_date_format , 'H:i:s') : $sysdate;
        $lastTransDate      = $sysdate;

        $itemRef = false;
        $itemPack = false;
        if (data_get($inputHeader, 'cigarate_refer_cost_item', false)) {
            $itemRef = $cigarateReferCostItemList = $this->getItemRefer(
                $itemId = false,
                $inputHeader->cigarate_refer_cost_item
            )->first();
        }
        if (data_get($inputHeader, 'cigarate_pack_cost_item', false)) {
            $itemPack = $cigaratePackCostItemList = $this->getItemPack(
                $itemId = false,
                $inputHeader->cigarate_pack_cost_item
            )->first();
        }

        $flavourHeader = null;
        if ($inputHeader->flavour) {
            $flavourHeader = $this->getFlavourHeader($inputHeader->flavour)->first();
        }
        $tobaccoType = $this->tobaccoTypeCode($inputHeader->tobacco_type_code)->first();

        $header = new PtpdSmlCostFmlHeadT;
        $header->created_by         = $profile->fnd_user_id;
        $header->created_by_id      = $profile->user_id;
        $header->created_at         = $sysdate;
        $header->creation_date      = $sysdate;
        $header->program_code       = $profile->program_code;
        $header->updated_by_id      = $profile->user_id;
        $header->last_updated_by    = $profile->fnd_user_id;
        $header->updated_at         = $sysdate;
        $header->last_update_date   = $sysdate;
        $header->web_batch_no       = '-1';


         $formulaType = PtpdFormulaTypeV::select(['lookup_code', 'meaning', 'description'])
                            ->where('lookup_code', $inputHeader->formula_type_code)
                            ->first();
        $header->formula_type_code      = optional($formulaType)->lookup_code;
        $header->formula_type           = optional($formulaType)->description;

        $header->lld_brand_code         = data_get($inputHeader, 'lld_brand_code', '');
        $header->lld_brand_desc         = data_get($inputHeader, 'lld_brand_desc', '');
        $header->lld_qty                = data_get($inputHeader, 'lld_qty', '');

        $header->formula_id             = data_get($inputHeader, 'formula_id', '');
        $header->formula_no             = data_get($inputHeader, 'formula_no', '');
        $header->formula_vers           = data_get($inputHeader, 'formula_vers', '');
        $header->recipe_fiscal_year     =  data_get($inputHeader, 'recipe_fiscal_year', '');
        $header->recipe_routing_no      = data_get($inputHeader, 'recipe_routing_no', '');
        $header->product_item_id        = data_get($inputHeader, 'product_item_id', '');
        $header->product_item_code      = data_get($inputHeader, 'product_item_code', '');

        $header->refer_blend_id         = data_get($inputHeader, 'refer_blend_id', '');
        $header->refer_blend_no         = data_get($inputHeader, 'refer_blend_no', '');
        $header->refer_example_no       = data_get($inputHeader, 'refer_example_no', '');

        $header->wc_ciga_cost           = data_get($inputHeader, 'wc_ciga_cost', '');
        $header->wc_cost_price_adjus    = data_get($inputHeader, 'wc_cost_price_adjus', '');
        $header->wc_cost_price_reduc_increase = data_get($inputHeader, 'wc_cost_price_reduc_increase', '');
        $header->wc_cost_after_price_adjus = data_get($inputHeader, 'wc_cost_after_price_adjus', '');
        $header->wage_cost              = data_get($inputHeader, 'wage_cost', '');
        $header->wage_cost_price_adjus  = data_get($inputHeader, 'wage_cost_price_adjus', '');
        $header->wage_cost_price_reduc_increase = data_get($inputHeader, 'wage_cost_price_reduc_increase', '');
        $header->wage_cost_after_price_adjus = data_get($inputHeader, 'wage_cost_after_price_adjus', '');
        $header->ovh_cost               = data_get($inputHeader, 'ovh_cost', '');
        $header->ovh_cost_price_adjus   = data_get($inputHeader, 'ovh_cost_price_adjus', '');
        $header->ovh_cost_price_reduc_increase = data_get($inputHeader, 'ovh_cost_price_reduc_increase', '');
        $header->ovh_cost_after_price_adjus = data_get($inputHeader, 'ovh_cost_after_price_adjus', '');

        $header->blend_id               = $inputHeader->blend_id;
        $header->blend_no               = $inputHeader->blend_no;
        $header->example_no             = $inputHeader->example_no;
        $header->flag_cost_standard     = $inputHeader->flag_cost_standard;
        $header->std_period_name        = ($header->flag_cost_standard == 'N') ? $stdPeriodNameValue : '';
        $header->create_transaction_date = $createTransDate;
        $header->last_transaction_date = $lastTransDate;
        $header->flavour                = $flavourHeader ? $flavourHeader->flavour_code : null;
        $header->flavour_desc           = $flavourHeader ? $flavourHeader->flavour_desc : null;
        $header->quantity               = $inputHeader->quantity;
        $header->uom                    = $inputHeader->uom;
        $header->uom_name               = $inputHeader->uom_name ?? '-';
        $header->user_name              = $profile->user_name;
        $header->cigarate_refer_cost_item = optional($itemRef)->item_no;
        $header->cigarate_refer_cost_desc = optional($itemRef)->item_desc;
        $header->cigarate_pack_cost_item  = optional($itemPack)->item_no;
        $header->cigarate_pack_cost_desc  = optional($itemPack)->item_desc;
        $header->details                = $inputHeader->details;
        $header->note                   = $inputHeader->note;
        $header->tobacco_type_code      = $tobaccoType->tobacco_type_code;
        $header->tobacco_type_desc      = $tobaccoType->tobacco_type_desc;
        $header->tobacco_organization_id = $tobaccoType->tobacco_organization_id;
        $header->tobacco_organization_code = $tobaccoType->tobacco_organization_code;

        $header->example_no             = $inputHeader->example_no;
        $header->web_status             = 'CREATE';
        if ($inputHeader->blend_id) {
            $header->web_status = 'UPDATE';
        }
        $batchDate                  = now()->format("YmdHisu");
        $header->save();
        $header->web_batch_no       = "{$batchDate}-{$header->program_code}-{$header->web_h_id}";
        $header->save();

        // Tab: leaf_formulas
        if (count($request->leaf_formulas)) {
            $leafFormulas = collect($request->leaf_formulas);
            $leafTotalProportion = $leafFormulas->sum('leaf_total_proportion');
            foreach ($leafFormulas as $key => $leafFormula) {
                $leafFormula = (object)$leafFormula;
                // ไม่บันทึกรายการใหม่ ที่ถูกลบ บนหน้าจอ
                if (!($leafFormula->is_new_row && $leafFormula->is_deleted)) {
                    $leaf = new PtpdSmlCostLeafHFmlT;
                    $leaf->web_h_id         = $header->web_h_id;
                    $leaf->blend_id         = $header->blend_id;
                    $leaf->blend_no         = $header->blend_no;
                    $leaf->example_no       = $header->example_no;
                    // $leaf->organization_code = $orgCode;
                    // $leaf->organization_id  = $organizationId;
                    $leaf->leaf_formula     = $leafFormula->leaf_formula;
                    $leaf->leaf_formula_desc = $leafFormula->leaf_formula_desc;
                    $leaf->leaf_proportion  = $leafFormula->leaf_proportion;
                    $leaf->leaf_total_proportion = $leafTotalProportion;

                    $leaf->web_status             = 'CREATE';
                    if (!$leafFormula->is_new_row) {
                        $leaf->web_status  = 'UPDATE';
                    }
                    if ($leafFormula->is_deleted) {
                        $leaf->web_status  = 'DELETE';
                        $delCasingByLeafFormula[] = $leaf->leaf_formula;
                    }

                    $leaf->created_by         = $header->created_by;
                    $leaf->created_by_id      = $header->created_by_id;
                    $leaf->created_at         = $header->created_at;
                    $leaf->creation_date      = $header->creation_date;
                    $leaf->program_code       = $header->program_code;
                    $leaf->updated_by_id      = $header->updated_by_id;
                    $leaf->last_updated_by    = $header->last_updated_by;
                    $leaf->updated_at         = $header->updated_at;
                    $leaf->last_update_date   = $header->last_update_date;
                    $leaf->web_batch_no       = $header->web_batch_no;
                    $leaf->save();

                    foreach ($leafFormula->leaf_dtl ?? [] as $key => $ingredient) {
                        $ingredient = (object) $ingredient;

                        if (!($ingredient->is_new_row && $ingredient->is_deleted) && $ingredient->inventory_item_id) {
                            $newIngredient = new PtpdSmlCostLeafDFmlT;

                            $newIngredient->web_h_id            = $header->web_h_id;
                            $newIngredient->web_lh_id           = $leaf->web_lh_id;
                            $newIngredient->blend_id            = $header->blend_id;
                            $newIngredient->blend_no            = $header->blend_no;
                            $newIngredient->example_no          = $header->example_no;
                            $newIngredient->leaf_formula        = $leaf->leaf_formula;
                            $newIngredient->line_no             = $ingredient->line_no;
                            $newIngredient->inventory_item_id   = $ingredient->inventory_item_id;
                            $newIngredient->item_code           = $ingredient->item_code;
                            $newIngredient->item_desc           = $ingredient->item_desc;
                            $newIngredient->lot_number          = $ingredient->lot_number;
                            // $newIngredient->ingredient_proportions = $ingredient->ingredient_proportions;


                            $newIngredient->enable_flag         = data_get($ingredient, 'enable_flag', 'N');
                            $newIngredient->x_fm_leaf_d_id      = data_get($ingredient, 'fm_leaf_d_id', '');
                            $newIngredient->unit_cost           = $ingredient->unit_cost;
                            $newIngredient->proportion_percent  = $ingredient->proportion_percent ?? 0;
                            $newIngredient->quantity_used       = $ingredient->quantity_used ?? 0;
                            $newIngredient->uom                 = $ingredient->uom;
                            $newIngredient->cost_materials_used = $ingredient->cost_materials_used ?? 0;
                            $newIngredient->price_adjus         = $ingredient->price_adjus ?? 0;
                            $newIngredient->price_reduc_increase = $ingredient->price_reduc_increase ?? 0;
                            $newIngredient->cost_after_price_adjus = $ingredient->cost_after_price_adjus ?? 0;

                            $newIngredient->cost_per_cgk_baht   = data_get($ingredient, 'cost_per_cgk_baht', '');
                            // $newIngredient->period_year         = $ingredient->period_year;
                            // $newIngredient->version             = $ingredient->version;


                            $newIngredient->web_status          = 'CREATE';
                            if (!$ingredient->is_new_row) {
                                $newIngredient->web_status      = 'UPDATE';
                            }
                            if ($ingredient->is_deleted || $leaf->web_status == 'DELETE') {
                                $newIngredient->web_status      = 'DELETE';
                            }

                            // $newIngredient->organization_code  = $orgCode;
                            $newIngredient->created_by         = $header->created_by;
                            $newIngredient->created_by_id      = $header->created_by_id;
                            $newIngredient->created_at         = $header->created_at;
                            $newIngredient->creation_date      = $header->creation_date;
                            $newIngredient->program_code       = $header->program_code;
                            $newIngredient->updated_by_id      = $header->updated_by_id;
                            $newIngredient->last_updated_by    = $header->last_updated_by;
                            $newIngredient->updated_at         = $header->updated_at;
                            $newIngredient->last_update_date   = $header->last_update_date;
                            $newIngredient->web_batch_no       = $header->web_batch_no;
                            $newIngredient->save();
                        }
                    }
                }
            }
        }

        // Tab: casings
        if (count($request->casings)) {
            foreach ($request->casings as $key => $inputCasing) {
                $inputCasing = (object) $inputCasing;

                if (!($inputCasing->is_new_row && $inputCasing->is_deleted)) { // ไม่บันทึกรายการใหม่ ที่ถูกลบ บนหน้าจอ

                    foreach ($inputCasing->casing_items as $key => $inputItem) {
                        $inputItem = (object) $inputItem;
                        $webStatus = 'CREATE';
                        if ($header->blend_id) {
                            $checkRow =  PtpdSmlCostCasingFmlV::where('blend_id', $header->blend_id)
                                            ->where('leaf_formula', $inputCasing->old_leaf_formula)
                                            ->where('casing_id', $inputCasing->old_casing_id)
                                            // ->where('item_code', $inputItem->item_code)
                                            ->first();
                            if ($checkRow) {
                                // $casing->formulaline_id = $checkRow->formulaline_id;
                                // $casing->line_no        = $checkRow->line_no;

                                $inputItem->formulaline_id  = $checkRow->formulaline_id;
                                $inputItem->line_no         = $checkRow->line_no;
                                $webStatus     = 'UPDATE';
                            }
                        }

                        if (!$inputCasing->is_new_row) {
                            $webStatus  = 'UPDATE';
                        }
                        if ($inputCasing->is_deleted) {
                            $webStatus  = 'DELETE';
                        }
                        $inputItem->web_status = $webStatus;
                        (new SmlCostFmlFuncRepository)->createCasingTmp($header, $inputCasing, $inputItem);
                    }
                }
            }
        }

        // Tab: flavors
        if (count($flavors = $request->flavors)) {
            foreach ($flavors as $key => $inputFlavor) {
                $inputFlavor = (object)$inputFlavor;
                // ไม่บันทึกรายการใหม่ ที่ถูกลบ บนหน้าจอ
                if (!($inputFlavor->is_new_row && $inputFlavor->is_deleted)) {
                    foreach ($inputFlavor->flavor_items as $key => $inputItem) {
                        $inputItem = (object) $inputItem;

                        $flavor                         = new PtpdSmlCostFlavorFmlT;
                        // $flavor->formula_id             = $header->formula_id;
                        // $flavor->formula_no             = $header->formula_no;
                        $flavor->flavor_id              = $inputFlavor->flavor_id;
                        $flavor->flavor_no              = $inputFlavor->flavor_no;
                        $flavor->flavor_desc            = $inputFlavor->flavor_desc;
                        // $flavor->flavor_status          = $inputFlavor->flavor_status ? 'Y' : 'N';
                        $flavor->enable_flag            = data_get($inputItem, 'enable_flag', 'N');
                        $flavor->unit_cost              = $inputItem->unit_cost;
                        $flavor->price_adjus            = $inputItem->price_adjus;
                        $flavor->price_reduc_increase   = $inputItem->price_reduc_increase;
                        $flavor->cost_after_price_adjus = $inputItem->cost_after_price_adjus;

                        // $flavor->organization_id        = $inputItem->organization_id;
                        $flavor->inventory_item_id      = $inputItem->inventory_item_id;
                        $flavor->item_code              = $inputItem->item_code;
                        $flavor->item_desc              = $inputItem->item_desc;
                        $flavor->quantity_used          = $inputItem->quantity_used;
                        $flavor->uom                    = $inputItem->uom;
                        $flavor->cost_per_cgk_baht      = data_get($inputItem, 'cost_per_cgk_baht', '');

                        // $flavor->formula_vers           = $header->formula_vers;
                        $flavor->blend_id               = $header->blend_id;
                        $flavor->blend_no               = $header->blend_no;
                        $flavor->example_no             = $header->example_no;
                        $flavor->x_fm_flavor_id         = data_get($inputItem, 'fm_flavor_id', '');
                        // $flavor->organization_code      = $header->tobacco_organization_code;

                        $flavor->created_by             = $header->created_by;
                        $flavor->created_by_id          = $header->created_by_id;
                        $flavor->created_at             = $header->created_at;
                        $flavor->creation_date          = $header->creation_date;
                        $flavor->program_code           = $header->program_code;
                        $flavor->updated_by_id          = $header->updated_by_id;
                        $flavor->last_updated_by        = $header->last_updated_by;
                        $flavor->updated_at             = $header->updated_at;
                        $flavor->last_update_date       = $header->last_update_date;
                        $flavor->web_batch_no           = $header->web_batch_no;

                        $flavor->web_status             = 'CREATE';
                        if ($header->formula_id) {
                            $checkRow =  PtpdSmlCostFlavorV::where('flavor_id', $inputFlavor->old_flavor_id)
                                            ->where('item_code', $inputItem->old_item_code)
                                            ->first();
                            if ($checkRow) {
                                // $flavor->formulaline_id = $checkRow->formulaline_id;
                                $flavor->line_no        = $checkRow->line_no;
                                $flavor->web_status     = 'UPDATE';
                            }
                        }
                        if (!$inputFlavor->is_new_row) {
                            $flavor->web_status  = 'UPDATE';
                        }
                        if ($inputFlavor->is_deleted) {
                            $flavor->web_status  = 'DELETE';
                        }
                        $flavor->save();
                    }
                }
            }
        }


        // Tab: cigarettes
        if (count($cigarettes = $request->cigarettes)) {
            foreach ($cigarettes as $key => $inputCigarette) {
                $inputCigarette = (object)$inputCigarette;
                // ไม่บันทึกรายการใหม่ ที่ถูกลบ บนหน้าจอ
                if (!($inputCigarette->is_new_row && $inputCigarette->is_deleted)) {
                    foreach ($inputCigarette->items as $key => $inputItem) {
                        $inputItem = (object) $inputItem;

                        $costWrapCigaFm                         = new PtpdSmlCostWrapCigaFmlT;
                        $costWrapCigaFm->product_item           = $inputItem->product_item;
                        $costWrapCigaFm->blend_id               = $inputItem->blend_id;
                        $costWrapCigaFm->x_fm_wc_id             = $inputItem->fm_wc_id;
                        $costWrapCigaFm->wip_code               = $inputItem->wip_code;
                        $costWrapCigaFm->wip_desc               = $inputItem->wip_desc;
                        $costWrapCigaFm->enable_flag            = $inputItem->enable_flag;
                        $costWrapCigaFm->inventory_item_id      = $inputItem->inventory_item_id;
                        $costWrapCigaFm->item_code              = $inputItem->item_code;
                        $costWrapCigaFm->item_desc              = $inputItem->item_desc;
                        $costWrapCigaFm->unit_cost              = $inputItem->unit_cost ?? 0;
                        $costWrapCigaFm->price_adjus            = $inputItem->price_adjus ?? 0;
                        $costWrapCigaFm->price_reduc_increase   = $inputItem->price_reduc_increase ?? 0;
                        $costWrapCigaFm->cost_after_price_adjus = $inputItem->cost_after_price_adjus ?? 0;
                        $costWrapCigaFm->quantity_used          = $inputItem->quantity_used ?? 0;
                        $costWrapCigaFm->cost_per_cgk_baht      = data_get($inputItem, 'cost_per_cgk_baht', '');
                        $costWrapCigaFm->attribute1             = data_get($inputItem, 'attribute1', '');

                        $costWrapCigaFm->uom                    = $inputItem->uom;

                        $costWrapCigaFm->blend_id               = $header->blend_id;
                        $costWrapCigaFm->blend_no               = $header->blend_no;
                        $costWrapCigaFm->example_no             = $header->example_no;

                        $costWrapCigaFm->created_by             = $header->created_by;
                        $costWrapCigaFm->created_by_id          = $header->created_by_id;
                        $costWrapCigaFm->created_at             = $header->created_at;
                        $costWrapCigaFm->creation_date          = $header->creation_date;
                        $costWrapCigaFm->program_code           = $header->program_code;
                        $costWrapCigaFm->updated_by_id          = $header->updated_by_id;
                        $costWrapCigaFm->last_updated_by        = $header->last_updated_by;
                        $costWrapCigaFm->updated_at             = $header->updated_at;
                        $costWrapCigaFm->last_update_date       = $header->last_update_date;
                        $costWrapCigaFm->web_batch_no           = $header->web_batch_no;

                        $costWrapCigaFm->web_status             = 'CREATE';
                        if ($header->formula_id) {
                            $checkRow =  PtpdSmlCostWrapCigaFmlV::where('blend_id', $header->blend_id)
                                            ->where('fm_wc_id', $inputItem->fm_wc_id)
                                            ->first();
                            if ($checkRow) {
                                // $costWrapCigaFm->formulaline_id = $checkRow->formulaline_id;
                                $costWrapCigaFm->line_no        = $checkRow->line_no;
                                $costWrapCigaFm->web_status     = 'UPDATE';
                            }
                        }
                        if (!data_get($inputItem, 'is_new_row')) {
                            $costWrapCigaFm->web_status  = 'UPDATE';
                        }
                        if (data_get($inputItem, 'is_deleted')) {
                            $costWrapCigaFm->web_status  = 'DELETE';
                        }
                        $costWrapCigaFm->save();
                    }
                }
            }
        }

        // $newCigarettes = [];
        // if (count($cigarettes = $request->cigarettes)) {
        //     foreach ($cigarettes as $key => $inputCigar) {
        //         $inputCigar = (object) $inputCigar;

        //         if (!($inputCigar->is_new_row && $inputCigar->is_deleted)) {

        //             if (!$inputCigar->is_new_row) {
        //                 $newCigar = PtpdSmlCostCigarFml::where("fm_cigar_id", $inputCigar->fm_cigar_id)->first();
        //             } else {
        //                 $newCigar = new PtpdSmlCostCigarFml;
        //             }

        //             // $newCigar->formula_id           = $formula->formula_id;
        //             $newCigar->formula_no           = -1;
        //             // $newCigar->formula_vers         = $formula->formula_vers;
        //             $newCigar->blend_id             = $header->blend_id;
        //             $newCigar->blend_no             = $header->blend_no;
        //             // $newCigar->cigar_formula_id     = $inputCigar->cigar_formula_id;
        //             // $newCigar->cigar_formula_no     = $inputCigar->cigar_formula_no;
        //             // $newCigar->cigar_description    = $inputCigar->cigar_description;

        //             $newCigar->cigar_item_id        = $inputCigar->cigar_item_id;
        //             $newCigar->cigar_organization_code = $inputCigar->cigar_organization_code;
        //             $newCigar->cigar_organization_id = $inputCigar->cigar_organization_id;
        //             $newCigar->cigar_item_code      = $inputCigar->cigar_item_code;
        //             $newCigar->cigar_item_desc      = $inputCigar->cigar_item_desc;

        //             $newCigar->created_by           = $header->created_by;
        //             $newCigar->created_by_id        = $header->created_by_id;
        //             $newCigar->created_at           = $header->created_at;
        //             $newCigar->creation_date        = $header->creation_date;
        //             $newCigar->program_code         = $header->program_code;
        //             $newCigar->updated_by_id        = $header->updated_by_id;
        //             $newCigar->last_updated_by      = $header->last_updated_by;
        //             $newCigar->updated_at           = $header->updated_at;
        //             $newCigar->last_update_date     = $header->last_update_date;
        //             $newCigar->web_batch_no         = $header->web_batch_no;

        //             $newCigar->web_status           = 'CREATE';
        //             if (!$inputCigar->fm_cigar_id) {
        //                 $newCigar->web_status       = 'UPDATE';
        //             }
        //             if ($inputCigar->is_deleted) {
        //                 $newCigar->web_status       = 'DELETE';
        //                 $newCigar->deleted_at       = now();
        //                 $newCigar->deleted_by_id    = $profile->user_id;
        //             }

        //             // if ($inputCigar->is_deleted) {
        //             //     // code...
        //             //     dd('xxx', $newCigar->web_status, $newCigar->fm_cigar_id, $inputCigar);
        //             // }
        //             $newCigar->save();
        //             data_set($newCigarettes, $inputCigar->fm_cigar_id, (object)[
        //                 'fm_cigar_id'           => $newCigar->fm_cigar_id,
        //                 'cigar_organization_id' => $newCigar->cigar_organization_id,
        //                 'cigar_organization_code' => $newCigar->cigar_organization_code,
        //                 'cigar_item_id'         => $newCigar->cigar_item_id,
        //                 'web_status'            => $newCigar->web_status
        //             ]);
        //         }
        //     }
        // };


        if (count($cigarDtl = $request->cigar_dtl)) {
            foreach (collect($cigarDtl)->groupBy('fm_cigar_id') as $keyFmCigarId => $inputCigarDtlByItem) {

                foreach ($inputCigarDtlByItem as $key => $inputCigarDtl) {
                    $inputCigarDtl = (object) $inputCigarDtl;
                    $checkCigarette = data_get($newCigarettes, "$keyFmCigarId");
                    if (!($inputCigarDtl->is_new_row && $inputCigarDtl->is_deleted) && $checkCigarette->fm_cigar_id) {
                        $checkItem = PtpdSmlCostWrappedFml::where("fm_wrapped_id", $inputCigarDtl->fm_wrapped_id)
                                        ->first();

                        if ($checkItem) {
                            $newCigarDtl = $checkItem;
                        } else {
                            $newCigarDtl = new PtpdSmlCostWrappedFml;
                        }

                        // $newCigarDtl->formula_id           = $header->formula_id;
                        // $newCigarDtl->formula_no           = $header->formula_no;

                        $newCigarDtl->wrapped_flag          = -1;
                        $newCigarDtl->wrapped_line_no       = $inputCigarDtl->cigar_line_no;
                        $newCigarDtl->wrapped_description   = $inputCigarDtl->cigar_description ?? '-';

                        $newCigarDtl->fm_cigar_id           = data_get($checkCigarette, "fm_cigar_id");
                        $newCigarDtl->tobacco_organization_id = data_get($checkCigarette, "cigar_organization_id");
                        $newCigarDtl->tobacco_organization_code = data_get($checkCigarette, "cigar_organization_code");

                        // $newCigarDtl->cigar_organization_id = data_get($checkCigarette, "cigar_organization_id");
                        // $newCigarDtl->cigar_item_id         = data_get($checkCigarette, "cigar_item_id");
                        // $newCigarDtl->formula_vers          = $header->formula_vers;
                        $newCigarDtl->web_h_id              = $header->web_h_id;
                        $newCigarDtl->blend_id              = $header->blend_id;
                        $newCigarDtl->blend_no              = $header->blend_no;
                        $newCigarDtl->example_no            = $header->example_no;
                        // $newCigarDtl->cigar_organization_id = $header->or_formula_organization_id ?? -1;

                        $newCigarDtl->created_by           = $header->created_by;
                        $newCigarDtl->created_by_id        = $header->created_by_id;
                        $newCigarDtl->created_at           = $header->created_at;
                        $newCigarDtl->creation_date        = $header->creation_date;
                        $newCigarDtl->program_code         = $header->program_code;
                        $newCigarDtl->updated_by_id        = $header->updated_by_id;
                        $newCigarDtl->last_updated_by      = $header->last_updated_by;
                        $newCigarDtl->updated_at           = $header->updated_at;
                        $newCigarDtl->last_update_date     = $header->last_update_date;
                        $newCigarDtl->web_batch_no         = $header->web_batch_no;

                        $newCigarDtl->web_status           = 'CREATE';
                        if ($inputCigarDtl->is_new_row) {
                            $newCigarDtl->web_status       = 'UPDATE';
                        }

                        if ($inputCigarDtl->is_deleted || data_get($checkCigarette, "web_status") == 'DELETE') {
                            $newCigarDtl->web_status       = 'DELETE';
                            $newCigarDtl->deleted_at       = now();
                            $newCigarDtl->deleted_by_id    = $profile->user_id;
                        }

                        $newCigarDtl->save();
                    }
                }
            }
        };


        // dd('xx', $header);


        $result = $this->interface($header);
        if ($result['status'] != 'S' && $result['status'] != 'C') {
            throw new \Exception($result['msg']);
        }
        $header = PtpdSmlCostFmlHeadV::where('blend_id', $result['blend_id'])->first();

        // PtpdSmlCostFmlHeadV

        return $header;
        dd('xx', $header);



        $inputHeader    = (object) $request->header;
        $profile        = $this->getProfile($inputHeader->formula_type_code);
        $organizationId = $profile->organization_id;
        $orgCode        = $profile->organization_code;
        $sysdate        = now();
        $delCasingByLeafFormula = [];

        // dd('xx', $inputHeader);


        // throw new \Exception('test Error');


        $formulaId = data_get($inputHeader, 'formula_id', $inputHeader->formula_id);
        $blendId = data_get($inputHeader, 'blend_id', $inputHeader->blend_id);
        if ($formulaId && false) {
            // code...
        } else {
            $formula = new PtpdFormulaHT;

            $formula->created_by         = $profile->fnd_user_id;
            $formula->created_by_id      = $profile->user_id;
            $formula->created_at         = $sysdate;
            $formula->creation_date      = $sysdate;
            $formula->program_code       = $profile->program_code;


            $formula->web_status    = 'CREATE';
            if ($formulaId || $blendId) {
                $formula->web_status = 'UPDATE';
            }

            $flavourData = PtpdBlendFlavourV::selectRaw("
                                flavour,
                                flavour_code,
                                formula_organization_id,
                                formula_organization_code,
                                organization_id,
                                organization_code,
                                department,
                                flavour_code    as value,
                                flavour         as label
                            ")
                            // ->where('formula_organization_code', $inputHeader->formula_organization_code)
                            // ->where('formula_organization_code', $profile->organization_code)
                            ->where('flavour_code', $inputHeader->flavour_code)
                            ->orderBy('flavour')
                            ->first();
            if ($flavourData) {
                $formula->flavour_code      = $flavourData->flavour_code;
                $formula->flavour           = $flavourData->flavour;
                // $formula->formula_organization_code = $flavourData->formula_organization_code; //DEV2 UAT ไม่มี
                // $formula->organization_code = $flavourData->organization_code; //DEV2 UAT ไม่มี
                $formula->department        = $flavourData->department;
            }

            $formula->or_formula_id          = $inputHeader->or_formula_id;
            $formula->or_formula_organization_id = $inputHeader->or_formula_organization_id;
            $formula->formula_vers              = $inputHeader->formula_vers;
            $formula->or_formula_vers           = $inputHeader->or_formula_vers;
            // $formula->organization_id          = $inputHeader->organization_id; //DEV2 UAT ไม่มี

            $formula->tobacco_type_code = $inputHeader->tobacco_type_code;
            if ($formula->tobacco_type_code) {
                $tobaccoTypeDesc = (new ExpFmlFuncRepository)->getTobaccoTypeList(
                                        $profile->organization_id,
                                        $formula->tobacco_type_code
                                    );
                $tobaccoTypeDesc = count($tobaccoTypeDesc) ? $tobaccoTypeDesc->first()->tobacco_type_desc : '';
                $formula->tobacco_type_desc        = $tobaccoTypeDesc;
            }

            $formula->tobacco_organization_id = $organizationId;
            $formula->tobacco_organization_code = $orgCode;

            $formula->recipe_fiscal_year = $inputHeader->recipe_fiscal_year;
            $formula->formula_id        = $formulaId;
            $formula->blend_id          = $inputHeader->blend_id;
            $formula->blend_no          = $inputHeader->blend_no;
            $formula->formula_no        = $inputHeader->blend_no;

            $formula->product_item_id = $inputHeader->product_item_id;
            if ($formula->product_item_id) {
                $item = collect(\DB::select("
                            SELECT segment1 FROM MTL_SYSTEM_ITEMS_B where  INVENTORY_ITEM_ID = {$inputHeader->product_item_id}
                        "))->first();
                $formula->product_item_code = $item->segment1;
            }


            $formula->description       = $inputHeader->description;
            $formula->comments          = $inputHeader->comments;
            $formula->quantity          = $inputHeader->quantity;
            $formula->uom               = $inputHeader->uom;
            $formula->recipe_routing_no = $inputHeader->recipe_routing_no;

            $formulaType = PtpdFormulaTypeV::select(['lookup_code', 'meaning', 'description'])
                            ->where('lookup_code', $inputHeader->formula_type_code)
                            ->first();
            $formula->formula_type_code = optional($formulaType)->lookup_code;
            $formula->formula_type      = optional($formulaType)->description;

            $formula->formula_status            = $inputHeader->formula_status;
            $formula->user_name                 = $inputHeader->user_name;
            $formula->formula_creation_date     = $inputHeader->formula_creation_date_format ? parseFromDateTh($inputHeader->formula_creation_date_format , 'H:i:s') : '';
            $formula->formula_last_update_date  = $inputHeader->formula_last_update_date_format ? parseFromDateTh($inputHeader->formula_last_update_date_format , 'H:i:s') : '';

            // $formula->formula_creation_date     = now();
            $formula->formula_last_update_date  = now();

            $formula->formula_approval_date     = $inputHeader->formula_approval_date_format ? parseFromDateTh($inputHeader->formula_approval_date_format) : '';
            $formula->formula_start_date        = $inputHeader->formula_start_date_format ? parseFromDateTh($inputHeader->formula_start_date_format) : '';


            // dd('zz', $formula);

            $formula->updated_by_id      = $profile->user_id;
            $formula->last_updated_by    = $profile->fnd_user_id;
            $formula->updated_at         = $sysdate;
            $formula->last_update_date   = $sysdate;
            $formula->web_batch_no       = '-1';

            $formula->save();
            // $formula->web_batch_no       = "{$formula->program_code}-{$formula->fm_id}";
            $batchDate                  = now()->format("YmdHisu");
            $formula->save();
            $formula->web_batch_no       = "{$batchDate}-{$formula->program_code}-{$formula->fm_id}";
            $formula->save();
            // dd('zz', $inputHeader, $inputHeader->blend_id, $formula->blend_id);

            // Tab: leaf_formulas
            if (count($request->leaf_formulas)) {
                $leafFormulas = collect($request->leaf_formulas);
                $leafTotalProportion = $leafFormulas->sum('leaf_total_proportion');


                foreach ($leafFormulas as $key => $leafFormula) {
                    $leafFormula = (object)$leafFormula;
                    // ไม่บันทึกรายการใหม่ ที่ถูกลบ บนหน้าจอ
                    // dd('xx', $leafFormula);
                    if (!($leafFormula->is_new_row && $leafFormula->is_deleted)) {
                        $leaf = new PtpdLeafHFormulaT;

                        $leaf->formula_id       = $formula->formula_id;
                        $leaf->formula_no       = $formula->formula_no;
                        $leaf->leaf_formula     = $leafFormula->leaf_formula;
                        $leaf->leaf_formula_desc = $leafFormula->leaf_formula_desc;
                        $leaf->leaf_proportion  = $leafFormula->leaf_proportion;
                        $leaf->leaf_total_proportion = $leafTotalProportion;

                        $leaf->web_status             = 'CREATE';
                        if (!$leafFormula->is_new_row) {
                            $leaf->web_status  = 'UPDATE';
                        }
                        if ($leafFormula->is_deleted) {
                            $leaf->web_status  = 'DELETE';
                            $delCasingByLeafFormula[] = $leaf->leaf_formula;
                        }


                        $leaf->organization_id    = $formula->tobacco_organization_id;
                        $leaf->organization_code  = $formula->tobacco_organization_code;
                        $leaf->formula_vers       = $formula->formula_vers;
                        $leaf->blend_id           = $formula->blend_id;
                        $leaf->blend_id           = $formula->blend_id;
                        $leaf->blend_no           = $formula->blend_no;
                        $leaf->created_by         = $formula->created_by;
                        $leaf->created_by_id      = $formula->created_by_id;
                        $leaf->created_at         = $formula->created_at;
                        $leaf->creation_date      = $formula->creation_date;
                        $leaf->program_code       = $formula->program_code;
                        $leaf->updated_by_id      = $formula->updated_by_id;
                        $leaf->last_updated_by    = $formula->last_updated_by;
                        $leaf->updated_at         = $formula->updated_at;
                        $leaf->last_update_date   = $formula->last_update_date;
                        $leaf->web_batch_no       = $formula->web_batch_no;
                        $leaf->save();

                        foreach ($leafFormula->leaf_dtl ?? [] as $key => $ingredient) {
                            $ingredient = (object) $ingredient;

                            if (!($ingredient->is_new_row && $ingredient->is_deleted)) {
                                $newIngredient = new PtpdLeafDtlFormulaT;
                                $newIngredient->formula_id          = $formula->formula_id;
                                $newIngredient->formula_no          = $formula->formula_no;
                                $newIngredient->leaf_formula        = $leaf->leaf_formula;
                                $newIngredient->formulaline_id      = $ingredient->formulaline_id;
                                $newIngredient->line_no             = $ingredient->line_no;
                                $newIngredient->inventory_item_id   = $ingredient->inventory_item_id;
                                $newIngredient->item_code           = $ingredient->item_code;
                                $newIngredient->item_desc           = $ingredient->item_desc;
                                $newIngredient->lot_number          = $ingredient->lot_number;
                                $newIngredient->ingredient_proportions = $ingredient->ingredient_proportions;
                                $newIngredient->quantity_used       = $ingredient->quantity_used;
                                $newIngredient->uom                 = $ingredient->uom;

                                $newIngredient->web_status          = 'CREATE';
                                if (!$ingredient->is_new_row) {
                                    $newIngredient->web_status      = 'UPDATE';
                                }
                                if ($ingredient->is_deleted || $leaf->web_status == 'DELETE') {
                                    $newIngredient->web_status      = 'DELETE';
                                }

                                $newIngredient->formula_vers       = $formula->formula_vers;
                                $newIngredient->blend_id           = $formula->blend_id;
                                $newIngredient->blend_no           = $formula->blend_no;
                                $newIngredient->organization_code  = $formula->tobacco_organization_code;
                                $newIngredient->created_by         = $formula->created_by;
                                $newIngredient->created_by_id      = $formula->created_by_id;
                                $newIngredient->created_at         = $formula->created_at;
                                $newIngredient->creation_date      = $formula->creation_date;
                                $newIngredient->program_code       = $formula->program_code;
                                $newIngredient->updated_by_id      = $formula->updated_by_id;
                                $newIngredient->last_updated_by    = $formula->last_updated_by;
                                $newIngredient->updated_at         = $formula->updated_at;
                                $newIngredient->last_update_date   = $formula->last_update_date;
                                $newIngredient->web_batch_no       = $formula->web_batch_no;
                                $newIngredient->save();
                            }
                        }
                    }
                }
            }

            // Tab: casings
            if (count($request->casings)) {
                foreach ($request->casings as $key => $inputCasing) {
                    $inputCasing = (object) $inputCasing;

                    if (!($inputCasing->is_new_row && $inputCasing->is_deleted)) { // ไม่บันทึกรายการใหม่ ที่ถูกลบ บนหน้าจอ

                        if ($inputCasing->leaf_formula == $inputCasing->old_leaf_formula) {
                            // Clear ข้อมูลเก่า
                            if ($inputCasing->casing_id != $inputCasing->old_casing_id) {
                                $oldData =  PtpdCasingFormulaV::where('formula_id', $formula->formula_id)
                                            ->where('leaf_formula', $inputCasing->old_leaf_formula)
                                            ->where('casing_id', $inputCasing->old_casing_id)
                                            ->get();

                                foreach ($oldData as $key => $old) {
                                    $input = $oldData;
                                    // $input->web_status  = 'DELETE';
                                    // (new ExpFmlFuncRepository)->createCasingTmp($formula, $inputCasing, $input);
                                }
                            }
                        }

                        foreach ($inputCasing->casing_items as $key => $inputItem) {
                            $inputItem = (object) $inputItem;
                            // $casing = new PtpdCasingFormulaT;
                            // $casing->formula_id             = $formula->formula_id;
                            // $casing->formula_no             = $formula->formula_no;
                            // $casing->leaf_formula           = $inputCasing->leaf_formula;
                            // $casing->leaf_formula_desc      = $inputCasing->leaf_formula_desc;
                            // $casing->casing_id              = $inputCasing->casing_id;
                            // $casing->casing_no              = $inputCasing->casing_no;
                            // $casing->casing_desc            = $inputCasing->casing_desc;
                            // $casing->blend_id               = $formula->blend_id;
                            // $casing->blend_no               = $formula->blend_no;
                            // $casing->organization_code      = $formula->tobacco_organization_code;


                            // // $casing->line_type          = $inputCasing->line_type;
                            // // $casing->line_no            = $inputCasing->line_no;
                            // $casing->organization_id        = null;
                            // $casing->inventory_item_id      = null;
                            // $casing->item_code              = $inputItem->item_code;
                            // $casing->item_desc              = $inputItem->item_desc;
                            // $casing->quantity_used          = $inputItem->quantity_used;
                            // $casing->uom                    = $inputItem->uom;
                            // $casing->web_status             = 'CREATE';

                            $webStatus = 'CREATE';
                            if ($formula->formula_id ||  $formula->blend_id) {
                                $checkRow =  PtpdCasingFormulaV::where('formula_id', $formula->formula_id)
                                                ->where('leaf_formula', $inputCasing->old_leaf_formula)
                                                ->where('casing_id', $inputCasing->old_casing_id)
                                                // ->where('item_code', $inputItem->item_code)
                                                ->first();
                                if ($checkRow) {
                                    // $casing->formulaline_id = $checkRow->formulaline_id;
                                    // $casing->line_no        = $checkRow->line_no;

                                    $inputItem->formulaline_id  = $checkRow->formulaline_id;
                                    $inputItem->line_no         = $checkRow->line_no;
                                    $webStatus     = 'UPDATE';
                                }
                            }

                            if (!$inputCasing->is_new_row) {
                                $webStatus  = 'UPDATE';
                            }
                            if ($inputCasing->is_deleted) {
                                $webStatus  = 'DELETE';
                            }

                            // $casing->created_by             = $formula->created_by;
                            // $casing->created_by_id          = $formula->created_by_id;
                            // $casing->created_at             = $formula->created_at;
                            // $casing->creation_date          = $formula->creation_date;
                            // $casing->program_code           = $formula->program_code;
                            // $casing->updated_by_id          = $formula->updated_by_id;
                            // $casing->last_updated_by        = $formula->last_updated_by;
                            // $casing->updated_at             = $formula->updated_at;
                            // $casing->last_update_date       = $formula->last_update_date;
                            // $casing->web_batch_no           = $formula->web_batch_no;
                            // $casing->save();

                            $inputItem->web_status = $webStatus;
                            (new ExpFmlFuncRepository)->createCasingTmp($formula, $inputCasing, $inputItem);
                        }
                    }
                }
            }

            // Tab: flavors
            if (count($flavors = $request->flavors)) {
                foreach ($flavors as $key => $inputFlavor) {
                    $inputFlavor = (object)$inputFlavor;
                    // ไม่บันทึกรายการใหม่ ที่ถูกลบ บนหน้าจอ
                    if (!($inputFlavor->is_new_row && $inputFlavor->is_deleted)) {
                        foreach ($inputFlavor->flavor_items as $key => $inputItem) {
                            $inputItem = (object) $inputItem;

                            $flavor                         = new PtpdFlavorFormulaT;
                            $flavor->formula_id             = $formula->formula_id;
                            $flavor->formula_no             = $formula->formula_no;
                            $flavor->flavor_id              = $inputFlavor->flavor_id;
                            $flavor->flavor_no              = $inputFlavor->flavor_no;
                            $flavor->flavor_desc            = $inputFlavor->flavor_desc;
                            $flavor->flavor_status          = $inputFlavor->flavor_status ? 'Y' : 'N';

                            $flavor->organization_id        = $inputItem->organization_id;
                            $flavor->inventory_item_id      = $inputItem->inventory_item_id;
                            $flavor->item_code              = $inputItem->item_code;
                            $flavor->item_desc              = $inputItem->item_desc;
                            $flavor->quantity_used          = $inputItem->quantity_used;
                            $flavor->uom                    = $inputItem->uom;

                            $flavor->formula_vers           = $formula->formula_vers;
                            $flavor->blend_id               = $formula->blend_id;
                            $flavor->blend_no               = $formula->blend_no;
                            $flavor->organization_code      = $formula->tobacco_organization_code;


                            $flavor->created_by             = $formula->created_by;
                            $flavor->created_by_id          = $formula->created_by_id;
                            $flavor->created_at             = $formula->created_at;
                            $flavor->creation_date          = $formula->creation_date;
                            $flavor->program_code           = $formula->program_code;
                            $flavor->updated_by_id          = $formula->updated_by_id;
                            $flavor->last_updated_by        = $formula->last_updated_by;
                            $flavor->updated_at             = $formula->updated_at;
                            $flavor->last_update_date       = $formula->last_update_date;
                            $flavor->web_batch_no           = $formula->web_batch_no;

                            $flavor->web_status             = 'CREATE';
                            if ($formula->formula_id) {
                                $checkRow =  PtpdFlavorFormulaV::searchBlendOrFormula($formula->blend_no, $formula->formula_id)
                                                ->where('flavor_id', $inputFlavor->old_flavor_id)
                                                ->where('item_code', $inputItem->old_item_code)
                                                ->first();
                                if ($checkRow) {
                                    $flavor->formulaline_id = $checkRow->formulaline_id;
                                    $flavor->line_no        = $checkRow->line_no;
                                    $flavor->web_status     = 'UPDATE';
                                }
                            }
                            if (!$inputFlavor->is_new_row) {
                                $flavor->web_status  = 'UPDATE';
                            }
                            if ($inputFlavor->is_deleted) {
                                $flavor->web_status  = 'DELETE';
                            }
                            $flavor->save();
                        }
                    }
                }
            }

            $newCigarettes = [];
            if (count($cigarettes = $request->cigarettes)) {
                foreach ($cigarettes as $key => $inputCigar) {
                    $inputCigar = (object) $inputCigar;

                    if (!($inputCigar->is_new_row && $inputCigar->is_deleted)) {

                        if (!$inputCigar->is_new_row) {
                            $newCigar = PtpdCigarFormulaT::where("fm_cigar_id", $inputCigar->fm_cigar_id)->first();
                        } else {
                            $newCigar = new PtpdCigarFormulaT;
                        }

                        $newCigar->formula_id           = $formula->formula_id;
                        $newCigar->formula_no           = $formula->formula_no;
                        $newCigar->formula_vers         = $formula->formula_vers;
                        $newCigar->blend_id             = $formula->blend_id;
                        $newCigar->blend_no             = $formula->blend_no;
                        // $newCigar->cigar_formula_id     = $inputCigar->cigar_formula_id;
                        // $newCigar->cigar_formula_no     = $inputCigar->cigar_formula_no;
                        // $newCigar->cigar_description    = $inputCigar->cigar_description;

                        $newCigar->cigar_item_id        = $inputCigar->cigar_item_id;
                        $newCigar->cigar_organization_code = $inputCigar->cigar_organization_code;
                        $newCigar->cigar_organization_id = $inputCigar->cigar_organization_id;
                        $newCigar->cigar_item_code      = $inputCigar->cigar_item_code;
                        $newCigar->cigar_item_desc      = $inputCigar->cigar_item_desc;

                        $newCigar->created_by           = $formula->created_by;
                        $newCigar->created_by_id        = $formula->created_by_id;
                        $newCigar->created_at           = $formula->created_at;
                        $newCigar->creation_date        = $formula->creation_date;
                        $newCigar->program_code         = $formula->program_code;
                        $newCigar->updated_by_id        = $formula->updated_by_id;
                        $newCigar->last_updated_by      = $formula->last_updated_by;
                        $newCigar->updated_at           = $formula->updated_at;
                        $newCigar->last_update_date     = $formula->last_update_date;
                        $newCigar->web_batch_no         = $formula->web_batch_no;

                        $newCigar->web_status           = 'CREATE';
                        if ($inputCigar->fm_cigar_id) {
                            $newCigar->web_status       = 'UPDATE';
                        }
                        if ($inputCigar->is_deleted) {
                            $newCigar->web_status       = 'DELETE';
                            $newCigar->deleted_at       = now();
                            $newCigar->deleted_by_id    = $profile->user_id;
                        }

                        // if ($inputCigar->is_deleted) {
                        //     // code...
                        //     dd('xxx', $newCigar->web_status, $newCigar->fm_cigar_id, $inputCigar);
                        // }
                        $newCigar->save();
                        data_set($newCigarettes, $inputCigar->fm_cigar_id, (object)[
                            'fm_cigar_id'           => $newCigar->fm_cigar_id,
                            'cigar_organization_id' => $newCigar->cigar_organization_id,
                            'cigar_item_id'         => $newCigar->cigar_item_id,
                            'web_status'            => $newCigar->web_status
                        ]);
                    }
                }
            };


            if (count($cigarDtl = $request->cigar_dtl)) {

                foreach (collect($cigarDtl)->groupBy('fm_cigar_id') as $keyFmCigarId => $inputCigarDtlByItem) {

                    foreach ($inputCigarDtlByItem as $key => $inputCigarDtl) {
                        $inputCigarDtl = (object) $inputCigarDtl;
                        $checkCigarette = data_get($newCigarettes, "$keyFmCigarId");
                        if (!($inputCigarDtl->is_new_row && $inputCigarDtl->is_deleted) && $checkCigarette->fm_cigar_id) {
                            $checkItem = PtpdWrappedDtlFormula::where("fm_wrap_dtl_id", $inputCigarDtl->fm_wrap_dtl_id)
                                            ->first();

                            if ($checkItem) {
                                $newCigarDtl = $checkItem;
                            } else {
                                $newCigarDtl = new PtpdWrappedDtlFormula;
                            }

                            $newCigarDtl->formula_id           = $formula->formula_id;
                            $newCigarDtl->formula_no           = $formula->formula_no;

                            $newCigarDtl->wrapped_flag          = -1;
                            $newCigarDtl->wrapped_line_no       = $inputCigarDtl->cigar_line_no;
                            $newCigarDtl->wrapped_description   = $inputCigarDtl->cigar_description ?? '-';

                            $newCigarDtl->fm_cigar_id           = data_get($checkCigarette, "fm_cigar_id");
                            $newCigarDtl->cigar_organization_id = data_get($checkCigarette, "cigar_organization_id");
                            $newCigarDtl->cigar_item_id         = data_get($checkCigarette, "cigar_item_id");
                            $newCigarDtl->formula_vers          = $formula->formula_vers;
                            $newCigarDtl->blend_id              = $formula->blend_id;
                            $newCigarDtl->blend_no              = $formula->blend_no;
                            $newCigarDtl->cigar_organization_id = $formula->or_formula_organization_id ?? -1;

                            $newCigarDtl->created_by           = $formula->created_by;
                            $newCigarDtl->created_by_id        = $formula->created_by_id;
                            $newCigarDtl->created_at           = $formula->created_at;
                            $newCigarDtl->creation_date        = $formula->creation_date;
                            $newCigarDtl->program_code         = $formula->program_code;
                            $newCigarDtl->updated_by_id        = $formula->updated_by_id;
                            $newCigarDtl->last_updated_by      = $formula->last_updated_by;
                            $newCigarDtl->updated_at           = $formula->updated_at;
                            $newCigarDtl->last_update_date     = $formula->last_update_date;
                            $newCigarDtl->web_batch_no         = $formula->web_batch_no;

                            $newCigarDtl->web_status           = 'CREATE';
                            if ($inputCigarDtl->is_new_row) {
                                $newCigarDtl->web_status       = 'UPDATE';
                            }

                            if ($inputCigarDtl->is_deleted || data_get($checkCigarette, "web_status") == 'DELETE') {
                                $newCigarDtl->web_status       = 'DELETE';
                                $newCigarDtl->deleted_at       = now();
                                $newCigarDtl->deleted_by_id    = $profile->user_id;
                            }

                            $newCigarDtl->save();
                        }
                    }
                }
            };

            $formula2 = $formula;
            if (count($delCasingByLeafFormula)) {
                $formula2 = $this->delCasings($formula, $delCasingByLeafFormula);
                // $result = $this->interface($formula2);
                // if ($result['status'] != 'S' && $result['status'] != 'C') {
                //     throw new \Exception($result['msg']);
                // }
            }

            $result = $this->interface($formula);
            if ($result['status'] != 'S' && $result['status'] != 'C') {
                throw new \Exception($result['msg']);
            }

            // // dd('xx', $formula->toArray());
            // dd('x', $formula->web_batch_no, $formula2->web_batch_no, $delCasingByLeafFormula);
            // dd('xx',$formula->web_batch_no, $result, $formula->toArray());

            if (!$formula->formula_id) {
                $data = PtpdFormulaHV::where('blend_no', $formula->blend_no)
                            ->where('formula_type_code', $formula->formula_type_code)
                            ->where('product_item_code', $formula->product_item_code)
                            ->first();

                $formula->formula_id = optional($data)->formula_id;
            }

            return $formula;
        }
    }

    function interface($haeder)
    {
        $db     =   \DB::connection('oracle')->getPdo();
        $sql    =   "
            DECLARE
                V_STAUTS VARCHAR2(10);
                V_MSG VARCHAR2(4000);
                V_BLEND_ID number;
            BEGIN
                PTPD_SIMULATE_FORMULA_PKG.MAIN_IMORT(P_WEB_BATCH_NO   => '{$haeder->web_batch_no}'
                                               , P_INTERFACE_STATUS   => :V_STAUTS
                                               , P_INTERFACE_MSG      => :V_MSG
                                               , P_BLEND_ID           => :V_BLEND_ID);

            END ;
        ";
        \Log::info($sql);

        $haeder->interface_name = $sql;
        $haeder->save();
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':V_STAUTS', $result['status'], \PDO::PARAM_STR, 10);
        $stmt->bindParam(':V_MSG', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':V_BLEND_ID', $result['blend_id'], \PDO::PARAM_STR, 4000);
        $stmt->execute();
        \Log::info($result);
        return $result;
    }

    function interfaceDuplicate($haeder)
    {
        $db     =   \DB::connection('oracle')->getPdo();
        $sql    =   "
            DECLARE
                V_STATUS VARCHAR2(10);
                V_MSG    VARCHAR2(4000);
                V_NEW_BLEND_ID  NUMBER;
            BEGIN
                PTPD_SIMULATE_FORMULA_PKG.COPPY_PD0003(P_WEB_BATCH_NO      => '{$haeder->web_batch_no}'
                                                      ,P_BLEND_ID         =>  $haeder->blend_id
                                                      ,P_INTERFACE_STATUS  => :V_STATUS
                                                      ,P_INTERFACE_MSG    => :V_MSG
                                                      ,P_NEW_BLEND_ID    => :V_NEW_BLEND_ID) ;

            END;
        ";
        \Log::info($sql);
        // $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':V_STATUS', $result['status'], \PDO::PARAM_STR, 10);
        $stmt->bindParam(':V_MSG', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':V_NEW_BLEND_ID', $result['blend_id'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        $haeder->interface_name = $sql . implode(", ",$result);
        $haeder->save();

        return $result;
    }

    function interfaceCopyToPd08(PtpdSmlCostFmlHeadT $haeder)
    {
        $db     =   \DB::connection('oracle')->getPdo();
        $sql    =   "
            DECLARE
                V_STATUS VARCHAR2(10);
                V_MSG    VARCHAR2(4000);
            BEGIN
                PTPD_SIMULATE_FORMULA_PKG.IMPORT_TO_PD0008        (P_WEB_BATCH_NO   =>  '{$haeder->web_batch_no}'
                                                                  ,P_BLEND_NO       => '{$haeder->blend_no}'
                                                                  ,P_EXAMPLE_NO     => '{$haeder->example_no}'
                                                                  ,P_INTERFACE_STATUS => :V_STATUS
                                                                  ,P_INTERFACE_MSG    => :V_MSG );
            END;
        ";

        $haeder->interface_name = $sql;
        $haeder->save();
        \Log::info("{$haeder->web_batch_no} INF", [$sql]);
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':V_STATUS', $result['status'], \PDO::PARAM_STR, 10);
        $stmt->bindParam(':V_MSG', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        \Log::info("{$haeder->web_batch_no} INF", [$result]);

        return $result;
    }

    function interfaceCopyFromPd08(PtpdSmlCostFmlHeadT $haeder)
    {
        $db     =   \DB::connection('oracle')->getPdo();
        $sql    =   "
            DECLARE
                V_STATUS VARCHAR2(10);
                V_MSG    VARCHAR2(4000);
                v_BLEND_ID number ;
            BEGIN
                PTPD_SIMULATE_FORMULA_PKG.PD0008_IMPORT_TO_PD0003(P_WEB_BATCH_NO                  => '{$haeder->web_batch_no}'
                                                  ,P_BLEND_NO           => '{$haeder->blend_no}'
                                                  ,P_FORMULA_VERS       => '{$haeder->formula_vers}'
                                                  ,P_INTERFACE_STATUS   =>  :V_STATUS
                                                  ,P_INTERFACE_MSG      =>  :V_MSG
                                                  ,P_BLEND_ID           =>  :V_BLEND_ID   );
            END;
        ";


        // $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':V_STATUS', $result['status'], \PDO::PARAM_STR, 10);
        $stmt->bindParam(':V_MSG', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':V_BLEND_ID', $result['blend_id'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        $haeder->interface_name = $sql . implode(", ",$result);
        $haeder->save();
        return $result;
    }

    function interfaceReCalCost($haeder)
    {
        $db     =   \DB::connection('oracle')->getPdo();
        $sql    =   "
            DECLARE
                V_STATUS VARCHAR2(10);
                V_MSG    VARCHAR2(4000);
            BEGIN

                        PTPD_SIMULATE_FORMULA_PKG.CALCULATE_UNIT_COST(P_WEB_BATCH_NO      => '{$haeder->web_batch_no}'
                                                                     ,P_BLEND_ID          => '{$haeder->blend_id}'
                                                                     ,P_BLEND_NO          =>  '98T'
                                                                     ,P_EXAMPLE_NO        =>  0
                                                                     ,P_INTERFACE_STATUS  => :V_STATUS
                                                                     ,P_INTERFACE_MSG     => :V_MSG )    ;

            END ;
        ";
        \Log::info($sql);

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':V_STATUS', $result['status'], \PDO::PARAM_STR, 10);
        $stmt->bindParam(':V_MSG', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->execute();
        return $result;
    }

    function interfaceConfirmSave($haeder)
    {
        $db     =   \DB::connection('oracle')->getPdo();
        $sql    =   "
            DECLARE
                V_STATUS VARCHAR2(10);
                V_MSG    VARCHAR2(4000);
            BEGIN


                PTPD_SIMULATE_FORMULA_PKG.GEN_VERS_EXAMPLE_NO( P_BLEND_ID          => $haeder->blend_id
                                                              ,P_INTERFACE_STATUS  => :V_STATUS
                                                              ,P_INTERFACE_MSG     => :V_MSG)  ;
            END ;
        ";
        \Log::info($sql);

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':V_STATUS', $result['status'], \PDO::PARAM_STR, 10);
        $stmt->bindParam(':V_MSG', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->execute();
        return $result;
    }

    function getDataInfo($request, $header, $profile)
    {
        $flavourList = [];
        $tobaccoTypeCodeList = [];

        $cigarateReferCostItemList = [];
        $cigaratePackCostItemList = [];


        $flavourList = PtpdSmlCostFlavourV::selectRaw("
                            flavour,
                            flavour_code,
                            formula_organization_id,
                            formula_organization_code,
                            organization_id,
                            organization_code,
                            department,
                            flavour_code    as value,
                            flavour         as label
                        ")
                        ->orderBy('label')
                        ->get();

        $tobaccoTypeCodeList = PtpdSmlCostTobaccoTypeV::selectRaw("
                            tobacco_type_code,
                            tobacco_type_desc,
                            tobacco_organization_id,
                            tobacco_organization_code,
                            tobacco_type_code    as value,
                            tobacco_type_desc         as label
                        ")
                        ->orderBy('label')
                        ->where('tobacco_organization_id', $profile->organization_id)
                        ->get();
        $formulaType = \App\Models\PD\PtpdFormulaTypeV::select(['lookup_code', 'meaning', 'description'])->get();
        $recipeFiscalYear =  \App\Models\PD\PtYearsV::selectRaw("distinct YEAR_THAI value, YEAR_THAI label")
                                ->orderBy('label')
                                ->get();


        $cigarateReferCostItemList = $this->getItemRefer();
        $cigaratePackCostItemList = $this->getItemPack();
        $lldList = $this->getLldList();

        $data = (object)[];
        $data->flavour_list                     = collect(optional($flavourList)->toArray() ?? []);
        $data->tobacco_type_code_list           = collect(optional($tobaccoTypeCodeList)->toArray() ?? []);
        $data->cigarate_refer_cost_item_list    = collect(optional($cigarateReferCostItemList)->toArray() ?? []);
        $data->cigarate_pack_cost_item_list     = collect(optional($cigaratePackCostItemList)->toArray() ?? []);
        $data->lld_list                         = collect(optional($lldList)->toArray() ?? []);
        $data->recipe_fiscal_year_list          = collect(optional($recipeFiscalYear)->toArray() ?? []);
        $data->formula_type                     = collect(optional($formulaType)->toArray() ?? []);
        $data->status_list                      = collect(['INACTIVE' => 'Inactive', 'ACTIVE' => 'Active']);

        $header->can = $this->getCan($header);

        $data->tabs                     = (object)[];
        $data->tabs->leaf_formula_line  = (object)[
                                                'leaf_new_line' => $this->getNewLeafFormulaLine(),
                                                'ingredient_new_line' => $this->getNewIngredientLine()
                                           ];
        $data->tabs->casings            = (object)[
                                                'new_line' => $this->getNewCasingLine(),
                                                'new_casing_line' => $this->getNewCasingItem(),
                                           ];
        $data->tabs->flavors            = (object)[
                                                'new_line' => $this->getNewFlavorLine(),
                                                'new_fla_item' => $this->getNewFlavorItem(),
                                           ];
        $data->tabs->cigarettes         = (object)[
                                                'new_line' => $this->getNewCigaretteLine(),
                                                'new_ciga_item' => $this->getNewCigaretteItem(),
                                                'new_dtl_line' => $this->getNewCigarDtlLine(),
                                           ];



        return $data;
        $tobaccoTypeList = [];
        $requestStatusList = [];
        $blendList = [];
        $flavourList = [];

        $tobaccoTypeList = (new ExpFmlFuncRepository)->getTobaccoTypeList($profile->organization_id);

        if (!$header->formula_id) {
            // PTPD_TOBACCO_TYPE_V
            $blendList = PtpdItemBlendNoV::selectRaw("
                            distinct
                            blend_no        as blend_no,
                            inventory_item_code as product_item_code,
                            organization_id as organization_id,
                            blend_no        as formula_no,
                            description     as description,
                            uom,
                            uom_name        as uom_name,
                            blend_no  as value,
                            blend_no || ' : ' || inventory_item_code  as label
                        ")
                        ->with(['uomDetail'])
                        ->where('organization_id', $profile->organization_id)
                        ->orderBy('blend_no')
                        ->get();
            // dd('xx');
        }

        $flavourList = PtpdBlendFlavourV::selectRaw("
                            flavour,
                            flavour_code,
                            formula_organization_id,
                            formula_organization_code,
                            organization_id,
                            organization_code,
                            department,
                            flavour_code    as value,
                            flavour         as label
                        ")
                        // ->where('formula_organization_id', $profile->organization_id)
                        ->orderBy('label')
                        ->get();

        $formulaType = PtpdFormulaTypeV::select(['lookup_code', 'meaning', 'description'])->get();
        $recipeFiscalYear =  \App\Models\PD\PtYearsV::selectRaw("distinct YEAR_THAI value, YEAR_THAI label")
                                ->orderBy('label')
                                ->get();
        $recipeRoutingNoList = PtpmOpmRoutingV::selectRaw("distinct routing_no value, routing_desc label")
                                ->where('owner_organization_id', $profile->organization_id)
                                ->get();

        $data = (object)[];
        $data->tobacco_type_code_list   = collect(optional($tobaccoTypeList)->toArray() ?? []);
        $data->recipe_fiscal_year_list  = collect(optional($recipeFiscalYear)->toArray() ?? []);
        $data->product_item_id_list     = collect([]);

        $data->recipe_routing_no_list   = collect(optional($recipeRoutingNoList)->toArray() ?? []);

        $data->formula_type             = collect(optional($formulaType)->toArray() ?? []);
        $data->request_status_list      = collect(optional($requestStatusList)->toArray() ?? []);
        $data->blend_no_list            = collect(optional($blendList)->toArray() ?? []);
        $data->flavour_list             = collect(optional($flavourList)->toArray() ?? []);
        $data->status_list              = collect(['INACTIVE' => 'Inactive', 'ACTIVE' => 'Active']);

        $data->tabs                     = (object)[];
        $data->tabs->leaf_formula_line  = (object)[
                                                'leaf_new_line' => $this->getNewLeafFormulaLine(),
                                                'ingredient_new_line' => $this->getNewIngredientLine()
                                           ];
        $data->tabs->casings            = (object)[
                                                'new_line' => $this->getNewCasingLine(),
                                           ];
        $data->tabs->flavors            = (object)[
                                                'new_line' => $this->getNewFlavorLine(),
                                           ];
        $data->tabs->cigarettes         = (object)[
                                                'new_line' => $this->getNewCigaretteLine(),
                                                'new_dtl_line' => $this->getNewCigarDtlLine(),
                                           ];

        if (!$header->has_tmp_table) {
            $defFormulaType = $formulaType->first();
            $header->formula_type_code  = $defFormulaType->lookup_code;
            $header->formula_type       = $defFormulaType->description;

            // $header->formula_type_code  = $header->formula_type_code;
            // $header->formula_type       = $header->formula_type;
        }

        $header->can = $this->getCan($header, $header->formula_status, $header->formula_type_code ?? 1);

        return $data;
    }
    function getFlavourHeader($flavourCode = false)
    {
        $data = PtpdSmlCostFlavourV::selectRaw("
                    flavour,
                    flavour_code,
                    flavour flavour_desc,
                    formula_organization_id,
                    formula_organization_code,
                    organization_id,
                    organization_code,
                    department,
                    flavour_code    as value,
                    flavour         as label
                ")
                ->when($flavourCode, function($q) use($flavourCode) {
                    $q->where("flavour_code", $flavourCode);
                })
                ->orderBy('label')
                ->get();
        return $data;
    }



    function tobaccoTypeCode($tobaccoTypeCode = false)
    {
        $data = PtpdSmlCostTobaccoTypeV::selectRaw("
                    tobacco_type_code,
                    tobacco_type_desc,
                    tobacco_organization_id,
                    tobacco_organization_code,
                    tobacco_type_code    as value,
                    tobacco_type_desc         as label
                ")
                ->when($tobaccoTypeCode, function($q) use($tobaccoTypeCode) {
                    $q->where("tobacco_type_code", $tobaccoTypeCode);
                })
                ->orderBy('label')
                ->get();
        return $data;
    }

    function getItemRefer($itemId = false, $itemNumber = false, $orgId = false, $orgCode = false)
    {
        $data = PtpdSmlCostSumProductV::selectRaw("
                    product_item_number         as item_no,
                    product_item_desc           as item_desc,
                    product_item_number         as value,
                    product_item_number ||': '|| product_item_desc         as label
                ")
                ->when($itemNumber, function($q) use($itemNumber) {
                    $q->where("product_item_number", $itemNumber);
                })
                ->groupByRaw("product_item_number, product_item_desc")
                ->orderBy('label')
                ->get();

        return $data;
    }

    function getItemPack($itemId = false, $itemNumber = false, $orgId = false, $orgCode = false)
    {
        $data = PtpdSmlCostSumProductV::selectRaw("
                    distinct
                    product_item_number         as item_no,
                    product_item_desc           as item_desc,
                    product_item_number         as value,
                    product_item_number ||': '|| product_item_desc         as label
                ")
                ->when($itemNumber, function($q) use($itemNumber) {
                    $q->where("product_item_number", $itemNumber);
                })
                ->orderBy('label')
                ->get();

        return $data;
    }

    function getLldList($itemId = false, $itemNumber = false, $orgId = false, $orgCode = false)
    {
        $data = PtpdLldV::selectRaw("
                    lld_year,
                    -- blend_no,
                    lld_brand_code,
                    lld_brand_desc,
                    lld_qty,
                    lld_brand_code  as value,
                    lld_brand_code || ' : ' || lld_brand_desc  as label
                ")
                ->when($itemNumber, function($q) use($itemNumber) {
                    $q->where("lld_brand_code", $itemNumber);
                })
                ->orderBy('lld_brand_code')
                ->get();
        return $data;
    }

    function getTotalRawMaterial($blendId)
    {
        $data = PtpdTotalRawMaterialV::where('blend_id', $blendId)->orderBy('row_type')->get();
        return $data;
    }

    function getNewLeafFormulaLine()
    {
        $line = (object)[];
        $line->is_new_row               = true;
        $line->is_deleted               = false;
        $line->is_edit_item             = false;
        $line->is_collapse              = false;
        $line->loading                  = false;

        $line->formula_id               = '';
        $line->formula_no               = '';

        $line->leaf_formula             = '';
        $line->leaf_formula_desc        = '';

        $line->leaf_proportion          = 0;
        $line->leaf_total_proportion    = '';

        $line->leaf_dtl                 = []; // สำหรับบันทึกข้อมูล
        $line->leaf_list                = []; // สำหรับ Form Vue JS

        return $line;
    }

    function getNewIngredientLine()
    {
        $line = (object)[];
        $line->is_new_row               = true;
        $line->is_deleted               = false;
        $line->is_edit_item             = false;
        $line->loading                  = false;


        $line->fm_leaf_d_id             = '';
        $line->enable_flag              = 'Y';
        $line->formulaline_id           = '';
        $line->line_no                  = '';

        $line->formulaline_id           = '';
        $line->inventory_item_id        = '';
        $line->item_code                = '';
        $line->item_desc                = '';
        $line->lot_number               = '';
        // $line->ingredient_proportions   = 0;


        $line->unit_cost                = 0;
        $line->proportion_percent       = 0;        // สัดส่่วน %
        $line->quantity_used            = 0;        // ปริมาณที่ใช้ (กก.)
        $line->cost_materials_used      = 0;        // ต้นทุนวัตถุดิบที่ใช้ (บาท)
        $line->price_adjus              = 0;        // ปรับราคา (%)
        $line->price_reduc_increase     = 0;        // ราคาปรับลด/เพื่ม (บาท)
        $line->cost_after_price_adjus   = 0;        // ต้นทุนหลังปรับราคา (บาท)

        $line->cost_per_cgk_baht        = 0;        // ต้นทุน บาท/พันมวน

        $line->period_year              = '';
        $line->version                  = '';

        $line->uom                      = 'KG';
        $line->status                   = '';

        $line->item_list                = []; // สำหรับ Form Vue JS
        $line->lot_list                 = []; // สำหรับ Form Vue JS
        return $line;
    }

    function getNewCasingLine()
    {
        $line = (object)[];
        $line->is_new_row               = true;
        $line->is_deleted               = false;
        $line->loading                  = false;
        $line->is_collapse              = true;

        $line->leaf_formula             = '';
        $line->old_leaf_formula         = '';
        $line->leaf_formula_desc        = '';

        $line->casing_id                = '';
        $line->old_casing_id            = '';
        $line->casing_no                = '';
        $line->casing_desc              = '';

        $line->unit_cost                = 0;
        $line->price_adjus              = 0;
        $line->price_reduc_increase     = 0;
        $line->cost_after_price_adjus   = 0;
        // $line->line_type                = '';
        // $line->line_no                  = '';
        // $line->organization_id          = '';
        // $line->inventory_item_id        = '';
        // $line->item_code                = '';
        // $line->item_desc                = '';
        // $line->quantity_used            = '';
        // $line->uom                      = '';

        $line->casing_leaf_formula_list = []; // สำหรับ Form Vue JS
        $line->casing_list              = []; // สำหรับ Form Vue JS
        return $line;
    }


    function getNewCasingItem()
    {
        $line = (object)[];
        $line->is_new_row               = true;
        $line->is_deleted               = false;
        $line->is_edit_item             = false;
        $line->loading                  = false;
        $line->enable_flag              = 'Y';

        $line->blend_no                 = '';
        $line->fm_casing_id             = '';
        $line->casing_id                = '';
        $line->leaf_formula             = '';
        $line->inventory_item_id        = '';
        $line->item_code                = '';
        $line->old_item_code            = '';
        $line->item_desc                = '';
        $line->quantity_used            = '';
        $line->uom                      = '';
        $line->uom_name                 = '';
        $line->status                   = '';

        $line->unit_cost                = 0;
        $line->price_adjus              = 0;
        $line->price_reduc_increase     = 0;
        $line->cost_after_price_adjus   = 0;
        $line->cost_per_cgk_baht        = 0;

        return $line;
    }

    function getNewFlavorLine()
    {
        $line = (object)[];
        $line->is_new_row               = true;
        $line->is_deleted               = false;
        $line->is_edit_item             = false;
        $line->loading                  = false;
        $line->is_collapse              = true;
        $line->flavor_status            = true; // default

        $line->flavor_id                = '';
        $line->old_flavor_id            = '';
        $line->flavor_no                = '';
        $line->flavor_desc              = '';

        $line->unit_cost = 0;
        $line->price_adjus = 0;
        $line->price_reduc_increase = 0;
        $line->cost_after_price_adjus = 0;

        $line->flavor_list              = []; // สำหรับ Form Vue JS
        return $line;
    }

    function getNewFlavorItem()
    {
        $line = (object)[];
        $line->is_new_row               = true;
        $line->is_deleted               = false;
        $line->is_edit_item             = false;
        $line->loading                  = false;
        $line->enable_flag              = 'Y';

        $line->blend_no                 = '';
        $line->fm_flavor_id             = '';
        $line->flavor_id                = '';
        $line->organization_id          = '';
        $line->inventory_item_id        = '';
        $line->old_item_code            = '';
        $line->item_code                = '';
        $line->item_desc                = '';
        $line->uom                      = '';
        $line->uom_name                 = '';
        $line->status                   = '';


        $line->quantity_used            = 0;
        $line->unit_cost                = 0;
        $line->price_adjus              = 0;
        $line->price_reduc_increase     = 0;
        $line->cost_after_price_adjus   = 0;
        $line->cost_per_cgk_baht        = 0;

        return $line;
    }

    function getNewCigaretteLine()
    {
        $line = (object)[];
        $line->is_new_row               = true;
        $line->is_deleted               = false;
        $line->loading                  = false;
        $line->is_collapse              = true;

        $line->cigar_organization_code  = '';
        $line->cigar_organization_id    = '';
        $line->cigar_item_id            = '';
        $line->cigar_item_code          = '';
        $line->cigar_item_desc          = '';
        $line->fm_cigar_id              = '';

        $line->cigar_list              = []; // สำหรับ Form Vue JS
        return $line;
    }

    function getNewCigaretteItem()
    {
        $line = (object)[];
        $line->is_new_row               = true;
        $line->is_deleted               = false;
        $line->is_edit_item             = false;
        $line->loading                  = false;
        $line->enable_flag              = 'Y';

        $line->product_item             = '';
        $line->blend_id                 = '';
        $line->fm_wc_id                 = '';
        $line->line_no                  = '';
        $line->wip_code                 = '';
        $line->wip_desc                 = '';
        $line->inventory_item_id        = '';
        $line->organization_id          = '';
        $line->item_code                = '';
        $line->item_desc                = '';
        $line->uom                      = '';
        $line->uom_name                 = '';
        $line->attribute1               = '';
        $line->status                   = '';

        $line->quantity_used            = 0;
        $line->unit_cost                = 0;
        $line->price_adjus              = 0;
        $line->price_reduc_increase     = 0;
        $line->cost_after_price_adjus   = 0;
        $line->cost_per_cgk_baht        = 0;
        return $line;
    }

    function getNewCigarDtlLine()
    {
        $line = (object)[];
        $line->is_new_row               = true;
        $line->is_deleted               = false;
        $line->loading                  = false;

        $line->fm_cigar_id              = '';
        $line->fm_wrapped_id           = '';
        $line->cigar_line_no            = '';
        $line->cigar_description        = '';

        return $line;
    }


    function getData($request)
    {
        $type = $request->type;
        $jsonNullable       = $this->getJsonNullable();
        $header             = json_decode($request->header ?? $jsonNullable);
        $profile            = $this->getProfile();



        $leafFormulaLines = [];
        $leafList = [];
        $itemList = [];
        $lotList = [];

        $casings = [];
        $casingLeafFormulaList = [];
        $casingList = [];
        $casingItemList = [];

        $flavors = [];
        $flavorList = [];
        $flavorItemList = [];

        $cigarettes = [];
        $cigaItemList = [];

        $cigarDtl = [];
        $cigarList = [];

        $cigaretteAll = [];
        switch (strtoupper($type)) {

            case 'LEAF_FORMULA_LINE': // Tab: LEAF_FORMULA
                $leafFormulaLines = $this->getLeafFormulaLine($request, $profile);
                break;
            case 'LEAF_FORMULA': // Tab: LEAF_FORMULA
                $leafList = $this->getleafList($request, $profile);
                break;
            case 'ITEM_LIST': // Tab: LEAF_FORMULA
                $itemList = $this->getItemList($request, $profile);
                break;
            case 'LOT_LIST': // Tab: LEAF_FORMULA
                $lotList = $this->getLotList($request, $profile);
                break;
            case 'CASINGS': // Tab: Casings
                $casings = $this->getCasings($request, $profile);
                break;
            case 'CASING_LEAF_FORMULA_LIST': // Tab: Casings
                $casingLeafFormulaList = $this->getCasingLeafFormulaList($request, $profile);
                break;
            case 'CASING_LIST': // Tab: Casings
                $casingList = $this->getCasingList($request, $profile);
                break;
            case 'CASING_ITEM_LIST': // Tab: Casings
                $casingItemList = $this->getCasingItemList($request, $profile);
                break;
            case 'FLAVORS': // Tab: Flavor

                $flavors = $this->getFlavors($request, $profile);
                break;
            case 'FLAVOR_LIST': // Tab: Flavor
                $flavorList = $this->getFlavorList($request, $profile);
                break;
            case 'FLAVOR_ITEM_LIST': // Tab: Flavor Item
                $flavorItemList = $this->getFlavorItemList($request, $profile);
                break;
            case 'CIGARETTES': // Tab: บุหรี่
                $cigarettes = $this->getCigarettes($request, $profile);
                $cigarDtl = $this->getCigarDtl($request, $profile);
                break;
            case 'CIGA_ITEM_LIST': // Tab: Item บุหรี่
                $cigaItemList = $this->getCigaItemList($request, $profile);
                break;
            case 'CIGAR_LIST': // Tab: บุหรี่
                $cigarList = $this->getCigaretteList($request, $profile);
                break;

            case 'CIGARETTE_ALL': // Tab: ทั้งหมด
                // $cigaretteAll = $this->getCigaretteAll($request, $profile);
                $cigaretteAll = $this->getCigaretteAll($request, $profile);
                break;
        }


        return [
            'type' => $type,

            // Tab: LEAF_FORMULA
            'leaf_list' => $leafList,
            'item_list' => $itemList,
            'lot_list' => $lotList,
            'leaf_formula_lines' => $leafFormulaLines,

            // Tab: Casings
            'casings' => $casings,
            'casing_leaf_formula_list' => $casingLeafFormulaList,
            'casing_list' => $casingList,
            'casing_item_list' => $casingItemList,

            // Tab: Flavor
            'flavors' => $flavors,
            'flavor_list' => $flavorList,
            'flavor_item_list' => $flavorItemList,

            // Tab: บุหรี่
            'cigarettes' => $cigarettes,
            'ciga_item_list' => $cigaItemList,

            'cigar_list' => $cigarList,
            'cigar_dtl' => $cigarDtl,

            // Tab: ทั้งหมด
            'cigarette_all' => $cigaretteAll,

        ];
    }

    function getLeafFormulaLine($request, $profile)
    {
        $header             = json_decode($request->header ?? []);
        $organizationId     = data_get($header ?? [], 'organization_id', $profile->organization_id);
        $formulaId          = data_get($header, 'formula_id', '');
        $formulaNo          = data_get($header, 'formula_no', '');
        $blendNo            = data_get($header, 'blend_no', '');
        $blendId            = data_get($header, 'blend_id', '');


        // if (! $formulaId) {
        //     return [];
        // }

        $leafFormulas = PtpdSmlCostLeafHFmlV::selectRaw("
                    distinct
                    blend_no,
                    blend_id,
                    '' formula_id,          -- not use
                    '' as formula_id,       -- not use
                    '' as formula_no,       -- not use
                    leaf_formula            as leaf_formula,
                    leaf_formula_desc       as leaf_formula_desc,
                    leaf_proportion         as leaf_proportion,
                    leaf_total_proportion   as leaf_total_proportion
                ")
                ->where(function($q) use ($formulaId, $blendNo, $organizationId) {
                    $q->where('blend_no', $blendNo)
                        ->when($organizationId != '', function($q) use($organizationId) {
                            // $q->where("organization_id", $organizationId);
                        });
                })
                ->where('blend_id', $blendId)
                // ->where('leaf_formula', 'B1')
                // ->where('leaf_formula', 'R')
                ->orderBy('leaf_formula')
                ->get();

        if (count($leafFormulas)) {
            $newLeafLine        = collect($this->getNewLeafFormulaLine());
            $newLeafDtlLine     = collect($this->getNewIngredientLine());

            data_set($leafFormulas, '*.is_new_row', false);

            $data = collect($leafFormulas)->map(function ($leafFormula) use ($newLeafLine, $newLeafDtlLine, $profile) {
                $leafFormula = (object) $newLeafLine->merge($leafFormula)->toArray();
                $leafFormula->leaf_dtl = [];

                if ($leafFormula->leaf_formula) {
                    // $leafFormula->leaf_list = $this->getleafList(request(), $profile, $leafFormula->leaf_formula);
                    $leafFormula->leaf_list = [];
                }

                $leafDtlList = PtpdSmlCostLeafDFmlV::selectRaw("
                                    fm_leaf_d_id,
                                    enable_flag,
                                    ''      as formulaline_id,
                                    proportion_percent,
                                    unit_cost,
                                    quantity_used,
                                    nvl(cost_materials_used, 0)     as cost_materials_used,
                                    nvl(price_adjus, 0)             as price_adjus,
                                    nvl(price_reduc_increase, 0)    as price_reduc_increase,
                                    nvl(cost_after_price_adjus, 0)  as cost_after_price_adjus,
                                    inventory_item_id           as inventory_item_id,
                                    line_no                     as line_no,
                                    item_code                   as item_code,
                                    item_desc                   as item_desc,
                                    lot_number                  as lot_number,
                                    nvl(proportion_percent, 0)  as ingredient_proportions,
                                    nvl(quantity_used, 0)       as quantity_used,
                                    nvl(cost_per_cgk_baht, 0)       as cost_per_cgk_baht,
                                    status
                                ")
                                ->where('leaf_formula', $leafFormula->leaf_formula)
                                ->where('blend_no', $leafFormula->blend_no)
                                ->where('blend_id', $leafFormula->blend_id)
                                // ->where('formula_id', $leafFormula->formula_id)
                                ->get();

                if ($leafDtlList) {
                    data_set($leafDtlList, '*.is_new_row', false);
                    $leafDtlList = $leafDtlList->map(function ($row) use ($newLeafDtlLine, $profile) {
                        $row = (object) $newLeafDtlLine->merge($row)->toArray();

                        if ($row->inventory_item_id) {
                            // $row->item_list = $this->getItemList(request(), $profile, $row->inventory_item_id);
                            $row->item_list = [];
                        }
                        if ($row->lot_number) {
                            $row->lot_list = $this->getLotList(request(), $profile, $row->inventory_item_id, $row->lot_number);
                        }

                        return $row;
                    });
                    $leafFormula->leaf_dtl = $leafDtlList->toArray();
                    // $leafFormula->leaf_dtl = [];
                }
                return $leafFormula;
            });

            return $data->toArray();
        }
        return [];
    }

    function getleafList($request, $profile, $leafFormula = false)
    {
        $jsonNullable       = $this->getJsonNullable();
        $header             = json_decode($request->header ?? $jsonNullable);
        $number             = strtolower($request->number) ?? false;
        $organizationId     = data_get($header ?? [], 'organization_id', $profile->organization_id);
        $formulaId          = data_get($header, 'formula_id', false);
        $except             = $request->except ?? [];
        // dd('xzz', $except);

        $leafList = PtpdSmlCostLeafFmlV::selectRaw("
                        lookup_code        as value,
                        description         as leaf_formula_desc,
                        lookup_code || ' : ' || description  as label
                    ")
                    ->when(!is_null($number), function($q) use($number) {
                        $q->whereRaw("LOWER(lookup_code || ' : ' || description) like '%{$number}%'");
                    })
                    ->when($leafFormula, function($q) use($leafFormula) {
                        $q->orWhere("lookup_code", $leafFormula);
                    })
                    ->when(count($except), function($q) use($except) {
                        $except = array_filter($except);
                        if (count($except)) {
                            $q->whereNotIn("lookup_code", $except);
                        }
                    })
                    // ->limit(20)
                    ->orderBy('lookup_code')
                    ->get();

        return $leafList;
    }

    function getItemList($request, $profile, $inventoryItemId = false)
    {
        $header             = json_decode($request->header ?? []);
        $jsonNullable       = $this->getJsonNullable();
        $line               = json_decode($request->line ?? $jsonNullable);
        $number             = strtolower($request->number) ?? false;
        $organizationId     = $profile->organization_id;
        $blend              = PtpdSmlCostFmlHeadV::where('blend_id', $header->blend_id)->first();
        // $periodYear         = $header->period_year;

        $flagCostStandard   = data_get($header, 'flag_cost_standard', false);
        $stdPeriodName      = data_get($header, 'std_period_name', false);
        // if (!$periodYear) {
        //     $biweekly = \App\Models\PM\PtBiweeklyV::selectRaw('TRUNC(sysdate) between start_date and end_date');
        //     $periodYear = $biweekly->period_year;
        // }

        $itemList = PtpdSmlCostLeafItemDtlV::selectRaw("
                        distinct
                        organization_code,
                        organization_id,
                        unit_cost,
                        item_code               as item_number,
                        item_desc               as item_desc,
                        'KG'                    as uom,
                        inventory_item_id       as value,
                        item_code || ' : ' || item_desc  as label
                    ")
                    ->when($organizationId, function($q) use($organizationId) {
                        $q->where("organization_id", $organizationId);
                    })
                    ->when($number, function($q) use($number) {
                        $q->whereRaw("LOWER(item_code || ' : ' || item_desc) like '%{$number}%'");
                    })
                    // ->when($blend->flag_cost_standard == 'Y', function($q) use($blend) {
                    //     $q->where("flag_cost_standard", $blend->flag_cost_standard);
                    // })
                    // ->when($blend->flag_cost_standard == 'N', function($q) use($blend) {
                    //     $q->where("std_period_name", $blend->getAttributes()['std_period_name']);
                    // })
                    // ->whereRaw("(period_year =  $periodYear or period_year is null)")
                    ->orderBy('unit_cost', 'desc')
                    ->orderBy('item_code')
                    // ->limit(1)
                    ->get();

        return $itemList;
    }

    function getLotList($request, $profile, $inventoryItemId = false, $lotNumber = false)
    {
        $jsonNullable   = $this->getJsonNullable();
        $line           = json_decode($request->line ?? $jsonNullable);
        $number         = strtolower($request->number) ?? false;
        $organizationId = $profile->organization_id;

        if (!$inventoryItemId) {
            $inventoryItemId = $line->inventory_item_id;
        }
        return [];

        $lotList = PtpdLeafDtlFmlV::selectRaw("
                        distinct
                        lot_number              as value,
                        lot_number              as label
                    ")
                    ->where('inventory_item_id', $inventoryItemId)
                    ->when($organizationId, function($q) use($organizationId) {
                        $q->where("organization_id", $organizationId);
                    })
                    ->when($lotNumber, function($q) use($lotNumber) {
                        $q->orWhere("lot_number", $lotNumber);
                    })
                    ->orderBy('lot_number')
                    ->whereNotNull('lot_number')
                    // ->limit(20)
                    ->get();

        return $lotList;
    }


    function getCasings($request, $profile)
    {
        $header             = json_decode($request->header ?? []);
        $organizationId     = data_get($header ?? [], 'organization_id', $profile->organization_id);
        $newCasingLine      = collect($this->getNewCasingLine());
        $newCasingItem      = collect($this->getNewCasingItem());
        $blendId            = data_get($header, 'blend_id', false);
        $formulaNo          = data_get($header, 'formula_no', '');
        $leafFormula        = request()->leaf_formula ?? '';
        $blendNo            = data_get($header, 'blend_no', '');

        $data = PtpdSmlCostCasingFmlV::selectRaw("
                    distinct
                    blend_no,
                    leaf_formula        as leaf_formula,
                    leaf_formula_desc   as leaf_formula_desc,
                    casing_id           as casing_id,
                    casing_no           as casing_no,
                    casing_desc         as casing_desc,

                    leaf_formula        as old_leaf_formula,
                    casing_id           as old_casing_id,
                    '' unit_cost,
                    '' price_adjus,
                    '' price_reduc_increase,
                    '' cost_after_price_adjus
                ")
                ->with(['casingItems' => function ($query) use ($blendId, $blendNo) {
                    $query->selectRaw("
                        enable_flag,
                        blend_no,
                        fm_casing_id,
                        casing_id,
                        leaf_formula,
                        inventory_item_id   as inventory_item_id,
                        item_code           as item_code,
                        item_code           as old_item_code,
                        item_desc           as item_desc,
                        quantity_used       as quantity_used,
                        uom                 as uom,
                        uom_name          as uom_name,
                        unit_cost,
                        price_adjus,
                        price_reduc_increase,
                        cost_after_price_adjus,
                        cost_per_cgk_baht,
                        status
                    ")
                   ->where(function($q) use ($blendNo, $blendId) {
                         $q->where('blend_id', $blendId);
                    });
                }])
                // ->searchBlendOrFormula($blendNo, $blendId)
                ->where(function($q) use ($blendNo, $blendId) {
                     $q->where('blend_id', $blendId);
                })
                ->when($leafFormula, function($q) use($leafFormula) {
                    $q->where("leaf_formula", $leafFormula);
                })
                // ->where('casing_no', 'PD12R')
                ->get();

        $data = $data->map(function ($casing) use ($newCasingLine, $newCasingItem, $profile) {
            $casingItems = $casing->casingItems->where('leaf_formula', $casing->leaf_formula)->where('casing_id', $casing->casing_id);
            $casing = (object) $newCasingLine->merge($casing)->toArray();
            $casing->casing_leaf_formula_list  = $this->getCasingLeafFormulaList(request(), $profile, $casing->leaf_formula);
            $casing->casing_list        = $this->getCasingList(request(), $profile, $casing->casing_id, $casingItems);
            $casing->is_new_row         = false;

            if (count($casingItems)) {
                data_set($casingItems, '*.is_new_row', false);
                $casingItems = $casingItems->map(function ($row) use ($newCasingItem, $profile) {
                    $row = (object) $newCasingItem->merge($row)->toArray();
                    return $row;
                });
            }
            $casing->casing_items    = count($casingItems) ? array_values($casingItems->toArray()) : [];
            return $casing;
        });

        if ($data) {
            return $data->toArray();
        }
        return $data;
    }

    function getCasingLeafFormulaList($request, $profile, $leafFormula = false)
    {
        $jsonNullable       = $this->getJsonNullable();
        $header             = json_decode($request->header ?? $jsonNullable);
        $number             = strtolower($request->number) ?? false;
        $organizationId     = data_get($header ?? [], 'organization_id', $profile->organization_id);
        $blendId            = data_get($header, 'blend_id', '');
        $leafFormulaArr     = [];

        if ($blendId) {
            $leafFormulaData = PtpdSmlCostLeafHFmlV::select(['leaf_formula', 'leaf_proportion'])
                                ->where('blend_id', $blendId)
                                ->get();
            if (count($leafFormulaData)) {
                $leafFormulaArr = $leafFormulaData->pluck('leaf_formula')->all();
            }
        }

        $leafList = PtpdSmlCostLeafFmlV::selectRaw("
                        lookup_code        as value,
                        description   as leaf_formula_desc,
                        lookup_code || ' : ' || description  as label
                    ")
                    ->when(!is_null($number), function($q) use($number) {
                        $q->whereRaw("LOWER(lookup_code || ' : ' || description) like '%{$number}%'");
                    })
                    ->when($leafFormula, function($q) use($leafFormula) {
                        $q->orWhere("lookup_code", $leafFormula);
                    })
                    ->whereIn('lookup_code', $leafFormulaArr)
                    ->orderBy('lookup_code')
                    ->get();
        foreach ($leafList as $key => $left) {
            $data = $leafFormulaData->where('leaf_formula', $left->value);
            $leafProportion = 0;
            if (count($data)) {
                $leafProportion = $data->first()->leaf_proportion;
            }
            $left->leaf_proportion = $leafProportion;
        }

        return $leafList;
    }

    function getCasingList($request, $profile, $casingId = false, $casingItems = false)
    {
        $jsonNullable       = $this->getJsonNullable();
        $header             = json_decode($request->header ?? $jsonNullable);
        $line               = json_decode($request->line ?? $jsonNullable);
        $number             = strtolower($request->number) ?? false;
        $organizationId     = data_get($header ?? [], 'or_formula_organization_id', $profile->organization_id);

        $blend              = PtpdSmlCostFmlHeadV::where('blend_id', $header->blend_id)->first();
        $flagCostStandard   = data_get($blend, 'flag_cost_standard', false);
        $stdPeriodName      = data_get($blend->getAttributes(), 'std_period_name', false);

        $data = PtpdSmlCostCasingV::selectRaw("
                    --casing_id           as casing_id,
                    --casing_no           as casing_no,
                    --casing_desc         as casing_desc,
                    --item_code           as item_code,
                    --item_desc           as item_desc,
                    --quantity_used       as quantity_used,
                    --uom                 as uom,
                    casing_id,
                    casing_no,
                    casing_desc,
                    casing_id           as value,
                    casing_no || ' : ' || casing_desc  as label,
                    '' unit_cost,
                    '' price_adjus,
                    '' price_reduc_increase,
                    '' cost_after_price_adjus
                ")
                ->with(['casingItems' => function ($query) use ($organizationId, $flagCostStandard, $stdPeriodName) {
                    $query->selectRaw("PTPD_SML_COST_CASING_V.*, 'Y' enable_flag ")
                        ->where('organization_id', $organizationId)
                        ->when($flagCostStandard == 'Y', function($q) use($flagCostStandard) {
                            $q->where("flag_cost_standard", $flagCostStandard);
                        })
                        ->when($flagCostStandard == 'N', function($q) use($stdPeriodName) {
                            $q->where("std_period_name", $stdPeriodName);
                        });
                }])
                ->when(!is_null($number), function($q) use($number) {
                    // dd('x');
                    $q->whereRaw("LOWER(casing_no || ' : ' || casing_desc) like '%{$number}%'");
                })
                ->when($casingId, function($q) use($casingId) {
                    $q->orWhere("casing_id", $casingId);
                })
                ->when($organizationId, function($q) use($organizationId) {
                    // $q->where("organization_id", $organizationId);
                })
                ->when($flagCostStandard == 'Y', function($q) use($flagCostStandard) {
                    $q->where("flag_cost_standard", $flagCostStandard);
                })
                ->when($flagCostStandard == 'N', function($q) use($stdPeriodName) {
                    $q->where("std_period_name", $stdPeriodName);
                })
                ->orderBy('casing_no')
                ->groupByRaw("
                    casing_id,
                    casing_no,
                    casing_desc
                ")
                // ->limit(20)
                ->get();

        if ($casingId) {
            data_set($jobLines, '*.casing_items', $casingItems);
            data_set($jobLines, '*.casing_items.*.old_item_code', '');
        }

        return $data;
    }

    function getCasingItemList($request, $profile)
    {
        $jsonNullable       = $this->getJsonNullable();
        $header             = json_decode($request->header ?? $jsonNullable);
        $line               = json_decode($request->line ?? $jsonNullable);
        $number             = strtolower($request->number) ?? false;
        $organizationId     = data_get($header ?? [], 'or_formula_organization_id', $profile->organization_id);
        $except             = $request->except ?? [];

        // $flagCostStandard   = data_get($header, 'flag_cost_standard', false);
        // $stdPeriodName      = data_get($header, 'std_period_name', false);
        // $blend              = PtpdSmlCostFmlHeadV::where('blend_id', $header->blend_id)->first();
        // $flagCostStandard   = data_get($blend, 'flag_cost_standard', false);
        // $stdPeriodName      = data_get($blend->getAttributes(), 'std_period_name', false);

        if (!$organizationId) {
            $organizationId = $profile->organization_id;
        }

        // dd('LEAF_FORMULA',  $line);

        $data = PtpdSmlCasingItemV::selectRaw("
                    'Y' enable_flag,
                    inventory_item_id         as value,
                    item_code || ' : ' || item_desc  as label,
                    '' fm_casing_id,
                    '$line->casing_id'              casing_id,
                    '$line->leaf_formula'           leaf_formula,
                    inventory_item_id,
                    item_code,
                    '' old_item_code,
                    item_desc,
                    uom,
                    uom_name,

                    item_desc,
                    unit_cost,
                    0 price_adjus,
                    0 price_reduc_increase,
                    0 cost_after_price_adjus,
                    0 quantity_used,
                    0 cost_per_cgk_baht,
                    '' status
                ")
                ->when(!is_null($number), function($q) use($number) {
                    $q->whereRaw("LOWER(item_code || ' : ' || item_desc) like '%{$number}%'");
                })
                ->when(count($except), function($q) use($except) {
                    // $except = array_filter($except);
                    // if (count($except)) {
                    //     $q->whereNotIn("inventory_item_id", $except);
                    // }
                    if (count($except)) {
                        // $q->whereNotIn("inventory_item_id", $except);
                        $except = "'" . implode("','", $except) . "'";
                        $q->whereRaw("nvl(to_char(inventory_item_id), item_code) not in ($except)");
                    }
                })
                // ->where('organization_id', $wipLine->organization_id)
                ->orderBy('item_code')
                ->get();

        if (count($data)) {
            data_set($data, '*.is_new_row', true);
            data_set($data, '*.is_deleted', false);
            data_set($data, '*.is_edit_item', false);
            data_set($data, '*.loading', false);
        }
        return $data;
    }

    function getFlavors($request, $profile)
    {
        $header             = json_decode($request->header ?? []);
        $newFlavorLine      = collect($this->getNewFlavorLine());
        $newFlavorItem      = collect($this->getNewFlavorItem());
        $formulaId          = data_get($header, 'formula_id', false);
        $organizationId     = data_get($header ?? [], 'or_formula_organization_id', $profile->organization_id);
        $blendNo            = data_get($header, 'blend_no', '');
        $blendId            = data_get($header, 'blend_id', '');

        $data = PtpdSmlCostFlavorFmlV::selectRaw("
                    distinct
                    'Y' flavor_status,
                    blend_no,
                    flavor_id as flavor_id,
                    flavor_id as old_flavor_id,
                    flavor_no as flavor_no,
                    flavor_desc as flavor_desc,
                    '' unit_cost,
                    '' price_adjus,
                    '' price_reduc_increase,
                    '' cost_after_price_adjus
                ")
                ->with(['flavorItems' => function ($query) use ($blendId, $blendNo, $organizationId) {
                    $query->selectRaw("
                        enable_flag,
                        blend_no,
                        fm_flavor_id,
                        flavor_id,
                        ''                                  as organization_id,
                        inventory_item_id                   as inventory_item_id,
                        item_code                           as old_item_code,
                        item_code                           as item_code,
                        item_desc                           as item_desc,
                        nvl(quantity_used, 0)               as quantity_used,
                        nvl(unit_cost, 0)                   as unit_cost,
                        nvl(price_adjus, 0)                 as price_adjus,
                        nvl(price_reduc_increase, 0)        as price_reduc_increase,
                        nvl(cost_after_price_adjus, 0)      as cost_after_price_adjus,
                        uom                                 as uom,
                        uom_name                            as uom_name,
                        nvl(cost_per_cgk_baht, 0)           as cost_per_cgk_baht,
                        status
                    ")
                    // ->where('formula_id', $blendId)
                    // ->searchBlendOrFormula($blendNo, $blendId)
                    ->where(function($q) use ($blendNo, $blendId) {
                         $q->where('blend_id', $blendId);
                    });
                    // ->where('organization_id', $organizationId);
                }])
                // ->searchBlendOrFormula($blendNo, $blendId)
                ->where(function($q) use ($blendNo, $blendId) {
                     $q->where('blend_id', $blendId);
                })
                // ->where('organization_id', $organizationId)
                // ->where('formula_id', $blendId)
                ->get();

         $data = $data->map(function ($row) use ($newFlavorLine, $newFlavorItem, $profile) {
            $flavorItems            = $row->flavorItems;
            $row                    = (object) $newFlavorLine->merge($row)->toArray();
            $row->flavor_status     = ($row->flavor_status == 'Y') ? true : false;
            // $row->flavor_list       = $this->getFlavorList(request(), $profile, $row->flavor_id, $flavorItems);
            if (count($flavorItems)) {
                data_set($flavorItems, '*.is_new_row', false);
                $flavorItems = $flavorItems->map(function ($row) use ($newFlavorItem) {
                    $row = (object) $newFlavorItem->merge($row)->toArray();
                    return $row;
                });
                $row->flavor_items = $flavorItems;
            }

            $row->flavor_list       = [];
            $row->is_new_row        = false;
            return $row;
        });

         if ($data) {
            return $data->toArray();
        }
        return [];
    }

    function getFlavorList($request, $profile, $flavorId = false, $flavorItems = false)
    {
        $jsonNullable       = $this->getJsonNullable();
        $header             = json_decode($request->header ?? $jsonNullable);
        $number             = strtolower($request->number) ?? false;
        $organizationId     = data_get($header ?? [], 'or_formula_organization_id', $profile->organization_id);
        $except             = $request->except ?? [];

        // $flagCostStandard   = data_get($header, 'flag_cost_standard', false);
        // $stdPeriodName      = data_get($header, 'std_period_name', false);
        $blend              = PtpdSmlCostFmlHeadV::where('blend_id', $header->blend_id)->first();
        $flagCostStandard   = data_get($blend, 'flag_cost_standard', false);
        $stdPeriodName      = data_get($blend->getAttributes(), 'std_period_name', false);

        if (!$organizationId) {
            $organizationId = $profile->organization_id;
        }

        $data = PtpdSmlCostFlavorV::selectRaw("
                    organization_id     as organization_id,
                    flavor_id           as flavor_id,
                    flavor_id           as old_flavor_id,
                    flavor_no           as flavor_no,
                    flavor_desc         as flavor_desc,
                    flavor_id           as value,
                    flavor_no || ' : ' || flavor_desc  as label,
                    sum(unit_cost)      unit_cost
                ")
                ->with(['flavorItems' => function ($query) use ($organizationId, $flagCostStandard, $stdPeriodName) {
                    $query->selectRaw("
                        'Y' enable_flag,
                        flavor_id,
                        organization_id     as organization_id,
                        inventory_item_id   as inventory_item_id,
                        item_code           as old_item_code,
                        item_code           as item_code,
                        item_desc           as item_desc,
                        quantity_used       as quantity_used,
                        unit_cost,
                        '' price_adjus,
                        '' price_reduc_increase,
                        '' cost_after_price_adjus,
                        uom                 as uom,
                        uom_name            as uom_name
                    ")
                    ->where('organization_id', $organizationId)
                    ->when($flagCostStandard == 'Y', function($q) use($flagCostStandard) {
                        $q->where("flag_cost_standard", $flagCostStandard);
                    })
                    ->when($flagCostStandard == 'N', function($q) use($stdPeriodName) {
                        $q->where("std_period_name", $stdPeriodName);
                    });
                }])
                ->when(!is_null($number), function($q) use($number) {
                    $q->whereRaw("LOWER(flavor_no || ' : ' || flavor_desc) like '%{$number}%'");
                })
                ->when($flavorId, function($q) use($flavorId) {
                    // $q->Where("flavor_id", $flavorId);
                })
                ->when(count($except), function($q) use($except) {
                    $except = array_filter($except);
                    if (count($except)) {
                        $q->whereNotIn("flavor_id", $except);
                    }
                })
                ->when($flagCostStandard == 'Y', function($q) use($flagCostStandard) {
                    $q->where("flag_cost_standard", $flagCostStandard);
                })
                ->when($flagCostStandard == 'N', function($q) use($stdPeriodName) {
                    $q->where("std_period_name", $stdPeriodName);
                })
                ->where('organization_id', $organizationId)
                ->groupByRaw("
                    organization_id
                    , flavor_id
                    , flavor_no
                    , flavor_desc
                ")
                ->orderBy('flavor_no')
                // ->limit(20)
                ->get();

        if ($flavorId) {
            data_set($jobLines, '*.flavor_items', $flavorItems);
        }

        return $data;
    }

    function getFlavorItemList($request, $profile, $flavorId = false, $flavorItems = false)
    {
        $jsonNullable       = $this->getJsonNullable();
        $header             = json_decode($request->header ?? $jsonNullable);
        $number             = strtolower($request->number) ?? false;
        $organizationId     = data_get($header ?? [], 'or_formula_organization_id', $profile->organization_id);
        $except             = $request->except ?? [];

        // $flagCostStandard   = data_get($header, 'flag_cost_standard', false);
        // $stdPeriodName      = data_get($header, 'std_period_name', false);
        // $blend              = PtpdSmlCostFmlHeadV::where('blend_id', $header->blend_id)->first();
        // $flagCostStandard   = data_get($blend, 'flag_cost_standard', false);
        // $stdPeriodName      = data_get($blend->getAttributes(), 'std_period_name', false);

        if (!$organizationId) {
            $organizationId = $profile->organization_id;
        }

        $data = PtpdSmlFlavorItemV::selectRaw("
                    'Y' enable_flag,
                    flavor_id,
                    organization_id     as organization_id,
                    inventory_item_id   as inventory_item_id,
                    item_code           as old_item_code,
                    item_code           as item_code,
                    item_desc           as item_desc,
                    quantity_used       as quantity_used,
                    inventory_item_id         as value,
                    item_code || ' : ' || item_desc  as label,
                    unit_cost,
                    0 price_adjus,
                    0 price_reduc_increase,
                    0 cost_after_price_adjus,
                    uom                 as uom,
                    uom_name            as uom_name
                ")
                ->when(!is_null($number), function($q) use($number) {
                    $q->whereRaw("LOWER(item_code || ' : ' || item_desc) like '%{$number}%'");
                })
                ->when($flavorId, function($q) use($flavorId) {
                    // $q->Where("flavor_id", $flavorId);
                })
                ->when(count($except), function($q) use($except) {
                    $except = array_filter($except);
                    if (count($except)) {
                        // $q->whereNotIn("inventory_item_id", $except);
                        $except = "'" . implode("','", $except) . "'";
                        $q->whereRaw("nvl(to_char(inventory_item_id), item_code) not in ($except)");
                    }
                })
                // ->when($flagCostStandard == 'Y', function($q) use($flagCostStandard) {
                //     $q->where("flag_cost_standard", $flagCostStandard);
                // })
                // ->when($flagCostStandard == 'N', function($q) use($stdPeriodName) {
                //     $q->where("std_period_name", $stdPeriodName);
                // })
                ->where('organization_id', $organizationId)
                ->groupByRaw("
                    flavor_id
                    , organization_id
                    , inventory_item_id
                    , item_code
                    , item_desc
                    , quantity_used
                    , unit_cost
                    , uom
                    , uom_name
                ")
                ->orderBy('item_code')
                // ->limit(20)
                ->get();

        if ($flavorId) {
            data_set($jobLines, '*.flavor_items', $flavorItems);
        }

        return $data;
    }


    function getCigaItemList($request, $profile)
    {
        $jsonNullable       = $this->getJsonNullable();
        $header             = json_decode($request->header ?? $jsonNullable);
        $wipLine            = json_decode($request->line ?? $jsonNullable);
        $number             = strtolower($request->number) ?? false;
        $organizationId     = data_get($header ?? [], 'or_formula_organization_id', $profile->organization_id);
        $except             = $request->except ?? [];

        // $flagCostStandard   = data_get($header, 'flag_cost_standard', false);
        // $stdPeriodName      = data_get($header, 'std_period_name', false);
        // $blend              = PtpdSmlCostFmlHeadV::where('blend_id', $header->blend_id)->first();
        // $flagCostStandard   = data_get($blend, 'flag_cost_standard', false);
        // $stdPeriodName      = data_get($blend->getAttributes(), 'std_period_name', false);

        if (!$organizationId) {
            $organizationId = $profile->organization_id;
        }

        $data = PtpdSmlWrapItemV::selectRaw("
                    'Y' enable_flag,
                    inventory_item_id         as value,
                    item_code || ' : ' || item_desc  as label,
                    '$wipLine->product_item' product_item,
                    $header->blend_id blend_id,
                    '' fm_wc_id,
                    '' line_no,
                    '$wipLine->wip_code' wip_code,
                    '$wipLine->wip_desc' wip_desc,
                    organization_id
                    inventory_item_id,
                    item_code,
                    item_desc,
                    unit_cost,
                    0 price_adjus,
                    0 price_reduc_increase,
                    0 cost_after_price_adjus,
                    0 quantity_used,
                    uom,
                    uom_name,
                    0 cost_per_cgk_baht,
                    '$wipLine->attribute1' attribute1,
                    '' status
                ")
                ->when(!is_null($number), function($q) use($number) {
                    $q->whereRaw("LOWER(item_code || ' : ' || item_desc) like '%{$number}%'");
                })
                ->when(count($except), function($q) use($except) {
                    $except = array_filter($except);
                    if (count($except)) {
                        $q->whereNotIn("inventory_item_id", $except);
                    }
                })
                ->where('organization_id', $wipLine->organization_id)
                ->orderBy('item_code')
                ->limit(20)
                ->get();
        if (count($data)) {
            data_set($data, '*.is_edit_item', false);
            data_set($data, '*.loading', false);
        }
        return $data;
    }

    function getCigarettes($request, $profile)
    {
        $header             = json_decode($request->header ?? []);
        $organizationId     = data_get($header ?? [], 'organization_id', $profile->organization_id);
        $newCigaretteLine   = collect($this->getNewCigaretteLine());
        $newCigaretteItem   = collect($this->getNewCigaretteItem());

        $formulaId          = data_get($header, 'formula_id', false);
        $blendNo            = data_get($header, 'blend_no', '');
        // $flagCostStandard   = data_get($header, 'flag_cost_standard', false);
        // $stdPeriodName      = data_get($header, 'std_period_name', false);

        $blend              = PtpdSmlCostFmlHeadV::where('blend_id', $header->blend_id)->first();
        $flagCostStandard   = data_get($blend, 'flag_cost_standard', false);
        $stdPeriodName      = data_get($blend->getAttributes(), 'std_period_name', false);
        $cigarateReferCostItem      = data_get($header, 'cigarate_refer_cost_item', false);

        $data = PtpdSmlCostWrapCigaFmlV::selectRaw("
                    blend_id,
                    product_item,
                    organization_id,
                    wip_code,
                    wip_desc,
                    attribute1
                ")
                ->with(['items' => function ($query) use ($flagCostStandard, $stdPeriodName, $cigarateReferCostItem) {
                    $query->selectRaw("
                        product_item,
                        blend_id,
                        fm_wc_id,
                        line_no,
                        wip_code,
                        wip_desc,
                        enable_flag,
                        inventory_item_id,
                        item_code,
                        item_desc,
                        unit_cost,
                        price_adjus,
                        price_reduc_increase,
                        cost_after_price_adjus,
                        quantity_used,
                        uom,
                        uom_name,
                        cost_per_cgk_baht,
                        attribute1,
                        status
                    ");
                    // ->when($flagCostStandard == 'Y', function($q) use($flagCostStandard) {
                    //     $q->where("flag_cost_standard", $flagCostStandard);
                    // })
                    // ->when($flagCostStandard == 'N', function($q) use($stdPeriodName) {
                    //     $q->where("std_period_name", $stdPeriodName);
                    // });
                }])
                ->where('blend_id', $header->blend_id)
                // ->when($flagCostStandard == 'Y', function($q) use($flagCostStandard) {
                //     $q->where("flag_cost_standard", $flagCostStandard);
                // })
                // ->when($flagCostStandard == 'N', function($q) use($stdPeriodName) {
                //     $q->where("std_period_name", $stdPeriodName);
                // })
                ->groupByRaw("blend_id, product_item, organization_id, wip_code, wip_desc, attribute1")
                ->orderByRaw("wip_code")
                ->get();

        $data = $data->map(function ($row) use ($newCigaretteLine, $newCigaretteItem, $profile) {
            $items = [];
            if ($itemList = $row->items) {
                $items = $itemList->where('wip_code', $row->wip_code);

                if (count($items)) {
                    data_set($items, '*.is_new_row', false);
                    $items = $items->map(function ($o) use ($newCigaretteItem) {
                        $o = (object) $newCigaretteItem->merge($o)->toArray();
                        return $o;
                    });
                    $items = $items->toArray();
                    $items = array_values($items);
                }
            }
            $row                    = (object) $newCigaretteLine->merge($row)->toArray();

            // $row->cigar_list        = $this->getCigaretteList(
            //                                 request(),
            //                                 $profile,
            //                                 $row->cigar_item_id,
            //                                 $row->cigar_organization_id
            //                             );
            $row->items             = $items;
            $row->is_new_row        = false;
            return $row;
        });

         if ($data) {
            return $data->toArray();
        }
        return [];
    }

    function getCigaretteList($request, $profile, $cigarItemId = false, $cigarOrganizationId = false)
    {
        $jsonNullable       = $this->getJsonNullable();
        $header             = json_decode($request->header ?? $jsonNullable);
        $number             = strtolower($request->number) ?? false;
        $organizationId     = data_get($header ?? [], 'organization_id', $profile->organization_id);
        $orFormulaOrganizationId = data_get($header ?? [], 'or_formula_organization_id');
        $except             = $request->except ?? [];



        $data = PtpdSmlCostCigarV::selectRaw("
                    cigar_organization_code,
                    cigar_organization_id,
                    cigar_item_id,
                    cigar_item_code,
                    cigar_item_desc,
                    cigar_item_id         as value,
                    cigar_item_code || ' : ' || cigar_item_desc  as label
                ")
                ->when(!is_null($number), function($q) use($number) {
                    $q->whereRaw("LOWER(cigar_item_code || ' : ' || cigar_item_desc) like '%{$number}%'");
                })
                ->when($cigarItemId, function($q) use($cigarItemId) {
                    $q->where("cigar_item_id", $cigarItemId);
                })
                ->when($cigarOrganizationId, function($q) use($cigarOrganizationId) {
                    $q->orWhere("cigar_organization_id", $cigarOrganizationId);
                })
                // ->when($orFormulaOrganizationId, function($q) use($orFormulaOrganizationId) {
                //     $q->where("cigar_organization_id", $orFormulaOrganizationId);
                // })
                ->when(count($except), function($q) use($except) {
                    $except = array_filter($except);
                    if (count($except)) {
                        $q->whereNotIn("cigar_item_id", $except);
                    }
                })
                ->groupByRaw("
                    cigar_organization_code,
                    cigar_organization_id,
                    cigar_item_id,
                    cigar_item_code,
                    cigar_item_desc
                ")
                ->orderBy('cigar_item_code')
                // ->limit(20)
                ->get();

        if ($data) {
            return $data->toArray();
        }

        return [];
    }

    function getCigarDtl($request, $profile)
    {
        $header             = json_decode($request->header ?? []);
        $organizationId     = data_get($header ?? [], 'organization_id', $profile->organization_id);
        $newLie             = collect($this->getNewCigarDtlLine());
        $formulaId          = data_get($header, 'formula_id', false);
        $blendNo            = data_get($header, 'blend_no', '');

        $toTalLine = 3;

        $data = PtpdSmlCostWrappedFml::selectRaw("
                    fm_cigar_id,
                    fm_wrapped_id,
                    wrapped_line_no as cigar_line_no,
                    wrapped_description as cigar_description
                ")
                // ->where('formula_id', $formulaId)
                ->where('blend_id', $header->blend_id)
                ->orderBy('cigar_line_no')
                // ->limit($toTalLine)
                ->get();

        if (count($data)) {
            data_set($data, '*.is_new_row', false);
            data_set($line, '*.is_deleted', false);
            $data = $data->map(function ($row) use ($newLie, $profile) {
                $row = (object) $newLie->merge($row)->toArray();
                return $row;
            });
        }

        // if (count($data) != $toTalLine) {
        //     data_set($data, '*.is_new_row', false);
        //     $countRow = count($data);
        //     foreach (range(1, $toTalLine - count($data)) as $key => $value) {
        //         // $countRow = $countRow + 1;
        //         // $newRaw['cigar_line_no']        = $value->wrapped_line_no;
        //         // $newRaw['cigar_description']    = '';
        //         // $newRaw['is_new_row']           = true;


        //         $row = (object) $newCigaretteLine->merge($value)->toArray();

        //         // $data->push($newRaw);
        //     }
        // }

        return $data->toArray();
    }

    function getCigaretteAll($request, $profile)
    {
        $header             = json_decode($request->header ?? []);
        $organizationId     = data_get($header ?? [], 'organization_id', $profile->organization_id);
        $newCigaretteLine   = collect($this->getNewCigaretteLine());
        $formulaId          = data_get($header, 'formula_id', '');
        $formulaNo          = data_get($header, 'formula_no', false);
        $blendNo            = data_get($header, 'blend_no', '');

        $set1 = PtpdSmlCostTotalV::where('blend_id', $header->blend_id)->get();
        $set2 = PtpdCigaReferCostTotalV::where('product_item_number', $header->cigarate_refer_cost_item)->get();

        $view1 = view('pd.sml-cost-fmls._set1_all_tab', compact('set1', 'set2'))->render();

        return [
            '_set1_all_tab' => $view1,
        ];
    }

    function getJsonNullable()
    {
        return json_encode(false);
    }

    function getCan($header)
    {
        $checkBlend = PtpdFormulaHV::where('blend_no', $header->blend_no)->count();
        $can = (object)[
            'edit' => ($header->example_no ?? 0) == 0 && $header->blend_id,
            'duplicate' => ($header->example_no ?? 0) > 0,
            'confirm_save' => ($header->example_no ?? 0) == 0 && $header->blend_id,
            'copy_pd08' => true,
            'copy_to_pd08' => $header->blend_no != '' && ($checkBlend == 0),
            'is_standart_formula_type' => false,
            'is_actual_formula_type' => false,
            'is_chnp_formula_type' => false,
            'cigarettes' => (object) [
                'multi_cigarettes' => true,
            ],
            // Tab: leaf_formulas
            'leaf_formulas' => (object) [
                'ingredient' => (object) [
                    'add_lot_number' => true
                ]
            ],
        ];

        return $can;
    }

    function getFormulaTypeCode($lookupCode = false, $meaning = false)
    {
        if ($lookupCode == false && $meaning == false) {
            return null;
        }

        $data = PtpdFormulaTypeV::select(['lookup_code', 'meaning', 'description'])
                    ->when($lookupCode, function($q) use($lookupCode) {
                        $q->where("lookup_code", $lookupCode);
                    })
                    ->when($meaning, function($q) use($meaning) {
                        $q->where("meaning", $meaning);
                    })
                    ->first();
        return $data;
    }


    function getProfile()
    {
        $data = getDefaultData($this::url);

        return $data;
    }

    function getCompareData($request)
    {
        return true;
        $originalData = $request->original_data;
        $originalDtlData = $request->original_dtl_data;
        $type = $request->type;
        $isEqual = true;


        $newCasingLine =  $this->getNewCasingLine();

        switch (strtoupper($type)) {

            case 'LEAF_FORMULA_LINE': // Tab: LEAF_FORMULA
                $leafFormulas = collect($request->leaf_formulas);
                $leafFormulas = $leafFormulas->filter(function ($value, $key) {
                    $value = (object)$value;
                    return !($value->is_new_row && $value->is_deleted);
                });
                if (count($originalData) != count($leafFormulas)) {
                    $isEqual = false;
                    break;
                }

                $newLeafFormulaLine = (array) $this->getNewLeafFormulaLine();
                $compareKeys =  Arr::except($newLeafFormulaLine, [
                                    'is_new_row', 'is_collapse', 'is_edit_item', 'leaf_dtl', 'leaf_list'
                                ]);
                $newIngredientLine = (array) $this->getNewIngredientLine();
                $ingredientCompareKeys =  Arr::except($newIngredientLine, [
                                    'is_new_row', 'is_collapse', 'is_edit_item', 'item_list', 'lot_list'
                                ]);

                foreach ($leafFormulas as $key => $value) {
                    $check = $this->compareValue(Arr::get($originalData, $key), $value, $compareKeys);
                    if (!$check) {
                        $isEqual = false;
                        break;
                    }

                    $value = (object) $value;
                    $leafDtls =  collect($value->leaf_dtl);
                    $leafDtls = $leafDtls->filter(function ($value, $key) {
                        $value = (object)$value;
                        return !($value->is_new_row && $value->is_deleted);
                    });
                    if (count($leafDtls) != count(Arr::get($originalData, "{$key}.leaf_dtl"))) {
                        $isEqual = false;
                        break;
                    } else {
                        foreach ($leafDtls as $keyLeafDtl => $leafDtl) {
                            $originalLeafDtl = Arr::get($originalData, "{$key}.leaf_dtl.{$keyLeafDtl}");
                            $check = $this->compareValue($originalLeafDtl, $leafDtl, $ingredientCompareKeys);
                            if (!$check) {
                                $isEqual = false;
                                break;
                            }
                        }
                    }
                }

                break;
            case 'CASINGS': // Tab: Casings
                $compareKeys = [
                    'leaf_formula',
                    'leaf_formula_desc',
                    'casing_id',
                    'casing_no',
                    'casing_desc',
                    'is_deleted',
                ];
                $itemCompareKeys = [
                    'item_code',
                    'item_desc',
                    'quantity_used',
                    'uom',
                ];

                $casings = collect($request->casings);
                $casings = $casings->filter(function ($value, $key) {
                    $value = (object)$value;
                    return !($value->is_new_row && $value->is_deleted);
                });


                if (count($originalData) != count($casings)) {
                    $isEqual = false;
                    break;
                }

                $compareKeys = array_flip($compareKeys);
                $itemCompareKeys = array_flip($itemCompareKeys);
                foreach ($casings as $key => $value) {
                    $check = $this->compareValue(Arr::get($originalData, $key), $value, $compareKeys);
                    if (!$check) {
                        $isEqual = false;
                        break;
                    }
                    $value = (object) $value;
                    $casingItems = $value->casing_items;
                    foreach ($casingItems as $csItemkey => $casingItem) {
                        $originalCasingItem = Arr::get($originalData, "{$key}.casing_items.{$csItemkey}");
                        $check = $this->compareValue($originalCasingItem, $casingItem, $itemCompareKeys);
                        if (!$check) {
                            $isEqual = false;
                            break;
                        }
                    }
                }

                break;
            case 'FLAVORS': // Tab: Flavor
                $compareKeys = [
                    'flavor_id',
                    'flavor_no',
                    'flavor_desc',
                    'is_deleted',
                ];
                $itemCompareKeys = [
                    'organization_id',
                    'inventory_item_id',
                    'item_code',
                    'item_desc',
                    'quantity_used',
                    'uom',
                ];

                $flavors = collect($request->flavors);
                $flavors = $flavors->filter(function ($value, $key) {
                    $value = (object)$value;
                    return !($value->is_new_row && $value->is_deleted);
                });

                if (count($originalData) != count($flavors)) {
                    $isEqual = false;
                    break;
                }

                $compareKeys = array_flip($compareKeys);
                $itemCompareKeys = array_flip($itemCompareKeys);
                foreach ($flavors as $key => $value) {
                    $check = $this->compareValue(Arr::get($originalData, $key), $value, $compareKeys);
                    if (!$check) {
                        $isEqual = false;
                        break;
                    }
                    $value = (object) $value;
                    $flavorItems = $value->flavor_items;
                    foreach ($flavorItems as $csItemkey => $flavorItem) {
                        $originalFlavorItem = Arr::get($originalData, "{$key}.flavor_items.{$csItemkey}");
                        $check = $this->compareValue($originalFlavorItem, $flavorItem, $itemCompareKeys);
                        if (!$check) {
                            $isEqual = false;
                            break;
                        }
                    }
                }
                break;
            case 'CIGARETTES': // Tab: บุหรี่

                $compareKeys = [
                    'cigar_item_id',
                    'cigar_organization_code',
                    'cigar_organization_id',
                    'cigar_item_code',
                    'cigar_item_desc',
                    'is_deleted',
                ];
                $dtlCompareKeys = [
                    // 'cigar_line_no',
                    'cigar_description',
                ];

                $cigarettes = collect($request->cigarettes);
                $cigarettes = $cigarettes->filter(function ($value, $key) {
                    $value = (object)$value;
                    return !($value->is_new_row && $value->is_deleted);
                });



                if (count($originalData) != count($cigarettes)) {
                    $isEqual = false;
                    break;
                }

                $compareKeys = array_flip($compareKeys);
                foreach ($cigarettes as $key => $value) {
                    $check = $this->compareValue(Arr::get($originalData, $key), $value, $compareKeys);
                    if (!$check) {
                        $isEqual = false;
                        break;
                    }
                }

                $cigarDtls = $request->cigar_dtl;
                $dtlCompareKeys =  array_flip($dtlCompareKeys);
                foreach ($cigarDtls as $key => $value) {
                    $check = $this->compareValue(Arr::get($originalDtlData, $key), $value, $dtlCompareKeys);
                    if (!$check) {
                        $isEqual = false;
                        break;
                    }
                }
                break;
        }

        return $isEqual;
    }

    function compareValue($originalData, $data, array $keys)
    {
        foreach ($keys as $key => $value) {
            \Log::info("compareValue", [$key, Arr::get($originalData, $key), Arr::get($data, $key)]);
            if (Arr::get($originalData, $key) != Arr::get($data, $key)) {
                return false;
            }
        }

        return true;
    }

    function delCasings($formula, $delCasingByLeafFormula)
    {
        // $newFormula = $formula->replicate();
        // $newFormula->created_at = $formula->created_at;
        // $newFormula->save();
        // $newFormula->web_batch_no  = "{$newFormula->program_code}-{$newFormula->fm_id}";
        // $newFormula->save();

        $formulaId = $formula->formula_id;
        $data = PtpdCasingFormulaV::selectRaw("
                    leaf_formula        as leaf_formula,
                    leaf_formula_desc   as leaf_formula_desc,
                    casing_id           as casing_id,
                    casing_no           as casing_no,
                    casing_desc         as casing_desc,

                    leaf_formula        as old_leaf_formula,
                    casing_id           as old_casing_id,

                    organization_id     as organization_id,
                    inventory_item_id   as inventory_item_id,
                    item_code           as item_code,
                    item_code           as old_item_code,
                    item_desc           as item_desc,
                    quantity_used       as quantity_used,
                    uom                 as uom,
                    uom_name            as uom_name,
                    formulaline_id      as formulaline_id,
                    line_no             as line_no
                ")
                // ->where('formula_id', $formulaId)
                ->when($formula->formula_id != '', function($q) use($formula) {
                    $q->where("formula_id", $formula->formula_id);
                })
                ->when($formula->formula_no != '', function($q) use($formula) {
                    $q->where("formula_no", $formula->formula_no);
                })
                ->when($formula->formula_vers != '', function($q) use($formula) {
                    $q->where("formula_vers", $formula->formula_vers);
                })
                ->when($formula->blend_no != '', function($q) use($formula) {
                    $q->where("blend_no", $formula->blend_no);
                })
                ->get();

        if (count($delCasingByLeafFormula)) {
            $createDelCasings = clone $data;
            $createDelCasings = $createDelCasings->whereIn("leaf_formula", $delCasingByLeafFormula);
            foreach ($createDelCasings as $key => $delCas) {
                $inputItem                  =  $delCas;
                $inputItem->web_status      = 'DELETE';
                (new ExpFmlFuncRepository)->createCasingTmp($formula, $delCas, $inputItem);
            }

            $createUpdCasings = clone $data;
            $createUpdCasings = $createUpdCasings->whereNotIn("leaf_formula", $delCasingByLeafFormula);
            foreach ($createUpdCasings as $key => $updCas) {
                $inputItem                  =  $updCas;
                $inputItem->web_status      = 'UPDATE';
                (new ExpFmlFuncRepository)->createCasingTmp($formula, $updCas, $inputItem);
            }
        }
        return $formula;

        foreach ($data as $key => $line) {
            $casing = new PtpdCasingFormulaT;
            $casing->formula_id             = $formula->formula_id;
            $casing->formula_no             = $formula->formula_no;
            $casing->leaf_formula           = $line->leaf_formula;
            $casing->leaf_formula_desc      = $line->leaf_formula_desc;
            $casing->casing_id              = $line->casing_id;
            $casing->casing_no              = $line->casing_no;
            $casing->casing_desc            = $line->casing_desc;

            // $casing->line_type          = $inputCasing->line_type;
            // $casing->line_no            = $inputCasing->line_no;
            $casing->blend_id               = $formula->blend_id;
            $casing->blend_no               = $formula->blend_no;
            $casing->organization_code      = $formula->tobacco_organization_code;
            $casing->organization_id        = null;
            $casing->inventory_item_id      = null;
            $casing->item_code              = $line->item_code;
            $casing->item_desc              = $line->item_desc;
            $casing->quantity_used          = $line->quantity_used;
            $casing->uom                    = $line->uom;
            $casing->web_status             = 'DELETE';
            $casing->formulaline_id         = $line->formulaline_id;
            $casing->line_no                = $line->line_no;
            $casing->created_by             = $formula->created_by;
            $casing->created_by_id          = $formula->created_by_id;
            $casing->created_at             = $formula->created_at;
            $casing->creation_date          = $formula->creation_date;
            $casing->program_code           = $formula->program_code;
            $casing->updated_by_id          = $formula->updated_by_id;
            $casing->last_updated_by        = $formula->last_updated_by;
            $casing->updated_at             = $formula->updated_at;
            $casing->last_update_date       = $formula->last_update_date;
            $casing->web_batch_no           = $formula->web_batch_no;
            $casing->save();
        }

        return $formula;
    }

    function getHeaderProductItem($request)
    {

        $blendNo = request()->blend_no ?? false;

        if ($blendNo == '') {
            return collect([]);
        }
        $profile = $this->getProfile($this::url);
        $blendNo = trim($blendNo);
        $tobaccoTypeCode = request()->tobacco_type_code ?? false;
        $formulaTypeCode = request()->formula_type_code ?? false;
        $organizationId = $profile->organization_id;


        $exceptItemData = [];
        $exceptItemSql = '';
        $formulaType = PtpdFormulaTypeV::select(['lookup_code', 'meaning', 'description'])->where('lookup_code', request()->formula_type_code)->first();
        if ($formulaType->description == 'สูตรใช้จริง') {
            $exceptItemData = PtpdFormulaHV::selectRaw('distinct product_item_id')
                            ->whereRaw("
                                tobacco_organization_id = $organizationId
                                and formula_type = '$formulaType->description'
                                and product_item_id is not null
                            ");

            $exceptItemSql = clone $exceptItemData;
            $exceptItemData = $exceptItemData->get();
        }

        // เช็คข้อมูลที่เคยสร้างแล้ว
        $checkProduct = PtpdFormulaHV::selectRaw('distinct product_item_id')
            ->whereRaw("upper(blend_no) = upper('$blendNo')")
            ->where('tobacco_organization_id', $organizationId)
            // ->whereNotNull('product_item_id')
            ->get();

        if (request()->is_creation && count($checkProduct)) {
            throw new \Exception("มีการสร้าง Blend No: $blendNo ในระบบแล้ว");
        }

        $checkProduct = array_filter($checkProduct->pluck('product_item_id', 'product_item_id')->all());
        $data = PtpdItemTobaccoV::selectRaw("
                    distinct
                    inventory_item_id,
                    inventory_item_id           as value,
                    item_code                   as label,
                    item_code || ' : ' || item_desc as cust_label,
                    item_code                   as product_item_code,
                    item_desc                   as description,
                    100                         as quantity,
                    uom,
                    uom_name
                ")
                ->when($exceptItemData, function($q) use($exceptItemSql) {
                    $sql = $exceptItemSql->toSql();
                    $q->whereRaw("inventory_item_id not in ($sql)");
                })
                ->when($tobaccoTypeCode, function($q) use($tobaccoTypeCode) {
                    $q->where("tobacco_type_code", $tobaccoTypeCode);
                })
                ->when($organizationId, function($q) use($organizationId) {
                    $q->where("organization_id", $organizationId);
                })
                ->when(count($checkProduct), function($q) use($checkProduct) {
                    $q->whereNotIn("inventory_item_id", $checkProduct);
                })
                ->orderBy("cust_label")
                ->get();

        return $data;
    }

    function stdPeriodName($value, $type)
    {
        if (!$value || $value == 'Invalid date') {
            return '';
        }

        if ($type == 'to_date_th') {
            $data = \Carbon\Carbon::createFromFormat('M-y', $value)->addYears(543)->timezone('Asia/Bangkok')->format('m/Y');
        } else if ($type == 'to_period') {
            $data = \Carbon\Carbon::createFromFormat('m/Y', $value)->subYears(543)->timezone('Asia/Bangkok');
            $data = $data->format('M-y');
            $data = strtoupper($data);
        }
        return $data;
    }
}
