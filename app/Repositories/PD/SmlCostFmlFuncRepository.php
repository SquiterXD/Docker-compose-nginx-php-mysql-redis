<?php
namespace App\Repositories\PD;

use Illuminate\Database\Eloquent\Collection;

use App\Models\PD\SmlCostFmls\PtpdSmlCostFlavourV;
use App\Models\PD\SmlCostFmls\PtpdSmlCostTobaccoTypeV;
use App\Models\PD\SmlCostFmls\PtctCostSumProduct;

use App\Models\PD\SmlCostFmls\PtpdSmlCostFmlHeadT;
use App\Models\PD\SmlCostFmls\PtpdSmlCostLeafHFmlT;
use App\Models\PD\SmlCostFmls\PtpdSmlCostLeafDFmlT;

use App\Models\PD\SmlCostFmls\PtpdSmlCostFmlHeadV;
use App\Models\PD\SmlCostFmls\PtpdSmlCostLeafHFmlV;
use App\Models\PD\SmlCostFmls\PtpdSmlCostLeafFmlV;
use App\Models\PD\SmlCostFmls\PtpdSmlCostLeafDFmlV;
use App\Models\PD\SmlCostFmls\PtpdSmlCostLeafItemDtlV;
use App\Models\PD\SmlCostFmls\PtpdSmlCostFlavorFmlV;

use App\Models\PD\SmlCostFmls\PtpdSmlCostCasingV;
use App\Models\PD\SmlCostFmls\PtpdSmlCostFlavorV;

use App\Models\PD\SmlCostFmls\PtpdSmlCostCasingFmlT;
use App\Models\PD\Lookup\MtlUnitsOfMeasureVl;

use DB;
use Arr;
use Carbon\Carbon;

class SmlCostFmlFuncRepository
{
    function createCasingTmp($haeder, $inputCasing, $inputItem)
    {
        $casing                         = new PtpdSmlCostCasingFmlT;
        // $casing->web_lh_id              = $inputCasing->web_lh_id;
        $casing->web_h_id               = $haeder->web_h_id;
        $casing->blend_id               = $haeder->blend_id;
        $casing->blend_no               = $haeder->blend_no;
        $casing->example_no             = $haeder->example_no;

        $casing->leaf_formula           = $inputCasing->leaf_formula;
        $casing->leaf_formula_desc      = $inputCasing->leaf_formula_desc;
        $casing->casing_id              = $inputCasing->casing_id;
        $casing->casing_no              = $inputCasing->casing_no;
        $casing->casing_desc            = $inputCasing->casing_desc;
        // $casing->organization_code      = $haeder->tobacco_organization_code;

        $casing->enable_flag            = data_get($inputItem, 'enable_flag', 'N');
        $casing->unit_cost              = data_get($inputItem, 'unit_cost', 0) ?? 0;
        $casing->price_adjus            = data_get($inputItem, 'price_adjus', 0) ?? 0;
        $casing->price_reduc_increase   = data_get($inputItem, 'price_reduc_increase', 0) ?? 0;
        $casing->cost_after_price_adjus = data_get($inputItem, 'cost_after_price_adjus',0) ?? 0;
        $casing->cost_per_cgk_baht      = data_get($inputItem, 'cost_per_cgk_baht',0) ?? 0;
        $casing->x_fm_casing_id         = data_get($inputItem, 'fm_casing_id', '');




        // $casing->line_type          = $input->line_type;
        // $casing->line_no            = $input->line_no;
        // $casing->organization_id        = null;
        $casing->inventory_item_id      = null;
        $casing->item_code              = $inputItem->item_code;
        $casing->item_desc              = $inputItem->item_desc;
        $casing->quantity_used          = $inputItem->quantity_used;
        $casing->uom                    = $inputItem->uom;
        $casing->web_status             = $inputItem->web_status;

        $casing->created_by             = $haeder->created_by;
        $casing->created_by_id          = $haeder->created_by_id;
        $casing->created_at             = $haeder->created_at;
        $casing->creation_date          = $haeder->creation_date;
        $casing->program_code           = $haeder->program_code;
        $casing->updated_by_id          = $haeder->updated_by_id;
        $casing->last_updated_by        = $haeder->last_updated_by;
        $casing->updated_at             = $haeder->updated_at;
        $casing->last_update_date       = $haeder->last_update_date;
        $casing->web_batch_no           = $haeder->web_batch_no;
        $casing->save();
    }
}
