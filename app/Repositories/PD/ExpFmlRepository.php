<?php
namespace App\Repositories\PD;

use Illuminate\Database\Eloquent\Collection;

use DB;
use Arr;
use App\Models\PM\PtpmWipRequestHeader;
use App\Models\PM\PtpmWipRequestLine;
use App\Models\PM\PtpmCompleteStatus;
use App\Models\PM\PtpmItemNumberV;

// use App\Models\PM\PtpmMesReviewIssueHeaders;
// use App\Models\PM\PtpmMesReviewIssueLines;
use App\Models\PM\PtpmMesReviewJobHeaders;
use App\Models\PM\PtpmMesReviewJobLines;

use App\Models\PM\PtpmSetupMfgDepartmentsV;
use App\Repositories\PM\CommonRepository;

use App\Models\PD\PtpdLeafFmlV;
use App\Models\PD\PtpdLeafDtlFmlV;
use App\Models\PD\PtpdItemBlendNoV;
use App\Models\PD\PtpdBlendFlavourV;
use App\Models\PD\PtpdCasingFmlV;

use App\Models\FndLookupValue;
use App\Models\PD\PtpdFormulaTypeV;

// New
use App\Models\PD\ExpFmls\PtpdFormulaHT;
use App\Models\PD\ExpFmls\PtpdFlavorFormulaT;
use App\Models\PD\ExpFmls\PtpdCigarFmlV;
use App\Models\PD\ExpFmls\PtpdCasingFormulaV;
use App\Models\PD\ExpFmls\PtpdFlavorFmlV;
use App\Models\PD\ExpFmls\PtpdTobaccoTypeV;
use App\Models\PD\ExpFmls\PtpdItemTobaccoV;
use App\Models\PD\ExpFmls\PtpdBlendFlavV;
use App\Models\PD\ExpFmls\PtpdFormulaHV;
use App\Models\PD\ExpFmls\PtpdLeafHFormulaT;
use App\Models\PD\ExpFmls\PtpdLeafDtlFormulaT;
use App\Models\PD\ExpFmls\PtpdCasingFormulaT;
use App\Models\PD\ExpFmls\PtpdFlavorFormulaV;

use App\Models\PD\ExpFmls\PtpdLeafHFormulaV;
use App\Models\PD\ExpFmls\PtpdLeafDtlFormulaV;
use App\Models\PD\ExpFmls\PtpdCigarFormulaV;
use App\Models\PD\ExpFmls\PtpdWrappedDtlFormula;
use App\Models\PD\ExpFmls\PtpdWrappedDtlFormulaV;
use App\Models\PD\ExpFmls\PtpdCigarFormulaT;
use App\Models\PD\ExpFmls\PtpdFormulaTotalV;

use App\Models\PM\PtpmOpmRoutingV;

use App\Repositories\PD\ExpFmlFuncRepository;

class ExpFmlRepository
{
    const url = '/pd/exp-fmls';

