<?php
namespace App\Repositories\PD;

use Illuminate\Database\Eloquent\Collection;

use DB;
use Arr;


// New
use App\Models\PD\ExpFmls\PtpdCasingFormulaT;

use App\Models\PD\ExpFmls\PtpdTobaccoTypeV;
use App\Models\PD\ExpFmls\PtpdItemTobaccoV;
use App\Models\PD\ExpFmls\PtpdBlendFlavV;
use App\Models\PD\ExpFmls\PtpdFormulaHV;

use App\Models\PD\ExpFmls\PtpdLeafHFormulaV;
use App\Models\PD\ExpFmls\PtpdCasingFormulaV;
use App\Models\PD\ExpFmls\PtpdFlavorFormulaV;
use App\Models\PD\ExpFmls\PtpdCigarFormulaV;

use App\Models\PM\PtBiweeklyV;

class ExpFmlFuncRepository
{
    function getCurrentPeriodYear()
    {
        $data = PtBiweeklyV::whereRaw("sysdate BETWEEN start_date and end_date")->first();
        return $data;
    }

    function getTobaccoTypeList($organizationId, $tobaccoTypeCode = false)
    {
        $data = PtpdTobaccoTypeV::selectRaw("
                    distinct
                    tobacco_type_code  as value,
                    -- tobacco_type_code || ' : ' || tobacco_type_desc  as label
                    tobacco_type_desc  as label,
                    tobacco_type_desc
                ")
                ->where('tobacco_organization_id', $organizationId)
                ->when($tobaccoTypeCode, function($q) use($tobaccoTypeCode) {
                    $q->where("tobacco_type_code", $tobaccoTypeCode);
                })
                ->orderBy('label')
                ->get();

        return $data;
    }

    function createCasingTmp($formula, $inputCasing, $inputItem)
    {
        $casing                         = new PtpdCasingFormulaT;
        $casing->formula_id             = $formula->formula_id;
        $casing->formula_no             = $formula->formula_no;
        $casing->leaf_formula           = $inputCasing->leaf_formula;
        $casing->leaf_formula_desc      = $inputCasing->leaf_formula_desc;
        $casing->casing_id              = $inputCasing->casing_id;
        $casing->casing_no              = $inputCasing->casing_no;
        $casing->casing_desc            = $inputCasing->casing_desc;
        $casing->formula_vers           = $formula->formula_vers;
        $casing->blend_id               = $formula->blend_id;
        $casing->blend_no               = $formula->blend_no;
        $casing->organization_code      = $formula->tobacco_organization_code;


        // $casing->line_type          = $input->line_type;
        // $casing->line_no            = $input->line_no;
        $casing->organization_id        = null;
        $casing->inventory_item_id      = null;
        $casing->item_code              = $inputItem->item_code;
        $casing->item_desc              = $inputItem->item_desc;
        $casing->quantity_used          = $inputItem->quantity_used;
        $casing->uom                    = $inputItem->uom;
        $casing->web_status             = $inputItem->web_status;

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

    function queryLeafFormulaLine($formulaId = '', $blendNo, $organizationId = '', $countDate = false, $blendId = '')
    {
        $leafFormulas = PtpdLeafHFormulaV::selectRaw("
                distinct
                blend_no,
                formula_id,
                formula_id as formula_id,
                formula_no as formula_no,
                leaf_formula            as leaf_formula,
                leaf_formula_desc       as leaf_formula_desc,
                leaf_proportion         as leaf_proportion,
                leaf_total_proportion   as leaf_total_proportion
            ")
            ->where('blend_id', $blendId)
            ->where(function($q) use ($formulaId, $blendNo, $organizationId, $blendId) {
                if ($formulaId) {
                    $q->where('formula_id', $formulaId);
                } else {
                    $q->where('blend_no', $blendNo)
                        ->when($organizationId != '', function($q) use($organizationId) {
                            // $q->where("organization_id", $organizationId);
                        });
                }
            })
            ->orderBy('leaf_formula');

        if ($countDate) {
            $leafFormulas = $leafFormulas->count();
        } else {
            $leafFormulas = $leafFormulas->get();
        }

        return $leafFormulas;
    }

    function queryCasings($formulaId = '', $blendNo, $leafFormula = false, $countDate = false, $blendId = '')
    {
        $data = PtpdCasingFormulaV::selectRaw("
                distinct
                blend_no,
                leaf_formula        as leaf_formula,
                leaf_formula_desc   as leaf_formula_desc,
                casing_id           as casing_id,
                casing_no           as casing_no,
                casing_desc         as casing_desc,

                leaf_formula        as old_leaf_formula,
                casing_id           as old_casing_id

                --line_type           as line_type,
                --line_no             as line_no,
                --organization_id     as organization_id,
                --inventory_item_id   as inventory_item_id,
                --item_code           as item_code,
                --item_desc           as item_desc,
                --quantity_used       as quantity_used,
                --uom                 as uom
            ")
            ->with(['casingItems' => function ($query) use ($formulaId, $blendNo, $blendId) {
                $query->selectRaw("
                    blend_no,
                    casing_id,
                    leaf_formula,
                    calcula_casing_quantity,
                    organization_id     as organization_id,
                    inventory_item_id   as inventory_item_id,
                    item_code           as item_code,
                    item_code           as old_item_code,
                    item_desc           as item_desc,
                    quantity_used       as quantity_used,
                    uom                 as uom,
                    uom_name            as uom_name
                ")
                ->orderByRaw('item_code, item_desc')
                ->where('blend_id', $blendId)
                ->searchBlendOrFormula($blendNo, $formulaId);
                if($blendId) {
                    $query->where('blend_id', $blendId);
                }
            }])
            ->where('blend_id', $blendId)
            ->searchBlendOrFormula($blendNo, $formulaId)
            ->when($leafFormula, function($q) use($leafFormula) {
                $q->where("leaf_formula", $leafFormula);
            });

        if ($countDate) {
            $data = $data->count();
        } else {
            if($blendId) {
                $data = $data->where('blend_id', $blendId);
            }
            $data = $data->orderByRaw('leaf_formula, casing_no')->get();
        }

        return $data;
    }

    function queryFlavors($formulaId = '', $blendNo, $organizationId = '', $countDate = false, $blendId = '')
    {
        $data = PtpdFlavorFormulaV::selectRaw("
                distinct
                flavor_status,
                blend_no,
                flavor_id as flavor_id,
                flavor_id as old_flavor_id,
                flavor_no as flavor_no,
                flavor_desc as flavor_desc
            ")
            ->with(['flavorItems' => function ($query) use ($formulaId, $blendNo, $organizationId, $blendId) {
                $query->selectRaw("
                    blend_no,
                    flavor_id,
                    calcula_flavor_quantity,
                    organization_id     as organization_id,
                    inventory_item_id   as inventory_item_id,
                    item_code           as old_item_code,
                    item_code           as item_code,
                    item_desc           as item_desc,
                    quantity_used       as quantity_used,
                    uom                 as uom,
                    uom_name            as uom_name
                ")
                // ->where('formula_id', $formulaId)
                // ->searchBlendOrFormula($blendNo, $formulaId)
                ->orderByRaw('item_code, item_desc')
                ->where('blend_id', $blendId)
                ->where(function($q) use ($blendNo, $formulaId) {
                     $q->where('formula_id', $formulaId)->orWhere('blend_no', $blendNo);
                })
                ->where('organization_id', $organizationId);

                if($blendId) {
                    $query->where('blend_id', $blendId);
                }
            }])
            // ->searchBlendOrFormula($blendNo, $formulaId)
            ->where('blend_id', $blendId)
            ->where(function($q) use ($blendNo, $formulaId) {
                 $q->where('formula_id', $formulaId)->orWhere('blend_no', $blendNo);
            })
            ->where('organization_id', $organizationId);

        if ($countDate) {
            $data = $data->count();
        } else {
            if($blendId) {
                $data = $data->where('blend_id', $blendId);
            }

            $data = $data->orderByRaw('flavor_no')->get();
        }

        return $data;
    }

    function queryCigarettes($formulaId = '', $blendNo, $countDate = false, $blendId = '')
    {
        $data = PtpdCigarFormulaV::selectRaw("
                distinct
                blend_no,
                cigar_organization_code     as cigar_organization_code,
                cigar_organization_id       as cigar_organization_id,
                cigar_item_id               as cigar_item_id,
                cigar_item_code             as cigar_item_code,
                cigar_item_desc             as cigar_item_desc,
                fm_cigar_id                 as fm_cigar_id
            ")
            ->where('blend_id', $blendId)
            ->searchBlendOrFormula($blendNo, $formulaId);

        if($blendId) {
            $data = $data->where('blend_id', $blendId);
        }
        if ($countDate) {
            $data = $data->count();
        } else {
            $data = $data->get();
        }

        return $data;
    }
}
