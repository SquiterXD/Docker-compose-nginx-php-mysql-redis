<?php

namespace App\Exports\PM;

use App\Models\PM\Settings\RecipesV;
use App\Models\PM\Settings\FormulaType;
use App\Models\PM\Settings\YearsV;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class FormulaExport implements FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $organizationCode  = request()->organization_code;
        $periodYear              = request()->year;
        $formulaType       = FormulaType::where('description', 'สูตรมาตรฐาน')->first();
        $formulaTypeID     = $formulaType ? $formulaType->lookup_code : '';

        $dataLists = RecipesV::selectRaw('distinct recipe_id, inventory_item_id, org_id, organization_code, qty,	
                                        version, folmula_type, machine,	status,	invoice_flag, period_year, start_date,	
                                        end_date, wip, routing_id,	creation_date')
                            ->where('organization_code', $organizationCode)
                            ->where('folmula_type', $formulaTypeID)
                            ->where('status', 'Approved for General Use')
                            ->where('period_year', $periodYear)
                            ->orderBy('recipe_id', 'desc')
                            ->get();

        return view('pm.settings.copy-production-formula.export', compact('dataLists', 'organizationCode'));
    }
}