    function info($request)
    {
        $profile = $this->getProfile($request->lookup_code);
        $formulaId = $request->formula_id;
        $formulaNo = $request->formula_no;
        $blendNo = $request->blend_no;
        $tobaccoOrganizationId = $request->tobacco_organization_id;

        // $blendNo = 'MCR081-001';
        // $blendNo = 'MCR_TEST_004';
        // $blendNo = 'TEST_NS';
        // $blendNo = 'TEST_BT_005';
        // $blendNo = 'TEST_NS0001';
        // $blendNo = '98TS';
        // $blendNo = 'NS0000001';
        // $blendNo = '98_BT_001A';
        // $blendNo = '98_BT_001P';
        // $blendNo = '98';
        // $blendNo = '98_BT_001S';
        // $blendNo = '9997S';
        // $blendNo = '12S_TEST0001';
        // $blendNo = 'BT01';
        // $blendNo = '98T';
        // $formulaNo = 'BT0001-S-65';
        // $formulaNo = '12S';
        // $formulaNo = '12S';
        // $formulaNo = '12SS-S-65';



        $header = PtpdFormulaHV::where(function($q) use ($formulaId, $blendNo, $tobaccoOrganizationId, $formulaNo) {
                        if ($formulaId) {
                            $q->where('formula_id', $formulaId);
                        } else if ($formulaNo) {
                            $q->where('formula_no', $formulaNo);
                        } else if($formulaId == '' && $blendNo == '' && $tobaccoOrganizationId == '') {
                            $q->whereRaw("1=2");
                        } else {
                            $q->where('blend_no', $blendNo)
                                ->when($tobaccoOrganizationId != '', function($q) use($tobaccoOrganizationId) {
                                    $q->where("tobacco_organization_id", $tobaccoOrganizationId);
                                });
                        }
                    })
                    ->with(['uomDetail'])
                    ->selectRaw("
                        recipe_fiscal_year,
                        tobacco_type_code,
                        formula_id,
                        blend_id,
                        blend_no,
                        formula_no,
                        product_item_id,
                        product_item_code,
                        description,
                        comments,
                        quantity,
                        uom,
                        uom_name,
                        flavour_code,
                        flavour,
                        tobacco_organization_id,
                        tobacco_organization_code,
                        '' formula_organization_code,
                        '' organization_code,
                        department,
                        formula_status,
                        or_formula_id,
                        '' or_formula_organization_id,
                        formula_vers,
                        or_formula_vers,
                        '' organization_id,
                        formula_type,
                        formula_type_code,
                        formula_approval_date,
                        formula_start_date,
                        formula_last_update_date,
                        formula_creation_date,
                        user_name,
                        web_user_name,
                        recipe_routing_no,
                        tobacco_type_desc,
                        product_item_desc,
                        invoice_flag,

                        formula_id                  as reference_formula_id,
                        formula_no                  as reference_formula_no,
                        formula_vers                as reference_version,
                        tobacco_organization_code   as reference_organization_code
                    ")
                    ->orderBy('formula_vers', 'desc')
                    ->first();

        if (!$header) {
            $model = new PtpdFormulaHT();
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
            $header->quantity               = 2000;
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
            $header->invoice_flag           = '';

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
            $header->def_uod_desc = 'กิโลกรัม';

            // New
            $header->tobacco_type_code      = '';
            $header->has_tmp_table = false;
            $header->recipe_routing_no = '';

            $header->check_match_blend_no = true;
            $header->check_match_blend_no_msg = '';
        } else {
            $header->has_tmp_table = true;
            $header->check_match_blend_no = true;
            $header->check_match_blend_no_msg = '';
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
        $preFixRoute            = 'pd.exp-fmls';
        $preFixAjaxRoute        = 'pd.ajax.exp-fmls';
        // $url->index             = route("{$preFixRoute}.index", request()->all() ?? []);
        $url->index             = route("{$preFixRoute}.index");
        $url->ajax_store        = route("{$preFixAjaxRoute}.store");
        $url->ajax_get_lines    = route("{$preFixAjaxRoute}.get-lines");
        $url->ajax_get_data     = route("{$preFixAjaxRoute}.get-data");
        $url->ajax_compare_data = route("{$preFixAjaxRoute}.compare-data");
        $url->ajax_set_status   = route("{$preFixAjaxRoute}.set-status", $headerId);
        return $url;
    }

    function search($request)
    {
        $blendNo            = false;
        $canSearch = (object)[
            'tobacco_type_code'     => [],
            'formula_type_code'     => [],
            'formula_status'        => [],
            'recipe_fiscal_year'    => []
        ];


        $defaultCanSearchฺBlend = (object)[
            'tobacco_type_code'     => '',
            'formula_type_code'     => '',
            'formula_status'        => '',
            'recipe_fiscal_year'    => '',
            'type_s'                => false  // สูตรมาตาฐาน
        ];

    
        if (request()->blend_no != '') {
            $blendNo            = strtolower(request()->blend_no);
        }
        $profile            = $this->getProfile($request->lookup_code);
        $organizationId     = $profile->organization_id;
        // $formulaType        = $this->getFormulaTypeCode($request->formula_type_code);
        $tobaccoTypeCode    = request()->tobacco_type_code;
        $formulaTypeCode    = request()->formula_type_code;
        $recipeFiscalYear   = request()->recipe_fiscal_year;
        $formulaStatus      = request()->formula_status;

        if ($request->action == 'search-get-param') {
            $headers = PtpdFormulaHV::selectRaw("
                                blend_no
                            ")
                            ->when($blendNo, function($q) use($blendNo) {
                                $q->whereRaw("LOWER(blend_no) like '%{$blendNo}%'");
                            })
                            // ->when($blendNo, function($q) use($blendNo) {
                            //     $q->whereRaw("LOWER(blend_no) = '$blendNo'");
                            // })
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
                                $formulaStatus = strtolower($formulaStatus);
                                $q->whereRaw("LOWER(formula_status) = '{$formulaStatus}'");
                            })
                            ->orderBy('blend_no')
                            ->groupBy('blend_no')
                            // ->limit(20)
                            ->get();
  
            $attributeHeaders = PtpdFormulaHV::selectRaw("
                blend_no,
                tobacco_type_code,
                formula_type_code,
                formula_status,
                recipe_fiscal_year
            ")
            ->when($blendNo, function($q) use($blendNo) {
                $q->whereRaw("LOWER(blend_no) = '$blendNo'");
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
                $formulaStatus = strtolower($formulaStatus);
                $q->whereRaw("LOWER(formula_status) = '{$formulaStatus}'");
            })
            ->orderBy('blend_no')
            ->groupByRaw("blend_no,tobacco_type_code,formula_type_code,formula_status,recipe_fiscal_year")
            // ->limit(20)
            ->get();


            // dd($attributeHeaders->pluck('recipe_fiscal_year', 'recipe_fiscal_year'));
            $canSearch->tobacco_type_code   = $attributeHeaders->where('tobacco_type_code', '!=', null)->pluck('tobacco_type_code', 'tobacco_type_code')->keys();
            $canSearch->formula_type_code   = $attributeHeaders->where('formula_type_code', '!=', null)->pluck('formula_type_code', 'formula_type_code')->keys();
            $canSearch->formula_status      = $attributeHeaders->where('formula_status', '!=', null)->pluck('formula_status', 'formula_status')->keys();
            $canSearch->recipe_fiscal_year  = $attributeHeaders->pluck('recipe_fiscal_year', 'recipe_fiscal_year')->keys();
   
            // if($blendNo){   
            //     if ($attributeHeaders->first() && $attributeHeaders->first()->formula_type_code != 'S') {
            //         $defaultCanSearchฺBlend->tobacco_type_code   = $attributeHeaders->first() ? $attributeHeaders->first()->tobacco_type_code : null;
            //         $defaultCanSearchฺBlend->formula_type_code   = $attributeHeaders->first() ? $attributeHeaders->first()->formula_type_code : null;
            //         $defaultCanSearchฺBlend->formula_status      = $attributeHeaders->first() ? $attributeHeaders->first()->formula_status : null;
            //         $defaultCanSearchฺBlend->recipe_fiscal_year  = $attributeHeaders->first() ? $attributeHeaders->first()->recipe_fiscal_year : null;
            //     } else {

            //         $defaultCanSearchฺBlend->tobacco_type_code   = $attributeHeaders->first() ? $attributeHeaders->first()->tobacco_type_code : null;
            //         $defaultCanSearchฺBlend->formula_type_code   = $attributeHeaders->first() ? $attributeHeaders->first()->formula_type_code : null;
            //         $defaultCanSearchฺBlend->type_s              = true;
            //         // dd($recipeFiscalYear, $formulaStatus);
            //         if($recipeFiscalYear){
            //             $defaultCanSearchฺBlend->recipe_fiscal_year  = $recipeFiscalYear ?? null;
            //         }
            //         if($formulaStatus){
            //             $defaultCanSearchฺBlend->formula_status      = $formulaStatus ?? null;
            //         }
            //         // $defaultCanSearchฺBlend->formula_status      = $attributeHeaders->first() ? $attributeHeaders->first()->formula_status : null;
            //         // $defaultCanSearchฺBlend->recipe_fiscal_year  = $attributeHeaders->first() ? $attributeHeaders->first()->recipe_fiscal_year : null;
            //     }

            // }

                   
        } else {
            $headers = PtpdFormulaHV::selectRaw("
                                formula_id
                                , formula_no
                                , formula_type
                                , blend_no
                                , formula_vers
                                , recipe_fiscal_year
                                , formula_status
                                , formula_approval_date
                                , tobacco_type_desc
                            ")
                            // ->when($blendNo, function($q) use($blendNo) {
                            //     $q->whereRaw("LOWER(blend_no) like '%{$blendNo}%'");
                            // })
                            ->when($blendNo, function($q) use($blendNo) {
                                $q->whereRaw("LOWER(blend_no) = '$blendNo'");
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
                                $formulaStatus = strtolower($formulaStatus);
                                $q->whereRaw("LOWER(formula_status) = '{$formulaStatus}'");
                            })
                            ->orderBy('blend_no')
                            // ->groupByRaw("formula_id, formula_type, blend_no, formula_vers, recipe_fiscal_year")
                            ->orderByRaw("formula_id, formula_no, formula_type, blend_no, formula_vers, recipe_fiscal_year")
                            // ->limit(20)
                            ->get();

        }


        if ($request->action == 'search-get-param') {
            $blendNoList = [];

            if (count($headers)) {
                $blendNoList = $headers;
            }

            return [
                'blend_no_list'             => $blendNoList,
                'can_search'                => $canSearch,
                'default_can_searchฺ_blend'  => $defaultCanSearchฺBlend
            ];
        }


        return $headers;
    }

    function duplicate($request)
    {
        $inputHeader    = (object) $request->new_header;
        $profile        = $this->getProfile($inputHeader->formula_type_code);
        $organizationId = $profile->organization_id;
        $orgCode        = $profile->organization_code;
        $sysdate        = now();

        $newFml = new PtpdFormulaHT;
        $newFml->created_by         = $profile->fnd_user_id;
        $newFml->created_by_id      = $profile->user_id;
        $newFml->created_at         = $sysdate;
        $newFml->creation_date      = $sysdate;
        $newFml->program_code       = $profile->program_code;
        $newFml->web_user_name      = $profile->user_name;
        $newFml->web_status         = 'CREATE';

        $newFml->flavour_code               = $inputHeader->flavour_code;
        $newFml->flavour                    = $inputHeader->flavour;
        $newFml->department                 = $inputHeader->department;
        $newFml->or_formula_id              = $inputHeader->or_formula_id;
        $newFml->or_formula_organization_id = $inputHeader->or_formula_organization_id;
        $newFml->formula_vers               = $inputHeader->formula_vers;
        $newFml->or_formula_vers            = $inputHeader->or_formula_vers;

        $newFml->tobacco_type_code = $inputHeader->tobacco_type_code;
        if ($newFml->tobacco_type_code) {
            $tobaccoTypeDesc = (new ExpFmlFuncRepository)->getTobaccoTypeList(
                                    $profile->organization_id,
                                    $newFml->tobacco_type_code
                                );
            $tobaccoTypeDesc = count($tobaccoTypeDesc) ? $tobaccoTypeDesc->first()->tobacco_type_desc : '';
            $newFml->tobacco_type_desc        = $tobaccoTypeDesc;
        }

        $newFml->tobacco_organization_id    = $inputHeader->tobacco_organization_id;
        $newFml->tobacco_organization_code  = $inputHeader->tobacco_organization_code;

        $newFml->recipe_fiscal_year         = $inputHeader->recipe_fiscal_year;
        $newFml->formula_id                 = $inputHeader->formula_id;
        $newFml->blend_id                   = $inputHeader->blend_id_old;
        $newFml->blend_no                   = $inputHeader->blend_no;
        $newFml->formula_no                 = $inputHeader->formula_no;

        $newFml->product_item_id            = $inputHeader->product_item_id;
        $newFml->product_item_code          = $inputHeader->product_item_code;

        $newFml->description                = $inputHeader->description;
        $newFml->comments                   = $inputHeader->comments;
        $newFml->quantity                   = $inputHeader->quantity;
        $newFml->uom                        = $inputHeader->uom;
        $newFml->recipe_routing_no          = $inputHeader->recipe_routing_no;

        $formulaType = PtpdFormulaTypeV::select(['lookup_code', 'meaning', 'description'])
                        ->where('lookup_code', $inputHeader->formula_type_code)
                        ->first();
        $newFml->formula_type_code = optional($formulaType)->lookup_code;
        $newFml->formula_type      = optional($formulaType)->description;

        $newFml->formula_status            = 'Inactive';
        $newFml->user_name                 = $inputHeader->user_name;
        $newFml->formula_creation_date     = now();
        $newFml->formula_last_update_date  = now();

        $newFml->formula_last_update_date  = now();
        $newFml->formula_approval_date     = '';
        $newFml->formula_start_date        = '';

        $newFml->reference_formula_id               = $inputHeader->reference_formula_id;
        $newFml->reference_formula_no               = $inputHeader->reference_formula_no;
        $newFml->reference_version                  = $inputHeader->reference_version;
        $newFml->reference_organization_code        = $inputHeader->reference_organization_code;


        $newFml->updated_by_id      = $profile->user_id;
        $newFml->last_updated_by    = $profile->fnd_user_id;
        $newFml->updated_at         = $sysdate;
        $newFml->last_update_date   = $sysdate;
        $newFml->web_batch_no       = '-1';
        $batchDate                  = now()->format("YmdHisu");
        $newFml->save();
        $newFml->web_batch_no       = "COPY-{$batchDate}-{$newFml->program_code}-{$newFml->fm_id}";
        $newFml->save();

        $result = $this->interfaceDuplicate($newFml);
        if ($result['status'] != 'S' && $result['status'] != 'C') {
            throw new \Exception($result['msg']);
        }

        $header = PtpdFormulaHV::where('formula_no', $result['formula_no'])->first();
        return $header;
    }

    function store($request)
    {
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
            $formula->formula_no        = data_get($inputHeader, 'formula_no');

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
                        if (!($inputCigarDtl->is_new_row && $inputCigarDtl->is_deleted) && optional($checkCigarette)->fm_cigar_id) {
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

            $data = PtpdFormulaHV::where('blend_id', $result['blend_id'])
                            // ->where('formula_type_code', $formula->formula_type_code)
                            // ->where('product_item_code', $formula->product_item_code)
                            ->first();
            if ($data) {
                $formula->formula_id = optional($data)->formula_id;
                if ($formula->formula_id) {
                    // Update formula_id กรณีที่ระบุรหัสยาเส้น ที่ tab : บุหรี่
                    $newCigar = PtpdCigarFormulaT::where("web_batch_no", $formula->web_batch_no)->get();
                    foreach ($newCigar as $key => $cigar) {
                        $cigar->formula_id = $formula->formula_id;
                        $cigar->save();
                    }
                }
            }

            return $data;
            return $formula;
        }
    }

    function interface(PtpdFormulaHT $formula)
    {
        $db     =   \DB::connection('oracle')->getPdo();
        $sql    =   "
            DECLARE
                V_STAUTS VARCHAR2(10);
                V_MSG VARCHAR2(4000);
                V_BLEND_ID number;
            BEGIN

                PTPD_FORMULA_PKG.MAIN_IMORT(P_WEB_BATCH_NO       =>'{$formula->web_batch_no}'
                                               , P_INTERFACE_STATUS => :V_STAUTS
                                               , P_INTERFACE_MSG    => :V_MSG
                                                , P_BLEND_ID        => :V_BLEND_ID);

            END ;
        ";

        $formula->interface_name = $sql;
        $formula->save();
        \Log::info("{$formula->web_batch_no} INF", [$sql]);
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':V_STAUTS', $result['status'], \PDO::PARAM_STR, 10);
        $stmt->bindParam(':V_MSG', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':V_BLEND_ID', $result['blend_id'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        \Log::info("{$formula->web_batch_no} INF", [$result]);

        return $result;
    }

    function interfaceDuplicate(PtpdFormulaHT $formula)
    {
        $db     =   \DB::connection('oracle')->getPdo();
        $sql    =   "
            DECLARE
                V_STAUTS VARCHAR2(10);
                V_MSG VARCHAR2(4000);
                V_FORMULA_NO  VARCHAR2(100);
            BEGIN
                PTPD_FORMULA_PKG.COPPY_FORMULA(    P_WEB_BATCH_NO             =>'{$formula->web_batch_no}'
                                                    ,P_ORGANIZATION_CODE      => '{$formula->tobacco_organization_code}'
                                                    ,P_FORMULA_NO             => '{$formula->formula_no}'
                                                    ,P_INTERFACE_STATUS       => :V_STAUTS
                                                    ,P_INTERFACE_MSG          => :V_MSG
                                                    ,FORMULA_NO               => :V_FORMULA_NO
                );
            END ;
        ";

        $formula->interface_name = $sql;
        $formula->save();
        \Log::info("{$formula->web_batch_no} INF", [$sql]);
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':V_STAUTS', $result['status'], \PDO::PARAM_STR, 10);
        $stmt->bindParam(':V_MSG', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':V_FORMULA_NO', $result['formula_no'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        \Log::info("{$formula->web_batch_no} INF", [$result]);

        return $result;
    }

    function getDataInfo($request, $header, $profile)
    {
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

        $header->can = $this->getCan($header, $header->formula_status, $header->formula_type_code ?? 1, $profile);

        return $data;
    }

    function getNewLeafFormulaLine()
    {
        $line = (object)[];
        $line->is_new_row               = true;
        $line->is_deleted               = false;
        $line->is_edit_item             = false;
        $line->loading                  = false;
        $line->is_collapse              = false;

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


        $line->formulaline_id           = '';
        $line->line_no                  = '';

        $line->formulaline_id           = '';
        $line->inventory_item_id        = '';
        $line->item_code                = '';
        $line->item_desc                = '';
        $line->lot_number               = '';
        $line->ingredient_proportions   = 0;
        $line->quantity_used            = '';
        $line->uom                      = 'KG';
        $line->validate_lot             = 'N';

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
        $line->is_collapse              = false;

        $line->is_edit_leaf             = false;
        $line->leaf_formula             = '';
        $line->old_leaf_formula         = '';
        $line->leaf_formula_desc        = '';

        $line->is_edit_casing           = false;
        $line->casing_id                = '';
        $line->old_casing_id            = '';
        $line->casing_no                = '';
        $line->casing_desc              = '';
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

    function getNewFlavorLine()
    {
        $line = (object)[];
        $line->is_new_row               = true;
        $line->is_deleted               = false;
        $line->loading                  = false;
        $line->is_collapse              = false;
        $line->is_edit_item             = false;
        $line->flavor_status            = true; // default

        $line->flavor_id                = '';
        $line->old_flavor_id            = '';
        $line->flavor_no                = '';
        $line->flavor_desc              = '';

        $line->flavor_list              = []; // สำหรับ Form Vue JS
        return $line;
    }

    function getNewCigaretteLine()
    {
        $line = (object)[];
        $line->is_new_row               = true;
        $line->is_deleted               = false;
        $line->loading                  = false;

        $line->cigar_organization_code  = '';
        $line->cigar_organization_id    = '';
        $line->cigar_item_id            = '';
        $line->cigar_item_code          = '';
        $line->cigar_item_desc          = '';
        $line->fm_cigar_id              = '';

        $line->cigar_list              = []; // สำหรับ Form Vue JS
        return $line;
    }

    function getNewCigarDtlLine()
    {
        $line = (object)[];
        $line->is_new_row               = true;
        $line->is_deleted               = false;
        $line->loading                  = false;

        $line->fm_cigar_id              = '';
        $line->fm_wrap_dtl_id           = '';
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

        $flavors = [];
        $flavorList = [];

        $cigarettes = [];
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

            case 'FLAVORS': // Tab: Flavor
                $flavors = $this->getFlavors($request, $profile);
                break;
            case 'FLAVOR_LIST': // Tab: Flavor
                $flavorList = $this->getFlavorList($request, $profile);
                break;

            case 'CIGARETTES': // Tab: บุหรี่
                $cigarettes = $this->getCigarettes($request, $profile);
                $cigarDtl = $this->getCigarDtl($request, $profile);
                break;
            case 'CIGAR_LIST': // Tab: บุหรี่
                $cigarList = $this->getCigaretteList($request, $profile);
                break;

            case 'CIGARETTE_ALL': // Tab: ทั้งหมด
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

            // Tab: Flavor
            'flavors' => $flavors,
            'flavor_list' => $flavorList,

            // Tab: บุหรี่
            'cigarettes' => $cigarettes,
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

        $leafFormulas = (new ExpFmlFuncRepository)->queryLeafFormulaLine($formulaId, $blendNo, $organizationId, $countDate = false, $blendId);

        if (count($leafFormulas)) {
            $newLeafLine        = collect($this->getNewLeafFormulaLine());
            $newLeafDtlLine     = collect($this->getNewIngredientLine());

            data_set($leafFormulas, '*.is_new_row', false);

            $data = collect($leafFormulas)->map(function ($leafFormula) use ($newLeafLine, $newLeafDtlLine, $profile, $blendId) {
                $leafFormula = (object) $newLeafLine->merge($leafFormula)->toArray();
                $leafFormula->leaf_dtl = [];

                if ($leafFormula->leaf_formula) {
                    // $leafFormula->leaf_list = $this->getleafList(request(), $profile, $leafFormula->leaf_formula);
                    $leafFormula->leaf_list = [];
                }

                $leafDtlList = PtpdLeafDtlFormulaV::selectRaw("
                                    formulaline_id      as formulaline_id,
                                    inventory_item_id   as inventory_item_id,
                                    line_no             as line_no,
                                    item_code           as item_code,
                                    item_desc           as item_desc,
                                    lot_number          as lot_number,
                                    ingredient_proportions as ingredient_proportions,
                                    quantity_used as quantity_used,
                                    CASE
                                        WHEN item_group = '1002' THEN 'Y'
                                        ELSE 'N'
                                    END                     as validate_lot
                                ")
                                ->where('leaf_formula', $leafFormula->leaf_formula)
                                ->where('blend_no', $leafFormula->blend_no)
                                ->where('formula_id', $leafFormula->formula_id)
                                ->where('blend_id', $blendId)
                                ->get();

                if ($leafDtlList) {
                    data_set($leafDtlList, '*.is_new_row', false);
                    $leafDtlList = $leafDtlList->map(function ($row) use ($newLeafDtlLine, $profile) {
                        $row = (object) $newLeafDtlLine->merge($row)->toArray();

                        if ($row->inventory_item_id) {
                            $row->item_list = [];
                            // $row->item_list = $this->getItemList(request(), $profile, $row->inventory_item_id);
                        }
                        if ($row->lot_number) {
                            $row->lot_list = $this->getLotList(request(), $profile, $row->inventory_item_id, $row->lot_number);
                        }

                        return $row;
                    });
                    $leafFormula->leaf_dtl = $leafDtlList->toArray();
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

        $leafList = PtpdLeafFmlV::selectRaw("
                        leaf_formula        as value,
                        description         as leaf_formula_desc,
                        leaf_formula || ' : ' || description  as label
                    ")
                    ->when(!is_null($number), function($q) use($number) {
                        $q->whereRaw("LOWER(leaf_formula || ' : ' || description) like '%{$number}%'");
                    })
                    ->when($leafFormula, function($q) use($leafFormula) {
                        $q->orWhere("leaf_formula", $leafFormula);
                    })
                    ->when(count($except), function($q) use($except) {
                        $except = array_filter($except);
                        if (count($except)) {
                            $q->whereNotIn("leaf_formula", $except);
                        }
                    })
                    // ->limit(20)
                    ->orderBy('leaf_formula')
                    ->get();

        return $leafList;
    }

    function getItemList($request, $profile, $inventoryItemId = false)
    {
        $jsonNullable       = $this->getJsonNullable();
        $header             = json_decode($request->header ?? $jsonNullable);
        $line               = json_decode($request->line ?? $jsonNullable);
        $number             = strtolower($request->number) ?? false;
        $organizationId     = $profile->organization_id;

        $itemList = PtpdLeafDtlFmlV::selectRaw("
                        distinct
                        organization_code,
                        organization_id,
                        item_code               as item_number,
                        item_desc               as item_desc,
                        'KG'                    as uom,
                        inventory_item_id       as value,
                        item_code || ' : ' || item_desc  as label,
                        CASE
                            WHEN item_group = '1002' THEN 'Y'
                            ELSE 'N'
                        END                     as validate_lot
                    ")
                    ->when($organizationId, function($q) use($organizationId) {
                        $q->where("organization_id", $organizationId);
                    })
                    // ->when($inventoryItemId, function($q) use($inventoryItemId) {
                    //     $q->orWhere("inventory_item_id", $inventoryItemId);
                    // })
                    ->when($number, function($q) use($number) {
                        $q->whereRaw("LOWER(item_code || ' : ' || item_desc) like '%{$number}%'");
                    })
                    ->when($header->formula_type_code == 'S' || $header->formula_type_code == 'P', function($q) use($number) {
                        $q->where("formula_type_code", 'S');
                    })
                    ->when($header->formula_type_code != 'S', function($q) use($number) {
                        $q->whereNull("formula_type_code");
                    })
                    ->orderBy('item_code')
                    // ->limit(20)
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
        $formulaId          = data_get($header, 'formula_id', false);
        $formulaNo          = data_get($header, 'formula_no', '');
        $leafFormula        = request()->leaf_formula ?? '';
        $blendNo            = data_get($header, 'blend_no', '');
        $blendId            = data_get($header, 'blend_id', '');

        $data = (new ExpFmlFuncRepository)->queryCasings($formulaId, $blendNo, $leafFormula, $countDate = false, $blendId);

        $data = $data->map(function ($casing) use ($newCasingLine, $profile) {
            $casingItems = $casing->casingItems->where('leaf_formula', $casing->leaf_formula);
            // dd('xx', $casingItems);
            $casing = (object) $newCasingLine->merge($casing)->toArray();
            // $casing->casing_leaf_formula_list  = $this->getCasingLeafFormulaList(request(), $profile, $casing->leaf_formula);
            // $casing->casing_list        = $this->getCasingList(request(), $profile, $casing->casing_id, $casingItems);

            $casing->casing_leaf_formula_list  = [];
            $casing->casing_list        = [];
            $casing->is_new_row         = false;
            $casing->casing_items    = count($casingItems) ? array_values($casingItems->toArray()) : [];

            // if ($casing->casing_list->where('casing_id', $casing->casing_id)->isEmpty()) {
            //     $casing->casing_list->push(
            //         collect([
            //             "casing_id" => $casing->casing_id,
            //             "casing_no" => $casing->casing_no,
            //             "casing_desc" => $casing->leaf_formula_desc,
            //             "value" => $casing->casing_id,
            //             "label" => "$casing->casing_no : $casing->leaf_formula_desc",
            //         ])
            //     );
            // }
            return $casing;
        });

        if ($data) {
            return array_values($data->toArray());
        }
        return $data;
    }

    function getCasingLeafFormulaList($request, $profile, $leafFormula = false)
    {
        $jsonNullable       = $this->getJsonNullable();
        $header             = json_decode($request->header ?? $jsonNullable);
        $number             = strtolower($request->number) ?? false;
        $organizationId     = data_get($header ?? [], 'organization_id', $profile->organization_id);
        $formulaId          = data_get($header ?? [], 'formula_id', false);
        $blendNo            = data_get($header, 'blend_no', '');
        $leafFormulaArr     = [];

        if ($formulaId || $blendNo) {
            $leafFormulaArr = PtpdLeafHFormulaV::select('leaf_formula')
                                ->searchBlendOrFormula($blendNo, $formulaId)
                                ->get();
            if (count($leafFormulaArr)) {
                $leafFormulaArr = $leafFormulaArr->pluck('leaf_formula')->all();
            }
        }

        $leafList = PtpdLeafFmlV::selectRaw("
                        leaf_formula        as value,
                        description   as leaf_formula_desc,
                        leaf_formula || ' : ' || description  as label
                    ")
                    ->when(!is_null($number), function($q) use($number) {
                        $q->whereRaw("LOWER(leaf_formula || ' : ' || description) like '%{$number}%'");
                    })
                    ->when($leafFormula, function($q) use($leafFormula) {
                        $q->orWhere("leaf_formula", $leafFormula);
                    })
                    ->whereIn('leaf_formula', $leafFormulaArr)
                    // ->limit(20)
                    ->orderBy('leaf_formula')
                    ->get();

        return $leafList;
    }

    function getCasingList($request, $profile, $casingId = false, $casingItems = false)
    {
        $jsonNullable       = $this->getJsonNullable();
        $header             = json_decode($request->header ?? $jsonNullable);
        $line               = json_decode($request->line ?? $jsonNullable);
        $number             = strtolower($request->number) ?? false;
        $organizationId     = data_get($header ?? [], 'or_formula_organization_id', $profile->organization_id);

        $data = PtpdCasingFmlV::selectRaw("
                    --casing_id           as casing_id,
                    --casing_no           as casing_no,
                    --casing_desc         as casing_desc,
                    --item_code           as item_code,
                    --item_desc           as item_desc,
                    --quantity_used       as quantity_used,
                    --uom                 as uom,
                    distinct
                    casing_id,
                    casing_no,
                    casing_desc,
                    casing_id           as value,
                    casing_no || ' : ' || casing_desc  as label
                ")
                ->with(['casingItems' => function ($query) use ($organizationId) {
                    $query->where('organization_id', $organizationId);
                }])
                ->when(!is_null($number), function($q) use($number) {
                    $q->whereRaw("LOWER(casing_no || ' : ' || casing_desc) like '%{$number}%'");
                })
                ->when($casingId, function($q) use($casingId) {
                    $q->orWhere("casing_id", $casingId);
                })
                ->when($organizationId, function($q) use($organizationId) {
                    $q->where("organization_id", $organizationId);
                })
                ->orderBy('casing_no')
                // ->limit(20)
                ->get();

        if ($casingId) {
            data_set($jobLines, '*.casing_items', $casingItems);
            data_set($jobLines, '*.casing_items.*.old_item_code', '');
        }

        return $data;
    }

    function getFlavors($request, $profile)
    {
        $header             = json_decode($request->header ?? []);
        $newFlavorLine      = collect($this->getNewFlavorLine());
        $formulaId          = data_get($header, 'formula_id', false);
        $organizationId     = data_get($header ?? [], 'or_formula_organization_id', $profile->organization_id);
        $blendNo            = data_get($header, 'blend_no', '');
        $blendId            = data_get($header, 'blend_id', '');

        $data = (new ExpFmlFuncRepository)->queryFlavors($formulaId, $blendNo, $organizationId, $countDate = false, $blendId);

         $data = $data->map(function ($row) use ($newFlavorLine, $profile) {
            $flavorItems            = $row->flavorItems;
            $row                    = (object) $newFlavorLine->merge($row)->toArray();
            $row->flavor_status     = ($row->flavor_status == 'Y') ? true : false;
            // $row->flavor_list       = $this->getFlavorList(request(), $profile, $row->flavor_id, $flavorItems);
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

        if (!$organizationId) {
            $organizationId = $profile->organization_id;
        }

        $data = PtpdFlavorFmlV::selectRaw("
                    distinct
                    organization_id     as organization_id,
                    flavor_id           as flavor_id,
                    flavor_id           as old_flavor_id,
                    flavor_no           as flavor_no,
                    flavor_desc         as flavor_desc,
                    flavor_id           as value,
                    flavor_no || ' : ' || flavor_desc  as label
                ")
                ->with(['flavorItems' => function ($query) use ($organizationId) {
                    $query->selectRaw("
                        flavor_id,
                        organization_id     as organization_id,
                        inventory_item_id   as inventory_item_id,
                        item_code           as old_item_code,
                        item_code           as item_code,
                        item_desc           as item_desc,
                        quantity_used       as quantity_used,
                        uom                 as uom,
                        uom_name            as uom_name
                    ")
                    ->where('organization_id', $organizationId);
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
                ->where('organization_id', $organizationId)
                ->orderBy('flavor_no')
                // ->limit(20)
                ->get();

        if ($flavorId) {
            data_set($jobLines, '*.flavor_items', $flavorItems);
        }

        return $data;
    }

    function getCigarettes($request, $profile)
    {
        $header             = json_decode($request->header ?? []);
        $organizationId     = data_get($header ?? [], 'organization_id', $profile->organization_id);
        $newCigaretteLine   = collect($this->getNewCigaretteLine());
        $formulaId          = data_get($header, 'formula_id', false);
        $blendNo            = data_get($header, 'blend_no', '');
        $blendId            = data_get($header, 'blend_id', '');

        $data = (new ExpFmlFuncRepository)->queryCigarettes($formulaId, $blendNo, $countDate = false, $blendId);

         $data = $data->map(function ($row) use ($newCigaretteLine, $profile) {
            $row                    = (object) $newCigaretteLine->merge($row)->toArray();
            $row->cigar_list        = $this->getCigaretteList(
                                            request(),
                                            $profile,
                                            $row->cigar_item_id,
                                            $row->cigar_organization_id
                                        );
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



        $data = PtpdCigarFmlV::selectRaw("
                    distinct
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

        $data = PtpdWrappedDtlFormulaV::selectRaw("
                    distinct
                    fm_cigar_id,
                    fm_wrap_dtl_id,
                    wrapped_line_no as cigar_line_no,
                    wrapped_description as cigar_description
                ")
                // ->where('formula_id', $formulaId)
                ->searchBlendOrFormula($blendNo, $formulaId)
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

        $data = PtpdFormulaTotalV::selectRaw("
                    tab,
                    leaf_formula,
                    item_number,
                    item_description,
                    lot_number,
                    qty,
                    uom
                ")
                // ->when($formulaId, function($q) use($formulaId) {
                //     $q->where("formula_id", $formulaId);
                // })
                ->when($formulaNo, function($q) use($formulaNo) {
                    $q->where("formula_no", $formulaNo);
                })
                ->searchBlendOrFormula($blendNo, $formulaId)
                // ->orderBy('tab')
                // ->orderBy('item_number')
                ->get();

        if ($data) {
            return $data->toArray();
        }
        return [];
    }

    function getJsonNullable()
    {
        return json_encode(false);
    }

    function getCan($header, $status, $lookupCode, $profile)
    {
        $organizationId     = data_get($header, 'or_formula_organization_id', $profile->organization_id);
        $formulaId          = data_get($header, 'formula_id', '');
        $formulaNo          = data_get($header, 'formula_no', '');
        $blendNo            = data_get($header, 'blend_no', '');
        $blendId            = data_get($header, 'blend_id', '');

        // $leafFormulas = (new ExpFmlFuncRepository)->queryLeafFormulaLine($formulaId, $blendNo, $organizationId, $countDate = true, $blendId);
        // $casings = (new ExpFmlFuncRepository)->queryCasings($formulaId, $blendNo, $leafFormula = false, $countDate = true, $blendId);
        // $flavors = (new ExpFmlFuncRepository)->queryFlavors($formulaId, $blendNo, $organizationId, $countDate = true, $blendId);
        // $cigarettes = (new ExpFmlFuncRepository)->queryCigarettes($formulaId, $blendNo, $countDate = true, $blendId);

        $can = (object)[
            'edit' => strtoupper($status) == 'INACTIVE' && ($header->invoice_flag != 'Y'),
            // 'edit' => strtoupper($status) == 'INACTIVE',
            // Tab: cigarettes
            // 'copy_formula' => $header->formula_id != '' && $header->blend_no != '',
            // 'select_product_item_id' => ($leafFormulas && $casings && $flavors && $cigarettes),
            'select_product_item_id' => true,
            'copy_formula' => $header->blend_no != '', // ให้คัดลอกหลังจากบันทึกข้อมูลแล้ว
            'is_standart_formula_type' => false,
            'is_actual_formula_type' => false,
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


    function getProfile($lookupCode = false)
    {
        $data = getDefaultData($this::url);

        return $data;
    }

    function getCompareData($request)
    {
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
        $recipeFiscalYear = '';
        if ($formulaTypeCode == 'S') { // ประเภทสูตรมาตรฐาน
            $recipeFiscalYear = request()->recipe_fiscal_year;
        }


        $exceptItemData = [];
        $exceptItemSql = '';
        $formulaType = PtpdFormulaTypeV::select(['lookup_code', 'meaning', 'description'])->where('lookup_code', request()->formula_type_code)->first();
        if ($formulaType->lookup_code == 'A') { // สูตรใช้จริง
            $exceptItemData = PtpdFormulaHV::selectRaw('distinct product_item_id')
                            ->whereRaw("
                                tobacco_organization_id = $organizationId
                                and formula_type_code = '$formulaType->lookup_code'
                                and product_item_id is not null
                            ");

            $exceptItemSql = clone $exceptItemData;
            $exceptItemData = $exceptItemData->count();
        }
        if ($formulaType->lookup_code == 'S') { // สูตรมาตรซาน
            $exceptItemData = PtpdFormulaHV::selectRaw('distinct product_item_id')
                            ->whereRaw("
                                tobacco_organization_id = $organizationId
                                and formula_type_code = '$formulaType->lookup_code'
                                and recipe_fiscal_year = '$recipeFiscalYear'
                                and product_item_id is not null
                            ");

            $exceptItemSql = clone $exceptItemData;
            $exceptItemData = $exceptItemData->count();
        }

        // เช็คข้อมูลที่เคยสร้างแล้ว
        // $checkProduct = PtpdFormulaHV::selectRaw('distinct product_item_id')
        //     ->whereRaw("upper(blend_no) = upper('$blendNo')")
        //     ->where('tobacco_organization_id', $organizationId)
        //     // ->where('formula_type_code', 'A')
        //     // ->when($formulaTypeCode, function($q) use($recipeFiscalYear) {
        //     //     $q->where("recipe_fiscal_year", $recipeFiscalYear);
        //     // })
        //     // ->whereNotNull('product_item_id')
        //     ->get();

        // if (request()->is_creation && count($checkProduct)) {
        //     throw new \Exception("มีการสร้าง Blend No: $blendNo ในระบบแล้ว");
        // }

        // $checkProduct = array_filter($checkProduct->pluck('product_item_id', 'product_item_id')->all());
        $blendNoRepl = str_replace($formulaType->lookup_code, "", strtoupper($blendNo));
        $data = PtpdItemTobaccoV::selectRaw("
                    distinct
                    inventory_item_id,
                    inventory_item_id           as value,
                    item_code                   as label,
                    item_code || ' : ' || item_desc as cust_label,
                    item_code                   as product_item_code,
                    item_desc                   as description,
                    2000                        as quantity,
                    uom,
                    uom_name,
                    INSTR(upper(item_code), '$blendNoRepl') as check_match_blend_no,
                    'Blend No: $blendNoRepl ไม่สัมพันธ์กับ รหัสยาเส้น: ' || item_code as check_match_blend_no_msg
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
                // ->when(count($checkProduct), function($q) use($checkProduct) {
                //     $q->whereNotIn("inventory_item_id", $checkProduct);
                // })
                ->orderBy("cust_label")
                ->get();

        return $data;
    }

    function validateBlendNo($request)
    {
        $header = json_decode($request->header ?? []);
        $profile = $this->getProfile($this::url);
        $result = [
            'check_blend_no' => true,
            'check_blend_no_msg' => '',
            'check_match_blend_no' => true,
            'check_match_blend_no_msg' => '',
        ];

        $blendNo = trim($header->blend_no);

        $organizationId = $profile->organization_id;

        $recipeFiscalYear = '';
        if ($header->formula_type_code == 'S') { // ประเภทสูตรมาตรฐาน
            $recipeFiscalYear = $header->recipe_fiscal_year;
        }
        $checkBlendNo = PtpdFormulaHV::selectRaw('blend_no, recipe_fiscal_year, formula_type_code')
                        ->whereRaw("upper(blend_no) = upper('$blendNo')")
                        ->where('tobacco_organization_id', $organizationId)
                        // ->where('formula_type_code', $header->formula_type_code)
                        // ->when($header->formula_type_code == 'S', function($q) use($recipeFiscalYear) {
                        //     $q->where("recipe_fiscal_year", $recipeFiscalYear);
                        // })
                        ->when($header->blend_id != '' && $header->blend_id != null, function($q) use($header) {
                            $q->where("blend_id", '<>', $header->blend_id);
                        })
                        ->whereNull('mfg_issue_flag')
                        ->get();

        $blendValid = true;
        $msg = "มีการสร้าง Blend No: $blendNo ในระบบแล้ว";
        if ($checkBlendNo) {
            $countBlendNo = count($checkBlendNo);
            if ($header->formula_type_code == 'S') {
                $countBlendNo = count($checkBlendNo->where('formula_type_code', '<>', $header->formula_type_code));
                $checkBlendNoStd = $checkBlendNo->where('formula_type_code', $header->formula_type_code)->where('recipe_fiscal_year', $recipeFiscalYear);
                if ($countBlendNo || count($checkBlendNoStd)) {
                    $msg = "มีการสร้าง Blend No: $blendNo, ปีงบประมาณ: $recipeFiscalYear ในระบบแล้ว";
                    $blendValid = false;
                }
            } else {
                if ($countBlendNo) {
                    $blendValid = false;
                }
            }
        }
        if (!$blendValid) {
            $formulaType = PtpdFormulaTypeV::select(['lookup_code', 'meaning', 'description'])
                                ->where('lookup_code', $header->formula_type_code)
                                ->first();
            // $msg = "ไม่สามารถสร้าง Blend No: $blendNo, ประเภทสูตร: $formulaType->description";
            $result['check_blend_no'] = false;
            $result['check_blend_no_msg'] = $msg;
            // $result['check_blend_no_msg'] = $msg . " ใหม่ได้ เนื่องจากมีอยู่ในระบบแล้ว";
            // if ($header->formula_type_code == 'S') {
            //     $result['check_blend_no_msg'] = $msg . ", ปีงบประมาณ: $recipeFiscalYear ใหม่ได้ เนื่องจากมีอยู่ในระบบแล้ว";
            // }
        }

        if ($header->product_item_id && false) {
            $blendNo = strtoupper($blendNo);
            $blendNo = str_replace($header->formula_type_code, "", $blendNo);

            $item = PtpmItemNumberV::where('organization_id', $organizationId)
                        ->where('inventory_item_id', $header->product_item_id)
                        ->first();
            $matchItem = PtpmItemNumberV::where('organization_id', $organizationId)
                        ->where('inventory_item_id', $header->product_item_id)
                        ->whereRaw("upper(item_number) like '%$blendNo%' ")
                        ->first();

            if (!$matchItem) {
                $result['check_match_blend_no'] = false;
                $result['check_match_blend_no_msg'] = "Blend No: $blendNo ไม่สัมพันธ์กับ รหัสยาเส้น: $item->item_number";
            }
        }
        return $result;
    }

    function getHistory($request)
    {
        $data = \App\Models\PD\ExpFmls\PtpdBlendHistory::selectRaw("
                        edit_no,
                        edit_by,
                        edit_date,

                        edit_tab,
                        edit_leaf_formula,
                        casing_flavor_no,
                        line_no,
                        item_code,
                        item_desc,
                        uom,

                        edit_field,
                        old_data,
                        new_data
                    ")
                    ->where('blend_no', $request->blend_no)
                    ->orderByRaw('blend_history_id, edit_no')
                    ->get();

        $data = $data->map(function($i) {
            return [
                $i->edit_no,
                $i->edit_by,
                parseToDateTh($i->edit_date, 'H:i:s'),
                $i->edit_tab,
                $i->edit_leaf_formula,
                $i->casing_flavor_no,
                $i->line_no,
                $i->item_code,
                $i->item_desc,
                $i->uom,
                $i->edit_field,
                $i->old_data,
                $i->new_data,
            ];
        });

        return $data;
    }
}
